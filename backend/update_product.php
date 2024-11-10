<?php
// // Display PHP errors for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// // Start session for error and success messages
// require 'login_check.php';
// require 'database_connection.php';

// // Check if the form is submitted
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
//     $product_id = (int)$_POST['product_id'];

//     // Validate and sanitize product name
//     if (empty($_POST['product_name'])) {
//         $_SESSION['error'] = 'Product name is required.';
//         header("Location: edit_product.php?id=$product_id");
//         exit;
//     }
//     $product_name = htmlspecialchars(trim($_POST['product_name']));

//     // Validate brand
//     if (empty($_POST['brand'])) {
//         $_SESSION['error'] = 'Brand is required.';
//         header("Location: edit_product.php?id=$product_id");
//         exit;
//     }
//     $brand_id = (int)$_POST['brand'];

//     // Validate categories and sizes
//     $category_ids = isset($_POST['category']) ? array_map('intval', $_POST['category']) : [];
//     $size_ids = isset($_POST['size']) ? array_map('intval', $_POST['size']) : [];

//     if (empty($category_ids)) {
//         $_SESSION['error'] = 'At least one category must be selected.';
//         header("Location: edit_product.php?id=$product_id");
//         exit;
//     }
//     if (empty($size_ids)) {
//         $_SESSION['error'] = 'At least one size must be selected.';
//         header("Location: edit_product.php?id=$product_id");
//         exit;
//     }

//     // Handle image upload
//     $image_path = '';
//     if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
//         // Check file type
//         $allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];
//         if (!in_array($_FILES['product_image']['type'], $allowed_types)) {
//             $_SESSION['error'] = 'Invalid image type. Only JPG, PNG, and JPEG are allowed.';
//             header("Location: edit_product.php?id=$product_id");
//             exit;
//         }

//         // Check file size (limit to 2MB)
//         $max_size = 2 * 1024 * 1024;
//         if ($_FILES['product_image']['size'] > $max_size) {
//             $_SESSION['error'] = 'Image size must be less than 2MB.';
//             header("Location: edit_product.php?id=$product_id");
//             exit;
//         }

//         // Delete old image if a new one is uploaded
//         $old_image_query = "SELECT image_path FROM products WHERE id = ?";
//         $stmt = $conn->prepare($old_image_query);
//         $stmt->bind_param("i", $product_id);
//         $stmt->execute();
//         $stmt->bind_result($old_image_path);
//         $stmt->fetch();
//         $stmt->close();

        

//         // Upload new image
//         $image_name = time() . '_' . basename($_FILES['product_image']['name']);
//         $target_dir = 'product_images/';
//         $image_path = $target_dir . $image_name;
//         if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path)) {
//             $_SESSION['error'] = 'Failed to upload image.';
//             header("Location: edit_product.php?id=$product_id");
//             exit;
//         }else{
//             if ($old_image_path && file_exists($old_image_path)) {
//             unlink($old_image_path);
//              }
//         }
//     } else {
//         $image_path = $old_image_path;
//     }

//     // Update product details
//     $update_product_query = "UPDATE products SET name = ?, brand_id = ?, image_path = ? WHERE id = ?";
//     $stmt = $conn->prepare($update_product_query);
//     $stmt->bind_param("sisi", $product_name, $brand_id, $image_path, $product_id);

//     if ($stmt->execute()) {
//         // Delete old categories and insert new ones
//         $delete_category_query = "DELETE FROM product_categories WHERE product_id = ?";
//         $stmt_delete_category = $conn->prepare($delete_category_query);
//         $stmt_delete_category->bind_param("i", $product_id);
//         $stmt_delete_category->execute();

//         $insert_category_query = "INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)";
//         $stmt_category = $conn->prepare($insert_category_query);
//         foreach ($category_ids as $category_id) {
//             $stmt_category->bind_param("ii", $product_id, $category_id);
//             $stmt_category->execute();
//         }

//         // Delete old sizes and insert new ones
//         $delete_size_query = "DELETE FROM product_sizes WHERE product_id = ?";
//         $stmt_delete_size = $conn->prepare($delete_size_query);
//         $stmt_delete_size->bind_param("i", $product_id);
//         $stmt_delete_size->execute();

//         $insert_size_query = "INSERT INTO product_sizes (product_id, size_id) VALUES (?, ?)";
//         $stmt_size = $conn->prepare($insert_size_query);
//         foreach ($size_ids as $size_id) {
//             $stmt_size->bind_param("ii", $product_id, $size_id);
//             $stmt_size->execute();
//         }

//         $_SESSION['success'] = 'Product updated successfully.';
//         header("Location: edit_product.php?id=$product_id");
//         exit;
//     } else {
//         $_SESSION['error'] = 'Failed to update product: ' . $stmt->error;
//         header("Location: edit_product.php?id=$product_id");
//         exit;
//     }

//     $stmt->close();
//     $conn->close();
// } else {
//     header("Location: edit_product.php");
//     exit;
// }

// Display PHP errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session for error and success messages
require 'login_check.php';
require 'database_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];

    // Validate and sanitize product name
    if (empty($_POST['product_name'])) {
        $_SESSION['error'] = 'Product name is required.';
        header("Location: edit_product.php?id=$product_id");
        exit;
    }
    $product_name = htmlspecialchars(trim($_POST['product_name']));

    // Validate brand
    if (empty($_POST['brand'])) {
        $_SESSION['error'] = 'Brand is required.';
        header("Location: edit_product.php?id=$product_id");
        exit;
    }
    $brand_id = (int)$_POST['brand'];

    // Validate categories and sizes
    $category_ids = isset($_POST['category']) ? array_map('intval', $_POST['category']) : [];
    $size_ids = isset($_POST['size']) ? array_map('intval', $_POST['size']) : [];

    if (empty($category_ids)) {
        $_SESSION['error'] = 'At least one category must be selected.';
        header("Location: edit_product.php?id=$product_id");
        exit;
    }
    if (empty($size_ids)) {
        $_SESSION['error'] = 'At least one size must be selected.';
        header("Location: edit_product.php?id=$product_id");
        exit;
    }

    // Fetch the old image path before processing the new image
    $old_image_query = "SELECT image_path FROM products WHERE id = ?";
    $stmt = $conn->prepare($old_image_query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($old_image_path);
    $stmt->fetch();
    $stmt->close();

    // Handle image upload
    $image_path = $old_image_path; // Default to the old image path if no new image is uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        // Check file type
        $allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];
        if (!in_array($_FILES['product_image']['type'], $allowed_types)) {
            $_SESSION['error'] = 'Invalid image type. Only JPG, PNG, and JPEG are allowed.';
            header("Location: edit_product.php?id=$product_id");
            exit;
        }

        // Check file size (limit to 2MB)
        $max_size = 2 * 1024 * 1024;
        if ($_FILES['product_image']['size'] > $max_size) {
            $_SESSION['error'] = 'Image size must be less than 2MB.';
            header("Location: edit_product.php?id=$product_id");
            exit;
        }

        // Upload new image
        $image_name = time() . '_' . basename($_FILES['product_image']['name']);
        $target_dir = 'product_images/';
        $image_path = $target_dir . $image_name;
        if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path)) {
            $_SESSION['error'] = 'Failed to upload image.';
            header("Location: edit_product.php?id=$product_id");
            exit;
        }

        // Delete old image if a new one is uploaded
        if ($old_image_path && file_exists($old_image_path)) {
            unlink($old_image_path);
        }
    }

    // Update product details
    $update_product_query = "UPDATE products SET name = ?, brand_id = ?, image_path = ? WHERE id = ?";
    $stmt = $conn->prepare($update_product_query);
    $stmt->bind_param("sisi", $product_name, $brand_id, $image_path, $product_id);

    if ($stmt->execute()) {
        // Delete old categories and insert new ones
        $delete_category_query = "DELETE FROM product_categories WHERE product_id = ?";
        $stmt_delete_category = $conn->prepare($delete_category_query);
        $stmt_delete_category->bind_param("i", $product_id);
        $stmt_delete_category->execute();

        $insert_category_query = "INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)";
        $stmt_category = $conn->prepare($insert_category_query);
        foreach ($category_ids as $category_id) {
            $stmt_category->bind_param("ii", $product_id, $category_id);
            $stmt_category->execute();
        }

        // Delete old sizes and insert new ones
        $delete_size_query = "DELETE FROM product_sizes WHERE product_id = ?";
        $stmt_delete_size = $conn->prepare($delete_size_query);
        $stmt_delete_size->bind_param("i", $product_id);
        $stmt_delete_size->execute();

        $insert_size_query = "INSERT INTO product_sizes (product_id, size_id) VALUES (?, ?)";
        $stmt_size = $conn->prepare($insert_size_query);
        foreach ($size_ids as $size_id) {
            $stmt_size->bind_param("ii", $product_id, $size_id);
            $stmt_size->execute();
        }

        $_SESSION['success'] = 'Product updated successfully.';
        header("Location: edit_product.php?id=$product_id");
        exit;
    } else {
        $_SESSION['error'] = 'Failed to update product: ' . $stmt->error;
        header("Location: edit_product.php?id=$product_id");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: edit_product.php");
    exit;
}

?>
