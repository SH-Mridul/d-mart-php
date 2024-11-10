<?php
// Display PHP errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session for error and success messages
require 'login_check.php';
require 'database_connection.php';

// Check if the product ID is set
if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];

    // Fetch the old image path before deleting the product
    $old_image_query = "SELECT image_path FROM products WHERE id = ? limit 1";
    $stmt = $conn->prepare($old_image_query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($old_image_path);
    $stmt->fetch();
    $stmt->close();

    // Delete the product
    $delete_product_query = "DELETE FROM products WHERE id = ?";
    $stmt_delete_product = $conn->prepare($delete_product_query);
    $stmt_delete_product->bind_param("i", $product_id);

    if ($stmt_delete_product->execute()) {
        // Delete associated categories
        $delete_category_query = "DELETE FROM product_categories WHERE product_id = ?";
        $stmt_delete_category = $conn->prepare($delete_category_query);
        $stmt_delete_category->bind_param("i", $product_id);
        $stmt_delete_category->execute();

        // Delete associated sizes
        $delete_size_query = "DELETE FROM product_sizes WHERE product_id = ?";
        $stmt_delete_size = $conn->prepare($delete_size_query);
        $stmt_delete_size->bind_param("i", $product_id);
        $stmt_delete_size->execute();

        // If the old image exists, delete it from the server
        if ($old_image_path && file_exists($old_image_path)) {
            unlink($old_image_path);
        }

        $_SESSION['success'] = 'Product deleted successfully.';
    } else {
        $_SESSION['error'] = 'Failed to delete product: ' . $stmt_delete_product->error;
    }

    $stmt_delete_product->close();
    $conn->close();
} else {
    $_SESSION['error'] = 'Invalid product ID.';
}

header("Location: products.php"); // Redirect back to the products page
exit;
?>
