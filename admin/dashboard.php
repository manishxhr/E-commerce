<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../classes/database.php');
require_once(__DIR__ . '/../classes/admin.php');

$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);

// Redirect to login if not logged in
if (!$admin->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

// Get username from session
// $username = isset($_SESSION['username']) ? $_SESSION['username'] : "Admin";
if(isset($_SESSION['username'])){
    $name=$_SESSION['username'];
}

//logout function
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
</head>
<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card p-5 shadow-sm text-center" style="min-width: 350px;">
        <h1 class="mb-4">Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
        <p class="mb-4">You are logged in as an admin.</p>
        <!-- <a href="logout.php" class="btn btn-danger w-100">Logout</a> -->
         <form action="" method="get">
        <button name="logout" class="btn btn-danger w-100">Logout</button>

         </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
