<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../classes/database.php');
require_once(__DIR__ . '/../classes/admin.php');
require_once(__DIR__ . '/../classes/product.php');

$database= new Database();
$db= $database->getConnection();

$admin= new Admin($db);

$product= new Product($db);
if(!$admin->isLoggedIn())
    {
        header("location:login.php");
        exit;
    }

    //delete request
if(isset($_GET['id'])){
    $id=$_GET['id'];
    if($product->deleteProduct($id)){
        $message="product deleted succesful";
        header("location:productslist.php?message=".urlencode($message));
        exit;
    }

}


?>