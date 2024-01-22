<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "autoloader.php";

class UserController extends AppController {

    public function friends(): void {
        $userRepository = new UserRepository();

        $username = $_SESSION["username"];

        $friends = $userRepository->getUserFriends($username);

        $this->render("friends", ["friends" => $friends]);
    }

    public function removeFriend(): void {
        $userRepository = new UserRepository();
        $friendShipRepository = new FriendshipRepository();

        $username = $_SESSION["username"];

        $user = $userRepository->getUser($username);

        $userID1 = $user->getId();
        $userID2 = $_POST["userID"];

        $friendShipRepository->removeFriendship($userID1, $userID2);

        $this->friends();
    }

    public function addFriend(): void {
        $friendshipRepository = new FriendshipRepository();
        $userRepository = new UserRepository();

        $username = $_SESSION["username"];

        $user = $userRepository->getUser($username);

        $userID1 = $user->getId();
        $userID2 = $_POST["userID"];

        $friendshipRepository->addFriendship($userID1, $userID2);

        $this->search();
    }

    public function acceptFriend(): void {
        $friendshipRepository = new FriendshipRepository();
        $userRepository = new UserRepository();

        $username = $_SESSION["username"];

        $user = $userRepository->getUser($username);

        $userID1 = $user->getId();
        $userID2 = $_POST["userID"];

        $friendshipRepository->acceptFriendship($userID1, $userID2);

        $this->pending();
    }

    public function pending(): void {
        $userRepository = new UserRepository();

        $username = $_SESSION["username"];

        $pendingFriends = $userRepository->getUserPendingFriends($username);

        $this->render("pending", ["pendingFriends" => $pendingFriends]);
    }

    public function search(): void {
        $userRepository = new UserRepository();

        $username = $_SESSION["username"];
        $loggedUser = $userRepository->getUser($username);

        $users = $userRepository->getUsers($username);
        $friends = $userRepository->getUserFriends($username);
        $pendingFriends = $userRepository->getUserPendingFriends($username);
        $usersWithoutFriends = [];

        for ($i = 0; $i < count($users); $i++) {
            $add = true;
            foreach ($friends as $friend) {
                if ($users[$i]->getID() == $friend->getID()) {
                    $add = false;
                }
            }
            foreach ($pendingFriends as $friend) {
                if ($users[$i]->getID() == $friend->getID()) {
                    $add = false;
                }
            }
            if ($add) {
                $usersWithoutFriends[] = $users[$i];
            }
        }

        $this->render("search", [
            "users" => $usersWithoutFriends,
            "friends" => $friends,
            "pendingFriends" => $pendingFriends,
            "type" => $loggedUser->getType()
        ]);
    }

    public function removeUsers(): void {
        $userRepository = new UserRepository();

        $users = $userRepository->getUsers($_SESSION["username"]);

        $this->render("removeUsers", ["users" => $users]);
    }

    public function removeUser(): void {
        $userRepository = new UserRepository();
        $userID = $_POST["userID"];

        $userRepository->removeUser($userID);

        $this->search();
    }
}