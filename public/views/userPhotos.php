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
    <link rel="stylesheet" type="text/css" href="public/css/styles-topbar.css">
    <link rel="stylesheet" type="text/css" href="public/css/styles-photos.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Megrim">
    <title>Profile</title>
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
        <div class="top-name"><?= $username ?> photos</div>
        <div class="photos">
            <?php foreach ($userPhotos as $userPhoto): ?>
            <div class="photo">
                <img src="public/uploads/<?= $userPhoto->getPath(); ?>" alt="photo">
                <div>
                    <div class="name"><?= $userPhoto->getName(); ?></div>
                    <div class="description"><?= $userPhoto->getDescription(); ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>