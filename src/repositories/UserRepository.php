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
            $user["userID"],
            $user["username"],
            $user["email"],
            $user["password"]
        );
    }

    public function getUserFriends(string $username): array {
        $result = [];

        $user = $this->getUser($username);
        $userID = $user->getId();

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM friendships JOIN users ON friendships."userID2" = users."userID" WHERE friendships."userID1" = :userID'
        );

        $statement->bindParam(":userID", $userID);
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            $result[] = new User(
                $user["userID"],
                $user["username"],
                $user["email"],
                $user["password"]
            );
        }

        return $result;
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
