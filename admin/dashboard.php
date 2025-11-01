<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../classes/database.php');
require_once(__DIR__ . '/../classes/admin.php');
require_once(__DIR__ . '/../classes/product.php');

$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);
$product = new Product($db);

// Redirect to login if not logged in
if (!$admin->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$name = isset($_SESSION['username']) ? $_SESSION['username'] : "Admin";

// Logout
if(isset($_GET['logout'])){
    $admin->logout();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar {
      background-color: #000 !important;
      padding: 0.6rem 2rem;
    }
    .navbar-brand {
      color: #fff !important;
      font-weight: 600;
      font-size: 1.3rem;
    }
    .admin-info {
      color: #fff;
      margin-right: 10px;
      font-weight: 500;
    }
    .btn-logout, .btn-create {
      border-radius: 20px;
      padding: 6px 18px;
      margin-left: 5px;
    }
    .dashboard-content {
      margin-top: 2rem;
    }
    .card-dashboard {
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
      padding: 2rem;
      text-align: center;
    }
    .card-dashboard:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    .card-title {
      font-weight: 600;
      font-size: 1.2rem;
      margin-bottom: 1rem;
    }
    .card-value {
      font-size: 2rem;
      font-weight: 700;
      color: #198754;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Thrift Shop</a>
    <div class="d-flex align-items-center ms-auto">
      <span class="admin-info">Hello, <?php echo htmlspecialchars($name); ?></span>
      <a href="createproduct.php" class="btn btn-primary btn-create">Create New Product</a>
      <form method="get" class="mb-0">
        <button name="logout" class="btn btn-danger btn-logout">Logout</button>
      </form>
    </div>
  </div>
</nav>

<!-- Dashboard Cards -->
<div class="container dashboard-content">
  <div class="row g-4">
    <div class="col-md-4 col-sm-6">
      <div class="card card-dashboard">
        <div class="card-title">Total Products</div>
        <div class="card-value"><?php echo count($product->allProducts()); ?></div>
        <a href="productslist.php" class="btn btn-success btn-sm mt-3">View</a>
      </div>
    </div>
    <!-- <div class="col-md-4 col-sm-6">
      <div class="card card-dashboard">
        <div class="card-title">Orders</div>
        <div class="card-value">78</div>
        <a href="#" class="btn btn-success btn-sm mt-3">View</a>
      </div>
    </div> -->
    <div class="col-md-4 col-sm-6">
      <div class="card card-dashboard">
        <div class="card-title">Users</div>
        <div class="card-value">120</div>
        <a href="#" class="btn btn-success btn-sm mt-3">View</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
