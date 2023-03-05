<?php

namespace superbot\App\Storage;
use superbot\App\Configs\Interfaces\DatabaseCredentials;

class DB
{
    private $conn;
    public function __construct()
    {
        try {
            $this->conn = new \PDO(
                "mysql:host=" . DatabaseCredentials::HOST . ";dbname=" . DatabaseCredentials::DBNAME,
                DatabaseCredentials::USER,
                DatabaseCredentials::PASSWORD
            );
        } catch (\PDOException $e) {
            //$logger->warning($e->getMessage());
        }
    }

    public function rquery($query, ...$vars)
    {
        $conn = $this->conn;
        $q = $conn->prepare($query);
        foreach ($vars as $key => &$value) {
            $key = $key + 1;
            if (is_numeric($value))
                $q->bindParam($key, $value, \PDO::PARAM_INT);
            else
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
                $q->bindParam($key, $value, \PDO::PARAM_INT);
            else
                $q->bindParam($key, $value);
        }
        $q->execute();
        return $q->fetchAll(\PDO::FETCH_OBJ);
    }


    public function wquery($query, ...$vars)
    {
        $conn = $this->conn;
        $q = $conn->prepare($query);
        foreach ($vars as $key => &$value) {
            $key = $key + 1;
            if (is_numeric($value))
                $q->bindParam($key, $value, \PDO::PARAM_INT);
            else
                $q->bindParam($key, $value);
        }
        try {
            $q->execute();
            try {
                $q = $conn->lastInsertId();
            } catch (\PDOException $e) {
                
            }
            return $q;
        } catch (\PDOException $e) {
            
        }
    }
}
