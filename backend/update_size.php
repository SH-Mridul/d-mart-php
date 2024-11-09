<?php
// Include the database configuration file
require 'login_check.php';
require 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch form data
    $name = trim($_POST['name']);
    $id = trim($_POST['id']);

    // Basic validation for bane
    if (empty($name)) {
        
            $_SESSION['error'] = "size name is required.";
            header("Location: edit_size.php?id=$id");
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
        header("Location: edit_size.php?id=$id");
        exit;
    }
    $checkStmt->close();

    // If name is not taken, proceed with updating the brand
    if (empty($_SESSION['error'])) {
        $sql = "UPDATE sizes SET name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss",$name,$id);

        // Execute the query and check for success
        if ($stmt->execute()) {
            $_SESSION['success'] = "size updated successfully!";
            header("Location: edit_size.php?id=$id");
        } else {
            $_SESSION['error'] = "An error occurred while updating the size. Please try again.";
        }

        // Close the statement
        $stmt->close();
    }

    // If there were errors, redirect back
    if (!empty($_SESSION['error'])) {
        header("Location: edit_size.php?id=$id");
        exit;
    }
}
?>
