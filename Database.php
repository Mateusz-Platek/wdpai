<?php

require_once "autoloader.php";

class Database {

    private string $username;
    private string $password;
    private string $host;
    private string $database;

    public function __construct() {
        $this->username = config::username;
        $this->password = config::password;
        $this->host = config::host;
        $this->database = config::database;
    }

    public function connect(): PDO {
        $connection = new PDO(
            "pgsql:host=$this->host;port=5432;dbname=$this->database",
            $this->username,
            $this->password
        );
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
}