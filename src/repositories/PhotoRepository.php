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
