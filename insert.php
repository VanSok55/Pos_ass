<?php
session_start();
if(!isset($_SESSION['u_name'])) {
    header("Location: index.php");
    exit();
}
include("connection.php");

// Error handling
$errors = [];
if (isset($_POST['up_pro'])) {
    $pname = $_POST['product'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    
    // Validation
    if(empty($pname)) $errors[] = "Product name is required";
    if(empty($price)) $errors[] = "Price is required";
    if(empty($stock)) $errors[] = "Stock quantity is required";
    
    if(empty($errors)) {
        $dirimg = "uploads/";
        $imagename = basename($_FILES['image']['name']);
        $fullfilename = $dirimg . $imagename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $fullfilename)) {
            $insertquery = "INSERT INTO tb_product (name,image,price,stock,category) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($insertquery);
            $stmt->bind_param("ssdis", $pname, $fullfilename, $price, $stock,$category);

            if ($stmt->execute()) {
                //$_SESSION['product_success'] = 'Product added successfully!';
                header("Location: product.php");
            } else {
                $errors[] = "Database error: " . $conn->error;
            }
        } else {
            $errors[] = "Image upload failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Add New Product</h1>
                <a href="dashboard.php" class="flex items-center text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back
                </a>
            </div>
            <?php if(!empty($errors)): ?>
                <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6">
                    <?php foreach($errors as $error): ?>
                        <p class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <?= $error ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Form -->
        <form method="post" enctype="multipart/form-data" class="space-y-6">
            <!-- Product Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" name="product" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>

            <!-- Price & Stock -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                    <input type="number" step="0.01" name="price" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                    <input type="number" name="stock" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                <div class="relative group border-2 border-dashed border-gray-300 rounded-xl hover:border-indigo-500 transition-colors h-48"
                     id="drop-zone">
                    <input type="file" name="image" id="image" accept="image/*" class="hidden" required>
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3 group-hover:text-indigo-500"></i>
                        <p class="text-sm text-gray-500">
                            Drag and drop your image here<br>
                            or <span class="text-indigo-600 cursor-pointer">browse files</span>
                        </p>
                        <p class="text-xs text-gray-400 mt-2">PNG, JPG, GIF up to 5MB</p>
                    </div>
                    <div id="preview-container" class="hidden absolute inset-0 bg-white rounded-xl overflow-hidden">
                        <img id="preview-image" class="object-cover w-full h-full">
                        <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white p-2 text-sm">
                            <span id="file-name"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <option value="Electronics">Electronics</option>
                    <option value="Clothing">Clothing</option>
                    <option value="Home Appliances">Home Appliances</option>
                    <option value="Books">Books</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="up_pro" 
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors flex items-center justify-center">
                <i class="fas fa-plus-circle mr-2"></i>
                Add Product
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('image');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const fileName = document.getElementById('file-name');

    // Click handler
    dropZone.addEventListener('click', () => fileInput.click());

    // Drag & drop handlers
    ['dragenter', 'dragover'].forEach(event => {
        dropZone.addEventListener(event, (e) => {
            e.preventDefault();
            dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
        });
    });

    ['dragleave', 'dragend'].forEach(event => {
        dropZone.addEventListener(event, () => {
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        });
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        const files = e.dataTransfer.files;
        if (files.length) handleFile(files[0]);
    });

    // File input change
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length) handleFile(e.target.files[0]);
    });

    function handleFile(file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
                fileName.textContent = file.name;
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>
</body>
</html>