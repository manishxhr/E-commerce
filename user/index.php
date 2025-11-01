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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .product-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .product-img {
            height: 220px;
            object-fit: cover;
        }
        .price {
            font-weight: bold;
            color: #198754;
        }
        .btn-add {
            border-radius: 30px;
            padding: 6px 18px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="text-center mb-5 fw-bold text-uppercase">All Products</h2>

    <div class="row g-4">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100">
                        <img src="../uploads/<?= htmlspecialchars($product['image']); ?>" 
                             alt="<?= htmlspecialchars($product['name']); ?>" 
                             class="card-img-top product-img">

                        <div class="card-body text-center">
                            <h6 class="card-title mb-2"><?= htmlspecialchars($product['name']); ?></h6>
                            <p class="price mb-3">₹<?= htmlspecialchars($product['price']); ?></p>

                            <form method="POST" action="cart.php" class="d-flex flex-column align-items-center gap-2">
                                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                <input type="number" name="quantity" value="1" min="1" 
                                       class="form-control w-50 text-center">
                                <button type="submit" class="btn btn-success btn-add mt-2">
                                    Add to Cart
                                </button>
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
