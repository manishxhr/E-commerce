<?php
class User{
    private $table="users";
    private $conn;

    public function __construct($db){
        $this->conn=$db;
    }
    
    public function register($name,$email,$password){
        $sql="insert into $this->table (name,email,password) VALUES(:name, :email, :password)";
        $stmt=$this->conn->prepare($sql);
        $hashedPass= password_hash($password,PASSWORD_DEFAULT);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$hashedPass);
        return $stmt->execute();
    }

    public function loginUser($email,$password){
        $sql="select * from $this->table where email=:email";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $user= $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password,$user['password']))
            {
                return $user;
            }
        return false;
    }

    public function getUserById($id){
        $sql="select * from $this->table where id=:id";
        $stmt= $this->conn->prepare($sql);
        $stmt->bondParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isLoggedIn(){
        if(isset($_session['name']) && isset($_session['name'])===true){
            return true;
        }
        else{
            return false;
        }
    }
}

?>