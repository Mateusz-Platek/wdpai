<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "autoloader.php";

class UserController extends AppController {

    public function friends(): void {
        $userRepository = new UserRepository();

        $username = $_SESSION["username"];

        $friends = $userRepository->getUserFriends($username);

        $this->render("friends", ["friends" => $friends]);
    }
}