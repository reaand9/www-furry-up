<?php 
    require_once "../model/database.php";
    require_once "../model/userModel.php";
    
    class UserManager {

        private $userModel;
        public function __construct() 
        {
            $database = new Database();
            $db = $database->connectDB();
            $this->userModel = new UserModel($db);
        }

        public function addUserFunc($roleID, $privilegeID, $firstName, $lastName, $age, $email, $passWord){
            try{
                return $this->userModel->createUser($roleID, $privilegeID, $firstName, $lastName, $age, $email, $passWord);
            }
            catch(PDOException $ex){
                error_log('UserManager addUserFunc error: ' . $ex->getMessage());
                return false;
            }
        }


        public function getUser(){
            $response = $this->userModel->readUser();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAdvancedUser(){
            $response = $this->userModel->readAdvancedUser();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function signinUserFunc($email, $passWord) {
            
            $users = $this->getAdvancedUser(); // IMPORTANT (must include privilege)

            foreach ($users as $user) {
                if ($user["email"] === $email && password_verify($passWord, $user["passWord"])){

                    $_SESSION["userID"] = $user["userID"];
                    $_SESSION["email"] = $user["email"];
                    $_SESSION["privilegeID"] = $user["privilegeID"];

                    echo $user["privilegeID"]; 
                    exit;
            }
        }

        echo "Invalid credentials.";
        exit;
        }
    

    }

?>