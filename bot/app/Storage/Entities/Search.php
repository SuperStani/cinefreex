<?php

namespace superbot\App\Storage\Entities;

class Search {
    private $id;
    private $text;
    private $type;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}