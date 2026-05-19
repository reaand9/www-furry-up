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

    public function cardPetSpecies(){
        $selectQuery = "SELECT s.speciesDescription, COUNT(p.petID) AS total_pets FROM tbl_species s LEFT JOIN tbl_pets p ON s.speciesID = p.speciesID GROUP BY s.speciesID, s.speciesDescription ORDER BY s.speciesID;";
        $response = $this->conn->prepare($selectQuery);
        $response->execute();
        return $response;
    }

    public function cardPetAge(){
        $selectQuery = "SELECT CONCAT(age, ' year(s)') AS pet_age, COUNT(petID) AS total_pets FROM tbl_pets GROUP BY age ORDER BY age;";
        $response = $this->conn->prepare($selectQuery);
        $response->execute();
        return $response;
    }

    public function cardUserAgeGroup(){
        $selectQuery = "SELECT CASE WHEN age < 18 THEN 'Under 18' WHEN age BETWEEN 18 AND 25 THEN '18-25' WHEN age BETWEEN 26 AND 35 THEN '26-35' WHEN age BETWEEN 36 AND 50 THEN '36-50' ELSE '51+' END AS age_group, COUNT(userID) AS total_users FROM tbl_users GROUP BY age_group ORDER BY MIN(age);";
        $response = $this->conn->prepare($selectQuery);
        $response->execute();
        return $response;
    }

    public function cardUserPrivilege(){
        $selectQuery = "SELECT p.privilegeDescription, COUNT(u.userID) AS total_users FROM tbl_user_privilege p LEFT JOIN tbl_users u ON p.privilegeID = u.privilegeID GROUP BY p.privilegeID, p.privilegeDescription ORDER BY p.privilegeID;";
        $response = $this->conn->prepare($selectQuery);
        $response->execute();
        return $response;
    }

}


?>