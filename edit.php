<?php
session_start();
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tb_product WHERE id='$id'";
    $rs = $conn->query($sql);

    if ($rs->num_rows > 0) {
        $product = $rs->fetch_assoc();
        
        // Process form submission
        if (isset($_POST['update'])) {
            $pname = $_POST['name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $category = $_POST['category'];
            $id = $_GET['id'];

            $image_path = $product['image'];
            $upload_message = "";
            
            if (!empty($_FILES['image']['name'])) {
                $dirimg = "uploads/";
                $imagename = basename($_FILES['image']['name']);
                $fullname = $dirimg . $imagename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $fullname)) {
                    $image_path = $fullname;
                    $upload_message = "<div class='mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg'>Image uploaded successfully!</div>";
                } else {
                    $upload_message = "<div class='mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg'>Image upload failed!</div>";
                }
            }

            $sql = "UPDATE tb_product SET name='$pname', image='$image_path', price='$price', stock='$stock', category='$category' WHERE id='$id'";

            if ($conn->query($sql)) {
                $_SESSION['update_succ'] = "Update Successful!!";
                header("Location: product.php");
                exit();
            } else {
                $error_message = "<div class='mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg'>Database error: " . $conn->error . "</div>";
            }
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Product</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
        <body class="bg-gray-50">
            <div class="container mx-auto py-10 px-4">
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Edit Product</h2>
                    <div class="h-px bg-gray-200 my-4"></div>
                    
                    <?php if(isset($error_message)) echo $error_message; ?>
                    <?php if(isset($upload_message)) echo $upload_message; ?>
                    
                    <div class="md:flex">
                        <div class="md:w-1/2 p-4">
                            <div class="relative mx-auto max-w-md">
                                <h3 class="text-lg font-medium text-gray-700 mb-2">Current Image</h3>
                                <img src="<?php echo $product['image']; ?>" class="w-full h-auto rounded-lg shadow-md" alt="Current Product Image" id="current-image">
                                
                                <!-- New Image Preview (hidden by default) -->
                                <div id="preview-container" class="hidden mt-6">
                                    <h3 class="text-lg font-medium text-gray-700 mb-2">New Image Preview</h3>
                                    <div class="relative">
                                        <img id="preview-image" class="w-full h-auto rounded-lg shadow-md border-2 border-blue-500" alt="New Image Preview">
                                        <div class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-md">Preview</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:w-1/2 p-4">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                           id="name" name="name" value="<?php echo $product['name']; ?>" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                           id="price" name="price" value="<?php echo $product['price']; ?>" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                           id="stock" name="stock" value="<?php echo $product['stock']; ?>" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                           id="category" name="category" value="<?php echo $product['category']; ?>" required>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="image-upload" class="block text-sm font-medium text-gray-700 mb-1">Upload New Image (Optional)</label>
                                    <div class="mt-1 flex items-center">
                                        <label for="image" class="cursor-pointer px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                            Choose File
                                        </label>
                                        <input type="file" id="image" name="image" class="hidden" accept="image/*" onchange="handleImageSelect(this);">
                                        <span id="file-name" class="ml-3 text-sm text-gray-500">No file chosen</span>
                                    </div>
                                    <div id="upload-message" class="mt-2 text-sm"></div>
                                </div>
                                
                                <div class="flex flex-col space-y-2">
                                    <button type="submit" name="update" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                                        Update Product
                                    </button>
                                    <a href="product.php" class="w-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-md text-center transition duration-200">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                function handleImageSelect(input) {
                    // Update file name display
                    updateFileName(input);
                    
                    // Show image preview
                    previewImage(input);
                }
                
                function updateFileName(input) {
                    const fileName = input.files[0] ? input.files[0].name : 'No file chosen';
                    const fileNameElement = document.getElementById('file-name');
                    const uploadMessageElement = document.getElementById('upload-message');
                    
                    // Add success message when file is selected
                    if (input.files[0]) {
                        fileNameElement.textContent = fileName;
                        uploadMessageElement.innerHTML = '<span class="text-green-600">✓ New image selected and ready to upload</span>';
                        
                        // Validate file type and size
                        const fileType = input.files[0].type;
                        const fileSize = input.files[0].size / 1024 / 1024; // in MB
                        
                        if (!fileType.match('image.*')) {
                            uploadMessageElement.innerHTML = '<span class="text-red-600">⚠ Please select an image file</span>';
                        } else if (fileSize > 5) {
                            uploadMessageElement.innerHTML = '<span class="text-red-600">⚠ File size exceeds 5MB limit</span>';
                        }
                    } else {
                        fileNameElement.textContent = 'No file chosen';
                        uploadMessageElement.innerHTML = '';
                        
                        // Hide preview if no file is selected
                        document.getElementById('preview-container').classList.add('hidden');
                    }
                }
                
                function previewImage(input) {
                    const previewContainer = document.getElementById('preview-container');
                    const previewImage = document.getElementById('preview-image');
                    
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // Show the preview container
                            previewContainer.classList.remove('hidden');
                            
                            // Set the preview image source
                            previewImage.src = e.target.result;
                        }
                        
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        // Hide the preview container if no file is selected
                        previewContainer.classList.add('hidden');
                    }
                }
            </script>
        </body>
        </html>
        <?php
    } else {
        echo "<div class='mx-auto max-w-4xl mt-8 p-4 text-sm text-red-700 bg-red-100 rounded-lg'>Product not found.</div>";
    }
} else {
    echo "<div class='mx-auto max-w-4xl mt-8 p-4 text-sm text-red-700 bg-red-100 rounded-lg'>No product ID specified.</div>";
}
?>

