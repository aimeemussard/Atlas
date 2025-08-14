<?php
Class User {
        
        private $pdo;
        
        public function __construct(){
                include_once '../Config/bdd.php';
                $database = new Bdd();
                $this->pdo = $database->connection();
        }

        //ADD, UPDATE AND GET ACCOUNT STATUS: 1 OR 0
        public function getStatus($id_user){
                $query = $this->pdo->prepare("SELECT status.id AS 'id_status' FROM status INNER JOIN user_status ON status.id = user_status.id_status INNER JOIN user ON user_status.id_user = user.id WHERE user.id = :id_user;");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->execute();
                return $query->fetchAll();
        }

        public function setStatus($id_user, $status){
                $query = $this->pdo->prepare("INSERT INTO user_status (id_user, id_status) VALUES (:id_user, :status)");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':status', $status, PDO::PARAM_INT);
                $query->execute();
        }

        public function updateStatus($id_user, $id_status){
                $query = $this->pdo->prepare("UPDATE user_status SET id_status = :id_status WHERE id_user = :id_user");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':id_status', $id_status, PDO::PARAM_INT);
                $query->execute();
        }

        //ADD, UPDATE, GET USER INFO
        public function getUser($email, $password){
                $query = $this->pdo->prepare("SELECT user.id As 'id', user.biography AS 'biography', user.email AS 'email', CONCAT(user.firstname, ' ', user.lastname) AS 'fullname', user.firstname AS 'firstname', user.lastname AS 'lastname', TIMESTAMPDIFF(YEAR, user.birthdate, NOW()) AS 'age', DATE_FORMAT(user.birthdate, '%d-%m-%Y') AS 'birthdate', user.city AS 'city', user.password AS 'password', user.hide_gender AS 'hide' FROM user WHERE email = :email AND password = :password");
                $query->execute([':email' => $email, ':password' => $password]);
                return $query->fetchAll();
        }

        public function setUser($firstname, $lastname, $hide_gender, $birthdate, $city, $country=null, $email, $salt, $password){
                $query = $this->pdo->prepare("INSERT INTO user (firstname, lastname, hide_gender,birthdate, city, country, email, salt_password, password ) VALUES (:fname, :lname, :hide_gender, DATE_FORMAT(:birthdate, '%Y-%m-%d'), :city, :country, :email, :salt, :password)");
                $query->execute([
                        ':fname' => $firstname, 
                        ':lname' => $lastname, 
                        ':hide_gender' => $hide_gender, 
                        ':birthdate' => $birthdate, 
                        ':email' => $email, 
                        ':password' => $password, 
                        ':salt' => $salt, 
                        ':city' => $city,
                        ':country' => (is_null($country)?'NULL':$country)
                ]);
        }

        //UPDATE user info

        public function updateUser($id_user, $firstname, $lastname, $birthdate, $city, $hide){
                $query = $this->pdo->prepare("UPDATE user SET (firstname, lastname, birthdate, city, hide_gender) = (:firstname, :lastname, DATE_FORMAT(:birthdate, '%Y-%m-%d'), :city, :hide_gender) WHERE id_user = $id_user");
                $query->execute([
                        ':firstname' => $firstname, 
                        ':lastname' => $lastname, 
                        ':hide_gender' => $hide, 
                        ':birthdate' => $birthdate,
                        ':city' => $city
                ]);
        }

        public function updateEmail($newEmail, $id_user){
                $query = $this->pdo->prepare("UPDATE user SET email = :email WHERE id_user = :id_user");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':email', $newEmail, PDO::PARAM_STR);
                $query->execute();
        }


        public function updatePassword($newPassword, $id_user){
                $query = $this->pdo->prepare("UPDATE user SET password = :password WHERE id_user = :id_user");
                $query->bindParam(':password', $newPassword, PDO::PARAM_STR);
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->execute();
        }

        //ADD, UPDATE AND GET PPicture
        public function getPicture($id_user = null, $path = null, $id_picture = null){
                if (isset($path) && !isset($id_picture, $id_user)) {
                        $query = $this->pdo->prepare("SELECT * FROM pictures WHERE pictures.path LIKE :path;");
                        $query->bindParam(':path', $path, PDO::PARAM_STR);
                }elseif(!isset($path, $id_user) && isset($id_picture)){
                        $query = $this->pdo->prepare("SELECT * FROM pictures WHERE pictures.id = :id_picture;");
                        $query->bindParam(':id_picture', $id_picture, PDO::PARAM_INT);
                }else{
                        $query = $this->pdo->prepare("SELECT pictures.path AS 'path' FROM pictures INNER JOIN user_pictures ON pictures.id = user_pictures.id_picture INNER JOIN user ON user_pictures.id_user = user.id WHERE user.id = :id_user;");
                        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                }
                $query->execute();
                return $query->fetchAll();
        }

        public function setPicture($id_user, $path = null){
                if (isset($path)) {
                        //ajouter condition si tableau ? ex sélections multiples de photo
                        $query = $this->pdo->prepare("INSERT INTO pictures (path) VALUES (:path)");
                        $query->bindParam(':path', $path, PDO::PARAM_INT);
                        $query->execute();
                        $query = $this->pdo->prepare("INSERT INTO user_pictures (id_user, id_picture) VALUES (:id_user, ".$this->getPicture(null, $path).")");
                        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        $query->execute();
                }else{
                        $query = $this->pdo->prepare("INSERT INTO user_pictures (id_user, id_picture) VALUES (:id_user, 1)");
                        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        $query->execute();
                }
        }

        public function updatePicture(){

        }

        //ADD, UPDATE AND GET HOBBIES
        public function getHobby($name = null, $id_user=null){
                if(!isset($name) &&  isset($id_user)){
                        $query = $this->pdo->prepare("SELECT hobby.name AS 'name', hobby.id AS 'id' FROM hobby INNER JOIN user_hobby ON hobby.id = user_hobby.id_hobby INNER JOIN user ON user_hobby.id_user = user.id WHERE user.id = :id_user;");
                        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                }elseif(isset($name) && !isset($id_user)){
                        $query = $this->pdo->prepare("SELECT hobby.name AS 'name', hobby.id AS 'id' FROM hobby WHERE hobby.name LIKE :name;");
                        $query->bindParam(':name', $name, PDO::PARAM_STR);
                }else{
                        $query = $this->pdo->prepare("SELECT hobby.name AS 'name', hobby.id AS 'id' FROM hobby;");
                }
                $query->execute();
                return $query->fetchAll();
        }

        public function setHobby($id_user, $hobby){
                for ($i=0; $i < count($hobby); $i++) { 
                        $query = $this->pdo->prepare("INSERT INTO user_hobby (id_user, id_hobby) VALUES (:id, ".($this->getHobby($hobby[$i]))[0]['id'].")");
                        $query->bindParam(':id', $id_user, PDO::PARAM_INT);
                        $query->execute();
                }
        }

        public function updateHobby($id_user, $id_hobby){
                $query = $this->pdo->prepare("UPDATE user_hobby SET id_hobby = :id_hobby WHERE id_user = :id_user AND id_hobby = null");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':id_hobby', $id_hobby, PDO::PARAM_INT);
                $query->execute();
        }

        public function deleteHobby($id_user, $id_hobby){
                $query = $this->pdo->prepare("UPDATE user_hobby SET id_hobby = null WHERE id_user = :id_user AND id_hobby = :id_hobby");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':id_hobby', $id_hobby, PDO::PARAM_INT);
                $query->execute();
        }

        //ADD, UPDATE AND GET GENDER
        public function getGender($name=null, $id_user=null){
                if(!isset($name) && isset($id_user)){
                        $query = $this->pdo->prepare("SELECT gender.name AS 'name', gender.id AS 'id' FROM gender INNER JOIN user_gender ON gender.id = user_gender.id_gender INNER JOIN user ON user_gender.id_user = user.id WHERE user.id = :id_user;");
                        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                }elseif(isset($name) && !isset($id_user)){
                        $query = $this->pdo->prepare("SELECT gender.name AS 'name', gender.id AS 'id' FROM gender WHERE gender.name LIKE :name;");
                        $query->bindParam(':name', $name, PDO::PARAM_STR);
                }else{
                        $query = $this->pdo->prepare("SELECT gender.name AS 'name', gender.id AS 'id' FROM gender");
                }
                $query->execute();
                return $result = $query->fetchAll();
        }

        public function setGender($id, $gender){
                for ($i=0; $i < count($gender); $i++) { 
                        $query = $this->pdo->prepare("INSERT INTO user_gender (id_user, id_gender) VALUES (:id, ".($this->getGender($gender[$i]))[0]['id'].")");
                        $query->bindParam(':id', $id, PDO::PARAM_INT);
                        $query->execute();
                }
        }

        public function updateGender($id_user, $id_gender){
                $query = $this->pdo->prepare("UPDATE user_gender SET id_gender = $id_gender WHERE id_user = $id_user AND id_gender = null");
                $query->execute();
        }

        public function deleteGender($id_user, $id_gender){
                $query = $this->pdo->prepare("UPDATE user_gender SET id_gender = null WHERE id_user = $id_user AND id_gender = $id_gender");
                $query->execute();
        }

        //GET SALT
        public function getSalt($email){
                $query = $this->pdo->prepare("SELECT user.salt_password AS 'salt' FROM user WHERE email = :email");
                $query->execute([':email' => $email]);
                return $query->fetchAll();
        }

        public function updateSalt($newSalt, $id_user){
                $query = $this->pdo->prepare("UPDATE user SET salt_password = $newSalt WHERE id_user = $id_user");
                $query->execute();
        }
}