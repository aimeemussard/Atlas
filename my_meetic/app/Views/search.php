<?php
        include '../Controllers/userController.php';
        include '../Controllers/searchController.php';
        $user = new UserController();
        $search = new SearchController();
        session_start()
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
                <h1></h1>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" id="logout" method="post">
                </form>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <img src="" alt="Filter icon">
                        <div>
                                <select name="searchGender" id="">
                                        <option value="" selected>Gender</option>
                                <?php 
                                        $genders = $user->getGender();
                                        foreach ($genders as $gender) {
                                                echo "<option value='".$gender['name']."'>".$gender['name']."</option>";
                                        }
                                ?>
                                </select>
                                <?php 
                                $hobbies = $user->getHobbies();
                                foreach ($hobbies as $hobby) {
                                        echo "<input type='checkbox' id='".$hobby['name']."' name='searchHobby[]' value='".$hobby['name']."'/>
                                        <label for='".$hobby['name']."'>".$hobby['name']."</label>";
                                }
                                ?>
                                <div class="input-container">
                                                <input type="text" id="city" name="searchCity" placeholder=" ">
                                                <label for="city">City</label>
                                        </div>
                                <select name="searchAge">
                                        <option value="" selected>Age</option>
                                        <option value="18/25">18/25</option>
                                        <option value="25/35">25/35</option>
                                        <option value="35/45">35/45</option>
                                        <option value="45+">45+</option>
                                </select>
                                <input type="submit" value="Search">
                        </div>
                </form>
                <section>
                        <?php 
                        foreach ($variable as $key => $value) {
                                
                        }
                        ?>
                </section>
        </main>
</body>
</html>