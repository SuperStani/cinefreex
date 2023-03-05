<?php

namespace superbot\App\Controllers\Query;

use superbot\App\Configs\Interfaces\SearchCategory;
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
    private MovieRepository $movieRepo;
    private GenreRepository $genreRepo;
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
            $menu[] = [["text" => get_button("it", "history"), "callback_data" => "Search:byHistory|0"], ["text" => get_button("it", "year_search"), "callback_data" => "Search:selectType|byYear|0"]];
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
        $results = $this->movieRepo->searchMoviesbyNameOrSynonyms($search_text, $offset, GeneralConfigs::MAX_SEARCH_RESULTS + 1);
        $text = null;
        $x = $y = 0;
        $offset_back = GeneralConfigs::MAX_SEARCH_RESULTS - $offset;
        $offset_next = GeneralConfigs::MAX_SEARCH_RESULTS + $offset;
        $emoji = ["1️⃣", "2️⃣", "3️⃣", "4️⃣", "5️⃣", "6️⃣", "7️⃣", "8️⃣", "9️⃣", "🔟"];
        foreach ($results as $key => $movie) {
            if ($key == 10) {
                if($offset > 0) {
                    $menu[] = [["text" => "«««", "callback_data" => "Search:q|$search_id|$offset_back"], ["text" => "»»»", "callback_data" => "Search:q|$search_id|$offset_next"]];
                } else {
                    $menu[] = [["text" => "»»»", "callback_data" => "Search:q|$search_id|$offset_next"]];
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
        if(count($results) < GeneralConfigs::MAX_SEARCH_RESULTS + 1) {
            $menu[] = [["text" => "«««", "callback_data" => "Search:q|$search_id|$offset_back"]];
        }
        $text .= "Risultati per « *{$search_text}* »";
        $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Search:home|1"]];
        $this->query->message->edit($text, $menu);
    }

    public function byHistory($offset = 0) {
        $results = $this->user->getMoviesHistory($offset, GeneralConfigs::MAX_SEARCH_RESULTS + 1);
        if(count($results) === 0) {
            return $this->query->alert('Non ho trovato risultati!', true);
        }
        $this->user->saveSearch(SearchCategory::BY_INDEX);
        $text = null;
        $x = $y = 0;
        $offset_back = GeneralConfigs::MAX_SEARCH_RESULTS - $offset;
        $offset_next = GeneralConfigs::MAX_SEARCH_RESULTS + $offset;
        $emoji = ["1️⃣", "2️⃣", "3️⃣", "4️⃣", "5️⃣", "6️⃣", "7️⃣", "8️⃣", "9️⃣", "🔟"];
        foreach ($results as $key => $movie) {
            if ($key == GeneralConfigs::MAX_SEARCH_RESULTS) {
                if($offset > 0) {
                    $menu[] = [["text" => "«««", "callback_data" => "Search:byHistory|$offset_back"], ["text" => "»»»", "callback_data" => "Search:byHistory|$offset_next"]];
                } else {
                    $menu[] = [["text" => "»»»", "callback_data" => "Search:byHistory|$offset_next"]];
                }
                continue;
            }
            $key = $emoji[$key];
            $text .= $key . " | *" . $movie->getName() . " " . $movie->getParsedSeason() . "* \n{$movie->getParsedGenres()}\n\n";
            if ($x < 5) $x++;
            else {
                $x = 1;
                $y++;
            }
            $menu[$y][] = ["text" => $key, "callback_data" => "Movie:view|{$movie->getId()}|1"];
        }
        if(count($results) < GeneralConfigs::MAX_SEARCH_RESULTS + 1 && $offset > 0) {
            $menu[] = [["text" => "«««", "callback_data" => "Search:byHistory|$offset_back"]];
        }
        $text .= "Cronologia";
        $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Search:home|0|1"]];
        $this->query->message->edit($text, $menu);
    }

    public function random($type, $delete_message = 0)
    {
        $this->query->alert();
        $movie = $this->movieRepo->searchMovieByRand($type);
        $menu[] = [["text" => get_button('it', 'watch_now'), "callback_data" => "Movie:view|{$movie->getId()}|1"]];
        $menu[] = [["text" => get_button('it', 'new_random'), "callback_data" => "Search:random|$type"]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:home|1|1"]];
        $genres = $movie->getParsedGenres();
        $text = get_string('it', 'random_search', $movie->getName(), $genres, $movie->getSynopsisUrl());
        if ($delete_message) {
            $this->query->message->delete();
            return $this->query->message->reply_photo(GeneralConfigs::POSTER_PHOTO_URI . $movie->getPoster(), $text, $menu);
        } else {
            $this->query->alert();
            return $this->query->message->edit_media(GeneralConfigs::POSTER_PHOTO_URI . $movie->getPoster(), $text, $menu);
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
        $menu[] = [["text" => "A", "callback_data" => "byListScroll|$type|a"], ["text" => "B", "callback_data" => "byListScroll|$type|b"], ["text" => "C", "callback_data" => "byListScroll|$type|c"], ["text" => "D", "callback_data" => "byListScroll|$type|d"]];
        $menu[] = [["text" => "E", "callback_data" => "byListScroll|$type|e"], ["text" => "F", "callback_data" => "byListScroll|$type|f"], ["text" => "G", "callback_data" => "byListScroll|$type|g"], ["text" => "H", "callback_data" => "byListScroll|$type|h"]];
        $menu[] = [["text" => "I", "callback_data" => "byListScroll|$type|i"], ["text" => "J", "callback_data" => "byListScroll|$type|j"], ["text" => "K", "callback_data" => "byListScroll|$type|k"], ["text" => "L", "callback_data" => "byListScroll|$type|l"]];
        $menu[] = [["text" => "M", "callback_data" => "byListScroll|$type|m"], ["text" => "N", "callback_data" => "byListScroll|$type|n"], ["text" => "O", "callback_data" => "byListScroll|$type|o"], ["text" => "P", "callback_data" => "byListScroll|$type|p"]];
        $menu[] = [["text" => "Q", "callback_data" => "byListScroll|$type|q"], ["text" => "R", "callback_data" => "byListScroll|$type|r"], ["text" => "S", "callback_data" => "byListScroll|$type|s"], ["text" => "T", "callback_data" => "byListScroll|$type|t"]];
        $menu[] = [["text" => "U", "callback_data" => "byListScroll|$type|u"], ["text" => "V", "callback_data" => "byListScroll|$type|v"], ["text" => "W", "callback_data" => "byListScroll|$type|w"], ["text" => "X", "callback_data" => "byListScroll|$type|x"]];
        $menu[] = [["text" => "Y", "callback_data" => "byListScroll|$type|y"], ["text" => "Z", "callback_data" => "byListScroll|$type|z"], ["text" => "#", "callback_data" => "byListScroll|$type|#"]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:selectType|byList"]];
        $this->query->alert();
        return $this->query->message->edit("[⤵️](#) *Seleziona un indice qua sotto ⤵️*", $menu);
    }

    public function byListScroll($type, $index, $offset = 0) {
        $results = $this->movieRepo->searchMoviesByIndexAndCategory($index, $type, $offset, GeneralConfigs::MAX_SEARCH_RESULTS + 1);
        if(count($results) === 0) {
            return $this->query->alert('Non ho trovato risultati!', true);
        }
        $this->user->saveSearch(SearchCategory::BY_INDEX);
        $text = null;
        $x = $y = 0;
        $offset_back = GeneralConfigs::MAX_SEARCH_RESULTS - $offset;
        $offset_next = GeneralConfigs::MAX_SEARCH_RESULTS + $offset;
        $emoji = ["1️⃣", "2️⃣", "3️⃣", "4️⃣", "5️⃣", "6️⃣", "7️⃣", "8️⃣", "9️⃣", "🔟"];
        foreach ($results as $key => $movie) {
            if ($key == GeneralConfigs::MAX_SEARCH_RESULTS) {
                if($offset > 0) {
                    $menu[] = [["text" => "«««", "callback_data" => "Search:byListScroll|$index|$type|$offset_back"], ["text" => "»»»", "callback_data" => "Search:byListScroll|$index|$type|$offset_next"]];
                } else {
                    $menu[] = [["text" => "»»»", "callback_data" => "Search:byListScroll|$index|$type|$offset_next"]];
                }
                continue;
            }
            $key = $emoji[$key];
            $text .= $key . " | *" . $movie->getName() . " " . $movie->getParsedSeason() . "* \n{$movie->getParsedGenres()}\n\n";
            if ($x < 5) $x++;
            else {
                $x = 1;
                $y++;
            }
            $menu[$y][] = ["text" => $key, "callback_data" => "Movie:view|{$movie->getId()}|1"];
        }
        if(count($results) < GeneralConfigs::MAX_SEARCH_RESULTS + 1 && $offset > 0) {
            $menu[] = [["text" => "«««", "callback_data" => "Search:byListScroll|$index|$type|$offset_back"]];
        }
        $text .= "Risultati per indice « *$index* »";
        $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Search:byList|$type"]];
        $this->query->message->edit($text, $menu);
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
            $menu[$y][] = ["text" => $i, "callback_data" => "Search:byYearScroll|$type|$i"];
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

    public function byYearScroll($type, $index, $offset = 0) {
        $results = $this->movieRepo->searchMoviesByYearAndCategory($index, $type, $offset, GeneralConfigs::MAX_SEARCH_RESULTS + 1);
        if(count($results) === 0) {
            return $this->query->alert('Non ho trovato risultati!', true);
        }
        $this->user->saveSearch(SearchCategory::BY_YEAR);
        $text = null;
        $x = $y = 0;
        $offset_back = GeneralConfigs::MAX_SEARCH_RESULTS - $offset;
        $offset_next = GeneralConfigs::MAX_SEARCH_RESULTS + $offset;
        $emoji = ["1️⃣", "2️⃣", "3️⃣", "4️⃣", "5️⃣", "6️⃣", "7️⃣", "8️⃣", "9️⃣", "🔟"];
        foreach ($results as $key => $movie) {
            if ($key == GeneralConfigs::MAX_SEARCH_RESULTS) {
                if($offset > 0) {
                    $menu[] = [["text" => "«««", "callback_data" => "Search:byIndexScroll|$index|$type|$offset_back"], ["text" => "»»»", "callback_data" => "Search:byIndexScroll|$index|$type|$offset_next"]];
                } else {
                    $menu[] = [["text" => "»»»", "callback_data" => "Search:byIndexScroll|$index|$type|$offset_next"]];
                }
                continue;
            }
            $key = $emoji[$key];
            $text .= $key . " | *" . $movie->getName() . " " . $movie->getParsedSeason() . "* \n{$movie->getParsedGenres()}\n\n";
            if ($x < 5) $x++;
            else {
                $x = 1;
                $y++;
            }
            $menu[$y][] = ["text" => $key, "callback_data" => "Movie:view|{$movie->getId()}|1"];
        }
        if(count($results) < GeneralConfigs::MAX_SEARCH_RESULTS + 1 && $offset > 0) {
            $menu[] = [["text" => "«««", "callback_data" => "Search:byIndexScroll|$index|$type|$offset_back"]];
        }
        $text .= "Risultati per anno « *$index* »";
        $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Search:byYear|$type"]];
        $this->query->message->edit($text, $menu);
    }

    public function byEpisodesNumber()
    {
        $menu[] = [["text" => "1~12ep", "callback_data" => "Search:byEpisodesScroll|1|12"], ["text" => "13~26ep", "callback_data" => "Search:byEpisodesScroll|13|26"]];
        $menu[] = [["text" => "27~60ep", "callback_data" => "Search:byEpisodesScroll|27|60"]];
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:home|0|1"]];
        return $this->query->message->edit("*Seleziona il numero di episodi per la ricerca*", $menu);
    }

    public function byEpisodesScroll($min, $max, $offset = 0) {
        $results = $this->movieRepo->searchMoviesByEpisodesNumber($min, $max, $offset, GeneralConfigs::MAX_SEARCH_RESULTS + 1);
        if(count($results) === 0) {
            return $this->query->alert('Non ho trovato risultati!', true);
        }
        $this->user->saveSearch(SearchCategory::BY_EPISODES);
        $text = null;
        $x = $y = 0;
        $offset_back = GeneralConfigs::MAX_SEARCH_RESULTS - $offset;
        $offset_next = GeneralConfigs::MAX_SEARCH_RESULTS + $offset;
        $emoji = ["1️⃣", "2️⃣", "3️⃣", "4️⃣", "5️⃣", "6️⃣", "7️⃣", "8️⃣", "9️⃣", "🔟"];
        foreach ($results as $key => $movie) {
            if ($key == GeneralConfigs::MAX_SEARCH_RESULTS) {
                if($offset > 0) {
                    $menu[] = [["text" => "«««", "callback_data" => "Search:byEpisodesScroll|$min|$max|$offset_back"], ["text" => "»»»", "callback_data" => "Search:byEpisodesScroll|$min|$max|$offset_next"]];
                } else {
                    $menu[] = [["text" => "»»»", "callback_data" => "Search:byEpisodesScroll|$min|$max|$offset_next"]];
                }
                continue;
            }
            $key = $emoji[$key];
            $text .= $key . " | *" . $movie->getName() . " " . $movie->getParsedSeason() . "* _[{$movie->getEpisodesNumber()}ep]_\n{$movie->getParsedGenres()}\n\n";
            if ($x < 5) $x++;
            else {
                $x = 1;
                $y++;
            }
            $menu[$y][] = ["text" => $key, "callback_data" => "Movie:view|{$movie->getId()}|1"];
        }
        if(count($results) < GeneralConfigs::MAX_SEARCH_RESULTS + 1 && $offset > 0) {
            $menu[] = [["text" => "«««", "callback_data" => "Search:byEpisodesScroll|$min|$max|$offset_back"]];
        }
        $text .= "Risultati per « *$min ~ $max* »";
        $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Search:byEpisodesNumber"]];
        $this->query->message->edit($text, $menu);
    }

    public function byGenres($type, $genre = null, $search_id = null)
    {
        if (!$search_id)
            $search_id = $this->user->saveSearch(SearchCategory::BY_GENRES)->getId();
        if ($genre != null) {
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
            $menu[] = [["text" => get_button('it', 'search_results'), "callback_data" => "Search:byGenresScroll|$search_id|$type|0"]];
        }
        $menu[] = [["text" => get_button('it', 'back'), "callback_data" => "Search:home|0|1"]];
        $this->query->alert();
        return $this->query->message->edit("Seleziona i generi:", $menu);
    }

    public function byGenresScroll($search_id, $category, $offset) {
        $results = $this->movieRepo->searchMoviesByGenresAndCategory($search_id, $category, $offset, GeneralConfigs::MAX_SEARCH_RESULTS + 1);
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
                    $menu[] = [["text" => "«««", "callback_data" => "Search:byGenresScroll|$search_id|$category|$offset_back"], ["text" => "»»»", "callback_data" => "Search:byGenresScroll|$search_id|$category|$offset_next"]];
                } else {
                    $menu[] = [["text" => "»»»", "callback_data" => "Search:byGenresScroll|$search_id|$category|$offset_next"]];
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
            $menu[] = [["text" => "«««", "callback_data" => "Search:byGenresScroll|$search_id|$category|$offset_back"]];
        }
        $text .= "Risultati";
        $menu[] = [["text" => get_button("it", "back"), "callback_data" => "Search:byGenres|$category|null|$search_id"]];
        $this->query->message->edit($text, $menu);
    }
}
