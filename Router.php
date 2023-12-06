<?php

require_once "autoloader.php";

class Router {
    public static array $routes;

    public static function get(string $url, string $controller): void {
        self::$routes[$url] = $controller;
    }

    public static function run(string $url): void {
        $action = explode("/", $url)[0];

        if ($action == "") {
            header("Location: login");
        }

        if (!array_key_exists($action, self::$routes)) {
            exit("Wrong url");
        }

        $controller = self::$routes[$action];
        $object = new $controller;

        $object->$action();
    }
}
