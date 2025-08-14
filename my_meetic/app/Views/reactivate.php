<?php
        include '../Controllers/userController.php';
        new UserController();
        session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Friends - Login</title>
        <link rel="icon" type="image/x-icon" href="">
        <link rel="stylesheet" href="../../public/CSS/index.css">
</head>
<body>
        <header>
                <nav>
                        <ul>
                                <li><a href="./index.php">Friends</a></li>
                                <li><a href="./register.php">Register</a></li>
                        </ul>
                </nav>
        </header>
        <main class="main-container">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                        <div class="input-container">
                                <h1>Your account has been disabled, please enter your password again if you siwh to retrieve your account:</h1>
                                <input type="password" placeholder=" " id="password" name="activationPassword" minlength="8" maxlength="20" size="20" autocomplete="off">
                                <label for="password">Password</label>
                        </div>
                        <div id="forgot-password-container">
                                <a href="./login.html">Forgotten password?</a>
                        </div>
                        <input type="submit" value="Login">
                </form>
        </main>
</body>
</html>