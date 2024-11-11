<?php
session_start();
require 'database_connection.php'; // Include your database connection file

// Check if form data is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    echo $name;
    echo $email;
    echo $password;
    echo $confirm_password;
    
   

    // Server-side validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../registration.php");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../registration.php");
        exit();
    }

    // Hash the password
    $hashedPassword = md5($password); // For better security, consider using password_hash instead

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists
        $_SESSION['error'] = "Email is already registrationed.";
        header("Location: ../registration.php");
        exit();
    } else {
        // Insert new user into the database
        $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! You can now log in.";
            header("Location: ../registration.php");
            exit();
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
            header("Location: ../registration.php");
            exit();
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: ../registration.php");
    exit();
}
?>
