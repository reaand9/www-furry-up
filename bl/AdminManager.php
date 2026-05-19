<?php 
    require_once "../model/database.php";
    require_once "../model/adminModel.php";
    class AdminManager {

        private $adminModel;
        public function __construct() 
        {
            $database = new Database();
            $db = $database->connectDB();
            $this->adminModel = new AdminModel($db);
        }


        public function getUser(){
            $response = $this->adminModel->readUser();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAdvancedUser(){
            $response = $this->adminModel->readAdvancedUser();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }

        public function updateUserFunc($userID, $firstName, $lastName, $age, $email, $passWord) {
            try{
                if($this->adminModel->updateUser($userID, $firstName, $lastName, $age, $email, $passWord)) {
                    echo "User has been updated";
                }
                else{
                    echo "Error is encountered while updating a value to the database";
                }           
            }
            catch(PDOException $ex){
                http_response_code(501);
                echo $ex -> getMessage();
                exit;
            }
        }

        public function deleteUserFunc($userID){
            try{
                if($this->adminModel->deleteUser($userID)) {
                    echo "User has been deleted";
                }
                else{
                    echo "Error is encountered while deleting a value to the database";
                }           
            }
            catch(PDOException $ex){
                http_response_code(501);
                echo $ex -> getMessage();
                exit;
            }
        }

        public function getRoleCard(){
            $response = $this->adminModel->cardRoles();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getPetStatusCard(){
            $response = $this->adminModel->cardPetStatus();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getPetSpeciesCard(){
            $response = $this->adminModel->cardPetSpecies();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getPetAgeCard(){
            $response = $this->adminModel->cardPetAge();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getUserAgeGroupCard(){
            $response = $this->adminModel->cardUserAgeGroup();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getUserPrivilegeCard(){
            $response = $this->adminModel->cardUserPrivilege();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }
    

    }

?>