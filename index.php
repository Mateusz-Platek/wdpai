<?php

require_once "autoloader.php";

$path = trim($_SERVER['REQUEST_URI'], "/");
$path = parse_url($path, PHP_URL_PATH);

Router::get("loginPage", "SecurityController");
Router::get("registerPage", "SecurityController");
Router::get("login", "SecurityController");
Router::get("register", "SecurityController");
Router::get("garden", "PhotoController");
Router::get("search", "UserController");
Router::get("friends", "UserController");
Router::get("removeFriend", "UserController");
Router::get("addFriend", "UserController");
Router::get("addPhoto", "PhotoController");
Router::get("searchUsersWithoutFriends", "UserController");
Router::get("searchPhotos", "PhotoController");
Router::get("logout", "SecurityController");
Router::get("pending", "UserController");
Router::get("acceptFriend", "UserController");
Router::get("removeUser", "UserController");
Router::get("userPhotos", "PhotoController");
Router::get("searchFriends", "UserController");
Router::get("removeUsers", "UserController");
Router::get("searchUsers", "UserController");

Router::run($path);
