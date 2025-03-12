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
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>This is your dashboard.</p>
    <a href="insert.php">Insert Product</a>
    <br><br>
    <a href="product.php">Product</a>
    <br><br>
    <a href="changepw.php">Change Password</a>
    <br><br>
    <a href="logout.php">Logout</a>
</body>
</html>
