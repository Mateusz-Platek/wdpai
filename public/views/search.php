<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    header("Location: loginPage");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="public/css/styles-sidebar.css">
    <link rel="stylesheet" type="text/css" href="public/css/styles-friends-search.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Megrim">
    <title>Search</title>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="name">Bloom</div>
        <div class="options">
            <a href="garden">
                <div class="option">
                    <img src="public/images/garden.svg" alt="garden icon">
                    <div>Garden</div>
                </div>
            </a>
            <a href="search">
                <div class="option active">
                    <img src="public/images/search.svg" alt="search icon">
                    <div>Search</div>
                </div>
            </a>
            <a href="friends">
                <div class="option">
                    <img src="public/images/friends.svg" alt="friends icon">
                    <div>Friends</div>
                </div>
            </a>
            <a href="profile">
                <div class="option">
                    <img src="public/images/profile.svg" alt="profile icon">
                    <div>Profile</div>
                </div>
            </a>
            <a href="logout">
                <div class="option">
                    <img src="public/images/logout.svg" alt="logout icon">
                    <div>Logout</div>
                </div>
            </a>
        </div>
    </div>
    <div class="main">
        <form class="search-bar">
            <input name="search" type="text" placeholder="Search">
            <button type="submit"><img src="public/images/search.svg" alt="search icon"></button>
        </form>
        <div class="people">
            <?php foreach ($users as $user): ?>
                <div class="person">
                    <div><?= $user->getUsername() ?></div>
                    <form method="post" action="addFriend">
                        <input type="hidden" name="userID" value=<?= $user->getID() ?>>
                        <button type="submit">Add</button>
                    </form>
                    <?php if ($user->getType() != "admin" && $type == "admin") {
                        echo '<form method="post" action="removeUser">
                            <input type="hidden" name="userID" value=' . $user->getID() . '>
                            <button type="submit">Delete</button>
                            </form>';
                    } ?>
                </div>
            <?php endforeach; ?>
            <?php foreach ($friends as $friend): ?>
                <div class="person">
                    <div><?= $friend->getUsername() ?></div>
                    <button type="submit" class="added">Added</button>
                    <?php if ($friend->getType() != "admin" && $type == "admin") {
                        echo '<form method="post" action="removeUser">
                            <input type="hidden" name="userID" value=' . $friend->getID() . '>
                            <button type="submit">Delete</button>
                            </form>';
                    } ?>
                </div>
            <?php endforeach; ?>
            <?php foreach ($pendingFriends as $pendingFriend): ?>
                <div class="person">
                    <div><?= $pendingFriend->getUsername() ?></div>
                    <button type="submit" class="added">Pending</button>
                    <?php if ($pendingFriend->getType() != "admin" && $type == "admin") {
                        echo '<form method="post" action="removeUser">
                            <input type="hidden" name="userID" value=' . $pendingFriend->getID() . '>
                            <button type="submit">Delete</button>
                            </form>';
                    } ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>