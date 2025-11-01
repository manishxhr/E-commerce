<?php
class Product{
    private $table="products";
    private $conn;

    public function __construct($db)
    {
        $this->conn=$db;
    }

    public function allProducts(){
        $sql="select * from $this->table";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id){
        $sql="select * from $this->table where id=:id";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


?>