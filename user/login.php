<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../classes/database.php');
require_once(__DIR__ . '/../classes/user.php');

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$message = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if($user->loginUser($email, $password)){
        $message = "User login successful!";
        header("Location: ../index.php?message=" . urlencode($message));
        exit;
    } else {
        $message = "Login failed! Check email/password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
    }
    .login-container {
        max-width: 400px;
        margin: 5rem auto;
        padding: 2rem;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }
    .btn-login {
        border-radius: 30px;
        padding: 8px 25px;
    }
    .message {
        text-align: center;
        margin-bottom: 1rem;
    }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🛍️ Thrift Shop</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="login.php">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Login Form -->
<div class="login-container">
    <h2 class="text-center mb-4">User Login</h2>

    <?php if($message): ?>
        <div class="alert alert-info message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-login">Login</button>
        </div>
    </form>
    <p class="text-center mt-3">New user? <a href="register.php">Register here</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
