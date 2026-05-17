<?php 
    require_once "../model/database.php";
    require_once "../model/petModel.php";
    class PetManager {

        private $petModel;
        public function __construct() 
        {
            $database = new Database();
            $db = $database->connectDB();
            $this->petModel = new PetModel($db);
        }

        public function getPets($speciesID = null){
            $response = $this->petModel->getPets($speciesID);
            return $response->fetchAll(PDO::FETCH_ASSOC);
        }

    }

?>