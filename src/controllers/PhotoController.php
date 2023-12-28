<?php

require_once "autoloader.php";

class PhotoController extends AppController {

    private const maxFileSize = 1024 * 1024;
    private const supportedTypes = ["image/jpeg", "image/png"];
    private array $messages = [];
    private PhotoRepository $photoRepository;

    public function __construct() {
        parent::__construct();
        $this->photoRepository = new PhotoRepository();
    }

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

            $photo = new Photo(
                $_POST["name"],
                $_FILES["file"]["name"],
                $_POST["description"]
            );
            $this->photoRepository->addPhoto($photo);

            header("Location: garden");
            return;
        }

        $this->render("addPhoto", ["messages" => $this->messages]);
    }

    public function garden(): void {
        $photos = $this->photoRepository->getPhotos();
        $this->render("garden", ["photos" => $photos]);
    }
}