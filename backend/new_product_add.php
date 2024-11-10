<?php
// Display PHP errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session for error and success messages
require 'login_check.php';
require 'database_connection.php'; // Ensure this connects successfully

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize product name
    if (empty($_POST['product_name'])) {
        $_SESSION['error'] = 'Product name is required.';
        header("Location: new_product_add_form.php");
        exit;
    }
    $product_name = htmlspecialchars(trim($_POST['product_name']));

    // Validate brand
    if (empty($_POST['brand'])) {
        $_SESSION['error'] = 'Brand is required.';
        header("Location: new_product_add_form.php");
        exit;
    }
    $brand_id = (int)$_POST['brand']; // Ensure it is an integer

    // Validate categories and sizes
    $category_ids = isset($_POST['category']) ? array_map('intval', $_POST['category']) : [];
    $size_ids = isset($_POST['size']) ? array_map('intval', $_POST['size']) : [];

    if (empty($category_ids)) {
        $_SESSION['error'] = 'At least one category must be selected.';
        header("Location: new_product_add_form.php");
        exit;
    }
    if (empty($size_ids)) {
        $_SESSION['error'] = 'At least one size must be selected.';
        header("Location: new_product_add_form.php");
        exit;
    }

    // Validate and upload product image
    $image_path = '';
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        // Check file type
        $allowed_types = ['image/jpg','image/jpeg', 'image/png'];
        if (!in_array($_FILES['product_image']['type'], $allowed_types)) {
            $_SESSION['error'] = 'Invalid image type. Only JPG, PNG, and JPEG are allowed.';
            header("Location: new_product_add_form.php");
            exit;
        }

        // Check file size (limit to 2MB)
        $max_size = 2 * 1024 * 1024;
        if ($_FILES['product_image']['size'] > $max_size) {
            $_SESSION['error'] = 'Image size must be less than 2MB.';
            header("Location: new_product_add_form.php");
            exit;
        }

        // Move the uploaded file to the target directory
        $image_name = time() . '_' . basename($_FILES['product_image']['name']);
        $target_dir = 'product_images/';
        $image_path = $target_dir . $image_name;
        if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path)) {
            $_SESSION['error'] = 'Failed to upload image.';
            header("Location: new_product_add_form.php");
            exit;
        }
    } else {
        $_SESSION['error'] = 'Product image is required.';
        header("Location: new_product_add_form.php");
        exit;
    }

    // Check if product with the same name already exists
    $check_query = "SELECT * FROM products WHERE name = ?";
    $stmt = $conn->prepare($check_query);
    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: new_product_add_form.php");
        exit;
    }
    $stmt->bind_param("s", $product_name);
    if (!$stmt->execute()) {
        $_SESSION['error'] = "Database error: " . $stmt->error;
        header("Location: new_product_add_form.php");
        exit;
    }
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the file from the server
        }
        $_SESSION['error'] = 'Product with the same name already exists.';
        header("Location: new_product_add_form.php");
        exit;
    } else {
        // Insert product into products table
        $insert_product_query = "INSERT INTO products (name, brand_id, image_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_product_query);
        if (!$stmt) {
            $_SESSION['error'] = "Database error: " . $conn->error;
            header("Location: new_product_add_form.php");
            exit;
        }
        $stmt->bind_param("sis", $product_name, $brand_id, $image_path);

        if ($stmt->execute()) {
            $product_id = $stmt->insert_id;

            // Insert categories into product_categories table
            $insert_category_query = "INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)";
            $stmt_category = $conn->prepare($insert_category_query);
            foreach ($category_ids as $category_id) {
                $stmt_category->bind_param("ii", $product_id, $category_id);
                $stmt_category->execute();
            }

            // Insert sizes into product_sizes table
            $insert_size_query = "INSERT INTO product_sizes (product_id, size_id) VALUES (?, ?)";
            $stmt_size = $conn->prepare($insert_size_query);
            foreach ($size_ids as $size_id) {
                $stmt_size->bind_param("ii", $product_id, $size_id);
                $stmt_size->execute();
            }

            $_SESSION['success'] = 'Product added successfully.';
            header("Location: new_product_add_form.php");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to add product: ' . $stmt->error;
            header("Location: new_product_add_form.php");
            exit;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: new_product_add_form.php");
    exit;
}
