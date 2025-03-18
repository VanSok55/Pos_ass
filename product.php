<?php
session_start();
include("connection.php");

// Handle success messages
if (isset($_SESSION['product_success'])) {
    echo "<script>alert('" . addslashes($_SESSION['product_success']) . "');</script>";
    unset($_SESSION['product_success']);
}

// Initialize filters
$search = $_GET['search'] ?? '';
$category_filter = $_GET['category_filter'] ?? '';

// Build query with prepared statements
$query = "SELECT * FROM tb_product WHERE 1=1";
$types = '';
$params = [];

if (!empty($search)) {
    $query .= " AND name LIKE ?";
    $types .= 's';
    $params[] = "%{$search}%";
}

if (!empty($category_filter)) {
    $query .= " AND category = ?";
    $types .= 's';
    $params[] = $category_filter;
}

// Prepare and execute statement
$stmt = $conn->prepare($query);
if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50/50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div class="space-y-2">
            <h1 class="text-2xl font-bold text-gray-900">Product Inventory</h1>
            <a href="dashboard.php" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center">
                <i class="fas fa-chevron-left mr-1.5 h-3 w-3"></i>
                Back to Dashboard
            </a>
        </div>
        <a href="insert.php" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">
            <i class="fas fa-plus mr-2 -ml-1"></i>
            New Product
        </a>
    </div>

    <!-- Filters Section -->
    <div class="mb-8 bg-white rounded-lg shadow-sm p-4 border border-gray-200">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="relative flex-1">
                <input
                    type="text"
                    name="search"
                    value="<?= htmlspecialchars($search) ?>"
                    placeholder="Search products..."
                    class="w-full pl-4 pr-10 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                >
                <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-500">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            
            <div class="relative flex-1">
                <select 
                    name="category_filter" 
                    class="pl-4 pr-8 py-2.5 text-sm border border-gray-300 rounded-lg appearance-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full outline-none"
                >
                    <option value="">All Categories</option>
                    <option value="Electronics" <?= $category_filter === "Electronics" ? 'selected' : '' ?>>Electronics</option>
                    <option value="Clothing" <?= $category_filter === "Clothing" ? 'selected' : '' ?>>Clothing</option>
                    <option value="Home Appliances" <?= $category_filter === "Home Appliances" ? 'selected' : '' ?>>Home Appliances</option>
                    <option value="Books" <?= $category_filter === "Books" ? 'selected' : '' ?>>Books</option>
                </select>
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg w-full sm:w-auto">
                    Apply Filters
                </button>
                <?php if(!empty($search) || !empty($category_filter)): ?>
                <a 
                    href="?" 
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 border border-gray-300 rounded-lg flex items-center"
                >
                    Clear Filters
                </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Product Grid -->
    <?php if ($result->num_rows > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-200 overflow-hidden">
                <div class="aspect-square bg-gray-100 relative">
                    <img 
                        src="<?= htmlspecialchars($row['image']) ?>" 
                        alt="<?= htmlspecialchars($row['name']) ?>" 
                        class="w-full h-full object-cover"
                    >
                    <div class="absolute top-3 right-3 flex items-center gap-2">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-white/90 backdrop-blur shadow-sm <?= 
                            $row['stock'] > 10 ? 'text-green-700 bg-green-50' : 
                            ($row['stock'] > 0 ? 'text-amber-700 bg-amber-50' : 'text-red-700 bg-red-50') 
                        ?>">
                            <?= $row['stock'] > 10 ? 'In Stock' : ($row['stock'] > 0 ? 'Low Stock' : 'Out of Stock') ?>
                        </span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900 truncate mb-1"><?= htmlspecialchars($row['name']) ?></h3>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-semibold text-gray-900">$<?= number_format($row['price'], 2) ?></span>
                        <div class="flex items-center gap-2">
                            <a 
                                href="edit.php?id=<?= $row['id'] ?>" 
                                class="w-9 h-9 inline-flex items-center justify-center text-indigo-600 hover:bg-indigo-50 rounded-lg"
                                title="Edit"
                            >
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <button 
                                onclick="confirmDelete(<?= $row['id'] ?>)" 
                                class="w-9 h-9 inline-flex items-center justify-center text-red-600 hover:bg-red-50 rounded-lg"
                                title="Delete"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 rounded-full bg-indigo-50 mx-auto mb-6 flex items-center justify-center">
                    <i class="fas fa-box-open text-3xl text-indigo-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                <p class="text-sm text-gray-500">Try adjusting your search or filters</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-sm">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Delete product?</h3>
                <p class="text-sm text-gray-500 mb-6">This action cannot be undone.</p>
                <div class="flex gap-3">
                    <button 
                        id="cancelDelete"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-lg"
                    >
                        Cancel
                    </button>
                    <button 
                        id="confirmDelete"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(productId) {
    const modal = document.getElementById("deleteModal");
    modal.classList.remove("hidden");
    
    document.getElementById("confirmDelete").onclick = function() {
        window.location.href = "delete.php?id=" + productId;
    }

    document.getElementById("cancelDelete").onclick = function() {
        modal.classList.add("hidden");
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById("deleteModal");
    if (event.target === modal) {
        modal.classList.add("hidden");
    }
}
</script>
</body>
</html>