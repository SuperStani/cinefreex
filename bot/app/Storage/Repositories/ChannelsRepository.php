<?php

namespace superbot\App\Storage\Repositories;

use superbot\App\Storage\DB;
use superbot\App\Storage\Entities\Channel;
use superbot\Telegram\Client;

class ChannelsRepository
{
    private $conn;
    private static $table = 'channels';
    public function __construct(DB $conn)
    {
        $this->conn = $conn;
    }

    public function getAll() {
        $c = $this->conn->rqueryAll("SELECT chat_id, invite_url, name FROM " . self::$table);
        $channels = [];
        foreach($c as $ch) {
            $channels[] = new Channel($ch->chat_id, $ch->invite_url, $ch->name);
        }
        return $channels;
    }

}