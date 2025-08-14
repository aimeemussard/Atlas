<?php
        include '../Controllers/userController.php';
        $user = new UserController();
        session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Friends - <?= $_SESSION['firstname']?></title>
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
                <section class="main-div-container">
                        <img src="<?= $_SESSION['picture']?>" alt="Profile picture" class="profile-picture">
                        <div>
                                <div>
                                        <h1><?= $_SESSION['fullname']?></h1>
                                        <a href="./settings.php"><img class='nav-img' src="../../public/assets/Settings.png" alt="Settings icon"></a>
                                </div>
                                <div>
                                        <?php foreach ($_SESSION['gender'] as $array) {
                                                foreach ($array as $value) {
                                                        echo "<h2>".$value['name']."</h2>  ";
                                                }
                                        }?><h2><?= $_SESSION['age']?></h2>
                                </div>
                                <div>
                                        <h3><?= $_SESSION['city']?></h3>
                                </div>
                        </div>
                </section>
                <section>
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" id="logout" method="post"></form>
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                                <textarea name="biography" id=""><?= (is_null($_SESSION['bio'])?'Describe yourself :)':$_SESSION['bio'])?></textarea>
                                <div>
                                <?php
                                $hobbies = $user->getHobbies();
                                foreach ($hobbies as $hobby) {
                                        echo "<input type='checkbox' id='".$hobby['name']."' name='updateHobbies[]' value='".$hobby['name']."'";
                                        foreach ($_SESSION['hobbies'][0] as $userHobby) {
                                                echo ($userHobby['name'] === $hobby['name']?'checked':'');
                                        }
                                        echo "/><label for='".$hobby['name']."'>".$hobby['name']."</label>";
                                }
                                ?>
                                <input type="submit" name='update' value="Update">
                        </form>
                </section>
        </main>
        <script src="../../public/js/account.js"></script>
</body>
</html>