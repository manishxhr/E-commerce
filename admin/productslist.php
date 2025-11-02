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
$productObj = new Product($db);

if(!$admin->isLoggedIn()){
   header("Location: login.php"); 
   exit;
}

//handle search product
if(isset($_GET['query']) && !empty(trim($_GET['query']))){
    $keyword=trim($_GET['query']);
    $products= $productObj->searchProduct($keyword);
}
else{

    $products = $productObj->allProducts();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #000 !important;
            padding: 0.8rem 2rem;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .nav-link {
            color: #ddd !important;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #fff !important;
        }
        .search-bar {
            max-width: 450px;
            margin: 0 auto;
        }
        .btn-cart {
            color: #fff;
            border: 1px solid #fff;
            border-radius: 20px;
            padding: 5px 15px;
            transition: all 0.3s ease;
        }
        .btn-cart:hover {
            background-color: #fff;
            color: #000;
        }
        .container {
            margin-top: 3rem;
        }
        table {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th {
            background-color: #000;
            color: #fff;
            text-align: center;
        }
        td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-action {
            border-radius: 20px;
            padding: 4px 12px;
            margin: 2px;
        }
        img.product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<!-- 🔹 NAVBAR START -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Thrift Store,  Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link active" href="productslist.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="createproduct.php">Add Product</a></li>
      </ul>

      <form class="d-flex search-bar" method="get">
        <input class="form-control me-2" type="search" name="query" placeholder="Search products..." aria-label="Search">
        <button class="btn btn-light" type="submit">Search</button>
      </form>

      <!-- <div class="d-flex">
        <a href="logout.php" class="btn btn-cart ms-3">Logout</a>
      </div> -->
    </div>
  </div>
</nav>
<!-- 🔹 NAVBAR END -->

<div class="container">
    <h2 class="text-center mb-4 fw-bold">All Products</h2>
    <?php if(isset($message)) echo "<p class='text-success text-center fw-semibold'>$message</p>"; ?>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>DESCRIPTION</th>
                    <th>IMAGE</th>
                    <th>STATUS</th>
                    <th colspan="2">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($products)) : ?>
                    <?php foreach($products as $product) : ?>
                    <tr>
                        <td><?= htmlspecialchars($product['id']); ?></td>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td>₹<?= htmlspecialchars($product['price']); ?></td>
                        <td><?= htmlspecialchars($product['description']); ?></td>
                        <td>
                            <?php if($product['image']): ?>
                                <img src="../uploads/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-img">
                            <?php else: ?>
                                <span class="text-muted">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= ucfirst(htmlspecialchars($product['status'])); ?></td>
                        <td>
                            <a href="editproduct.php?id=<?= $product['id']; ?>" class="btn btn-warning btn-action">EDIT</a>
                            <a href="deleteproduct.php?id=<?= $product['id']; ?>" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this product?');">DELETE</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">No products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
