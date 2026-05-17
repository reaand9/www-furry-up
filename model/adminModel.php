<?php

    class AdminModel {

    private $conn;

    public function __construct($db)
        {
            $this -> conn = $db;
        }

    public function createAdminUser($roleID, $privilegeID, $fName, $lName, $age, $email, $passWord){
        $insertQuery = "INSERT INTO tbl_users 
                (roleID, privilegeID, firstName, lastName, age, email, passWord, createdAt, updatedAt) 
                VALUES (:roleID, :privilegeID, :firstName, :lastName, :age, :email, :passWord, :createdAt, :updatedAt)";

        $hashPassword = password_hash($passWord, PASSWORD_ARGON2ID);
        
        $now = new DateTime("now", new DateTimeZone('Asia/Manila'));
        $dateNow = ('Y-m-d H:i:s');

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

    public function updateUser($uID, $fName, $lName, $age, $email, $passWord){
        $updateQuery = "UPDATE tbl_users 
                        SET firstName = :firstName,
                            lastName = :lastName,
                            age = :age,
                            email = :email,
                            passWord = :passWord,
                            updatedAt = :updatedAt
                        WHERE userID = :userID";
        $response = $this->conn->prepare($updateQuery);

        $now = new DateTime("now", new DateTimeZone('Asia/Manila'));
        $dateNow = $now->format('Y-m-d H:i:s');
        $response->bindParam(":userID", $uID);
        $response->bindParam(":firstName", $fName);
        $response->bindParam(":lastName", $lName);
        $response->bindParam(":age", $age);
        $response->bindParam(":email", $email);
        $response->bindParam(":passWord", $passWord);
        $response->bindParam(":updatedAt", $dateNow);

        $response -> execute();
        return $response;
    }
    public function deleteUser($uID){
        $deleteQuery = "DELETE FROM tbl_users WHERE userID = :userID";
        $response = $this->conn->prepare($deleteQuery);

        $response->bindParam(":userID", $uID);

        $response->execute();
        return $response;
    }

    public function cardRoles(){
        $selectQuery = "SELECT r.roleDescription, COUNT(u.userID) AS total_users FROM tbl_user_roles r LEFT JOIN tbl_users u ON r.roleID = u.roleID GROUP BY r.roleDescription;";
        $response = $this->conn->prepare($selectQuery);
        $response->execute();
        return $response;
    }

    public function cardPetStatus(){
        $selectQuery = "SELECT p.pet_statusDescription, COUNT(l.petID) AS total_pets FROM tbl_pet_status p LEFT JOIN tbl_pets l ON p.pet_statusID = l.pet_statusID GROUP BY p.pet_statusDescription;";
        $response = $this->conn->prepare($selectQuery);
        $response->execute();
        return $response;
    }

}


?>