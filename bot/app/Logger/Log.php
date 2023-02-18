<?php

namespace superbot\App\Logger;
use \PDO;
class Log
{
    private $conn;
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function error($error_type, $message) {
        //$this->conn->wquery();
    }

    public static function warning($message) {
        syslog(LOG_ERR, $message);
    }
}
