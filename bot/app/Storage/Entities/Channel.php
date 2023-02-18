<?php

namespace superbot\App\Storage\Entities;

class Channel
{
    private $id;
    private $invite_url;
    private $name;
    public function __construct($id, $invite_url, $name)
    {
        $this->id = $id;
        $this->invite_url = $invite_url;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getInviteUrl() {
        return $this->invite_url;
    }
}