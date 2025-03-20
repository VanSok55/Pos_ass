<?php
    session_start();
    include("connection.php");

    $product_id = isset($_GET['id']) ? $_GET['id'] : '';

    if ($product_id) {
        $delete_query = "DELETE FROM tb_product WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            // Redirect directly without showing an alert message
            header("Location: product.php");
            exit; // Ensure the script stops executing after the redirect
        } else {
            echo "Error deleting product: " . $stmt->error;
        }
    } else {
        echo "No product ID specified.";
    }
?>
