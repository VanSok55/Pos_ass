<?php

session_start();
include("connection.php");

// Fetch all products from the database
$sql = "SELECT * FROM tb_product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        
        <aside class="bg-gray-800 text-white w-64 flex-shrink-0 hidden lg:block">
            <div class="p-4 border-b border-gray-700">
                <h1 class="text-2xl font-semibold">Dashboard</h1>
            </div>
            <nav class="flex-1 overflow-y-auto">
                <ul class="p-4 space-y-2">
                    <li>
                        <a href="dashboard.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-home mr-2"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="insert.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-plus-circle mr-2"></i> Insert Product
                        </a>
                    </li>
                    <li>
                        <a href="product.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-box mr-2"></i> Products
                        </a>
                    </li>
                    <li>
                        <a href="all_product.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-clipboard-list mr-2"></i> All Products
                        </a>
                    </li>
                    <li>
                        <a href="all_user.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-users mr-2"></i> All Users
                        </a>
                    </li>
                    <li>
                        <a href="changepw.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-key mr-2"></i> Change Password
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="p-4 border-t border-gray-700">
                <a href="logout.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </aside>

        
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <button class="lg:hidden" id="mobile-menu-button">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <h1 class="text-3xl font-semibold mb-6">All Products</h1>
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['id']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="w-12 h-12 object-cover rounded">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['name']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">$<?= number_format($row['price'], 2) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $row['stock'] > 10 ? 'bg-green-100 text-green-800' : ($row['stock'] > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                            <?= htmlspecialchars($row['stock']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="openDeleteModal(<?= $row['id'] ?>)" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
        
        <div id="mobile-menu" class="fixed top-0 left-0 w-64 bg-gray-800 text-white h-full z-50 hidden lg:hidden">
            <div class="p-4 border-b border-gray-700 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Dashboard</h1>
                <button id="close-mobile-menu" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="flex-1 overflow-y-auto">
                <ul class="p-4 space-y-2">
                    <li>
                        <a href="dashboard.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-home mr-2"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="insert.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-plus-circle mr-2"></i> Insert Product
                        </a>
                    </li>
                    <li>
                        <a href="product.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-box mr-2"></i> Products
                        </a>
                    </li>
                     <li>
                        <a href="all_product.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-clipboard-list mr-2"></i> All Products
                        </a>
                    </li>
                    <li>
                        <a href="all_user.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-users mr-2"></i> All Users
                        </a>
                    </li>
                    <li>
                        <a href="changepw.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-key mr-2"></i> Change Password
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="p-4 border-t border-gray-700">
                <a href="logout.php" class="flex items-center p-2 rounded hover:bg-gray-700">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </div>
    </div>

    
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Confirm Delete</h2>
            <p class="mb-4">Are you sure you want to delete this product?</p>
            <div class="flex justify-end space-x-2">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>

    <script>
        let productIdToDelete = null;

        function openDeleteModal(id) {
            productIdToDelete = id;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function confirmDelete() {
            if (productIdToDelete) {
                window.location.href = `delete.php?id=${productIdToDelete}`;
            }
        }

        document.getElementById('mobile-menu-button').addEventListener('click', function(event) {
            event.stopPropagation();
            document.getElementById('mobile-menu').classList.remove('hidden');
        });

        document.getElementById('close-mobile-menu').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.add('hidden');
        });

        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = document.getElementById('mobile-menu-button');

            if (!mobileMenu.classList.contains('hidden') &&
                !mobileMenu.contains(event.target) &&
                event.target !== mobileMenuButton) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
