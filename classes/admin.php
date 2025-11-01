<?php
class Admin{
    private $table="admins";
    private $conn;
    private $username="Manish";
    private $password="admin123";

    public function __construct($db)
    {
        $this->conn=$db;
    }

    public function login($username, $password){
        if($username=== $this->username && $password===$this->password)
        {
            $_SESSION['admin_logged_in']=true;
            $_SESSION['username']=$username;

            return true;
        }
        else{
            return false;
        }
    }

    public function isLoggedIn(){
        if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']==true){
            return true;
        }
        else{
            return false;
        }
    }

    public function logout(){
        session_destroy();
        header("Location:login.php");
        exit;
    }
}