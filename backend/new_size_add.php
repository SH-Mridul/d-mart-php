<?php
// Include the database configuration file
require 'login_check.php';
require 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch form data
    $name = trim($_POST['name']);

    // Basic validation for bane
    if (empty($name)) {
        
            $_SESSION['error'] = "size name is required.";
            header("Location: new_size_add_form.php");
            exit;
    }

    

    // Check if name already exists in the database
    $checkExistEmailSql = "SELECT * FROM sizes WHERE name = ?";
    $checkStmt = $conn->prepare($checkExistEmailSql);
    $checkStmt->bind_param("s", $name);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "This size is already added into database.";
        header("Location: new_size_add_form.php");
        exit;
    }
    $checkStmt->close();

    // If name is not taken, proceed with adding the new brand
    if (empty($_SESSION['error'])) {
        $sql = "INSERT INTO sizes (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);

        // Execute the query and check for success
        if ($stmt->execute()) {
            $_SESSION['success'] = "New size added successfully!";
            header("Location: new_size_add_form.php");
        } else {
            $_SESSION['error'] = "An error occurred while adding the new size. Please try again.";
        }

        // Close the statement
        $stmt->close();
    }

    // If there were errors, redirect back
    if (!empty($_SESSION['error'])) {
        header("Location: new_size_add_form.php");
        exit;
    }
}
?>
