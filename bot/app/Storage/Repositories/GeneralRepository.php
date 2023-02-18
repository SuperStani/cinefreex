<?php

namespace superbot\App\Storage\Repositories;

use superbot\App\Storage\DB;
use superbot\App\Storage\Entities\Episode;
use superbot\App\Storage\Entities\Movie;
use superbot\App\Storage\Entities\Genre;
use superbot\App\Configs\GeneralConfigs as cfg;

class GeneralRepository
{
    private $conn;
    private $episodeRepo;
    private $genreRepo;
    public function __construct(
        DB $conn,
        EpisodeRepository $episodeRepo,
        GenreRepository $genreRepo
    ) {
        $this->conn = $conn;
        $this->episodeRepo = $episodeRepo;
        $this->genreRepo = $genreRepo;
    }

    public function getEpisodeWithMovieInfoByMovieId($movie_id, $episode): ?array
    {
        $info = $this->conn->rqueryAll("SELECT a.id as m_id, a.name, a.season, a.episode_poster, a.category, e.id, e.episodeNumber, e.url, e.file_id, e.title as eTitle, e.synopsis, e.poster FROM movie a JOIN episodes e ON a.id = e.movie LEFT JOIN movie_groups ag ON a.id = ag.movie WHERE a.id = ? AND e.episodeNumber BETWEEN ? AND ? ORDER By e.episodeNumber ASC", $movie_id, $episode, $episode + 1);
        $movie = new Movie();
        $movie->setId($info[0]->m_id ?? null);
        $movie->setSeason($info[0]->season ?? 0);
        $movie->setName($info[0]->name ?? null);
        $movie->setCategory($info[0]->category);
        $episode = new Episode();
        $episode->setId($info[0]->id);
        $episode->setNumber($info[0]->episodeNumber ?? 1);
        $episode->setUrl($info[0]->url);
        $episode->setFileId($info[0]->file_id);
        $episode->setPoster($info[0]->episode_poster ?? cfg::$episodes_photo_path . $info[0]->poster);
        $episode->setName($info[0]->eTitle ?? null);
        $episode->setSynopsis($info[0]->synopsis ?? null);
        if (isset($info[1])) {
            $episode->confirmHasNext();
        }

        return [
            "movie" => $movie,
            "episode" => $episode
        ];
    }
}
