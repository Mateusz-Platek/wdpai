<?php

require_once "autoloader.php";

$path = trim($_SERVER['REQUEST_URI'], "/");
$path = parse_url($path, PHP_URL_PATH);

Router::get("loginPage", "DefaultController");
Router::get("registerPage", "DefaultController");
Router::get("login", "SecurityController");
Router::get("register", "SecurityController");
Router::get("garden", "PhotoController");
Router::get("search", "DefaultController");
Router::get("friends", "DefaultController");
Router::get("profile", "DefaultController");
Router::get("addPhoto", "PhotoController");
Router::get("searchPhotos", "PhotoController");
Router::get("logout", "SecurityController");

Router::run($path);
