<?php

namespace superbot\App\Controllers\Messages;

use Exception;
use superbot\App\Controllers\MessageController;
use superbot\Telegram\Client;
use superbot\App\Configs\GeneralConfigs as cfg;
use superbot\App\Storage\Entities\Movie;
use superbot\App\Storage\Entities\Episode;
use superbot\App\Storage\Repositories\GenreRepository;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Message;
use superbot\App\Controllers\UserController;
use superbot\App\Storage\Repositories\EpisodeRepository;

class SettingsController extends MessageController
{
    private $movieRepo;
    private $genreRepo;
    private $epRepo;
    public function __construct(
        Message $message,
        UserController $user,
        MovieRepository $movieRepo,
        GenreRepository $genreRepo,
        EpisodeRepository $epRepo
    ) {
        $this->message = $message;
        $this->user = $user;
        $this->movieRepo = $movieRepo;
        $this->genreRepo = $genreRepo;
        $this->epRepo = $epRepo;
    }

    public function uploadEpisodes($id, $message_id)
    {
        Client::editMessageText($this->user->id, $message_id, null, "*Attendi sto recuperando le info del episodio..*", "Markdown");
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $episodes = $this->movieRepo->getEpisodesByMovieId($movie->getId());
        $number = (count($episodes) == 0 ? 0 : end($episodes)->getNumber()) + 1;
        $episode = new Episode();
        $episode->setNumber($number);
        $episode->setMovieId($id);
        $episode->setFileId(Client::copyMessage(cfg::$episodes_channel, $this->user->id, $this->message->id)->result->message_id);
        $this->message->delete();
        //$episode->setUrl($ep);
        if ($movie->getCategory() == 'TVSERIES') {
            $url = cfg::$api_url . "?type=TVSERIES&episode=" . $episode->getNumber() . "&season=" . $movie->getSeason() . "&movie_id=" . $movie->getTmdbId();
            $otherInfo = json_decode(file_get_contents($url));
            $episode->setName($otherInfo->name);
            $episode->setPoster($otherInfo->poster);
            $episode->setSynopsis($otherInfo->synopsis);
            $url = cfg::$domain . "/netfluzmax/photoshop/?pass=@Naruto96&saveEpisodePoster=1&fileName=" . $episode->getPoster() . "&source=" . cfg::$tmdb_photo_path  . $episode->getPoster();
            file_get_contents($url);
        }
        $this->epRepo->add($episode);

        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "*✅ EPISODIO $number CARICATO CON SUCCESSSO*", "Markdown", null, false, $keyboard);
    }

    public function epBackup($id, $message_id)
    {
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $from_movie = $this->message->text;
        $this->movieRepo->deleteAllEpisodesFromMovieId($id);
        $this->epRepo->backup($movie->getTmdbId(), $id, $from_movie, $movie->getCategory(), $movie->getSeason());
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        $this->message->delete();
        Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
    }

    public function reloadInfo($id, $message_id, $add = 0)
    {
        if ($this->message->find("http")) {
            $movie = $this->movieRepo->getMovieSimpleById($id);
            $e = explode("/", $this->message->text);
            $movie_id = explode("-", end($e))[0];
            $info = json_decode(file_get_contents(cfg::$api_url . '?type=' . $movie->getCategory() . '&movie_id=' . $movie_id . ($movie->getSeason() !== null ? '&season=' . $movie->getSeason() : '')));
            $movie->setTmdbId($movie_id);
            $movie->setName($info->name);
            $movie->setAiredOn($info->air_date);
            $movie->setEpisodesNumber($info->episodes);
            $poster = file_get_contents(cfg::$domain . "/netfluzmax/photoshop/?pass=@Naruto96&saveposter=1&source=" . $info->poster);
            $movie->setPoster($poster);
            $movie->setSynonyms("");
            $movie->setTrailer("#");
            $movie->setSynopsis($info->synopsis);
            $movie->setSynopsisUrl($info->synopsis_url);
            $movie->setDuration((int)$info->duration);

            $movie_id = $this->movieRepo->Update($movie);
            $this->genreRepo->removeAllGenreFromMovieById($movie->getId());
            foreach ($info->genres as $row) {
                $this->genreRepo->addGenreToMovie($row, $movie_id);
            }

            if ($add)
                $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "movie:view|$id|1"]];
            else
                $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
            $keyboard["inline_keyboard"] = $menu;
            $this->message->delete();
            Client::editMessageText($this->user->id, $message_id, null, "Informazioni dell'movie aggiunte con successo!", "html", null, false, $keyboard);
        }
    }

    public function title($id, $message_id)
    {
        $this->message->delete();
        $e = $this->message->split("+", 2);
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $movie->setName($e[0]);
        if (isset($e[1]))
            $movie->setSynonyms($e[1] ?? 'NULL');
        $this->movieRepo->Update($movie);
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
    }

    public function poster($id, $message_id)
    {
        if (isset($this->message->photo)) {
            $movie = $this->movieRepo->getMovieSimpleById($id);
            $photo_to_delete = $movie->getPoster();
            unlink("/var/www/netfluzmax/img/$photo_to_delete.jpg");
            $photo_file_id = $this->message->photo[count($this->message->photo) - 1]->file_id;
            $photo = "https://api.telegram.org/file/bot" . cfg::get("bot_token") . "/" . Client::getFile($photo_file_id)->result->file_path;
            $poster = file_get_contents("https://xohosting.it/netfluzmax/photoshop/?pass=@Naruto96&saveposter=1&source=" . $photo);
            $movie->setPoster($poster);
            $this->movieRepo->Update($movie);
            $this->user->page();
            $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
            $keyboard["inline_keyboard"] = $menu;
            $this->message->delete();
            Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
        }
    }

    public function season($id, $message_id)
    {
        $this->message->delete();
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $movie->setSeason($this->message->text);
        $this->movieRepo->Update($movie);
        $this->user->page();
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
    }

    public function episodes($id, $message_id)
    {
        $this->message->delete();
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $movie->setEpisodesNumber($this->message->text);
        $this->movieRepo->Update($movie);
        $this->user->page();
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
    }

    public function orderView($id, $message_id)
    {
        $this->message->delete();
        $this->movieRepo->changeOrderView($id, $this->message->text);
        $this->user->page();
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:group|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
    }

    public function newGroup($id, $message_id)
    {
        $this->message->delete();
        $group = $this->conn->wquery("INSERT INTO groups_list SET name = ?", $this->message->text);
        $this->conn->wquery("INSERT INTO movie_groups SET group_id = ?, movie = ?, viewOrder = (SELECT season FROM movie WHERE id = ?)", $group, $id, $id);
        $this->user->page();
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:group|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
    }

    public function synopsis($id, $message_id)
    {
        $this->message->delete();
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $movie->setSynopsis($this->message->text);
        $this->movieRepo->Update($movie);
        $this->user->page();
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
    }

    public function trailer($id, $message_id)
    {
        $this->message->delete();
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $movie->setTrailer($this->message->text);
        $this->movieRepo->Update($movie);
        $this->user->page();
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
    }

    public function duration($id, $message_id)
    {
        $this->message->delete();
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $movie->setDuration($this->message->text);
        $this->movieRepo->Update($movie);
        $this->user->page();
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
    }


    public function simulcastBanner($id, $message_id, $first_time = 0)
    {
        $this->message->delete();
        $photo_file_id = $this->message->photo[count($this->message->photo) - 1]->file_id;
        $photo = "https://api.telegram.org/file/bot" . cfg::$bot_token . "/" . Client::getFile($photo_file_id)->result->file_path;
        file_get_contents("https://xohosting.it/netfluzmax/photoshop/?pass=@Naruto96&saveSimulcastPoster=1&pass=@Naruto96" . "&fileName=" . $photo_file_id . "&source=" . $photo);
        //$this->message->reply_photo(cfg::get('domain').'resources/img/'.$photo_file_id.'.jpg', 'anteprima');
        if ($first_time) {
            $movie = new Movie();
            $movie->setName("");
            $movie->setPoster($photo_file_id);
            $movie->setId($id);
            $this->movieRepo->saveSimulcast($movie);
            Client::editMessageText($this->user->id, $message_id, null, "Ok, adesso invia il titolo del simulcast:", "html", null, false, null);
            $this->user->page("Settings:simulcastName|$id|$message_id|$first_time");
        } else {
            $movie = $this->movieRepo->getSimulcastByMovieId($id);
            try {
                unlink("/var/www/netfluzmax/img/simulcasts/{$movie->getPoster()}.jpg");
            } catch (Exception $e) {
            }
            $movie->setPoster($photo_file_id);
            $this->movieRepo->updateSimulcast($movie);
            $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
            $keyboard["inline_keyboard"] = $menu;
            Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!\n", "html", null, false, $keyboard);
            $this->user->page();
        }
    }

    public function simulcastName($id, $message_id, $first_time = 0)
    {
        $this->message->delete();
        $movie = $this->movieRepo->getSimulcastByMovieid($id);
        $movie->setName($this->message->text);
        $this->movieRepo->updateSimulcast($movie);
        if ($first_time) {
            $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
            $keyboard["inline_keyboard"] = $menu;
            Client::editMessageText($this->user->id, $message_id, null, "Simulcast aggiunto con successo!", "html", null, false, $keyboard);
            $this->user->page();
        } else {
            $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
            $keyboard["inline_keyboard"] = $menu;
            Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
            $this->user->page();
        }
    }
}
