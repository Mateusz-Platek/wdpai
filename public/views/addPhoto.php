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
    <link rel="stylesheet" type="text/css" href="public/css/styles-addPhoto.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Megrim">
    <title>Add Photo</title>
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
            <div class="title">Upload your photo</div>
            <div class="messages">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <form class="upload-form" action="addPhoto" method="post" enctype="multipart/form-data">
                <input name="name" type="text" placeholder="Name">
                <textarea name="description" placeholder="Description" rows="10"></textarea>
                <input name="file" type="file" id="file" accept="image/jpeg, image/png">
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>
</body>
</html>