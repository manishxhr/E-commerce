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

// Handle form request
$message = '';
if($_SERVER['REQUEST_METHOD'] === "POST"){

    $productName = filter_var($_POST['name']);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_var($_POST['description']);
    $status = filter_var($_POST['status']);

    // Handle image upload (optional)
    $imageName = null; // default to null
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
        $uploadDir = '../uploads/';
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
    }

    if($product->createProduct($productName, $price, $description, $imageName, $status)){
        header('Location: dashboard.php');
        exit;
    } else {
        $message = "Product creation failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Product</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .navbar { background-color: #000 !important; padding: 0.6rem 2rem; }
    .navbar-brand { color: #fff !important; font-weight: 600; font-size: 1.3rem; }
    .admin-info { color: #fff; margin-right: 15px; font-weight: 500; }
    .btn-logout, .btn-back { border-radius: 20px; padding: 6px 18px; margin-left: 5px; }
    .form-container {
      max-width: 500px;
      margin: 3rem auto;
      padding: 2rem;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }
    .form-container h2 { margin-bottom: 1.5rem; font-weight: 600; text-align: center; }
    .form-control { border-radius: 10px; margin-bottom: 1rem; }
    .btn-submit { border-radius: 30px; padding: 8px 20px; }
    .message { text-align: center; margin-bottom: 1rem; color: red; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Thrift Shop</a>
    <div class="d-flex align-items-center ms-auto">
      <span class="admin-info">Hello, <?php echo htmlspecialchars($name); ?></span>
      <a href="dashboard.php" class="btn btn-primary btn-back">Go Back</a>
      <form method="get" class="mb-0">
        <button name="logout" class="btn btn-danger btn-logout">Logout</button>
      </form>
    </div>
  </div>
</nav>

<!-- Form -->
<div class="form-container">
    <h2>Create New Product</h2>
    <?php if($message) echo "<div class='message'>$message</div>"; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="name" class="form-control" placeholder="Product Name" required>
        <input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required>
        <textarea name="description" class="form-control" placeholder="Description" rows="3" required></textarea>
        <input type="file" name="image" class="form-control">
        <select name="status" class="form-control" required>
            <option value="">Select Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <button type="submit" class="btn btn-success btn-submit w-100 mt-2">Create Product</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
