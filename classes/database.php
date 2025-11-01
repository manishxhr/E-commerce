<?php
class Database{
    private $host="localhost";
    private $user="root";
    private $password="";
    private $dbname="e-commerce";
    private $conn;

    public function __construct()
    {
        try{
            $this->conn= new PDO("mysql:host=$this->host; dbname=$this->dbname",$this->user,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "database connected";
        }

        catch(PDOException $e){
            echo "connection failed".$e->getMessage();
        }
    }
    public function getConnection(){
        return $this->conn;
    }
}

// $database= new Database();
// $db= $database->getConnection();

?>