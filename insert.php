<?php
session_start();
if(!isset($_SESSION['u_name']))
{
    header("Location: form.php");
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
    <title>Document</title>
</head>
<body>
    <center>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="">Insert Product</label>
            <hr><br><br>
            <label for="">Product name</label>
            <input type="text" name="product" id=""><br><br>
            <label for="">Price</label>
            <input type="text" name="price" id=""><br><br>
            <label for="">Stock</label>
            <input type="number" name="stock" id=""><br><br>
            <label for="">Upload the image</label>
            <input type="file" name="image" id=""><br><br>
            <label for="">Category</label>
            <select name="category" id="">
                <option value="Electronics">Electronics</option>
                <option value="Clothing">Clothing</option>
                <option value="Home Appliances">Home Appliances</option>
                <option value="Books">Books</option>
            </select>
            <br><br>
            <button name="up_pro" type="submit">Upload Product</button>
        </form>
    </center>
</body>
</html>
