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
    <script type="text/javascript" src="public/javascript/script.js" defer></script>
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="inputs">
                <div class="name">Bloom</div>
                <div class="messages">
                    <?php
                    if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <form class="register-form" action="register" method="post">
                    <input name="username" type="text" placeholder="Username">
                    <input name="email" type="email" placeholder="Email@email.com">
                    <input name="password" type="password" placeholder="Password">
                    <input name="confirmPassword" type="password" placeholder="Confirm Password">
                    <button class="login-btn" type="submit">Register</button>
                </form>
                <a class="account" href="loginPage">I have an account</a>
            </div>
        </div>
    </div>
</body>
</html>