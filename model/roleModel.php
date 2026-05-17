<?php

    class RoleModel {

    private $conn;

    public function __construct($db)
        {
            $this -> conn = $db;
        }


    public function readRole(){
        $selectQuery = "SELECT * FROM tbl_user_roles";
        $response = $this->conn->prepare($selectQuery);
   
        $response->execute();
        return $response;
    }   

    }
?>