<?php

    class UserModel {

    private $conn;

    public function __construct($db)
        {
            $this -> conn = $db;
        }

   public function createUser($roleID, $privilegeID, $fName, $lName, $age, $email, $passWord)
    {
    $insertQuery = "INSERT INTO tbl_users 
        (roleID, privilegeID, firstName, lastName, age, email, passWord, createdAt, updatedAt) 
        VALUES (:roleID, :privilegeID, :firstName, :lastName, :age, :email, :passWord, :createdAt, :updatedAt)";

        $hashPassword = password_hash($passWord, PASSWORD_ARGON2ID);
        //$passwordCheck = password_verify("676767", $hashPassword);

        //$SigninQuery = "SELECT * FROM tbl_users WHERE email = :email";
        //$SigninResponse = $this->conn->prepare($SigninQuery);
        //$SigninResponse->execute();

        //if($SigninResponse){
        //    $passVerify = password_verify($passWord, $SigninResponse);
        //}

        $now = new DateTime("now", new DateTimeZone('Asia/Manila'));
        $dateNow = $now->format('Y-m-d H:i:s');

        $response = $this->conn->prepare($insertQuery);

        $response->bindParam(":roleID", $roleID);
        $response->bindParam(":privilegeID", $privilegeID);
        $response->bindParam(":firstName", $fName);
        $response->bindParam(":lastName", $lName);
        $response->bindParam(":age", $age);
        $response->bindParam(":email", $email);
        $response->bindParam(":passWord", $hashPassword);
        $response->bindParam(":createdAt", $dateNow);
        $response->bindParam(":updatedAt", $dateNow);

        return $response->execute();
    }
    public function readUser(){
        $selectQuery ="SELECT * FROM tbl_users"; 
        $response = $this->conn->prepare($selectQuery);
   
        $response->execute();
        return $response;
    }  
    
    public function readAdvancedUser(){
        $selectQuery = "SELECT 
                    tbl_users.*, 
                    tbl_user_roles.roleDescription,
                    tbl_user_privilege.privilegeDescription
                FROM tbl_users
                INNER JOIN tbl_user_roles 
                    ON tbl_users.roleID = tbl_user_roles.roleID
                INNER JOIN tbl_user_privilege 
                    ON tbl_users.privilegeID = tbl_user_privilege.privilegeID"; //pinagsama ung data from one table to another
        $response = $this->conn->prepare($selectQuery);
   
        $response->execute();
        return $response;
    }

    }


?>