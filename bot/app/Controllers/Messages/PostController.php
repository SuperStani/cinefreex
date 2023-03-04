<?php

namespace superbot\App\Controllers\Messages;

use superbot\App\Controllers\MessageController;
use superbot\Telegram\Client;
use superbot\App\Configs\Interfaces\GeneralConfigs;
use superbot\App\Storage\Entities\Movie;
use superbot\App\Storage\Repositories\GenreRepository;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Message;
use superbot\App\Controllers\UserController;
use GuzzleHttp\Client as HttpClient;
use superbot\App\Configs\Interfaces\MovieCategory;

class PostController extends MessageController
{
    private MovieRepository $movieRepo;
    private GenreRepository $genreRepo;
    private HttpClient $httpClient;

    public function __construct(
        Message $message,
        UserController $user,
        MovieRepository $movieRepo,
        GenreRepository $genreRepo,
        HttpClient $httpClient
    ) {
        $this->message = $message;
        $this->user = $user;
        $this->movieRepo = $movieRepo;
        $this->genreRepo = $genreRepo;
        $this->httpClient = $httpClient;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function url($type, $season = null)
    {
        $e = explode("/", $this->message->text);
        $movie_id = explode("-", end($e))[0];
        $movie_id = explode("?", $movie_id)[0];
        $movie = $this->movieRepo->getMovieSimpleByTmdbId($movie_id);
        if ($movie->getId() !== null) {
            if ($season !== null && $season == $movie->getSeason()) {
                $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Home:start"]];
                $this->message->reply("Questa serie esiste gia nel database", $menu);
                die;
            }
            if ($movie->getCategory() == MovieCategory::FILM && $season == null) {
                $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Home:start"]];
                $this->message->reply("Questo film esiste gia nel database", $menu);
                die;
            }
        }
        $info = json_decode($this->httpClient->get(GeneralConfigs::TMDB_API_URI . '?type=' . $type . '&movie_id=' . $movie_id . ($season !== null ? '&season=' . $season : ''))->getBody());
        $movie = new Movie();
        $movie->setTmdbId($movie_id);
        $movie->setName($info->name);
        $movie->setSeason($season ?? 0);
        $movie->setAiredOn($info->air_date);
        $movie->setCategory($type);
        $movie->setEpisodesNumber($info->episodes);
        $poster = $this->httpClient->get(GeneralConfigs::PHOTOSHOP_URI . "?pass=@Naruto96&saveposter=1&source=" . $info->poster)->getBody();
        $movie->setPoster($poster);
        $movie->setSynonyms("");
        $movie->setTrailer("#");
        $movie->setSynopsis($info->synopsis);
        $movie->setSynopsisUrl($info->synopsis_url);
        $movie->setDuration((int)$info->duration);

        $movie_id = $this->movieRepo->Save($movie);
        foreach ($info->genres as $row) {
            $this->genreRepo->addGenreToMovie($row, $movie_id);
        }
        $menu[] = [["text" => "APRI", "callback_data" => "Movie:view|$movie_id"]];
        $this->message->reply("Movie caricato con successo!", $menu);
    }

    public function season()
    {
        if (is_numeric($this->message->text)) {
            $this->message->delete();
            $m = $this->message->reply("Ok, invia il link tmdb:");
            $this->user->page("Post:url|TVSERIES|{$this->message->text}");
        }
    }

    public function broadcast($message_id)
    {
        $e = explode(" ", shell_exec("nohup /usr/bin/php -f /scripts/netfluzmax/app/Workers/broadcast.php \"" . $this->message->text . "\" \"SELECT id FROM users\" > /dev/null 2>&1 &"));
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Home:start"]];
        $keyboard["inline_keyboard"] = $menu;
        $this->message->delete();
        Client::editMessageText($this->user->id, $message_id, null, "Broadcast avviato!", "html", null, false, $keyboard);
    }
}
