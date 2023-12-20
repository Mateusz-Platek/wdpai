<?php

require_once "autoloader.php";

class PhotoController extends AppController {

    private const maxFileSize = 1024 * 1024;
    private const supportedTypes = ["image/jpeg", "image/png"];
    private array $messages = [];

    private function validate(array $file): bool {
        if ($file["size"] > self::maxFileSize) {
            $this->messages[] = "File is to large";
            return false;
        }

        if (!isset($file["type"]) && !in_array($file["type"], self::supportedTypes)) {
            $this->messages[] = "File type is not supported";
            return false;
        }

        return true;
    }

    public function addPhoto(): void {
        if ($this->isPost() && is_uploaded_file($_FILES["file"]["tmp_name"]) && $this->validate($_FILES["file"])) {
            move_uploaded_file($_FILES["file"]["tmp_name"], "public/uploads/" . $_FILES["file"]["name"]);

            $this->render("garden");
            return;
        }

        $this->render("addPhoto", ["messages" => $this->messages]);
    }
}