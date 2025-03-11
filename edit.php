<?php
session_start();
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tb_product WHERE id='$id'";
    $rs = $conn->query($sql);

    if ($rs->num_rows > 0) {
        $product = $rs->fetch_assoc();
        echo "<center><h2>Edit Form</h2><hr><br><br>";
        echo "<img src='" . $product['image'] . "' width='400px' height='400px' alt='Product Image'><br><br>";

        echo "<form method='POST' action='' enctype='multipart/form-data'>";
        echo "<label>Product Name</label><input type='text' name='name' value='" . $product['name'] . "'><br><br>";
        echo "<label>Price</label><input type='text' name='price' value='" . $product['price'] . "'><br><br>";
        echo "<label>Stock</label><input type='text' name='stock' value='" . $product['stock'] . "'><br><br>";
        echo "<label>Category</label><input type='text' name='category' value='" . $product['category'] . "'><br><br>";
        echo "<label>Upload New Image (Optional)</label><input type='file' name='image'><br><br>";
        echo "<button type='submit' name='update'>Update</button>";
        echo "</form>";
    } else {
        echo "Product not found.";
    }
} else {
    echo "No product ID specified.";
}

if (isset($_POST['update'])) {
    $pname = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    $id = $_GET['id'];

    $image_path = $product['image'];
    if (!empty($_FILES['image']['name'])) {
        $dirimg = "uploads/";
        $imagename = basename($_FILES['image']['name']);
        $fullname = $dirimg . $imagename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $fullname)) {
            $image_path = $fullname;
        } else {
            echo "Image update failed!!";
        }
    }

    $sql = "UPDATE tb_product SET name='$pname', image='$image_path', price='$price', stock='$stock', category='$category' WHERE id='$id'";

    if ($conn->query($sql)) {
        $_SESSION['update_succ'] = "Update Successful!!";
        header("Location: product.php");
        exit();
    } else {
        echo "Database error: " . $conn->error;
    }
}
?>
