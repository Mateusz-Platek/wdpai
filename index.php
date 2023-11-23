
<?php

require_once "autoloader.php";

$path = trim($_SERVER['REQUEST_URI'], "/");
$path = parse_url($path, PHP_URL_PATH);

Router::get("login", "DefaultController");
Router::get("register", "DefaultController");
Router::get("garden", "DefaultController");
Router::get("search", "DefaultController");
Router::get("friends", "DefaultController");
Router::get("profile", "DefaultController");
Router::run($path);
