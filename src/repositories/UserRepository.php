<?php

require_once "autoloader.php";

class UserRepository extends Repository {

    public function getUser(string $username): ?User {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM users WHERE users.username = :username'
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

    public function addUser(string $username, string $email, string $password): void {
        $statement = $this->database->connect()->prepare(
            'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)'
        );

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $statement->bindParam(":username", $username);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":password", $hashedPassword);
        $statement->execute();
    }
}
