<?php 

    class Database {
        private $host ="localhost";
        private $dbName = "furryup_db";
        private $username = "root";
        private $password = "";
        private $port = 3307;

        public function connectDB() {
            try{
                $conn = new PDO(
                "mysql:host=$this->host;port=$this->port;dbname=$this->dbName",
            $this->username,
            $this->password
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            return $conn;

        }
        catch(PDOException $e){
            echo "Connection failed " . $e -> getMessage();
        }
    }
}

?>