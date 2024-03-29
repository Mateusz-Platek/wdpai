<?php

class PhotoRepository extends Repository {

    public function getPhotosByName(string $name, int $userID): array {
        $searchName = '%' . strtolower($name) . '%';

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM photos WHERE photos."usersID" = :userID AND (LOWER(photos.name) LIKE :search OR LOWER(photos.description) LIKE :search)'
        );
        $statement->bindParam(":search", $searchName);
        $statement->bindParam(":userID", $userID);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserPhotos(string $username): array {
        $result = [];

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM photos JOIN users ON photos."usersID" = users."userID" WHERE users.username = :username'
        );
        $statement->bindParam(":username", $username);
        $statement->execute();

        $photos = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($photos as $photo) {
            $result[] = new Photo(
                $photo["photoID"],
                $photo["name"],
                $photo["path"],
                $photo["description"]
            );
        }

        return $result;
    }


    public function addPhoto(Photo $photo): void {
        $userRepository = new UserRepository();
        $user = $userRepository->getUser($_SESSION["username"]);
        $userID = $user->getId();

        $name = $photo->getName();
        $path = $photo->getPath();
        $desc = $photo->getDescription();

        $statement = $this->database->connect()->prepare(
            'INSERT INTO photos (name, path, "usersID", description)
                    VALUES (:name, :path, :userID, :desc)'
        );

        $statement->bindParam(":name", $name);
        $statement->bindParam(":path", $path);
        $statement->bindParam(":userID", $userID);
        $statement->bindParam(":desc", $desc);
        $statement->execute();
    }
}
