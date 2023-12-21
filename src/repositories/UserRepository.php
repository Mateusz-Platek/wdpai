<?php

require_once "autoloader.php";

class UserRepository extends Repository {

    public function getUser(string $username): ?User {
        $statement = $this->database->connect()->prepare('SELECT * FROM "Users" WHERE "Username" = :username');
        $statement->bindParam(":username", $username);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return null;
        }

        return new User(
            $user["Username"],
            $user["Email"],
            $user["Password"]);
    }
}
