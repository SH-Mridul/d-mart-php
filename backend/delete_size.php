<?php
// Include the database configuration file
require 'login_check.php';
require 'database_connection.php';

// Check if this is a GET request to delete a size
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    // Get the size ID from the URL
    $id = trim($_GET['id']);
    $status = 0;

    // Prepare and execute the DELETE query
    $sql = "UPDATE sizes SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$status,$id);

    // Execute the query and check if the brand was deleted
    if ($stmt->execute()) {
        $_SESSION['success'] = "size deleted successfully!";
    } else {
        $_SESSION['error'] = "An error occurred while deleting the size. Please try again.";
    }

    // Close the statement
    $stmt->close();

    // Redirect back to the sizes page with a success or error message
    header("Location: sizes.php");
    exit;
} else {
    // If no ID is provided, redirect with an error
    $_SESSION['error'] = "Invalid request.";
    header("Location: sizes.php");
    exit;
}
?>
