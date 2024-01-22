<?php

class FriendshipRepository extends Repository {

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
}