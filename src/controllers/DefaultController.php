<?php

require_once "autoloader.php";

class DefaultController extends AppController {

    public function loginPage(): void {
        $this->render("login");
    }

    public function registerPage(): void {
        $this->render("register");
    }

    public function search(): void {
        $this->render("search");
    }

    public function friends(): void {
        $this->render("friends");
    }

    public function profile(): void {
        $this->render("profile");
    }
}
