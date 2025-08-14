<?php
Class Search {
        
        private $pdo;
        
        public function __construct(){
                include_once '../Config/bdd.php';
                $database = new Bdd();
                $this->pdo = $database->connection();
        }

        public function getAllUsers($id_user){
                $query = $this->pdo->prepare("SELECT user.id As 'id', user.biography AS 'biography', CONCAT(user.firstname, ' ', user.lastname) AS 'fullname', user.firstname AS 'firstname', user.lastname AS 'lastname', TIMESTAMPDIFF(YEAR, user.birthdate, NOW()) AS 'age', user.city AS 'city', user.hide_gender AS 'hide' FROM user WHERE user.id != :id_user");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->execute();
                return $query->fetchAll();
        }

        public function getUsersByAge($id_user, $age){
                $firstAge = explode('/', $age)[0];
                $secondAge = explode('/', $age)[1];
                $query = $this->pdo->prepare("SELECT user.id As 'id', user.biography AS 'biography', CONCAT(user.firstname, ' ', user.lastname) AS 'fullname', user.firstname AS 'firstname', user.lastname AS 'lastname', TIMESTAMPDIFF(YEAR, user.birthdate, NOW()) AS 'age', user.city AS 'city', user.hide_gender AS 'hide' FROM user WHERE user.id != :id_user AND user.age BETWEEN(:firstAge, :secondAge)");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':firstAge', $firstAge, PDO::PARAM_INT);
                $query->bindParam(':secondAge', $secondAge, PDO::PARAM_INT);
                $query->execute();
                return $query->fetchAll();
        }

        public function getUsersByCity($id_user, $city){
                $query = $this->pdo->prepare("SELECT user.id As 'id', user.biography AS 'biography', CONCAT(user.firstname, ' ', user.lastname) AS 'fullname', user.firstname AS 'firstname', user.lastname AS 'lastname', TIMESTAMPDIFF(YEAR, user.birthdate, NOW()) AS 'age', user.city AS 'city', user.hide_gender AS 'hide' FROM user WHERE user.id != :id_user AND user.city = :city");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':city', $city, PDO::PARAM_STR);
                $query->execute();
                return $query->fetchAll();
        }

        public function getUsersByGender($id_user, $gender){
                $query = $this->pdo->prepare("SELECT user.id As 'id', user.biography AS 'biography', CONCAT(user.firstname, ' ', user.lastname) AS 'fullname', user.firstname AS 'firstname', user.lastname AS 'lastname', TIMESTAMPDIFF(YEAR, user.birthdate, NOW()) AS 'age', user.city AS 'city', user.hide_gender AS 'hide' FROM user WHERE user.id != :id_user AND user.gender = :gender");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                $query->execute();
                return $query->fetchAll();
        }

        public function getUsersByHobby($id_user, $hobby){
                $query = $this->pdo->prepare("SELECT user.id As 'id', user.biography AS 'biography', CONCAT(user.firstname, ' ', user.lastname) AS 'fullname', user.firstname AS 'firstname', user.lastname AS 'lastname', TIMESTAMPDIFF(YEAR, user.birthdate, NOW()) AS 'age', user.city AS 'city', user.hide_gender AS 'hide' FROM user WHERE user.id != :id_user AND user.hobb = :gender");
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                $query->execute();
                return $query->fetchAll();
        }
}