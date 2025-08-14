<?php
        require '../Controllers/userController.php';
        $user = new userController();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Friends - Register</title>
        <link rel="icon" type="image/x-icon" href="">
        <link rel="stylesheet" href="../../public/CSS/index.css">
</head>
<body>
        <header>
                <nav>
                        <ul>
                                <li><a href="./index.php">Friends</a></li>
                                <li><a href="./login.php">Login</a></li>
                        </ul>
                </nav>
        </header>
        <main class="main-container">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <h1>Register</h1>
                        <div>
                                <h2>Enter your name</h2>
                                <div class="form-container">
                                        <div class="input-container">
                                                <input type="text" placeholder=" " id="firstname" name="firstname" autocomplete="off">
                                                <label for="firstname">Firstname</label>
                                        </div>
                                        <div class="input-container">
                                                <input type="text" placeholder=" " id="lastname" name="lastname" autocomplete="off">
                                                <label for="lastname">Lastname</label>
                                        </div>
                                </div>
                        </div>
                        <div>
                                <h2>Fill in your email</h2>
                                <div class="input-container">
                                        <input type="email" id="email" name="email" placeholder=" ">
                                        <label for="email">Email</label>
                                </div>
                        </div>
                        <div>
                                <h2>Choose a password</h2>
                                <div class="input-container">
                                        <input type="password" placeholder=" " id="password" name="password" minlength="8" maxlength="20" size="20" autocomplete="off">
                                        <label for="password">Password</label>
                                        <h3>Password must contain:</h3>
                                        <ul>
                                                <li>At least 8 characters </li>
                                                <li>Maximum 20 characters</li>
                                                <li>At least one digit (0-9)</li>
                                                <li>At least one special character</li>
                                                <li>At least one lowercase character (a-z)</li>
                                                <li>At least one uppercase character (A-Z)</li>
                                        </ul>
                                </div>
                        </div>
                        <div>
                                <h2>Pick a profile picture</h2>
                                <div>
                                        <label for="file-upload" class="file-upload">Add a profile picture</label>
                                        <input type="file" id="file-upload" name="picture" accept="image/png, image/jpeg" />
                                </div>
                        </div>
                        <div>
                                <h2>Which gender best describe you ?</h2>
                                <div>
                                        <?php 
                                                $genders = $user->getGender();
                                                foreach ($genders as $gender) {
                                                        echo "<input type='checkbox' id='".$gender['name']."' name='gender[]' value='".$gender['name']."'/>
                                                        <label for='".$gender['name']."'>".$gender['name']."</label>";
                                                }
                                        ?>
                                        <h3>Do you wish to keep your gender private ?</h3>
                                        <input type="radio" name="hide_gender" value=1 id="yes">
                                        <label for="yes">Yes</label>
                                        <input type="radio" name="hide_gender" value=0 id="no" checked>
                                        <label for="no">No</label>
                                </div>
                        </div>
                        <div>
                                <h2>Fill in your birthdate</h2>
                                <div class="date_picker"></div>
                                <h3>You must be 18 years old.</h3>
                        </div>
                        <div>
                                <h2>Describe yourself...</h2>
                                <textarea name="biography" id=""></textarea>
                        </div>
                        <div>
                                <h2>What is your location ?</h2>
                                <div class="form-container">
                                        <div class="input-container">
                                                <input type="text" id="city" name="city" placeholder=" ">
                                                <label for="city">City</label>
                                        </div>
                                        <div class="input-container">
                                                <input type="text" id="country" name="country" placeholder=" ">
                                                <label for="country">Country</label>
                                        </div>
                                </div>
                        </div>
                        <div>
                                <h2>Pick at least one hobby</h2>
                                <div>
                                        <?php 
                                        $hobbies = $user->getHobbies();
                                        foreach ($hobbies as $hobby) {
                                                echo "<input type='checkbox' id='".$hobby['name']."' name='hobby[]' value='".$hobby['name']."'/>
                                                <label for='".$hobby['name']."'>".$hobby['name']."</label>";
                                        }
                                        ?>
                                </div>
                        </div>
                        <input type="submit" value="Register">
                </form>
        </main>
        <script src="../../public/js/validation.js"></script>
</body>
</html>