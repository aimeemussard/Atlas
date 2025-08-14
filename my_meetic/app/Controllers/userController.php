<?php
require('../Models/user.php');

class UserController {
        public function __construct(){
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $this->route();
                }
        }

        public function login($email, $password){
                $user = new User();
                $salt = $user->getSalt($email);
                $password = MD5($salt[0]['salt'].$password);
                $result = $user->getUser($email, $password);
                $status = $user->getStatus($result[0]['id']);
                if ($status[0]['id_status'] == 0 && count($result) == 1) {
                        $_SESSION['id'] = $result[0]['id'];
                        $_SESSION['email'] = $result[0]['email'];
                        header('Location: http://localhost:8000/app/Views/reactivate.php');
                        exit;
                }elseif ($status[0]['id_status'] == 1 && count($result) == 1) {
                        $picture = $user->getPicture($result[0]['id']);
                        $gender = $user->getGender(null, $result[0]['id']);
                        $hobby = $user->getHobby(null, $result[0]['id']);

                        session_start();
                        $_SESSION['picture'] = $picture[0]['path'];
                        $_SESSION['status'] = $status[0]['id_status'];
                        $_SESSION['gender'] = array($gender);
                        $_SESSION['hobbies'] = array($hobby);
                        $_SESSION['id'] = $result[0]['id'];
                        //$_SESSION['role'] = $result[0]['role'];
                        $_SESSION['fullname'] = $result[0]['fullname'];
                        $_SESSION['firstname'] = $result[0]['firstname'];
                        $_SESSION['lastname'] = $result[0]['lastname'];
                        $_SESSION['hide'] = $result[0]['hide'];
                        $_SESSION['birthdate'] = $result[0]['birthdate'];
                        $_SESSION['bio'] = $result[0]['biography'];
                        $_SESSION['password'] = $result[0]['password'];
                        $_SESSION['email'] = $result[0]['email'];
                        $_SESSION['age'] = $result[0]['age'];
                        $_SESSION['city'] = $result[0]['city'];

                        header('Location: http://localhost:8000/app/Views/account.php');
                        exit;
                } else {
                        header('Location: http://localhost:8000/app/Views/login.php');
                        exit;
                }
        }

        public function activateAccount($password){
                session_start();
                $user = new User();
                $salt = $user->getSalt($_SESSION('email'));
                $password = MD5($salt[0]['salt'].$password);
                $result = $user->getUser($_SESSION('email'), $password);
                if (count($result) == 1) {
                        $user->updateStatus($_SESSION['id'],1);
                        $this->login($_SESSION('email'), $password);
                }
        }

        public function register($firstname, $lastname, $hide_gender, $birthdate, $city, $email, $salt, $password, $gender, $hobby, $country = null) {
                //check if user email already taken in route function ?
                $user = new User();
                $check = $user->getUser($email, $password);
                if(count($check) == 0){
                        $firstname = ucwords(strtolower($firstname), " -\t\r\n\f\v'");
                        $lastname = ucwords(strtolower($lastname), " -\t\r\n\f\v'");
                        $user->setUser($firstname, $lastname, $hide_gender, $birthdate, $city, $country, $email, $salt, MD5($salt.$password));
                        $account = $user->getUser($email, MD5($salt.$password));
                        if (count($account) == 1) {
                                $user->setStatus($account[0]['id'], 1);
                                $user->setGender($account[0]['id'], $gender);
                                $user->setHobby($account[0]['id'], $hobby);
                                // if(count($picture)>0){
                                //         foreach ($picture as $path) {
                                //                 $user->setPicture($account[0]['id'], $path);
                                //         }
                                // }else{
                                //         $user->setPicture($account[0]['id']);
                                // }
                                $this->login($email, $password);
                        }else{
                                header('Location: http://localhost:8000/app/Views/register.php');
                        }
                }else{
                        header('Location: http://localhost:8000/app/Views/login.php');
                }
        }

        //update user infos
        public function updateEmail($newEmail){
                session_start();
                $user = new User();
                $user->updateEmail($newEmail,$_SESSION['id']);
                header('Location: http://localhost:8000/app/Views/account.php');
                exit;
        }

        public function updatePassword($newPassword){
                session_start();
                $user = new User();
                $salt = $this->generateSalt();
                $user->updateSalt($salt, $_SESSION['id']);
                $user->updatePassword(MD5($salt.$newPassword),$_SESSION['id']);
                header('Location: http://localhost:8000/app/Views/account.php');
                        exit;
        }

        //account status
        public function deleteAccount(){
                session_start();
                $user = new User();
                $user->updateStatus($_SESSION['id'], 0);
                $this->logout();
        }

        public function logout(){
                        session_start();
                        session_unset();
                        session_destroy();
                        header('Location: http://localhost:8000/app/Views/login.php');
        }

        //gender
        public function getGender(){
                $user = new User();
                return $user->getGender();
        }

        public function updateGender($newGender){
                session_start();
                $user = new User();
                $id_gender= $user->getGender(null, $_SESSION['id']);
                foreach ($id_gender as $gender) {
                        if (is_null($gender)) {
                                
                        }
                        $user->updateGender($_SESSION['id'], $gender);
                }
                // header('Location: http://localhost:8000/app/Views/account.php');
                // exit;
        }

        //hobbies
        public function getHobbies(){
                $user = new User();
                return $user->getHobby();
        }

        public function updateHobbies($newHobbies){
                session_start();
                $user = new User();
                $hobbies= $user->getHobby();
                $user_hobbies= $user->getHobby(null, $_SESSION['id']);
                foreach ($hobbies as $hobby) {
                        foreach ($newHobbies as $newHobby) {
                        //         foreach ($user_hobbies as $user_hobby) {
                                //                 if ($newHobby != $user_hobby['name']) {
                                        
                                //                 }
                                //         }
                                if($hobby['name'] == $newHobby){
                                        var_dump($newHobby);
                                }
                        }
                         //$user->updateGender($_SESSION['id'], $gender);
                }
                // header('Location: http://localhost:8000/app/Views/account.php');
                // exit;
        }

        public function generateSalt(){
                return bin2hex(random_bytes(16));
        }

        public function sanitize($data){
                if(is_array($data)){
                        for ($i=0; $i < count($data); $i++) { 
                                $data[$i]=trim($data[$i]);
                                $data[$i]=stripslashes($data[$i]);
                                $data[$i]=htmlspecialchars($data[$i]);
                        }
                        return $data;
                }else{
                        $data=trim($data);
                        $data=stripslashes($data);
                        $data=htmlspecialchars($data);
                        return $data;
                }
        }

        public function route(){
                if (isset($_POST['email'], $_POST['password']) && !isset($_POST['firstname'], $_POST['lastname'], $_POST['gender'], $_POST['city'], $_POST['hobby'], $_POST['day'], $_POST['month'], $_POST['year'])) {
                        
                        $password = $this->sanitize($_POST['password']);
                        $email = $this->sanitize($_POST['email']);
                        $this->login($email, $password);

                }elseif(isset($_POST['firstname'], $_POST['lastname'], $_POST['gender'], $_POST['hide_gender'], $_POST['password'], $_POST['email'], $_POST['city'], $_POST['hobby'], $_POST['day'], $_POST['month'], $_POST['year'])){
                        
                        $firstname = $this->sanitize($_POST['firstname']);
                        $lastname = $this->sanitize($_POST['lastname']);
                        $hide_gender = intval($this->sanitize($_POST['hide_gender']));
                        $gender = $this->sanitize($_POST['gender']);
                        $password = $this->sanitize($_POST['password']);
                        $email = $this->sanitize($_POST['email']);
                        $city = $this->sanitize($_POST['city']);
                        $country = $this->sanitize($_POST['country']);
                        $hobby = $this->sanitize($_POST['hobby']);
                        $day = $this->sanitize($_POST['day']);
                        $month = intval($this->sanitize($_POST['month']))+1;
                        $year = $this->sanitize($_POST['year']);
                        $birthdate = "$year-$month-$day";
                        $this->register($firstname, $lastname, $hide_gender, $birthdate, $city, $email, $this->generateSalt(), $password, $gender, $hobby, $country);

                }elseif(isset($_POST['logout']) && !isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['gender'], $_POST['city'], $_POST['hobby'], $_POST['day'], $_POST['month'], $_POST['year'])){
                        $this->logout();
                }elseif (isset($_POST['delete'])) {
                        $this->deleteAccount();
                }elseif(isset($_POST['activationPassword'])){
                        $this->sanitize($_POST['activationPassword']);$this->activateAccount($_POST['activationPassword']);
                }elseif (isset($_POST['update'])) {
                        if(isset($_POST['updateEmail'])){
                                $this->sanitize($_POST['updateEmail']);
                                $this->updateEmail($_POST['updateEmail']);
                        }
                        if(isset($_POST['updatePassword'])){
                                $this->sanitize($_POST['updatePassword']);
                                $this->updatePassword($_POST['updatePassword']);
                        }
                        if(isset($_POST['updateGender'])){
                                $this->sanitize($_POST['updateGender']);
                                $this->updateGender($_POST['updateGender']);
                        }
                        if(isset($_POST['updateHobbies'])){
                                $this->sanitize($_POST['updateHobbies']);
                                $this->updateHobbies($_POST['updateHobbies']);
                        }
                        if(isset($_POST['firstname'], $_POST['lastname'], $_POST['gender'], $_POST['hide_gender'], $_POST['password'], $_POST['email'], $_POST['city'], $_POST['hobby'], $_POST['day'], $_POST['month'], $_POST['year'])){

                        }
                }
        }
}