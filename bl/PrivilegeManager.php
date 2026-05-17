<?php 
    require_once "../model/database.php";
    require_once "../model/privilegeModel.php";
    class PrivilegeManager {

        private $privilegeModel;
        public function __construct() 
        {
            $database = new Database();
            $db = $database->connectDB();
            $this->privilegeModel = new PrivilegeModel($db);
        }


        public function getPrivileges() {
        $response = $this->privilegeModel->readPrivilege();
        return $response->fetchAll(PDO::FETCH_ASSOC);
    }
        
    }

?>