<?php

spl_autoload_register(function (string $className): bool {
    $fileName = $className . ".php";

    if (!file_exists($fileName)) {
        return false;
    }

    require_once $fileName;
    return true;
});

spl_autoload_register(function (string $className): bool {
    $fileName = "src/controllers/" . $className . ".php";

    if (!file_exists($fileName)) {
        return false;
    }

    require_once $fileName;
    return true;
});

spl_autoload_register(function (string $className): bool {
    $fileName = "src/models/" . $className . ".php";

    if (!file_exists($fileName)) {
        return false;
    }

    require_once $fileName;
    return true;
});
