<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;
use superbot\App\Configs\GeneralConfigs as cfg;
use superbot\Telegram\Client;
use superbot\App\Controllers\UserController;
use superbot\App\Logger\Log;
use superbot\App\Services\CacheService;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Query as QueryUpdate;

class MovieController extends QueryController
{
    private $movieRepo;
    private $cacheService;
    public function __construct(
        QueryUpdate $query,
        UserController $user,
        MovieRepository $movieRepo,
        CacheService $cacheService,
        Log $logger
    ) {
        $this->query = $query;
        $this->user = $user;
        $this->logger = $logger;
        $this->movieRepo = $movieRepo;
        $this->cacheService = $cacheService;
    }

    public function view($id, $delete_message = null, $refresh = false)
    {
        if (($movie = $this->cacheService->getMovieInfoById($id)) === false || $refresh) {
            $movie = $this->movieRepo->getMovieById($id, true);
            if ($movie === null) {
                $this->query->message->reply("Questo movie non esiste!");
                die;
            }
            $this->cacheService->saveMovieInfo($movie);
        }

        $this->user->addMovieToHistory($id);

        if ($movie->getSeason() > 0)
            $season = "➥ <i>" . ["Prima", "Seconda", "Terza", "Quarta", "Quinta", "Sesta", "Settima", "Ottava", "Nona", "Decima", "Undicessima", "Dodicesima", "Tredicesima", "Quattordicesima", "Quindicesima", "Sedicesima", "Diciasettesima", "Diciottesima", "Dicianovesima"][$movie->getSeason() - 1] . " stagione</i>";
        else
            $season = "";
        $menu[] = [["text" => "1 ⭐️", "callback_data" => "Movie:vote|$id|1"], ["text" => "2 ⭐️", "callback_data" => "Movie:vote|$id|2"], ["text" => "3 ⭐️", "callback_data" => "Movie:vote|$id|3"], ["text" => "4 ⭐️", "callback_data" => "Movie:vote|$id|4"], ["text" => "5 ⭐️", "callback_data" => "Movie:vote|$id|5"]];
        $isPreferred = $this->user->isPreferredMovieById($movie->getId());

        $menu[] = [
            ["text" => ($isPreferred) ? '❤️' : '💔', "callback_data" => "Movie:love|$id|" . (($isPreferred) ? '0' : '1')],
            ["text" => "📌", "callback_data" => "Bookmark:home|$id"]
        ];
        if ($this->user->isAdmin())
            $menu[1][] = ["text" => "⚙️", "callback_data" => "Settings:home|$id|1"];

        if ($movie->getCategory() == "FILM") {
            $episode = $this->movieRepo->getEpisodesByMovieId($id)[0] ?? null;
            if($episode !== null) {
                if($episode->getFileId() !== 0) {
                    $menu[] = [["text" => "▶️ GUARDA ORA ", "callback_data" => "Player:play|$id|1|1"]];
                } else {
                    $menu[] = [["text" => "▶️ GUARDA ORA ", "url" => $episode->getUrl() ?? "t.me/netfluzrobot"]];
                }
            } else {
                $menu[] = [["text" => "▶️ GUARDA ORA ", "url" => "t.me/netfluzrobot"]];
            }
        } else {
            if (($episode = $this->user->haveViewInHistoryByMovieId($id)) !== false)
                $menu[] = [["text" => "⏯ RIPRENDI", "callback_data" => "Player:play|$id|$episode|1"], ["text" => "💽 EPISODI", "callback_data" => "Movie:showEpisodesList|$id"]];
            else
                $menu[] = [["text" => "💽 EPISODI", "callback_data" => "Movie:showEpisodesList|$id"]];
        }

        $group = $this->movieRepo->getGroupByMovieId($id);
        if ($group !== null)
            $menu[] = [["text" => get_button('it', 'correlated'), "web_app" => ["url" => cfg::$webapp  . "/movie/{$id}/correlated"]], ["text" => get_button('it', 'similar1'), "web_app" => ["url" => cfg::$webapp  . "/movie/{$id}/similar/{$movie->getCategory()}"]]];
        else
            $menu[] = [["text" => get_button('it', 'similar'), "web_app" => ["url" => cfg::$webapp  . "/movie/{$id}/similar/{$movie->getCategory()}"]]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:home|1"]];

        if ($movie->getCategory() == 'FILM') {
            $text = get_string(
                'it',
                'film_template',
                $movie->getName(),
                $movie->getParsedGenres(),
                $movie->getRank(),
                $movie->getAiredOn(),
                $movie->getDuration(),
                $movie->getSynopsisUrl(),
                $movie->getScore(),
                $movie->getTotalVotes(),
                $movie->getViews()
            );
        } else {
            $text = get_string(
                'it',
                'tvseries_template',
                $movie->getName(),
                $season,
                $movie->getParsedGenres(),
                $movie->getRank(),
                $movie->getAiredOn(),
                $movie->getEpisodesNumber(),
                $movie->getDuration(),
                $movie->getSynopsisUrl(),
                $movie->getScore(),
                $movie->getTotalVotes(),
                $movie->getViews()
            );
        }
        $text .= ($this->user->isAdmin()) ? "\n\nℹ️ | <b>ID:</b> " . $movie->getId() : '';
        if ($delete_message !== null) {
            $this->query->message->delete();
        }
        if ($refresh) {
            return $this->query->message->edit_media($this->query->message->photo[0]->file_id, $text, $menu, 'photo', 'html');
        }
        $res = Client::sendPhoto($this->user->id, cfg::$photo_path . $movie->getPoster(), $text, $menu, 'html');
        if(!isset($res->result) && $this->user->isAdmin()) {
            $settings[] = [["text" => "⚙️", "callback_data" => "Settings:home|{$movie->getId()}"]];
            Client::debug($res, $movie->getId());
            $this->query->message->reply("Qualcosa è andato storto con l'apertura del movie", $settings);
        }
    }

    public function vote($id, $vote)
    {
        $this->user->voteMovie($id, $vote);
        $this->query->alert("Hai votato $vote ⭐️!", true);
        $this->view($id, null, true);
    }

    public function love($id, $vote)
    {
        if ($vote == 0) {
            $this->user->removePreferredByMovieId($id);
            $this->query->alert("💔");
        } else {
            $this->user->savePreferredByMovieId($id);
            $this->query->alert("❤️");
        }
        $this->view($id, null, true);
    }

    public function showEpisodesList($id, $delete_message = null)
    {
        $this->query->alert();
        $moviePoster = $this->movieRepo->getMovieSimpleById($id)->getPoster();
        $episodes = $this->movieRepo->getEpisodesByMovieId($id);
        $x = $y = 0;
        foreach ($episodes as $key => $episode) {

            $button =  ["text" => $episode->getNumber(), "callback_data" => "Player:play|$id|{$episode->getNumber()}|1"];
            if ($x < 5)
                $x++;
            else {
                $y++;
                $x = 1;
            }
            $menu[$y][] = $button;
        }
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Movie:view|$id|1"]];
        if ($delete_message === null) {
            $this->query->message->edit_media(cfg::$photo_path . $moviePoster, "*Seleziona il numero dell'episodio ⤵️*", $menu);
        } else {
            $this->query->message->delete();
            $this->query->message->reply_photo(cfg::$photo_path . $moviePoster, "*Seleziona il numero dell'episodio ⤵️*", $menu);
        }
    }


    public function similar($id)
    {
        $movie = $this->movieRepo->getMovieSimpleById($id);
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Movie:view|$id|1"]];
        $caption = "*CONTENUTI SIMILI:*\n";
        foreach (($similar = $this->movieRepo->getSimilarMovie($movie)) as $m) {
            $caption .= "\n" . "➥ [" . $m->getName() . " " . $m->getParsedSeason() . "]" . "(https://t.me/myanimetvbetabot?start=movieID_" . $m->getId() . ")";
        }
        return $this->query->message->edit_media(cfg::$photo_path . $movie->getPoster(), $caption, $menu);
    }
}
