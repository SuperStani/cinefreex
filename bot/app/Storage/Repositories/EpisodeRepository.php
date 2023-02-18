<?php

namespace superbot\App\Storage\Repositories;

use superbot\App\Storage\DB;
use superbot\App\Storage\Entities\Episode;
use superbot\Telegram\Client;
use superbot\App\Configs\GeneralConfigs as cfg;


class EpisodeRepository
{
    private $conn;
    private static $table = 'episodes';
    public function __construct(DB $conn)
    {
        $this->conn = $conn;
    }

    public function getTotalEpisodes(): int
    {
        $query = "SELECT COUNT(*) AS tot FROM " . self::$table;
        return $this->conn->rquery($query)->tot;
    }

    public function add(Episode $e)
    {
        $query = "INSERT INTO " . self::$table . " SET file_id = ?, episodeNumber = ?, poster = ?, title = ?, synopsis = ?, movie = ?";
        return $this->conn->wquery(
            $query,
            $e->getFileId(),
            $e->getNumber(),
            $e->getPoster(),
            $e->getName(),
            $e->getSynopsis(),
            $e->getMovieId()
        );
    }

    public function update(Episode $e) {
        $query = "UPDATE episodes SET file_id = ?, episodeNumber = ?, poster = ?, title = ?, synopsis = ? WHERE id = ?";
        return $this->conn->wquery(
            $query,
            $e->getFileId(),
            $e->getNumber(),
            $e->getPoster(),
            $e->getName(),
            $e->getSynopsis(),
            $e->getId()
        );
    }

    public function removeEpisodeFromMovieId(Episode $episode, $movie_id)
    {
    }

    public function deleteAllEpisodesFromMovieId($id)
    {
        $this->conn->wquery("DELETE FROM episodes WHERE movie = ?", $id);
    }

    public function getEpisodesByMovieId($movie_id): ?array
    {
        $query = "SELECT * FROM episodes WHERE movie = ? ORDER by episodeNumber ASC";
        $res = $this->conn->rqueryAll($query, $movie_id);
        $episodes = [];
        foreach($res as $episode) {
            $ep = new Episode();
            $ep->setId($episode->id);
            $ep->setNumber($episode->episodeNumber);
            $ep->setFileId($episode->file_id);
            $ep->setName($episode->title);
            $ep->setSynopsis($episode->synopsis ?? null);
            $ep->setPoster($episode->poster);
            $episodes[] = $ep;
        }
        return $episodes;
    }

    public function backup($tmdbid, $movie, $from_movie, $type, $season = 0) {
        $query = "SELECT e.msgid FROM netfluzbackup.episodes e WHERE e.movie_id = ? ORDER by e.upload_on ASC";
        $res = $this->conn->rqueryAll($query, $from_movie);
        foreach ($res as $number => $ep) {
            $episode = new Episode();
            $episode->setNumber($number + 1);
            $episode->setMovieId($movie);
            $episode->setFileId($ep->msgid);
            if ($type == 'TVSERIES') {
                $url = cfg::$api_url . "?type=TVSERIES&episode=" . $episode->getNumber() . "&season=" . $season . "&movie_id=" . $tmdbid;
                $otherInfo = json_decode(file_get_contents($url));
                $episode->setName($otherInfo->name);
                $episode->setPoster($otherInfo->poster);
                $episode->setSynopsis($otherInfo->synopsis);
                //$url = "https://xohosting.it/netfluzmax/photoshop/?pass=@Naruto96&saveEpisodePoster=1&fileName=" . $episode->getPoster() . "&source=" . cfg::$tmdb_photo_path  . $episode->getPoster();
                //file_get_contents($url);
            }
            $this->add($episode);
        }
    }
}
