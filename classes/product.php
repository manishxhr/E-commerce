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

    public function createProduct($name,$price,$description,$image,$status){
        $sql="insert into $this->table (name, price, description, image, status) VALUES (:name, :price, :description, :image, :status)";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':image',$image);
        $stmt->bindParam(':status',$status);

        return $stmt->execute();
    }
    
    public function deleteProduct($id){
        $sql="delete from $this->table where id= :id";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }

    public function updateProduct($id,$name,$price,$description,$image,$status){
        $sql="update $this->table SET name=:name, price=:price, price=:price, description=:description, image=:image, status=:status WHERE id=:id";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':image',$image);
        $stmt->bindParam(':status',$status);
        return $stmt->execute();
    }
}


?>