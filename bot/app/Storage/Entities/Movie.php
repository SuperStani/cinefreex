<?php

namespace superbot\App\Storage\Entities;

class Movie
{
    private ?int $id;
    private ?int $tmdb_id;
    private ?string $name;
    private ?string $synonyms;
    private ?string $poster;
    private ?int $episodesNumber;
    private ?string $trailer;
    private ?string $synopsis;
    private ?string $synopsisUrl;
    private ?array $genres;
    private ?string $category;
    private ?string $airedOn;
    private ?int $season;
    private ?int $duration;
    private $topRank;
    private $vote;
    private ?int $totalVotes;
    private ?int $views;
    private ?int $viewOrder;

    public function __construct()
    {
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTmdbId($tmdb_id)
    {
        $this->tmdb_id = $tmdb_id;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdb_id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setSynonyms($synonyms)
    {
        $this->synonyms = $synonyms;
    }

    public function getSynonyms(): ?string
    {
        return $this->synonyms;
    }

    public function setPoster($poster)
    {
        $this->poster = $poster;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setEpisodesNumber($n)
    {
        $this->episodesNumber = $n;
    }

    public function getEpisodesNumber(): ?int
    {
        return $this->episodesNumber;
    }

    public function setTrailer($trailer)
    {
        $this->trailer = $trailer;
    }

    public function getTrailer(): ?string
    {
        return $this->trailer;
    }

    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsisUrl($synopsisUrl)
    {
        $this->synopsisUrl = $synopsisUrl;
    }

    public function getSynopsisUrl(): ?string
    {
        return $this->synopsisUrl;
    }

    public function setGenres($genres)
    {
        $this->genres = $genres;
    }

    public function getGenres(): ?array
    {
        return $this->genres;
    }

    public function getParsedGenres(): ?string
    {
        $r = "";
        foreach ($this->genres as $genre) {
            $r .= "#" . $genre->getName() . " ";
        }
        return trim($r);
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setAiredOn($airedOn)
    {
        $this->airedOn = $airedOn;
    }

    public function getAiredOn(): ?string
    {
        return $this->airedOn;
    }

    public function getParsedAiredOn(): ?string
    {
        $aired = explode("-", $this->airedOn);
        return  $aired[2] . " " . ["", "Gennaio", "Febbraio", "Marzo", "Maggio", "Aprile", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"][(int)$aired[1]] . " " . $aired[0];
    }

    public function setSeason($season)
    {
        $this->season = $season;
    }

    public function getSeason(): ?int
    {
        return $this->season;
    }

    public function getParsedSeason(): ?string
    {
        return ($this->season == 0) ? '' : 'S' . $this->season;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setScore($vote)
    {
        $this->vote = $vote;
    }

    public function getScore(): ?int
    {
        return $this->vote;
    }

    public function setTotalVotes($votes)
    {
        $this->totalVotes = $votes;
    }

    public function getTotalVotes(): ?int
    {
        return $this->totalVotes;
    }

    public function setRank($rank)
    {
        $this->topRank = $rank;
    }

    public function getRank(): ?int
    {
        return $this->topRank;
    }

    public function setViews($views)
    {
        $this->views = $views;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViewOrder($viewOrder)
    {
        $this->viewOrder = $viewOrder;
    }

    public function getViewOrder(): ?int
    {
        return $this->viewOrder;
    }

    public function setEpisodePoster($poster)
    {
        $this->episodePoster = $poster;
    }

}
