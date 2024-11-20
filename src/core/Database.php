<?php

namespace app\core;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $dbName;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        $this->host = Config::get('DB_HOST');
        $this->dbName = Config::get('DB_NAME');
        $this->username = Config::get('DB_USER');
        $this->password = Config::get('DB_PASS');
    }

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName}",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            error_log("Connection error: {$exception->getMessage()}", 3, __DIR__ . "/../../log/error.log");
        }

        return $this->conn;
    }
}
