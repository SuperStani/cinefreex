<?php

namespace superbot\App\Services;

use superbot\App\Storage\RedisController;

use superbot\App\Storage\Entities\Movie;

class CacheService
{
    public function __construct(RedisController $connection)
    {
        $this->redisController = $connection;
    }

    public function getStartMessage()
    {
        return $this->redisController->get('start_message');
    }

    public function setStartMessage($message, $expire = 30)
    {
        return $this->redisController->set('start_message', $message, $expire);
    }

    public function saveMovieInfo(Movie $movie)
    {
        return $this->redisController->set("movie_info_" . $movie->getId(), serialize($movie), 60);
    }

    /**
     * @return Movie|false
     */
    public function getMovieInfoById($id)
    {
        return unserialize($this->redisController->get("movie_info_" . $id));
    }

    public function saveMovieSimple(Movie $movie, $timeout = 20)
    {
        return $this->redisController->set("movie_simple_" . $movie->getId(), serialize($movie), $timeout);
    }

    /**
     * @return Movie|false
     */
    public function getMovieSimpleById($id)
    {
        if(($movie = $this->getMovieInfoById($id)) === false) {
            return unserialize($this->redisController->get("movie_simple_" . $id));
        }
        return $movie;
    }
}
