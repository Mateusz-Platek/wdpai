
<?php

require_once "autoloader.php";

class AppController {

    protected function render(string $name = null): void {
        $path = "public/views/" . $name . ".html";
        include $path;
    }
}
