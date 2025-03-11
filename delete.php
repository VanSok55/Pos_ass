<?php
session_start();
include("connection.php");

$product_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($product_id) {
    $delete_query = "DELETE FROM tb_product WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        $_SESSION['product_success'] = 'Product deleted successfully!';
        header("Location: product.php");
    } else {
        echo "Error deleting product: " . $stmt->error;
    }
} else {
    echo "No product ID specified.";
}
?>
