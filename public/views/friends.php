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
    <title>Garden</title>
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
                <div class="option">
                    <img src="public/images/search.svg" alt="search icon">
                    <div>Search</div>
                </div>
            </a>
            <a href="friends">
                <div class="option active">
                    <img src="public/images/friends.svg" alt="friends icon">
                    <div>Friends</div>
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
        <div class="top-bar">
            <form class="search-bar">
                <input name="search" type="text" placeholder="Search">
                <button type="submit"><img src="public/images/search.svg" alt="search icon"></button>
            </form>
            <a href="pending">
                <div class="add-photo">
                    <img src="public/images/profile.svg" alt="add icon">
                    <div>Pending</div>
                </div>
            </a>
        </div>
        <div class="people">
            <?php foreach ($friends as $friend): ?>
                <div class="person">
                    <div class="name"><?= $friend->getUsername() ?></div>
                    <form method="post" action="userPhotos">
                        <input type="hidden" name="username" value=<?= $friend->getUsername() ?>>
                        <button type="submit">View photos</button>
                    </form>
                    <form method="post" action="removeFriend">
                        <input type="hidden" name="userID" value=<?= $friend->getID() ?>>
                        <button type="submit">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>