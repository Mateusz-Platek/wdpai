<?php

require_once "autoloader.php";

$path = trim($_SERVER['REQUEST_URI'], "/");
$path = parse_url($path, PHP_URL_PATH);

Router::get("loginPage", "DefaultController");
Router::get("registerPage", "DefaultController");
Router::get("login", "SecurityController");
Router::get("register", "SecurityController");
Router::get("garden", "PhotoController");
Router::get("search", "UserController");
Router::get("friends", "UserController");
Router::get("removeFriend", "UserController");
Router::get("addFriend", "UserController");
Router::get("profile", "DefaultController");
Router::get("addPhoto", "PhotoController");
Router::get("searchPhotos", "PhotoController");
Router::get("logout", "SecurityController");
Router::get("pending", "UserController");
Router::get("acceptFriend", "UserController");

Router::run($path);
