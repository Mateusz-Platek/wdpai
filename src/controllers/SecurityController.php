<?php

require_once "autoloader.php";

class SecurityController extends AppController {

    public function login() : void {
        $user = new User("jkowal", "jkowal@abc.com", "pass");

        if (!$this->isPost()) {
            $this->render("login");
            return;
        }

        $username = $_POST["username"];
        $password = $_POST["password"];

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