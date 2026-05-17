<?php 
    require_once "../model/database.php";
    require_once "../model/roleModel.php";
    class RoleManager {

        private $roleModel;
        public function __construct() 
        {
            $database = new Database();
            $db = $database->connectDB();
            $this->roleModel = new RoleModel($db);
        }
        public function getRoles(){
            $response = $this->roleModel->readRole();
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }

    }

?>