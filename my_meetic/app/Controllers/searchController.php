<?php
require('../Models/search.php');

class SearchController {
        public function __construct(){
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $this->route();
                }
                $this->getAllUsers();
        }

        public function getAllUsers(){
                session_start();
                $search = new Search($_SESSION['id']);
                return $search->getAllUsers();
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

        }
}