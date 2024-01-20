<?php

require_once "autoloader.php";

class UserRepository extends Repository {

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

    public function getUsers(string $username): ?array {
        $result = [];

        $userRepository = new UserRepository();

        $loggedUser = $userRepository->getUser($username);

        $user = $this->getUser($username);
        $userID = $user->getId();

        $statement = $this->database->connect()->prepare(
            'SELECT * FROM users JOIN "accountTypes" ON users."accountTypeID" = "accountTypes"."accountTypeID"'
        );
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            if ($user["userID"] == $loggedUser->getId()) {
                continue;
            }

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

    public function addFriendship(int $userID1, int $userID2): void {
        $connection = $this->database->connect();
        try {
            $connection->beginTransaction();

            $statement1 = $connection->prepare(
                'INSERT INTO friendships ("userID1", "userID2") VALUES (:userID1, :userID2)'
            );
            $statement1->bindParam(":userID1", $userID1);
            $statement1->bindParam(":userID2", $userID2);
            $statement1->execute();

            $statement2 = $connection->prepare(
                'INSERT INTO friendships ("userID1", "userID2") VALUES (:userID2, :userID1)'
            );
            $statement2->bindParam(":userID1", $userID1);
            $statement2->bindParam(":userID2", $userID2);
            $statement2->execute();

            $connection->commit();
        } catch (Exception $e) {
            $connection->rollBack();
            var_dump($e->getMessage());
        }
    }

    public function acceptFriendship(int $userID1, int $userID2): void {
        $connection = $this->database->connect();
        try {
            $connection->beginTransaction();

            $statement1 = $connection->prepare(
                'UPDATE friendships SET "friendshipStatuesID" = 2 WHERE friendships."userID1" = :userID1 AND friendships."userID2" = :userID2'
            );
            $statement1->bindParam(":userID1", $userID1);
            $statement1->bindParam(":userID2", $userID2);
            $statement1->execute();

            $statement2 = $connection->prepare(
                'UPDATE friendships SET "friendshipStatuesID" = 2 WHERE friendships."userID1" = :userID2 AND friendships."userID2" = :userID1'
            );
            $statement2->bindParam(":userID1", $userID1);
            $statement2->bindParam(":userID2", $userID2);
            $statement2->execute();

            $connection->commit();
        } catch (Exception $e) {
            $connection->rollBack();
            var_dump($e->getMessage());
        }
    }

    public function removeFriendship(int $userID1, int $userID2): void {
        $connection = $this->database->connect();
        try {
            $connection->beginTransaction();

            $statement1 = $connection->prepare(
                'DELETE FROM friendships WHERE "userID1" = :userID1 AND "userID2" = :userID2'
            );
            $statement1->bindParam(":userID1", $userID1);
            $statement1->bindParam(":userID2", $userID2);
            $statement1->execute();

            $statement2 = $connection->prepare(
                'DELETE FROM friendships WHERE "userID1" = :userID2 AND "userID2" = :userID1'
            );
            $statement2->bindParam(":userID1", $userID1);
            $statement2->bindParam(":userID2", $userID2);
            $statement2->execute();

            $connection->commit();
        } catch (Exception $e) {
            $connection->rollBack();
            var_dump($e->getMessage());
        }
    }

    public function getUserFriends(string $username): ?array {
        $result = [];

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

    public function getUserPendingFriends(string $username): ?array {
        $result = [];

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
