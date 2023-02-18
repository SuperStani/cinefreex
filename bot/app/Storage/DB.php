<?php

namespace superbot\App\Storage;

use superbot\App\Configs\DBConfigs;
use PDO;
use PDOException;

class DB
{
    private $conn;
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . DBConfigs::$dbhost . ";dbname=" . DBConfigs::$dbname, DBConfigs::$dbuser, DBConfigs::$dbpassword);
        } catch (PDOException $e) {
            //$logger->warning($e->getMessage());
        }
    }

    public function rquery($query, ...$vars)
    {
        $conn = $this->conn;
        $q = $conn->prepare($query);
        foreach ($vars as $key => &$value) {
            $key = $key + 1;
            $q->bindParam($key, $value);
        }
        $q->execute();
        return $q->fetchObject();
    }

    public function rqueryAll($query, ...$vars)
    {
        $conn = $this->conn;
        $q = $conn->prepare($query);
        foreach ($vars as $key => &$value) {
            $key = $key + 1;
            if (is_numeric($value))
                $q->bindParam($key, $value, PDO::PARAM_INT);
            else
                $q->bindParam($key, $value);
        }
        $q->execute();
        return $q->fetchAll(PDO::FETCH_OBJ);
    }


    public function wquery($query, ...$vars)
    {
        $conn = $this->conn;
        $q = $conn->prepare($query);
        foreach ($vars as $key => &$value) {
            $key = $key + 1;
            $q->bindParam($key, $value);
        }
        try {
            $q->execute();
            try {
                $q = $conn->lastInsertId();
            } catch (PDOException $e) {
                
            }
            return $q;
        } catch (PDOException $e) {
            
        }
    }
}
