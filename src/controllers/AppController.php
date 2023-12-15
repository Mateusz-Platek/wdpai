<?php

require_once "autoloader.php";

class AppController {

    private string $request;

    public function __construct(){
        $this->request = $_SERVER["REQUEST_METHOD"];
    }

    protected function isGet(): bool {
        return $this->request == "GET";
    }

    protected function isPost(): bool {
        return $this->request == "POST";
    }

    protected function render(string $name = null, array $variables = []): void {
        $path = "public/views/" . $name . ".php";

        if (file_exists($path)) {
            extract($variables);
            include $path;
        }
    }
}
