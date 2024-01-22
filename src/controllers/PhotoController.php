<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    echo 'error';
    exit();
}

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
        $photoRepository = new PhotoRepository();

        if ($this->isPost() && is_uploaded_file($_FILES["file"]["tmp_name"]) && $this->validate($_FILES["file"])) {
            move_uploaded_file($_FILES["file"]["tmp_name"], "public/uploads/" . $_FILES["file"]["name"]);

            $photo = new Photo(
                1,
                $_POST["name"],
                $_FILES["file"]["name"],
                $_POST["description"]
            );
            $photoRepository->addPhoto($photo);

            header("Location: garden");
            return;
        }

        $this->render("addPhoto", ["messages" => $this->messages]);
    }

    public function userPhotos(): void {
        $photoRepository = new PhotoRepository();

        $username = $_POST["username"];

        $userPhotos = $photoRepository->getUserPhotos($username);

        $this->render("userPhotos", ["userPhotos" => $userPhotos, "username" => $username]);
    }

    public function garden(): void {
        $photoRepository = new PhotoRepository();

        $photos = $photoRepository->getUserPhotos($_SESSION["username"]);

        $this->render("garden", ["photos" => $photos]);
    }

    public function searchPhotos(): void {
        $photoRepository = new PhotoRepository();
        $userRepository = new UserRepository();

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : "";

        $user = $userRepository->getUser($_SESSION["username"]);

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header("Content-type: application/json");
            http_response_code(200);

            echo json_encode($photoRepository->getPhotosByName($decoded["search"], $user->getId()));
        }
    }
}