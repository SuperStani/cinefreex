<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Controllers\QueryController;
use superbot\App\Configs\Interfaces\GeneralConfigs;
use superbot\App\Controllers\UserController;
use superbot\App\Storage\Repositories\MovieRepository;
use superbot\App\Storage\Repositories\GenreRepository;
use superbot\App\Logger\Log;
use superbot\Telegram\Query as QueryUpdate;
use superbot\Telegram\Client;

class SearchController extends QueryController
{
    private $movieRepo;
    private $genreRepo;
    public function __construct(
        QueryUpdate $query,
        UserController $user,
        MovieRepository $movieRepo,
        GenreRepository $genreRepo,
        Log $logger
    ) {
        $this->query = $query;
        $this->user = $user;
        $this->logger = $logger;
        $this->movieRepo = $movieRepo;
        $this->genreRepo = $genreRepo;
    }

    public function home($delete_message, $options = 0)
    {
        if ($options) {
            $menu[] = [["text" => get_button('it', 'advanced_search_on'), "callback_data" => "Search:home|0"]];
            $menu[] = [["text" => get_button("it", "history"), "web_app" => ["url" => GeneralConfigs::WEBAPP_URI.  "/search/history/{$this->user->id}"]], ["text" => get_button("it", "year_search"), "callback_data" => "Search:selectType|byYear|0"]];
            $menu[] = [["text" => get_button("it", "genres_search"), "callback_data" => "Search:selectType|byGenres"], ["text" => get_button("it", "a-z-list"), "callback_data" => "Search:selectType|byList"]];
            $menu[] = [["text" => get_button("it", "ep_search"), "callback_data" => "Search:byEpisodesNumber"], ["text" => get_button("it", "random"), "callback_data" => "Search:selectType|random|1"]];
            $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Home:start"]];
        } else {
            $menu[] = [["text" => get_button('it', 'advanced_search_off'), "callback_data" => "Search:home|0|1"]];
            $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Home:start"]];
        }
        $text = get_string('it', 'search_home');
        if ($delete_message) {
            $this->query->message->delete();
            $m = $this->query->message->reply($text, $menu);
        } else {
            $this->query->alert();
            $m = $this->query->message->edit($text, $menu);
        }
        $message_id = $m->result->message_id ?? '';
        $this->user->page("Search:q|{$message_id}");
    }

    public function q($search_id, $offset)
    {
        $search_text = $this->user->getSearchById($search_id)->getText();
        $results = $this->movieRepo->searchMoviesbyNameOrSynonyms($search_text, $offset);
        $text = null;
        $x = $y = 0;
        $emoji = ["1️⃣", "2️⃣", "3️⃣", "4️⃣", "5️⃣", "6️⃣", "7️⃣", "8️⃣", "9️⃣", "🔟"];
        foreach ($results as $key => $movie) {
            if ($key == 10) {
                $menu[] = [["text" => "»»»", "callback_data" => "Search:q|$search_id|10"], ["text" => "»»»", "callback_data" => "Search:q|$search_id|10"]];
                continue;
            }
            $key = $emoji[$key];
            $text .= $key . " | *" . $movie->getName() . " " . $movie->getParsedSeason() . "*\n";
            if ($x < 5) $x++;
            else {
                $x = 1;
                $y++;
            }
            $menu[$y][] = ["text" => $key, "callback_data" => "Movie:view|{$movie->getId()}|1"];
        }
        $text .= "\nRisultati per « *{$search_text}* »";
        $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Search:home|1"]];
        $this->query->message->edit($text, $menu);
    }

    public function random($type, $delete_message = 0)
    {
        $this->query->alert();
        $movie = $this->movieRepo->searchMovieByRand($type);
        $menu[] = [["text" => get_button('it', 'watch_now'), "callback_data" => "Movie:view|{$movie->getId()}|1"]];
        $menu[] = [["text" => get_button('it', 'new_random'), "callback_data" => "Search:random|$type"]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:home|1"]];
        $genres = $movie->getParsedGenres();
        $text = get_string('it', 'random_search', $movie->getName(), $genres, $movie->getSynopsisUrl());
        if ($delete_message) {
            $this->query->message->delete();
            return $this->query->message->reply_photo(cfg::$photo_path . $movie->getPoster(), $text, $menu);
        } else {
            $this->query->alert();
            return $this->query->message->edit_media(cfg::$photo_path . $movie->getPoster(), $text, $menu);
        }
    }


    public function selectType($searchCategory, ...$args)
    {
        $menu[] = [
            ["text" => "FILM", "callback_data" => "Search:$searchCategory|FILM|" . implode("|", $args)],
            ["text" => "SERIE TV", "callback_data" => "Search:$searchCategory|TVSERIES|" . implode("|", $args)],
        ];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:home|0|1"]];
        $this->query->alert();
        return $this->query->message->edit("[⤵️](#) *Che cosa stai cercando? ⤵️*", $menu);
    }


    public function byList($type)
    {
        $webapp = GeneralConfigs::WEBAPP_URI. "/search/{$this->user->id}/index/{$type}";
        $menu[] = [["text" => "A", "web_app" => ["url" => "$webapp/a"]], ["text" => "B", "web_app" => ["url" => "$webapp/b"]], ["text" => "C", "web_app" => ["url" => "$webapp/c"]], ["text" => "D", "web_app" => ["url" => "$webapp/d"]]];
        $menu[] = [["text" => "E", "web_app" => ["url" => "$webapp/e"]], ["text" => "F", "web_app" => ["url" => "$webapp/f"]], ["text" => "G", "web_app" => ["url" => "$webapp/g"]], ["text" => "H", "web_app" => ["url" => "$webapp/h"]]];
        $menu[] = [["text" => "I", "web_app" => ["url" => "$webapp/i"]], ["text" => "J", "web_app" => ["url" => "$webapp/j"]], ["text" => "K", "web_app" => ["url" => "$webapp/k"]], ["text" => "L", "web_app" => ["url" => "$webapp/l"]]];
        $menu[] = [["text" => "M", "web_app" => ["url" => "$webapp/m"]], ["text" => "N", "web_app" => ["url" => "$webapp/n"]], ["text" => "O", "web_app" => ["url" => "$webapp/o"]], ["text" => "P", "web_app" => ["url" => "$webapp/p"]]];
        $menu[] = [["text" => "Q", "web_app" => ["url" => "$webapp/q"]], ["text" => "R", "web_app" => ["url" => "$webapp/r"]], ["text" => "S", "web_app" => ["url" => "$webapp/s"]], ["text" => "T", "web_app" => ["url" => "$webapp/t"]]];
        $menu[] = [["text" => "U", "web_app" => ["url" => "$webapp/u"]], ["text" => "V", "web_app" => ["url" => "$webapp/v"]], ["text" => "W", "web_app" => ["url" => "$webapp/w"]], ["text" => "X", "web_app" => ["url" => "$webapp/x"]]];
        $menu[] = [["text" => "Y", "web_app" => ["url" => "$webapp/y"]], ["text" => "Z", "web_app" => ["url" => "$webapp/z"]], ["text" => "#", "web_app" => ["url" => "$webapp/special"]]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:selectType|byList"]];
        $this->query->alert();
        return $this->query->message->edit("[⤵️](#) *Seleziona un indice qua sotto ⤵️*", $menu);
    }

    public function byYear($type, $index = 0)
    {
        $webapp = GeneralConfigs::WEBAPP_URI. "/search/{$this->user->id}/year/$type";
        $next_index = $index + 10;
        $prev_index = $index - 10;
        $actual_year = (int)date("Y");
        $year = $actual_year - $index;
        $x = $y = 0;
        for ($i = $year; $i > $year - 12; $i--) {
            if ($x  < 3) {
                $x++;
            } else {
                $y++;
                $x = 1;
            }
            $menu[$y][] = ["text" => $i, "web_app" => ["url" => "$webapp/$i"]];
        }
        if ($actual_year == $year && $year > 1980) {
            $menu[] = [["text" => "»»»", "callback_data" => "Search:byYear|$type|$next_index"]];
        } elseif ($year > 1991) {
            $menu[] = [["text" => "«««", "callback_data" => "Search:byYear|$type|$prev_index"], ["text" => "»»»", "callback_data" => "Search:byYear||$type$next_index"]];
        } else {
            $menu[] = [["text" => "«««", "callback_data" => "Search:byYear|$type|$prev_index"]];
        }
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:selectType|byYear|0"]];
        $this->query->alert();
        return $this->query->message->edit("*Seleziona l'anno per la ricerca*", $menu);
    }

    public function byEpisodesNumber()
    {
        $webapp = GeneralConfigs::WEBAPP_URI. "/search/{$this->user->id}/episodes";
        $menu[] = [["text" => "1~12ep", "web_app" => ["url" => "$webapp/1-12"]], ["text" => "13~26ep", "web_app" => ["url" => "$webapp/13-26"]]];
        $menu[] = [["text" => "27~60ep", "web_app" => ["url" => "$webapp/27-63"]]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:home|0|1"]];
        return $this->query->message->edit("*Seleziona il numero di episodi per la ricerca*", $menu);
    }

    public function byGenres($type, $genre = null, $search_id = null)
    {
        if (!$search_id)
            $search_id = $this->user->saveSearch("BY_GENRES")->getId();
        if ($genre != '') {
            $check = $this->genreRepo->checkGenreInSearch($search_id, $genre);
            if ($check) {
                $this->genreRepo->removeGenreFromSearchBySeearchId($genre, $search_id);
            } else {
                $this->genreRepo->addGenreToSearch($search_id, $genre);
            }
                
        }
        $q = $this->genreRepo->getAll();
        $x = $y = 0;
        foreach ($q as $g) {
            $check = $this->genreRepo->checkGenreInSearch($search_id, $g->getId());
            if ($x < 2) {
                $x++;
            } else {
                $x = 1;
                $y++;
            }
            $menu[$y][] = ["text" => $g->getName() . " " . (($check) ? '🔵' : '🔴'), "callback_data" => "Search:byGenres|$type|{$g->getId()}|{$search_id}"];
        }
        if ($genre) {
            $webapp = GeneralConfigs::WEBAPP_URI. "/search/{$this->user->id}/genres/{$type}/$search_id";
            $menu[] = [["text" => get_button('it', 'search_results'), "web_app" => ["url" => $webapp]]];
        }
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:home|0|1"]];
        $this->query->alert();
        return $this->query->message->edit("Seleziona i generi:", $menu);
    }
}
