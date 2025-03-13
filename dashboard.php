<?php
session_start();

// Check if the user is logged in (i.e., if the session variable is set)
if (!isset($_SESSION['u_name'])) {
    header("Location: index.php"); // Redirect to the login page if not logged in
    exit();
}

$username = $_SESSION['u_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style/dashboard.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">Dashboard</div>
        <button class="sidebar-toggle">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <ul class="nav-list">
        <li class="nav-item active">
            <a href="#">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="insert.php">
                <i class="fas fa-plus-circle"></i>
                <span>Insert Product</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="product.php">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="changepw.php">
                <i class="fas fa-key"></i>
                <span>Change Password</span>
            </a>
        </li>
    </ul>

    <div class="logout">
        <a href="logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="header">
        <button class="mobile-toggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="user-info">
            <div class="user-avatar"></div>
            <div class="user-name"><?php echo htmlspecialchars($username); ?></div>
        </div>
    </div>

    <h1 class="dashboard-title">Welcome, <?php echo htmlspecialchars($username); ?>!</h1>

    <div class="cards-container">
        <div class="card">
            <div class="card-icon insert">
                <i class="fas fa-plus-circle"></i>
            </div>
            <h3 class="card-title">Insert Product</h3>
            <p class="card-description">Add new products to your inventory</p>
            <a href="insert.php" class="card-link">
                Insert now <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card">
            <div class="card-icon products">
                <i class="fas fa-box"></i>
            </div>
            <h3 class="card-title">View Products</h3>
            <p class="card-description">Manage your product inventory</p>
            <a href="product.php" class="card-link">
                View products <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card">
            <div class="card-icon password">
                <i class="fas fa-key"></i>
            </div>
            <h3 class="card-title">Change Password</h3>
            <p class="card-description">Update your account security</p>
            <a href="changepw.php" class="card-link">
                Change now <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<script src="dashboard.js"></script>
</body>
</html>