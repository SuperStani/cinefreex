<?php

namespace superbot\App\Storage\Entities;

class Episode
{
    private $id;
    private $url;
    private $file_id;
    private $number;
    private $poster;
    private $name;
    private $synopsis;
    private $movie_id;
    private $hasNext = false;

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

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setPoster($poster)
    {
        $this->poster = $poster;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setMovieId($id)
    {
        $this->movie_id = $id;
    }

    public function getMovieId(): ?int
    {
        return $this->movie_id;
    }

    public function setFileId($id)
    {
        $this->file_id = $id;
    }

    public function getFileId(): ?int
    {
        return $this->file_id;
    }

    public function confirmHasNext()
    {
        $this->hasNext = true;
    }

    public function hasNext(): bool
    {
        return $this->hasNext;
    }
}
