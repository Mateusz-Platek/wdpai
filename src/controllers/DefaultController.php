
<?php

require_once "autoloader.php";

class DefaultController extends AppController {

    public function login(): void {
        $this->render("login");
    }

    public function register(): void {
        $this->render("register");
    }

    public function garden(): void {
        $this->render("garden");
    }

    public function addPlant(): void {
        $this->render("addPlant");
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
