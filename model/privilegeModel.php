<?php

    class PrivilegeModel {

    private $conn;

    public function __construct($db)
        {
            $this -> conn = $db;
        }

    public function readPrivilege() {
        $selectQuery = "SELECT * FROM tbl_user_privilege";
        $response = $this->conn->prepare($selectQuery);

        $response->execute();
        return $response;
    }

    }


?>