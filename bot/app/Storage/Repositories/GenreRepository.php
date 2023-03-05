<?php

namespace superbot\App\Storage\Repositories;

use Exception;
use superbot\App\Storage\Entities\Genre;
use superbot\App\Storage\DB;

class GenreRepository
{
    private $conn;
    private static $table = 'genres';

    public function __construct(DB $conn)
    {
        $this->conn = $conn;
    }

    public function add($name)
    {
        $query = "INSERT INTO " . self::$table . " SET name = ?";
        try {
            $this->conn->wquery($query, $name);
        } catch (Exception $e) {
        }
    }

    public function getGenreByName($name): ?Genre
    {
        $query = "SELECT id, name FROM " . self::$table . " WHERE name = ?";
        $genre = $this->conn->rquery($query, $name);
        return new Genre($genre->id, $genre->name);
    }


    public function getGenresByMovieId($id): array
    {
        $query = "SELECT g.id, g.name FROM movie_" . self::$table . " mg INNER JOIN genres g ON mg.genre = g.id WHERE mg.movie = ?";
        $result = $this->conn->rqueryAll($query, $id);
        $r = [];
        foreach ($result as $genre_row) {
            $genre = new Genre($genre_row->id, $genre_row->name);
            $r[] = $genre;
        }
        return $r;
    }

    public function getAll()
    {
        $q = $this->conn->rqueryAll("SELECT id, name FROM genres");
        foreach ($q as $e) {
            $res[] = new Genre($e->id, $e->name);
        }
        return $res;
    }

    public function addGenreToMovie($id, $movie_id)
    {
        $query = "INSERT INTO movie_" . self::$table . " SET movie = ?, genre = ?";
        $this->conn->wquery($query, $movie_id, $id);
    }

    public function removeGenreFromMovieId($id, $movie_id)
    {
        $query = "DELETE FROM movie_" . self::$table . " WHERE movie = ? AND genre = ?";
        $this->conn->wquery($query, $movie_id, $id);
    }

    public function removeAllGenreFromMovieById($movie_id)
    {
        $this->conn->wquery("DELETE FROM movie_genres WHERE movie = ?", $movie_id);
    }

    public function checkIfMovieHasGenre($movie_id, $genre_id)
    {
        return $this->conn->rquery("SELECT genre FROM movie_genres WHERE genre = ? AND movie = ?", $genre_id, $movie_id)->genre ?? false;
    }

    public function checkGenreInSearch($search_id, $genre_id)
    {
        return $this->conn->rquery("SELECT genre FROM search_genres WHERE s_id = ? AND genre = ?", $search_id, $genre_id)->genre ?? false;
    }

    public function removeGenreFromSearchBySeearchId($genre_id, $search_id)
    {
        $this->conn->wquery("DELETE FROM search_genres WHERE genre = ? AND s_id = ?", $genre_id, $search_id);
    }

    public function addGenreToSearch($search_id, $genre_id)
    {
        $this->conn->wquery("INSERT INTO search_genres SET genre = ?, s_id = ?", $genre_id, $search_id);
    }
}
