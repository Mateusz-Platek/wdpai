<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="public/css/styles-login-register.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Megrim">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="logo">
                <img src="public/images/logo.svg" alt="logo flower">
                <div class="name">Bloom</div>
            </div>
            <div class="inputs">
                <div class="messages">
                    <?php
                    if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <form class="login-form" action="login" method="post">
                    <input name="username" type="text" placeholder="Username">
                    <input name="password" type="password" placeholder="Password">
                    <button class="login-btn" type="submit">Login</button>
                </form>
                <a class="account" href="registerPage">I don't have an account</a>
            </div>
        </div>
    </div>
</body>
</html>