<?php

namespace superbot\App\Storage\Repositories;

use superbot\App\Storage\DB;
use superbot\App\Storage\Entities\Episode;
use superbot\App\Storage\Entities\Movie;
use superbot\App\Storage\Entities\Genre;
use superbot\App\Services\CacheService;

class MovieRepository
{
    private $conn;
    private $episodeRepo;
    private $genreRepo;
    private $cacheService;
    private static $table = 'movie';
    public function __construct(
        DB $conn,
        CacheService $cacheService,
        EpisodeRepository $episodeRepo,
        GenreRepository $genreRepo
    ) {
        $this->conn = $conn;
        $this->episodeRepo = $episodeRepo;
        $this->genreRepo = $genreRepo;
        $this->cacheService = $cacheService;
    }

    public function getTotalFilms(): int
    {
        $query = "SELECT COUNT(*) AS tot FROM " . self::$table . " WHERE category = 'FILM'";
        return $this->conn->rquery($query)->tot;
    }

    public function getTotalTvSeries(): int
    {
        $query = "SELECT COUNT(*) AS tot FROM " . self::$table . " WHERE category = 'TVSERIES'";
        return $this->conn->rquery($query)->tot;
    }

    public function getTotalEpisodes(): int
    {
        return $this->episodeRepo->getTotalEpisodes();
    }

    public function getMovieById($id, $fetch_views = false): ?Movie
    {
        $query = sprintf(
            '
            SELECT 
                %1$s.*,
                a1.average,
                a1.toprank,
                a1.amount
            FROM (
                SELECT 
                    *,
                    RANK() OVER(ORDER By bayesan DESC) AS toprank
                FROM (
                    SELECT 
                        a.id,
                        COUNT(vote) AS amount, 
                        ROUND(AVG(vote), 1) + 0.0 AS average,
                        -- (WR) = (v ÷ (v+m)) × R + (m ÷ (v+m)) × C
                        --    * R = average for the %1$s (mean) = (Rating)
                        --    * v = number of movie_votes for the movie = (movie_votes)
                        --    * m = minimum movie_votes required to be listed in the Top 150 (currently 1300)
                        --    * C = the mean vote across the whole report (currently 6.8)
                        (  (COUNT(vote) + 0.0 / (COUNT(vote)+0)) * AVG(vote) + 0.0 + (0 + 0.0 / (COUNT(vote)+0)) * (6.8) ) AS bayesan
                    FROM %1$s AS a
                    LEFT OUTER JOIN %1$s_votes AS v
                    ON a.id = v.%1$s
                    GROUP BY a.id
                    HAVING 
                        COUNT(vote) >= 0
                ) AS aub
            ) AS a1
            INNER JOIN %1$s ON %1$s.id = a1.id
            WHERE a1.id = ?;
            ',
            self::$table
        );
        $result = $this->conn->rquery($query, $id);
        if (!$result) {
            return null;
        }
        $movie = new Movie();
        $movie->setId($result->id);
        $movie->setTmdbId($result->tmdb_id);
        $movie->setName($result->name);
        $movie->setPoster($result->poster);
        $movie->setSynonyms($result->synonyms);
        $movie->setCategory($result->category);
        $movie->setEpisodesNumber($result->episodes);
        $movie->setSeason($result->season);
        $movie->setAiredOn($result->aired_on);
        $movie->setSynopsis($result->synopsis);
        $movie->setSynopsisUrl($result->synopsis_url);
        $movie->setTrailer($result->trailer);
        $movie->setDuration($result->duration);
        $movie->setScore($result->average);
        $movie->setRank($result->toprank);
        $movie->setTotalVotes($result->amount);
        $movie->setGenres($this->genreRepo->getGenresByMovieId($movie->getId()));
        if ($fetch_views) {
            $movie->setViews($this->getTotalViewsByMovieId($movie->getId()));
        }
        return $movie;
    }

    public function getMovieSimpleById($id): ?Movie
    {
        if (($movie = $this->cacheService->getMovieSimpleById($id)) === false) {
            $query = "
                SELECT 
                    id,
                    tmdb_id,
                    name,
                    synonyms,
                    season,
                    category,
                    aired_on,
                    synopsis,
                    synopsis_url,
                    trailer,
                    poster,
                    episodes,
                    duration
                FROM movie
                WHERE id = ?
            ";
            $result = $this->conn->rquery($query, $id);
            $movie = new Movie();
            $movie->setId($result->id);
            $movie->setTmdbId($result->tmdb_id);
            $movie->setName($result->name);
            $movie->setPoster($result->poster);
            $movie->setSynonyms($result->synonyms);
            $movie->setCategory($result->category);
            $movie->setEpisodesNumber($result->episodes);
            $movie->setSeason($result->season);
            $movie->setAiredOn($result->aired_on);
            $movie->setSynopsis($result->synopsis);
            $movie->setSynopsisUrl($result->synopsis_url);
            $movie->setTrailer($result->trailer);
            $movie->setDuration($result->duration);
            $this->cacheService->saveMovieSimple($movie);
        }
        return $movie;
    }


    public function getMovieSimpleByTmdbId($id): ?Movie
    {
        if (($movie = $this->cacheService->getMovieSimpleById($id)) === false) {
            $query = "
                SELECT 
                    id,
                    tmdb_id,
                    name,
                    synonyms,
                    season,
                    category,
                    aired_on,
                    synopsis,
                    synopsis_url,
                    trailer,
                    poster,
                    episodes,
                    duration,
                    episode_poster
                FROM movie
                WHERE tmdb_id = ?
            ";
            $result = $this->conn->rquery($query, $id);
            if(!isset($result->id)) {
                return new Movie();
            }
            $movie = new Movie();
            $movie->setId($result->id);
            $movie->setTmdbId($result->tmdb_id);
            $movie->setName($result->name);
            $movie->setPoster($result->poster);
            $movie->setSynonyms($result->synonyms);
            $movie->setCategory($result->category);
            $movie->setEpisodesNumber($result->episodes);
            $movie->setSeason($result->season);
            $movie->setAiredOn($result->aired_on);
            $movie->setSynopsis($result->synopsis);
            $movie->setSynopsisUrl($result->synopsis_url);
            $movie->setTrailer($result->trailer);
            $movie->setDuration($result->duration);
            $movie->setEpisodePoster($result->episode_poster);
            
        }
        return $movie;
    }

    public function getGroupByMovieId($id): ?int
    {
        return $this->conn->rquery("SELECT group_id FROM movie_groups WHERE movie = ?", $id)->group_id ?? null;
    }

    public function getTotalViewsByMovieId($movie_id): ?int
    {
        $query = sprintf(
            "SELECT COUNT(*) AS tot FROM %s WHERE movie = ?",
            self::$table . "_views"
        );
        return $this->conn->rquery($query, $movie_id)->tot;
    }

    public function searchMoviesbyNameOrSynopsys($q, $category, $offset = 0, $limit = 10): array
    {
        $query = "SELECT * FROM " . self::$table . " WHERE category = ? AND name LIKE ? OR synonyms LIKE ? LIMIT ?, ?";
        $results = $this->conn->rqueryALl(
            $query,
            $category,
            '%' . $q . '%',
            '%' . $q . '%',
            $offset,
            $limit
        );

        $r = [];
        foreach ($results as $row) {
            $movie = new Movie();
            $movie->setId($row->id);
            $movie->setName($row->name);
            $movie->setAiredOn($row->aired_on);
            $movie->setCategory($row->category);
            $movie->setEpisodesNumber($row->episodes);
            $movie->setPoster($row->poster);
            $movie->setSynonyms($row->synonyms);
            $movie->setTrailer($row->trailer);
            $movie->setSynopsis($row->synopsis);
            $movie->setSynopsisUrl($row->synopsis_url);
            $movie->setDuration($row->duration);
            $movie->setSeason($row->season);
            $movie->setGenres($this->genreRepo->getGenresByMovieId($movie->getId()));
            $r[] = $movie;
        }
        return $r;
    }

    public function getTotalSearchResultsByName($q)
    {
        $films = $this->conn->rquery(sprintf("SELECT COUNT(*) AS tot FROM %s WHERE category = 'FILM' AND name LIKE ? OR synonyms LIKE ?", self::$table), '%' . $q . '%', '%' . $q . '%');
        $series = $this->conn->rquery(sprintf("SELECT COUNT(*) AS tot FROM %s WHERE category = 'TVSERIES' AND name LIKE ? OR synonyms LIKE ?", self::$table), '%' . $q . '%', '%' . $q . '%');
        return [
            "tvseries" => $series->tot,
            "films" => $films->tot
        ];
    }

    public function getMoviesbyCategory($q): array
    {
        $query = "SELECT * FROM " . self::$table . " WHERE category = ?";
        $results = $this->conn->rqueryAll($query, $q);
        $r = [];
        foreach ($results as $row) {
            $movie = new Movie();
            $movie->setId($row->id);
            $movie->setName($row->name);
            $movie->setAiredOn($row->aired_on);
            $movie->setCategory($row->category);
            $movie->setEpisodesNumber($row->episodes);
            $movie->setPoster($row->poster);
            $movie->setSynonyms($row->synonyms);
            $movie->setTrailer($row->trailer);
            $movie->setSynopsis($row->synopsis);
            $movie->setSynopsisUrl($row->synopsis_url);
            $movie->setGenres($this->genreRepo->getGenresByMovieId($movie->getId()));
            $r[] = $movie;
        }
        return $r;
    }

    public function Save(Movie $movie): int
    {
        $query = "
            INSERT INTO movie 
            SET 
                tmdb_id = ?,
                name = ?,
                synonyms = ?,
                poster = ?,
                aired_on = ?,
                episodes = ?,
                synopsis = ?,
                synopsis_url = ?,
                category = ?,
                season = ?,
                trailer = ?,
                duration = ?
        ";
        return $this->conn->wquery(
            $query,
            $movie->getTmdbId(),
            $movie->getName(),
            $movie->getSynonyms(),
            $movie->getPoster(),
            $movie->getAiredOn(),
            $movie->getEpisodesNumber(),
            $movie->getSynopsis(),
            $movie->getSynopsisUrl(),
            $movie->getCategory(),
            $movie->getSeason(),
            $movie->getTrailer(),
            $movie->getDuration()
        );
    }

    public function Update(Movie $movie)
    {
        $query = "
            UPDATE movie 
            SET 
                tmdb_id = ?,
                name = ?,
                synonyms = ?,
                poster = ?,
                aired_on = ?,
                episodes = ?,
                synopsis = ?,
                synopsis_url = ?,
                category = ?,
                season = ?,
                trailer = ?,
                duration = ?
            WHERE id = ?
        ";
        $this->conn->wquery(
            $query,
            $movie->getTmdbId(),
            $movie->getName(),
            $movie->getSynonyms(),
            $movie->getPoster(),
            $movie->getAiredOn(),
            $movie->getEpisodesNumber(),
            $movie->getSynopsis(),
            $movie->getSynopsisUrl(),
            $movie->getCategory(),
            $movie->getSeason(),
            $movie->getTrailer(),
            $movie->getDuration(),
            $movie->getId(),
        );
        return $movie->getId();
    }

    public function deleteMovieById($id)
    {
        $this->conn->wquery("DELETE FROM movie_votes WHERE movie = ?", $id);
        $this->conn->wquery("DELETE FROM movie_views WHERE movie = ?", $id);
        $this->conn->wquery("DELETE FROM movie_watchlists WHERE movie = ?", $id);
        $this->conn->wquery("DELETE FROM movie_preferreds WHERE movie = ?", $id);
        $this->conn->wquery("DELETE FROM movie_simulcasts WHERE movie = ?", $id);
        $this->conn->wquery("DELETE FROM movie_genres WHERE movie = ?", $id);
        $this->conn->wquery("DELETE FROM movie_history WHERE movie = ?", $id);
        $movie = $this->getMovieSimpleById($id);
        unlink("/var/www/netfluzmax/img/" . $movie->getPoster() . ".jpg");
        $episodes = $this->getEpisodesByMovieId($id);
        foreach ($episodes as $e) {
            unlink("/var/www/netfluzmax/img/episodes/" . $e->getPoster());
        }
        $this->conn->wquery("DELETE FROM episodes WHERE movie = ?", $id);
        $this->conn->wquery("DELETE FROM movie WHERE id = ?", $id);
    }

    public function deleteAllEpisodesFromMovieId($id)
    {
        $this->episodeRepo->deleteAllEpisodesFromMovieId($id);
    }

    public function removeSimulcast($id)
    {
        $poster = $this->conn->rquery("SELECT poster FROM movie_simulcasts WHERE movie = ?", $id)->poster;
        $this->conn->wquery("DELETE FROM movie_simulcasts WHERE movie = ?", $id);
        unlink("/var/www/netfluzmax/img/simulcasts/" . $poster . ".jpg");
    }

    public function voteMovieById($id, $vote, $user_id)
    {
        $this->conn->wquery("DELETE FROM movie_votes WHERE user = ? AND movie = ?", $user_id, $id);
        $this->conn->wquery("INSERT INTO movie_votes SET user = ?, movie = ?, vote = ?", $user_id, $id, $vote);
    }

    public function savePreferredByMovieId($id, $user)
    {
        $this->conn->wquery("INSERT INTO movie_preferreds SET user = ?, movie = ?", $user, $id);
    }

    public function removePreferredByMovieId($id, $user)
    {
        $this->conn->wquery("DELETE FROM movie_preferreds WHERE user = ? AND movie = ?", $user, $id);
    }

    public function getEpisodesByMovieId($movie_id): ?array
    {
        return $this->episodeRepo->getEpisodesByMovieId($movie_id);
    }

    public function saveView($movie_id, $user_id, $episode)
    {
        $this->conn->wquery("INSERT INTO movie_views SET user = ?, movie = ?, episode = ?", $user_id, $movie_id, $episode);
    }

    public function isSimulcastByMovieId($movie_id)
    {
        return $this->conn->rquery("SELECT movie FROM movie_simulcasts WHERE movie = ?", $movie_id)->movie ?? false;
    }

    public function getGroupMembersByMovieId($id)
    {
        $g = $this->conn->rqueryAll("SELECT a.id, a.name, a.season, ag.viewOrder, ag.group_id FROM movie a INNER JOIN movie_groups ag ON a.id = ag.movie WHERE ag.group_id = (SELECT group_id FROM movie_groups WHERE movie = ?) ORDER by ag.viewOrder ASC", $id);
        foreach ($g as $m) {
            $movie = new Movie();
            $movie->setName($m->name);
            $movie->setId($m->id);
            $movie->setSeason($m->season);
            $movie->setViewOrder($m->viewOrder);
            $res[] = $movie;
        }
        return $res;
    }

    public function addInGroup($movie_id, $group_id)
    {
        $this->conn->wquery("INSERT INTO movie_groups SET group_id = ?, movie = ?, viewOrder = (SELECT season FROM movie WHERE id = ?)", $group_id, $movie_id, $movie_id);
    }

    public function removeFromGroupByMovieId($id)
    {
        $this->conn->wquery("DELETE FROM movie_groups WHERE movie = ?", $id);
    }

    public function changeOrderView($movie_id, $order)
    {
        $this->conn->wquery("UPDATE movie_groups SET viewOrder = ? WHERE movie = ?", $order, $movie_id);
    }


    public function getSimilarMovie(Movie $movie): array
    {
        $query = "
            SELECT
                COUNT(*) AS total_matches,
                m.id,
                m.name,
                m.season
            FROM movie m
            INNER JOIN movie_genres mg
            ON m.id = mg.movie
            WHERE m.category = ?
            AND m.tmdb_id <> ?
            AND mg.genre IN (
                SELECT
                    genre
                FROM movie_genres
                WHERE movie = ?
            )
            GROUP by m.id, m.name, m.season
            ORDER by total_matches DESC, m.name ASC, m.season ASC
            LIMIT 10
        ";
        $results = $this->conn->rqueryAll($query, $movie->getCategory(), $movie->getTmdbId(), $movie->getId());
        $movies = [];
        foreach ($results as $m) {
            $movie = new Movie();
            $movie->setName($m->name);
            $movie->setId($m->id);
            $movie->setSeason($m->season);
            $movies[] = $movie;
        }
        return $movies;
    }

    public function getLeadership($offset): array
    {
        $query = '
            SELECT 
                *,
                RANK() OVER(ORDER By bayesan DESC) AS toprank
            FROM (
                SELECT 
                    v.movie,
                    a.name, 
                    a.season,
                    COUNT(vote) AS amount, 
                    ROUND(AVG(vote), 1) + 0.0 AS average,
                    -- (WR) = (v ÷ (v+m)) × R + (m ÷ (v+m)) × C
                    --    * R = average for the movie (mean) = (Rating)
                    --    * v = number of movie_votes for the movie = (movie_votes)
                    --    * m = minimum movie_votes required to be listed in the Top 150 (currently 1300)
                    --    * C = the mean vote across the whole report (currently 6.8)
                    (  (COUNT(vote) + 0.0 / (COUNT(vote)+0)) * AVG(vote) + 0.0 + (0 + 0.0 / (COUNT(vote)+0)) * (6.8) ) AS bayesan
                FROM movie_votes AS v
                LEFT OUTER JOIN movie AS a
                ON a.id = v.movie
                GROUP BY v.movie
                HAVING 
                    COUNT(vote) >= 0
            ) AS aub LIMIT ?, 11
        ';
        $movies = [];
        $res = $this->conn->rqueryAll($query, $offset);
        foreach ($res as $m) {
            $movie = new Movie();
            $movie->setName($m->name);
            $movie->setSeason($m->season);
            $movie->setTotalVotes($m->amount);
            $movie->setScore($m->average);
            $movie->setRank($m->toprank);
            $movie->setId($m->movie);
            $movies[] = $movie;
        }
        return $movies;
    }

    public function addMovieToHistory($movie_id, $user_id)
    {
        return $this->conn->wquery("INSERT INTO movie_history SET movie = ?, user = ?", $movie_id, $user_id);
    }

    public function searchMovieByRand($type)
    {
        $query = "
            SELECT 
                id,
                tmdb_id,
                name,
                synonyms,
                season,
                category,
                aired_on,
                synopsis,
                synopsis_url,
                trailer,
                poster,
                episodes,
                duration,
                episode_poster
            FROM movie
            WHERE category = ?
            ORDER by RAND()
            LIMIT 1
        ";
        $result = $this->conn->rquery($query, $type);
        $movie = new Movie();
        $movie->setId($result->id);
        $movie->setTmdbId($result->tmdb_id);
        $movie->setName($result->name);
        $movie->setPoster($result->poster);
        $movie->setSynonyms($result->synonyms);
        $movie->setCategory($result->category);
        $movie->setEpisodesNumber($result->episodes);
        $movie->setSeason($result->season);
        $movie->setAiredOn($result->aired_on);
        $movie->setSynopsis($result->synopsis);
        $movie->setSynopsisUrl($result->synopsis_url);
        $movie->setTrailer($result->trailer);
        $movie->setDuration($result->duration);
        $movie->setEpisodePoster($result->episode_poster);
        $movie->setGenres($this->genreRepo->getGenresByMovieId($movie->getId()));
        $this->cacheService->saveMovieSimple($movie, 5);
        return $movie;
    }

    public function getSimulcastByMovieId($id): ?Movie
    {
        $res = $this->conn->rquery("SELECT name, poster, movie FROM movie_simulcasts WHERE movie = ?", $id);
        $movie = new Movie();
        $movie->setName($res->name);
        $movie->setPoster($res->poster);
        $movie->setId($res->movie);
        return $movie;
    }

    public function saveSimulcast(Movie $movie)
    {
        $this->conn->wquery("INSERT INTO movie_simulcasts SET name = ?, poster = ?, movie = ?", $movie->getName(), $movie->getPoster(), $movie->getId());
    }

    public function updateSimulcast(Movie $movie)
    {
        $this->conn->wquery("UPDATE movie_simulcasts SET name = ?, poster = ? WHERE movie = ?", $movie->getName(), $movie->getPoster(), $movie->getId());
    }

    public function checkMovieInWatchList($movie_id, $user_id)
    {
        return $this->conn->rquery("SELECT list FROM movie_watchlists WHERE movie = ? AND user = ?", $movie_id, $user_id)->list ?? false;
    }

    public function deleteMovieFromWatchList($movie_id, $user_id)
    {
        $this->conn->wquery("DELETE FROM movie_watchlists WHERE movie = ? AND user = ?", $movie_id, $user_id);
    }

    public function updateMovieOnWatchList($movie_id, $list_id, $user_id)
    {
        $this->conn->wquery("UPDATE movie_watchlists SET list = ? WHERE movie = ? AND user = ?", $list_id, $movie_id, $user_id);
    }

    public function addMovieToWatchList($movie_id, $list_id, $user_id)
    {
        $this->conn->wquery("INSERT INTO movie_watchlists SET list = ?, movie = ?, user = ?", $list_id, $movie_id, $user_id);
    }

    public function getTotalMoviesWatchedByUserId($user_id): int
    {
        return $this->conn->rquery("SELECT COUNT(*) AS tot FROM movie a INNER JOIN movie_watchlists aw ON a.id = aw.movie WHERE aw.user = ? AND aw.list = 1  AND a.season < 2 AND a.category <> 'FILM'", $user_id)->tot;
    }

    public function getTotalTvSeriesWatchedByUserId($user_id): int
    {
        return $this->conn->rquery("SELECT COUNT(*) AS tot FROM movie a INNER JOIN movie_watchlists aw ON a.id = aw.movie WHERE aw.user = ? AND aw.list = 1  AND a.season < 2 AND a.category <> 'TVSERIES'", $user_id)->tot;
    }

    public function getTotalEpisodesWatchedByUserId($user_id): int
    {
        return $this->conn->rquery("SELECT COUNT(*) AS tot FROM episodes e INNER JOIN movie_watchlists aw ON e.movie = aw.movie WHERE aw.user = ? AND aw.list = 1", $user_id)->tot;
    }
}
