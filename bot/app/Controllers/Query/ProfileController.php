<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Configs\Interfaces\SearchCategory;
use superbot\App\Controllers\QueryController;
use superbot\App\Configs\Interfaces\GeneralConfigs;
use superbot\Telegram\Client;
use superbot\App\Controllers\UserController;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\Telegram\Query as QueryUpdate;
use DateTime;

class ProfileController extends QueryController
{
    private MovieRepository $movieRepo;

    public function __construct(
        QueryUpdate $query,
        UserController $user,
        MovieRepository $movieRepo
    ) {
        $this->query = $query;
        $this->user = $user;
        $this->movieRepo = $movieRepo;
    }

    public function me($delete_message = false)
    {
        $total_films = $this->user->getTotalMoviesWatched(); //$this->conn->rquery("SELECT COUNT(*) AS tot FROM movie a INNER JOIN movie_watchlists aw ON a.id = aw.movie WHERE aw.user = ? AND aw.list = 1  AND a.season < 2 AND a.category <> 'Movie'", $this->user->id)->tot;
        $total_tvseries =  $this->user->getTotalTvSeriesWatched(); //$this->conn->rquery("SELECT COUNT(*) AS tot FROM movie a INNER JOIN movie_watchlists aw ON a.id = aw.movie WHERE aw.user = ? AND aw.list = 1  AND a.season < 2 AND a.category = 'Movie'", $this->user->id)->tot;
        $episodes = $this->user->getTotalEpisodesWatched(); //$this->conn->rquery("SELECT COUNT(*) AS tot, SUM(e.duration) as tot_duration FROM episodes e INNER JOIN movie_watchlists aw ON e.movie = aw.movie WHERE aw.user = ? AND aw.list = 1", $this->user->id);
        $tot_duration = $episodes * 45;
        $dtF = new DateTime('@0');
        $dtT = new DateTime("@$tot_duration");
        $ore = $dtF->diff($dtT)->format('%a giorni | %h h | %i min');
        $text = get_string('it', 'profile', $this->user->mention, $total_films, $total_tvseries, $episodes, $ore);
        $menu[] = [["text" => "❤️ PREFERITI", "callback_data"  => "Profile:preferreds"], ["text" => "🔵 COMPLETED", "callback_data"  => "Profile:watchlist|1"]];
        $menu[] = [["text" => "🟢 WATCHING", "callback_data"  => "Profile:watchlist|2"], ["text" => "⚪️ PLAN TO WATCH", "callback_data"  => "Profile:watchlist|3"]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Home:start|1"]];
        if ($delete_message) {
            $this->query->message->delete();
            return $this->query->message->reply($text, $menu);
        } else {
            $this->query->alert();
            return $this->query->message->edit($text, $menu);
        }
    }

    public function preferreds($offset = 0) {
        $results = $this->movieRepo->getMoviesPreferreds($this->user->id, $offset, GeneralConfigs::MAX_SEARCH_RESULTS + 1);
        if(count($results) === 0) {
            return $this->query->alert('Non ho trovato risultati!', true);
        }
        $text = null;
        $x = $y = 0;
        $offset_back = GeneralConfigs::MAX_SEARCH_RESULTS - $offset;
        $offset_next = GeneralConfigs::MAX_SEARCH_RESULTS + $offset;
        $emoji = ["1️⃣", "2️⃣", "3️⃣", "4️⃣", "5️⃣", "6️⃣", "7️⃣", "8️⃣", "9️⃣", "🔟"];
        foreach ($results as $key => $movie) {
            if ($key == GeneralConfigs::MAX_SEARCH_RESULTS) {
                if($offset > 0) {
                    $menu[] = [["text" => "«««", "callback_data" => "Profile:preferreds|$offset_back"], ["text" => "»»»", "callback_data" => "Profile:preferreds|$offset_next"]];
                } else {
                    $menu[] = [["text" => "»»»", "callback_data" => "Profile:preferreds|$offset_next"]];
                }
                continue;
            }
            $key = $emoji[$key];
            $text .= $key . " | *" . $movie->getName() . " " . $movie->getParsedSeason() . "*\n{$movie->getParsedGenres()}\n\n";
            if ($x < 5) $x++;
            else {
                $x = 1;
                $y++;
            }
            $menu[$y][] = ["text" => $key, "callback_data" => "Movie:view|{$movie->getId()}|1"];
        }
        if(count($results) < GeneralConfigs::MAX_SEARCH_RESULTS + 1 && $offset > 0) {
            $menu[] = [["text" => "«««", "callback_data" => "Profile:preferreds|$offset_back"]];
        }
        $text .= "*I tuoi preferiti*";
        $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Profile:me"]];
        $this->query->message->edit($text, $menu);
    }

    public function watchlist($list, $offset = 0) {
        $results = $this->movieRepo->getMoviesByWatchList($list, $this->user->id, $offset, GeneralConfigs::MAX_SEARCH_RESULTS + 1);
        if(count($results) === 0) {
            return $this->query->alert('Non ho trovato risultati!', true);
        }
        $text = null;
        $x = $y = 0;
        $offset_back = GeneralConfigs::MAX_SEARCH_RESULTS - $offset;
        $offset_next = GeneralConfigs::MAX_SEARCH_RESULTS + $offset;
        $emoji = ["1️⃣", "2️⃣", "3️⃣", "4️⃣", "5️⃣", "6️⃣", "7️⃣", "8️⃣", "9️⃣", "🔟"];
        switch($list) {
            case 1:
                $list_name = 'COMPLETED';
                break;
            case 2:
                $list_name = 'WATCHING';
                break;
            case 3:
                $list_name = 'PLAN-TO-WATCH';
        }
        foreach ($results as $key => $movie) {
            if ($key == GeneralConfigs::MAX_SEARCH_RESULTS) {
                if($offset > 0) {
                    $menu[] = [["text" => "«««", "callback_data" => "Profile:watchlist|$list|$offset_back"], ["text" => "»»»", "callback_data" => "Profile:watchlist|$list|$offset_next"]];
                } else {
                    $menu[] = [["text" => "»»»", "callback_data" => "Profile:watchlist|$list|$offset_next"]];
                }
                continue;
            }
            $key = $emoji[$key];
            $text .= $key . " | *" . $movie->getName() . " " . $movie->getParsedSeason() . "*\n{$movie->getParsedGenres()}\n\n";
            if ($x < 5) $x++;
            else {
                $x = 1;
                $y++;
            }
            $menu[$y][] = ["text" => $key, "callback_data" => "Movie:view|{$movie->getId()}|1"];
        }
        if(count($results) < GeneralConfigs::MAX_SEARCH_RESULTS + 1 && $offset > 0) {
            $menu[] = [["text" => "«««", "callback_data" => "Profile:watchlist|$list|$offset_back"]];
        }
        $text .= "*$list_name LIST*";
        $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Profile:me"]];
        $this->query->message->edit($text, $menu);
    }
}
