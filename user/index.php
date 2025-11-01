<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../classes/database.php');
require_once(__DIR__ . '/../classes/product.php');

$database = new Database();
$db = $database->getConnection();

$productObj = new Product($db);
$products = $productObj->allProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>All Products</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #d2dde8ff;
    }

    /* Navbar */
    .navbar {
      background-color: #000 !important;
      padding: 0.6rem 2rem;
    }

    .navbar-brand {
      font-weight: 600;
      color: #57c3e0ff !important;
    }

    .search-form {
      width: 40%;
    }

    .search-form input {
      border-radius: 25px 0 0 25px;
      text-align: center;
    }

    .search-form button {
      border-radius: 0 25px 25px 0;
    }

    .nav-buttons .btn {
      margin-left: 10px;
      padding: 6px 16px;
      font-weight: 500;
      border-radius: 20px;
    }

    .nav-buttons .btn-cart {
      border-radius: 50%;
      padding: 6px 10px;
    }

    /* Product cards */
    .product-img {
      height: 220px;
      object-fit: cover;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .card {
      border: none;
      border-radius: 12px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .btn-add {
      border-radius: 25px;
      font-size: 14px;
      padding: 5px 14px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <!-- Left Logo -->
    <a class="navbar-brand" href="#">Thrift Shop</a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar center + right -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">

      <!-- Center Search -->
      <form class="d-flex mx-auto my-2 search-form" role="search" action="products.php" method="GET">
        <input class="form-control" type="search" placeholder="Search products..." name="query" aria-label="Search">
        <button class="btn btn-outline-light ms-2" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>

      <!-- Right Buttons -->
      <div class="nav-buttons ms-auto">
        <a href="../admin/login.php" class="btn btn-outline-light btn-sm">Login</a>
        <a href="../admin/login.php" class="btn btn-outline-warning btn-sm">Admin</a>
        <a href="cart.php" class="btn btn-success btn-cart">
          <i class="bi bi-cart3 fs-5"></i>
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Products Section -->
<div class="container py-5">
  <h2 class="text-center mb-5 fw-bold text-uppercase">All Products</h2>

  <div class="row g-4">
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $product): ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card shadow-sm h-100">
            <img src="../uploads/<?= htmlspecialchars($product['image']); ?>" 
                 alt="<?= htmlspecialchars($product['name']); ?>" 
                 class="card-img-top product-img">

            <div class="card-body text-center">
              <h6 class="card-title mb-2"><?= htmlspecialchars($product['name']); ?></h6>
              <p class="fw-bold text-success mb-3">₹<?= htmlspecialchars($product['price']); ?></p>

              <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <input type="number" name="quantity" value="1" min="1" class="form-control w-50 text-center">
                  <button type="submit" class="btn btn-success btn-add">Add</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-muted">No products available.</p>
    <?php endif; ?>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
