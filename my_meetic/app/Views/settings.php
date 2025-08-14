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
                <aside>
                        <ul>
                                <li>Settings</li>
                                <li>Personnal Informations</li>
                                <li>Account</li>
                        </ul>
                </aside>
                <section class="main-container">
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" id="logout" method="post"></form>
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                                <div id="info">
                                        <div class="form-container">
                                                <div class="input-container">
                                                        <input type="text" placeholder=" " id="updateFirstname" name="updateFirstname"  value="<?= $_SESSION['firstname']?>">
                                                        <label for="updateFirstname">Firstname</label>
                                                </div>
                                                <div class="input-container">
                                                        <input type="text" placeholder=" " id="updateLastname" name="updateLastname" value="<?= $_SESSION['lastname']?>">
                                                        <label for="updateLastname">Lastname</label>
                                                </div>
                                        </div>
                                        <div>
                                                <h2>Birthdate</h2>
                                                <div class="date_picker"></div>
                                        </div>
                                        <div>
                                                <?php
                                                foreach ($_SESSION['gender'] as $array) {
                                                        foreach ($array as $value) {
                                                                echo "<h3>".$value['name']."</h3>";
                                                                //echo "<input type='checkbox' value='".$value['name']."' id='".$value['name']."' name='updateGender[]'><label for='".$value['name']."'>".$value['name']."</label>";
                                                        }
                                                }?>
                                        </div>
                                        <div>
                                                <?php
                                                        $genders = $user->getGender();
                                                        foreach ($genders as $gender) {
                                                                echo "<input type='checkbox' id='".$gender['name']."' name='updateGender[]' value='".$gender['name']."'";
                                                                foreach ($_SESSION['gender'][0] as $userGender) {
                                                                        echo ($userGender['name'] === $gender['name']?'checked':'');
                                                                }
                                                                echo "/><label for='".$gender['name']."'>".$gender['name']."</label>";
                                                        } 
                                                ?>
                                        </div>
                                        <p>Do you wish to keep your gender private ?</p>
                                        <div>
                                                <input type="radio" name="updateHide" id="yes" <?= ($_SESSION['hide']==1?'checked':'') ?>>
                                                <label for="yes">Yes</label>
                                                <input type="radio" name="updateHide" id="no" <?= ($_SESSION['hide']==0?'checked':'') ?>>
                                                <label for="no">No</label>
                                        </div>
                                </div>
                                <div id="account">
                                        <div class="input-container">
                                                <input type="email" name="updateEmail" id="updateEmail" value="<?= $_SESSION['email']?>">
                                                <label for="updateEmail">Email</label>
                                        </div>
                                        <div class="input-container">
                                                <input type="password" placeholder=" " id="updatePassword" name="updatePassword" minlength="8" maxlength="20" size="20" value="<?= $_SESSION['password']?>">
                                                <label for="updatePassword">Password</label>
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
                                        <h2>Are you sure you want to leave ?</h2>
                                        <input type="submit" name="delete" value="Delete account">
                                </div>
                                <input type="submit" name="update" value="Update">
                        </form>
                </section>
        </main>
        <script src="../../public/js/account.js"></script>
</body>
</html>