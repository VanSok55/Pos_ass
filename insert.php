<?php
session_start();
if(!isset($_SESSION['u_name']))
{
    header("Location: index.php");
    exit();
}
include("connection.php");
if (isset($_POST['up_pro'])) {
    $pname = $_POST['product'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    $dirimg = "uploads/";
    $imagename = basename($_FILES['image']['name']);
    $fullfilename = $dirimg . $imagename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $fullfilename)) {
        $insertquery = "INSERT INTO tb_product (name,image,price,stock,category) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($insertquery);
        $stmt->bind_param("ssdis", $pname, $fullfilename, $price, $stock,$category);

        if ($stmt->execute()) {
            $_SESSION['product_success'] = 'Product added successfully!';
            header("Location: product.php");
        } else {
            echo "Database error: " . $conn->error;
        }
    } else {
        echo "Image upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <link rel="stylesheet" href="style/insert-products.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="form-container">
    <div class="form-header">
        <h1>Insert New Product</h1>
    </div>

    <div class="form-body">
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form id="product-form" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product">Product Name</label>
                <input type="text" name="product" id="product" placeholder="Enter product name">
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" placeholder="Enter product price">
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" placeholder="Enter stock quantity">
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <div class="file-upload">
                    <input type="file" name="image" id="image" accept="image/*">
                    <div class="file-upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="file-upload-text">
                        <p>Drag and drop your image here or click to browse</p>
                        <p>Supported formats: JPG, PNG, GIF</p>
                    </div>
                    <div class="file-upload-preview">
                        <img src="#" alt="Preview">
                        <div class="file-upload-name"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category">
                    <option value="Electronics">Electronics</option>
                    <option value="Clothing">Clothing</option>
                    <option value="Home Appliances">Home Appliances</option>
                    <option value="Books">Books</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="button" id="back-button" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    <a href="dashboard.php">Back to Dashboard</a>
                </button>
                <button name="up_pro" type="submit" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Upload Product
                </button>
            </div>
        </form>
    </div>
</div>

<script src="insert-product.js"></script>
</body>
</html>