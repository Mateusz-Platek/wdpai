<?php

require_once "autoloader.php";

class UserRepository extends Repository {

    private function createUsers(array $users): array {
        $result = [];
        
        foreach ($users as $user) {
            $result[] = new User(
                $user["userID"],
                $user["username"],
                $user["email"],
                $user["password"],
                $user["type"]
            );
        }

        return $result;
    }

    public function getUser(string $username): ?User {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM users JOIN "accountTypes" ON users."accountTypeID" = "accountTypes"."accountTypeID" WHERE users.username = :username'
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
            $user["password"],
            $user["type"]
        );
    }

    public function getFriendsByName(string $name, int $userID): array {
        $searchName = '%' . strtolower($name) . '%';

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM friendships JOIN users ON friendships."userID2" = users."userID"
                    WHERE friendships."userID1" = :userID AND friendships."friendshipStatuesID" = 2 AND LOWER(users.username) LIKE :search'
        );
        $statement->bindParam(":userID", $userID);
        $statement->bindParam(":search", $searchName);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsersByName(string $name, int $userID): array {
        $searchName = '%' . strtolower($name) . '%';

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM users WHERE users."userID" != :userID AND users.username LIKE :search'
        );
        $statement->bindParam(":userID", $userID);
        $statement->bindParam(":search", $searchName);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsers(string $username): ?array {
        $user = $this->getUser($username);
        $userID = $user->getId();

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM users JOIN "accountTypes" ON users."accountTypeID" = "accountTypes"."accountTypeID"
                    WHERE users."userID" != :userID'
        );
        $statement->bindParam("userID", $userID);
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->createUsers($users);
    }

    public function getUserFriends(string $username): ?array {
        $user = $this->getUser($username);
        $userID = $user->getId();

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM friendships JOIN users ON friendships."userID2" = users."userID" 
                    JOIN "accountTypes" ON users."accountTypeID" = "accountTypes"."accountTypeID" 
                    WHERE friendships."userID1" = :userID AND friendships."friendshipStatuesID" = 2'
        );
        $statement->bindParam(":userID", $userID);
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $this->createUsers($users);
    }

    public function getUsersWithoutFriendsByName(string $name, int $userID): ?array {
        $searchName = '%' . strtolower($name) . '%';

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM users WHERE users."userID" != :userID AND users."userID"
                    NOT IN (SELECT "userID2" FROM friendships WHERE friendships."userID1" = :userID)
                    AND users.username LIKE :search'
        );
        $statement->bindParam(":userID", $userID);
        $statement->bindParam(":search", $searchName);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserPendingFriends(string $username): ?array {
        $user = $this->getUser($username);
        $userID = $user->getId();

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM friendships JOIN users ON friendships."userID2" = users."userID" 
                    JOIN "accountTypes" ON users."accountTypeID" = "accountTypes"."accountTypeID" 
                    WHERE friendships."userID1" = :userID AND friendships."friendshipStatuesID" = 1'
        );
        $statement->bindParam(":userID", $userID);
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $this->createUsers($users);
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

    public function removeUser(int $userID): void {
        $statement = $this->database->connect()->prepare(
            'DELETE FROM users WHERE users."userID" = :userID'
        );
        $statement->bindParam(":userID", $userID);
        $statement->execute();
    }
}
