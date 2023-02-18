<?php

namespace superbot\App\Storage\Repositories;

use Exception;
use superbot\App\Storage\DB;

class CustomizedContentRepository
{
    private $conn;
    private static $table = 'customized_contents';

    public function __construct(DB $conn)
    {
        $this->conn = $conn;
    }


    public function getContentByName($name): ?string
    {
        return $this->conn->rquery("SELECT content FROM " . self::$table . " WHERE id = ?", $name)->content;
    }

    public function updateContentByName($name, $content) {
        $this->conn->wquery("UPDATE " . self::$table . " SET content = ? WHERE id = ?", $content, $name);
    }
}
