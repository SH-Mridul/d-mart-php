<?php
// Include the database configuration file
require 'login_check.php';
require 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $hashed_password = "";

    // Basic validation for username and email
    if (empty($username) || empty($email)||empty($password) || empty($confirm_password)) {
        if(empty($username)){
            $_SESSION['error'] = "Username is required.";
            header("Location: new_admin_add_form.php");
            exit;
        }else if(empty($email)){
            $_SESSION['error'] = "Email is required.";
            header("Location: new_admin_add_form.php");
            exit;
        }else if(empty($password)){
            $_SESSION['error'] = "Password is required.";
            header("Location: new_admin_add_form.php");
            exit;
        }else{
            $_SESSION['error'] = "Confirm Password is required.";
            header("Location: new_admin_add_form.php");
            exit;
        }
    }else{
        if (empty($confirm_password)) {
            $_SESSION['error'] = "Confirm Password is required when adding a new admin.";
            header("Location: new_admin_add_form.php");
            exit;
        } elseif ($password !== $confirm_password) {
            $_SESSION['error'] = "Password and Confirm Password do not match.";
            header("Location: new_admin_add_form.php");
            exit;
        } else {
            // Hash the new password
            $hashed_password = md5($password);
        }
    }

    

    // Check if email already exists in the database
    $checkExistEmailSql = "SELECT * FROM admin WHERE email = ?";
    $checkStmt = $conn->prepare($checkExistEmailSql);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "This email is already registered. Please use a different email.";
        header("Location: new_admin_add_form.php");
        exit;
    }
    $checkStmt->close();

    // If email is not taken, proceed with adding the new admin
    if (empty($_SESSION['error'])) {
        $sql = "INSERT INTO admin (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // Execute the query and check for success
        if ($stmt->execute()) {
            $_SESSION['success'] = "New admin added successfully!";
            header("Location: new_admin_add_form.php");
        } else {
            $_SESSION['error'] = "An error occurred while adding the new admin. Please try again.";
        }

        // Close the statement
        $stmt->close();
    }

    // If there were errors, redirect back
    if (!empty($_SESSION['error'])) {
        header("Location: new_admin_add_form.php");
        exit;
    }
}
?>
