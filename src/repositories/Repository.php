<?php

require_once "autoloader.php";

class Repository {

    protected Database $database;

    public function __construct() {
        $this->database = new Database();
    }
}
