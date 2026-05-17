<?php

    class PetModel {

    private $conn;

    public function __construct($db)
        {
            $this -> conn = $db;
        }
    public function getPets($speciesID = null){
    
        $SelectQuery = "SELECT 
                p.petID,
                p.speciesID,
                p.pet_statusID,
                p.petDescription,
                p.picture,
                p.name,
                p.age,
                s.pet_statusDescription
              FROM tbl_pets p
              INNER JOIN tbl_pet_status s 
              ON p.pet_statusID = s.pet_statusID";

    // if filtering by species
    if($speciesID !== null){
        $SelectQuery .= " WHERE p.speciesID = :speciesID";
    }

        $response = $this->conn->prepare($SelectQuery);

    if($speciesID !== null){
        $response->bindParam(":speciesID", $speciesID);
    }

        $response->execute();
        return $response;
    }

    

    }

?>