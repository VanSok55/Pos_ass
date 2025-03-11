<?php
session_start();
include("connection.php");

if (isset($_SESSION['product_success'])) {
    echo "<script>alert('" . $_SESSION['product_success'] . "');</script>";
    unset($_SESSION['product_success']); // Remove it so it only shows once
}


$search = isset($_GET['search']) ? $_GET['search'] : '';
$category_filter = isset($_GET['category_filter']) ? $_GET['category_filter'] : ''; 

$query = "SELECT * FROM tb_product WHERE 1";

if (!empty($search)) {
    $query .= " AND name LIKE '%$search%'";
}

if (!empty($category_filter)) {
    $query .= " AND category = '$category_filter'";  
}

$result = $conn->query($query);  

if ($result->num_rows > 0) {
    echo "<h2>Product List</h2>";
    echo "<div style='display: flex; flex-wrap: wrap; justify-content: space-between;'>";
    
   while ($row = $result->fetch_assoc()) {
    echo "<div style='flex: 1 1 23%; box-sizing: border-box; border: 1px solid #ddd; padding: 10px; margin: 10px;'>";
    echo "<img src='" . $row['image'] . "' width='100%' height='400px' alt='Product Image'>";
    echo "<h3>" . $row['name'] . "</h3>";
    echo "<p>Price: $" . $row['price'] . "</p>";
    echo "<p>Stock: " . $row['stock'] . "</p>";
    echo "<p>Created At: " . $row['created_at'] . "</p>"; 
    echo "<p>Category: " . $row['category'] . "</p>"; 
    echo "<a href='edit.php?id=". $row['id']  ."' style='text-decoration: none; color: #007bff; padding: 5px 10px; border: 1px solid #007bff; margin-right: 10px; border-radius: 5px;'>Edit</a>";
    echo "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\")' style='text-decoration: none; color: #dc3545; padding: 5px 10px; border: 1px solid #dc3545; border-radius: 5px;'>Delete</a>";
    echo "</div>";  
}


    echo "</div>";
} else {
    echo "No products found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="GET">
    <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
</form>

<form method="GET">
    <select name="category_filter">
         <option value="">All Categories</option>
         <option value="Electronics" <?php if($category_filter == "Electronics") echo "selected"; ?>>Electronics</option>
         <option value="Clothing" <?php if($category_filter == "Clothing") echo "selected"; ?>>Clothing</option>
         <option value="Home Appliances" <?php if($category_filter == "Home Appliances") echo "selected"; ?>>Home Appliances</option>
         <option value="Books" <?php if($category_filter == "Books") echo "selected"; ?>>Books</option>
    </select>
    <button type="submit">Filter</button>
</form>

</body>
</html>