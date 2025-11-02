<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../classes/database.php');
require_once(__DIR__ . '/../classes/admin.php');
require_once(__DIR__ . '/../classes/product.php');

// Create database and class objects
$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);
$product = new Product($db);

// Check admin login
if (!$admin->isLoggedIn()) {
    header("location: login.php");
    exit;
}

// Fetch admin name 
$adminName = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : "Admin";

// Get product by ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $currentProduct = $product->getProductById($id);
} else {
    header("Location: productslist.php");
    exit;
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = filter_var($_POST['name'], );
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_var($_POST['description']);
    $image = filter_var($_POST['image'], FILTER_SANITIZE_URL);
    $status = filter_var($_POST['status']);

    if ($product->updateProduct($id, $name, $price, $description, $image, $status)) {
        $message = "Product updated successfully!";
        header("Location: productslist.php?message=" . urlencode($message));
        exit;
    } else {
           $errorInfo = $db->errorInfo();
           var_dump($errorInfo);
           die("Update failed!");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ✅ NAVBAR -->
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="dashboard.php">🛍️ Thrift Shop</a>
    <div class="d-flex align-items-center text-white">
        <span class="me-3">Welcome, <?= htmlspecialchars($adminName) ?></span>
        <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- ✅ MAIN CONTENT -->
<div class="container mt-5 pt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 500px;">
        <h2 class="mb-4 text-center">Update Product</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($currentProduct['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($currentProduct['price']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($currentProduct['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Image URL</label>
                <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($currentProduct['image']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" <?= $currentProduct['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $currentProduct['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">Update Product</button>
                <a href="productslist.php" class="btn btn-secondary ms-2 px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
