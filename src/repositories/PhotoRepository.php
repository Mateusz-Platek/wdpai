<?php

class PhotoRepository extends Repository {

    public function getPhoto(int $id): ?Photo {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM dockerdb.public.photos WHERE dockerdb.public.photos."photoID" = :id'
        );
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $photo = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$photo) {
            return null;
        }

        return new Photo(
            $photo["photosID"],
            $photo["name"],
            $photo["path"],
            $photo["description"]
        );
    }

    public function getPhotoByName(string $name): array
    {
        $searchName = '%' .strtolower($name). '%';

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM dockerdb.public.photos WHERE LOWER(photos.name) LIKE :search OR LOWER(photos.description) LIKE :search'
        );
        $statement->bindParam(":search", $searchName, PDO::PARAM_STR);
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
                $photo["photosID"],
                $photo["name"],
                $photo["path"],
                $photo["description"]
            );
        }

        return $result;
    }


    public function addPhoto(Photo $photo): void {
        $statement = $this->database->connect()->prepare(
            'INSERT INTO photos (name, path, "usersID", description) VALUES (?, ?, ?, ?)'
        );

        $userRepository = new UserRepository();
        $user = $userRepository->getUser($_SESSION["username"]);
        $userID = $user->getId();

        $statement->execute([
            $photo->getName(),
            $photo->getPath(),
            $userID,
            $photo->getDescription()
        ]);
    }
}
