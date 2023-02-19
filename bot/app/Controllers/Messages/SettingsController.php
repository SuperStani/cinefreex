<?php

namespace superbot\App\Controllers\Messages;

use Exception;
use superbot\App\Configs\MovieCategory;
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
use \GuzzleHttp\Client as HttpClient;

class SettingsController extends MessageController
{
    private MovieRepository $movieRepo;
    private GenreRepository $genreRepo;
    private EpisodeRepository $epRepo;

    private HttpClient $httpClient;

    public function __construct(
        Message $message,
        UserController $user,
        MovieRepository $movieRepo,
        GenreRepository $genreRepo,
        EpisodeRepository $epRepo,
        HttpClient $httpClient
    )
    {
        $this->message = $message;
        $this->user = $user;
        $this->movieRepo = $movieRepo;
        $this->genreRepo = $genreRepo;
        $this->epRepo = $epRepo;
        $this->httpClient = $httpClient;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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
        if ($movie->getCategory() == 'TVSERIES') {
            $url = cfg::$api_url . "?type=TVSERIES&episode=" . $episode->getNumber() . "&season=" . $movie->getSeason() . "&movie_id=" . $movie->getTmdbId();
            $otherInfo = json_decode($this->httpClient->get($url)->getBody());
            $episode->setName($otherInfo->name);
            $episode->setPoster($otherInfo->poster);
            $episode->setSynopsis($otherInfo->synopsis);
            $url = cfg::$domain . "/netfluzmax/photoshop/?pass=@Naruto96&saveEpisodePoster=1&fileName=" . $episode->getPoster() . "&source=" . cfg::$tmdb_photo_path . $episode->getPoster();
            $this->httpClient->get($url);
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

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function reloadInfo($id, $message_id, $add = 0)
    {
        if ($this->message->find("http")) {
            $movie = $this->movieRepo->getMovieSimpleById($id);
            $e = explode("/", $this->message->text);
            $movie_id = explode("-", end($e))[0];
            $info = json_decode($this->httpClient->get(cfg::$api_url . '?type=' . $movie->getCategory() . '&movie_id=' . $movie_id . ($movie->getSeason() !== null ? '&season=' . $movie->getSeason() : ''))->getBody());
            $movie->setTmdbId($movie_id);
            $movie->setName($info->name);
            $movie->setAiredOn($info->air_date);
            $movie->setEpisodesNumber($info->episodes);
            $poster = $this->httpClient->get(cfg::$domain . "/netfluzmax/photoshop/?pass=@Naruto96&saveposter=1&source=" . $info->poster)->getBody();
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

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function poster($id, $message_id)
    {
        if (isset($this->message->photo)) {
            $movie = $this->movieRepo->getMovieSimpleById($id);
            $photo_to_delete = $movie->getPoster();
            unlink("/var/www/netfluzmax/img/$photo_to_delete.jpg");
            $photo_file_id = $this->message->photo[count($this->message->photo) - 1]->file_id;
            $photo = "https://api.telegram.org/file/bot" . cfg::$bot_token . "/" . Client::getFile($photo_file_id)->result->file_path;
            $poster = $this->httpClient->get("https://xohosting.it/netfluzmax/photoshop/?pass=@Naruto96&saveposter=1&source=" . $photo)->getBody();
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
        /*$group = $this->conn->wquery("INSERT INTO groups_list SET name = ?", $this->message->text);
        $this->conn->wquery("INSERT INTO movie_groups SET group_id = ?, movie = ?, viewOrder = (SELECT season FROM movie WHERE id = ?)", $group, $id, $id);*/
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


    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function simulcastBanner($id, $message_id, $first_time = 0)
    {
        $this->message->delete();
        $photo_file_id = $this->message->photo[count($this->message->photo) - 1]->file_id;
        $photo = "https://api.telegram.org/file/bot" . cfg::$bot_token . "/" . Client::getFile($photo_file_id)->result->file_path;
        $this->httpClient->get(cfg::$domain . "/netfluzmax/photoshop/?pass=@Naruto96&saveSimulcastPoster=1&pass=@Naruto96" . "&fileName=" . $photo_file_id . "&source=" . $photo);
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

    public function aired($id, $message_id)
    {
        $this->message->delete();
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $movie->setAiredOn($this->message->text);
        $this->movieRepo->Update($movie);
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]];
        $keyboard["inline_keyboard"] = $menu;
        Client::editMessageText($this->user->id, $message_id, null, "Modifica effettuata con successo!", "html", null, false, $keyboard);
        $this->user->page();
    }

    public function sendPosterAndSend($id, $channel_id)
    {
        $this->message->delete();
        $photo = end($this->message->photo);
        $poster_id = $photo->file_id;
        $photo_file_id_telegram_uri = "https://api.telegram.org/file/bot" . cfg::$bot_token . "/" . Client::getFile($poster_id)->result->file_path;
        $final_poster = cfg::$photoshop_uri . "?posterOrizzontale=" . $photo_file_id_telegram_uri;
        $movie = $this->movieRepo->getMovieSimpleById($id);
        switch ($movie->getCategory()) {
            case MovieCategory::TV_SERIES:
                $text = get_string(
                    'it',
                    'channelTVSERIES',
                    $movie->getName(),
                    $movie->getParsedSeason(),
                    $movie->getParsedGenres(),
                    $movie->getAiredOn(),
                    $movie->getEpisodesNumber(),
                    $movie->getDuration(),
                    $movie->getSynopsisUrl()
                );
                break;
            default:
                $text = get_string(
                    'it',
                    'channelFilm',
                    $movie->getName(),
                    $movie->getParsedGenres(),
                    $movie->getAiredOn(),
                    $movie->getDuration(),
                    $movie->getSynopsisUrl()
                );
        }
        $menu[] = [["text" => "🍿 𝗦𝗧𝗥𝗘𝗔𝗠𝗜𝗡𝗚 / 𝗗𝗢𝗪𝗡𝗟𝗢𝗔𝗗 🍿", "url" => "http://t.me/CodeToLinksBot?start=movie_" . $id]];
        $menu[] = [
            ["text" => "✉️ RICHIESTE", "url" => "https://t.me/NetfluzRobot"],
            ["text" => "📝 TUTORIAL", "url" => "https://t.me/+FjXzQx6eStFhMDI8"]
        ];
        $menu[] = [
            ["text" => "🎞 LISTA SERIE", "url" => "http://t.me/NetfluzRobot?start=listaserie"],
            ["text" => "🎬 LISTA FILM", "url" => "http://t.me/NetfluzRobot?start=listafilm"]
        ];
        $menu[] = [["text" => "👤 INVITA UN AMICO", "url" => "https://telegram.me/share/url?url=https://t.me/Netfluz_Official"]];
        $this->message->reply("Movie inviato con successo!", [[["text" => get_button('it', 'back'), "callback_data" => "Settings:home|$id"]]]);
        return Client::sendPhoto($channel_id, $final_poster, $text, $menu, 'html');;
    }
}
