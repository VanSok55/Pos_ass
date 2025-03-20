<?php
session_start();

if (!isset($_SESSION['u_name'])) {
    header("Location: index.php");
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
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
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-300 mr-2"></div>
                    <div class="user-name"><?php echo htmlspecialchars($username); ?></div>
                </div>
            </div>

            <h1 class="text-3xl font-semibold mb-6">Welcome, <?php echo htmlspecialchars($username); ?>!</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-plus-circle text-4xl text-blue-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Insert Product</h3>
                    <p class="text-gray-600 mb-4">Add new products to your inventory</p>
                    <a href="insert.php" class="text-blue-600 hover:text-blue-800 flex items-center">
                        Insert now <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-box text-4xl text-green-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">View Products</h3>
                    <p class="text-gray-600 mb-4">Manage your product inventory</p>
                    <a href="product.php" class="text-green-600 hover:text-green-800 flex items-center">
                        View products <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-key text-4xl text-yellow-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Change Password</h3>
                    <p class="text-gray-600 mb-4">Update your account security</p>
                    <a href="changepw.php" class="text-yellow-600 hover:text-yellow-800 flex items-center">
                        Change now <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
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
                        <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
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

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function(event) {
            event.stopPropagation();
            document.getElementById('mobile-menu').classList.remove('hidden');
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

        document.getElementById('close-mobile-menu').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.add('hidden');
        });
    </script>
</body>
</html>
