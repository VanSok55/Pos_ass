<?php
session_start();

if (!isset($_SESSION['u_name'])) {
    header("Location: index.php");
    exit();
}

include("connection.php");

// Fetch all users from the database, excluding the currently logged-in admin
$admin_username = $_SESSION['u_name'];
$sql_select = "SELECT id, u_name, email FROM tb_user";
$result = $conn->query($sql_select);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST["user_id"];
    $new_name = $_POST["username"];
    $new_email = $_POST["email"];

    // 1. Debugging: Output the data being used in the update
    error_log("Updating user with ID: " . $id . ", Name: " . $new_name . ", Email: " . $new_email);

    // SQL query to update user data
    $sql = "UPDATE tb_user SET u_name=?, email=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssi", $new_name, $new_email, $id);

        // 2. Debugging: Output the query and parameters *before* execution
        error_log("Prepared SQL: " . $sql);
        //error_log("Parameters: " . print_r(array($new_name, $new_email, $id), true)); // Removed print_r

        if ($stmt->execute()) {
            // 3. Debugging: Check the number of affected rows *after* execution
            $affected_rows = $stmt->affected_rows;
            error_log("Affected rows: " . $affected_rows);
            echo "<script>alert('User updated successfully!'); window.location.href='all_user.php';</script>";
            exit();
        } else {
            echo "Error updating user: " . $stmt->error;
            error_log("MySQL Error: " . $stmt->error); // Log the error
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        error_log("MySQL Error: " . $conn->error); // Log the error
    }
    $conn->close();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
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

            <h1 class="text-3xl font-semibold mb-6">All Users</h1>
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['id']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['u_name']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['email']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <button onclick="openEditModal(<?= $row['id'] ?>, '<?= htmlspecialchars($row['u_name']) ?>', '<?= htmlspecialchars($row['email']) ?>')" class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="openDeleteModal(<?= $row['id'] ?>)" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">No users found.</td>
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
            <p class="mb-4">Are you sure you want to delete this user?</p>
            <div class="flex justify-end space-x-2">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>

    
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Edit User</h2>
            <form method="post" id="editUserForm">
                <div class="mb-4">
                    <label for="edit_username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                    <input type="text" name="username" id="edit_username" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <input type="hidden" name="user_id" id="edit_user_id">
                </div>
                
                <div class="mb-4">
                    <label for="edit_email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" name="email" id="edit_email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" name="update" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Update User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let userIdToDelete = null;
        let userIdToEdit = null;

        function openDeleteModal(id) {
            userIdToDelete = id;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function confirmDelete() {
            if (userIdToDelete) {
                window.location.href = `delete_user.php?id=${userIdToDelete}`;
            }
        }

        function openEditModal(id, username, email) {
            userIdToEdit = id;
            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
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

        
        document.getElementById('editUserForm').addEventListener('submit', function(event) {
            event.preventDefault();
             
            const form = this;

            fetch('', {  // Send to the same page
                method: 'POST',
                body: new FormData(form),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text(); // Or response.json() if you return JSON
            })
            .then(data => {
                console.log('Response from server:', data); // Log the response
                alert('User updated successfully!');
                window.location.href='all_user.php';
                closeEditModal();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating user. Check console for details.');
            });


        });
    </script>
</body>
</html>
