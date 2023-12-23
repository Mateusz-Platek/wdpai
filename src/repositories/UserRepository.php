<?php

require_once "autoloader.php";

class UserRepository extends Repository {

    public function getUser(string $username): ?User {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM dockerdb.public.users WHERE dockerdb.public.users.username = :username'
        );
        $statement->bindParam(":username", $username);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return null;
        }

        return new User(
            $user["username"],
            $user["email"],
            $user["password"]);
    }
}
