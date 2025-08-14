<?php

class Bdd{
        private $dsn;
        private $username;
        private $password;

        public function __construct(){
                $this->dsn = 'mysql:dbname=friends;host=127.0.0.1';
                $this->username = 'aimee';
                $this->password = 'aim&aims2';
        }

        public function connection(){
                try {
                        return new PDO($this->dsn, $this->username, $this->password);
                } catch (Exception $e) {
                        echo $e->getMessage();
                }
        }
}
