<?php

require_once "autoloader.php";

session_start();

class SecurityController extends AppController {

    public function loginPage(): void {
        $this->render("login");
    }

    public function registerPage(): void {
        $this->render("register");
    }

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

        if (!password_verify($password, $user->getPassword())) {
            $this->render("login", ["messages" => ["Wrong password"]]);
            return;
        }

        $_SESSION["username"] = $username;

        header("Location: garden");
    }

    public function register(): void {
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            $this->render("register");
            return;
        }

        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $userRepository->getUser($username);
        if ($user) {
            $this->render("register", ["messages" => ["User exists"]]);
            return;
        }

        $userRepository->addUser($username, $email, $password);

        $_SESSION["username"] = $username;

        header("Location: garden");
    }

    public function logout(): void {
        if (session_destroy()) {
            header("Location: loginPage");
        }
    }
}