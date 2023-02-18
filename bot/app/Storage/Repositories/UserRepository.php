<?php

namespace superbot\App\Storage\Repositories;

use Exception;
use superbot\App\Storage\DB;
use superbot\App\Storage\Entities\Search;

class UserRepository
{
    private $conn;
    private static $table = 'users';
    private $movieRepo;
    public function __construct(DB $conn, MovieRepository $movieRepo)
    {
        $this->conn = $conn;
        $this->movieRepo = $movieRepo;
    }

    public function page($user_id, $text = null)
    {
        $page = "Search:q";
        if ($text != null)
            $page = $text;
        $query = "UPDATE " . self::$table . " SET page = ? WHERE id = ?";
        $this->conn->wquery($query, $page, $user_id);
    }

    public function getPage($user_id): string
    {
        $query = "SELECT page FROM " . self::$table . " WHERE id = ?";
        $page = $this->conn->rquery($query, $user_id)->page;
        return $page;
    }

    public function save($user_id): void
    {
        try {
            $query = "INSERT INTO " . self::$table . " SET id = ?";
            $this->conn->wquery($query, $user_id);
        } catch (Exception $e) {
            ///...
        }
        
    }

    public function updateLastAction($user_id)
    {
        $query = "UPDATE " . self::$table . " SET last_update = NOW() WHERE id = ?";
        $this->conn->wquery($query, $user_id);
    }

    public function getMovieListByListType($user_id, $type): ?array
    {
        return null;
    }

    public function getPreferredMovies($user_id): ?array
    {
        return null;
    }

    public function getTotalWatchingTimeOnMovies($user_id): int
    {
        return 0;
    }

    public function getTotalEpisodesWatched($user_id): int
    {
        return 0;
    }

    public function getMoviesHistory($user_id)
    {
    }

    public function getTotalUsers(): int
    {
        $query = "SELECT COUNT(*) AS tot FROM " .  self::$table;
        return $this->conn->rquery($query)->tot;
    }

    public function saveNewSearch($user_id, $category, $text = null): ?Search
    {
        $query = sprintf(
            "INSERT INTO %s SET user = ?, search_text = ?, type = ?",
            'movie_searchs'
        );
        $search = new Search();
        $search->setId($this->conn->wquery($query, $user_id, $text, $category));
        $search->setText($text);
        $search->setType($category);
        return $search;
    }

    public function getSearchById($id): ?Search
    {
        $query = sprintf(
            "SELECT type, search_text, id FROM %s WHERE id = ?",
            'movie_searchs'
        );
        $result = $this->conn->rquery($query, $id);
        if (!isset($result->id)) {
            return null;
        }
        $search = new Search();
        $search->setId($result->id);
        $search->setText($result->search_text);
        $search->setType($result->type);
        return $search;
    }


    public function isPreferredMovieById($user_id, $movie_id): bool
    {
        return $this->conn->rquery("SELECT movie FROM movie_preferreds WHERE user = ? AND movie = ?", $user_id, $movie_id)->movie ?? false;
    }

    public function voteMovie($movie_id, $vote, $user_id)
    {
        $this->movieRepo->voteMovieById($movie_id, $vote, $user_id);
    }


    public function savePreferredByMovieId($id, $user)
    {
        $this->movieRepo->savePreferredByMovieId($id, $user);
    }

    public function removePreferredByMovieId($id, $user)
    {
        $this->movieRepo->removePreferredByMovieId($id, $user);
    }

    public function haveViewInHistoryByMovieId($movie_id, $user_id): bool
    {
        return $this->conn->rquery("SELECT episode FROM movie_views WHERE user = ? AND movie = ? AND viewed_on = (SELECT MAX(viewed_on) FROM movie_views WHERE user = ? AND movie = ?)", $user_id, $movie_id, $user_id, $movie_id)->episode ??  false;
    }

}
