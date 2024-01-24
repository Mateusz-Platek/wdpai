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
    <link rel="stylesheet" type="text/css" href="public/css/styles-users.css">
    <link rel="stylesheet" type="text/css" href="public/css/styles-topbar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Megrim">
    <script type="text/javascript" src="public/javascript/search-remove-user.js" defer></script>
    <title>Remove users</title>
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
                <div class="option">
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
        <div class="top-name">Remove users</div>
        <div class="top-bar">
            <div class="search-bar single">
                <input name="search" type="text" placeholder="Search">
                <button><img src="public/images/search.svg" alt="search icon"></button>
            </div>
        </div>
        <div class="people">
            <?php foreach ($users as $user): ?>
            <div class="person">
                <div class="name"><?= $user->getUsername() ?></div>
                <form method="post" action="removeUser">
                    <input type="hidden" name="userID" value=<?= $user->getID() ?>>
                    <button type="submit">Delete</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
<template class="user-template">
    <div class="person">
        <div class="name">name</div>
        <form method="post" action="removeUser">
            <input type="hidden" name="userID" value="">
            <button type="submit">Delete</button>
        </form>
    </div>
</template>
</html>