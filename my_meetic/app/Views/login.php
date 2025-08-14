<?php
        include '../Controllers/userController.php';
        $login = new UserController();
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
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" onsubmit="validateLogin()">
                        <h1>Login</h1>
                        <div class="input-container">
                                <input type="email" id="email" name="email" placeholder=" ">
                                <label for="email">Email</label>
                        </div>
                        <div class="input-container">
                                <input type="password" placeholder=" " id="password" name="password" minlength="8" maxlength="20" size="20" autocomplete="off">
                                <label for="password">Password</label>
                                <h2>Password must contain:</h2>
                                <ul>
                                        <li>At least 8 characters </li>
                                        <li>Maximum 20 characters</li>
                                        <li>At least one digit (0-9)</li>
                                        <li>At least one special character</li>
                                        <li>At least one lowercase character (a-z)</li>
                                        <li>At least one uppercase character (A-Z)</li>
                                </ul>
                        </div>
                        <div id="forgot-password-container">
                                <a href="./login.html">Forgotten password?</a>
                        </div>
                        <input type="submit" value="Login">
                        <div id="subscribe-container">
                                <p>Not a member yet ? <a href="./register.php">Sign up now</a></p>
                        </div>
                </form>
        </main>
        <script src="../../public/js/validation.js"></script>
</body>
</html>