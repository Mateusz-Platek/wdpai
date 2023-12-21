<?php

require_once "autoloader.php";

class SecurityController extends AppController {

    public function login() : void {
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            $this->render("login");
            return;
        }

        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = $userRepository->getUser($username);
        if (!$user) {
            $this->render("login", ["messages" => ["User doesn't exists"]]);
        }

        if ($user->getUsername() !== $username) {
            $this->render("login", ["messages" => ["User with this username doesn't exists"]]);
            return;
        }

        if ($user->getPassword() !== $password) {
            $this->render("login", ["messages" => ["Wrong password"]]);
            return;
        }

        header("Location: garden");
    }
}