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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="style/product-list.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container">
    <a href="dashboard.php" class="back-to-dashboard">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <div class="page-header">
        <h1 class="page-title">Product List</h1>

        <div class="filters-container">
            <form id="search-form" class="search-form" method="GET">
                <input
                        type="text"
                        id="search-input"
                        name="search"
                        class="search-input"
                        placeholder="Search products..."
                        value="<?php echo htmlspecialchars($search); ?>"
                >
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>

            <form id="filter-form" class="filter-form" method="GET">
                <select id="category-filter" name="category_filter" class="filter-select">
                    <option value="">All Categories</option>
                    <option value="Electronics" <?php if($category_filter == "Electronics") echo "selected"; ?>>Electronics</option>
                    <option value="Clothing" <?php if($category_filter == "Clothing") echo "selected"; ?>>Clothing</option>
                    <option value="Home Appliances" <?php if($category_filter == "Home Appliances") echo "selected"; ?>>Home Appliances</option>
                    <option value="Books" <?php if($category_filter == "Books") echo "selected"; ?>>Books</option>
                </select>
                <button type="submit" class="btn btn-outline">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>

            <?php if(!empty($search) || !empty($category_filter)): ?>
                <button id="clear-filters" class="btn btn-outline">
                    <i class="fas fa-times"></i> Clear Filters
                </button>
            <?php endif; ?>

            <a href="insert.php" class="btn btn-primary" style="margin-left: auto;">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <div class="product-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="<?php echo $row['image']; ?>" class="product-image" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <div class="product-category-badge"><?php echo htmlspecialchars($row['category']); ?></div>
                    </div>

                    <div class="product-details">
                        <h3 class="product-name"><?php echo htmlspecialchars($row['name']); ?></h3>

                        <div class="product-meta">
                            <div class="product-price">$<?php echo number_format($row['price'], 2); ?></div>

                            <?php if($row['stock'] > 10): ?>
                                <div class="product-stock in-stock">
                                    <i class="fas fa-check-circle"></i> In Stock
                                </div>
                            <?php elseif($row['stock'] > 0): ?>
                                <div class="product-stock low-stock">
                                    <i class="fas fa-exclamation-circle"></i> Low Stock
                                </div>
                            <?php else: ?>
                                <div class="product-stock out-of-stock">
                                    <i class="fas fa-times-circle"></i> Out of Stock
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="product-info">
                            <div class="product-date">
                                <i class="far fa-calendar-alt"></i> Added <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                            </div>
                        </div>

                        <div class="product-actions">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="action-btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="action-btn btn-delete">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="no-products">
            <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
            <p>No products found. Try a different search or add a new product.</p>
        </div>
    <?php endif; ?>
</div>

<script src="products-list.js"></script>
</body>
</html>