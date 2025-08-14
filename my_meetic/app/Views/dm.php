<?php
        include '../Controllers/userController.php';
        new UserController();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ship - <?= $_SESSION['firstname']?></title>
        <link rel="icon" type="image/x-icon" href="">
        <link rel="stylesheet" href="../../public/CSS/index.css">
</head>
<body>
        <header>
                <nav>
                        <ul>
                                <li><a href="./search.php">Friends</a></li>
                                <li><a href="./account.php"><?=$_SESSION['firstname']?></a></li>
                                <li><a href="./dm.php"><img src="../../public/assets/Mail.png" alt="Mailbox icon" class="nav-img"></a></li>
                                <li><input form="logout" type="submit" name="logout" value=" " style="display:none;"><img src="../../public/assets/Logout.png" alt="Logout icon" class="nav-img logout"></li>
                        </ul>
                </nav>
        </header>
        <main>
                <aside>

                </aside>
                <section>

                </section>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" id="logout" method="post">
                </form>
        </main>
</body>
</html>