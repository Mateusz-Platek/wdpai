<?php

class PhotoRepository extends Repository {

    public function getPhoto(int $id): ?Photo {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM dockerdb.public.photos WHERE dockerdb.public.photos."photosID" = :id'
        );
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $photo = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$photo) {
            return null;
        }

        return new Photo(
            $photo["name"],
            $photo["path"],
            $photo["description"]);
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

    public function getPhotos(): array {
        $result = [];

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM dockerdb.public.photos'
        );
        $statement->execute();

        $photos = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($photos as $photo) {
            $result[] = new Photo(
                $photo["name"],
                $photo["path"],
                $photo["description"]
            );
        }

        return $result;
    }

    public function addPhoto(Photo $photo): void {
        $statement = $this->database->connect()->prepare(
            'INSERT INTO dockerdb.public.photos (name, path, "usersID", description) VALUES (?, ?, ?, ?)'
        );

        $userID = 1;

        $statement->execute([
            $photo->getName(),
            $photo->getPath(),
            $userID,
            $photo->getDescription()
        ]);
    }
}
