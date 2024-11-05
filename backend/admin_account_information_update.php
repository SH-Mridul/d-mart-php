<?php
// Include the database configuration file
require 'login_check.php';
require 'database_connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch admin ID from session (assuming admin ID is stored in session)
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $hashed_password = "";
    $updated_with_password = false;

    // Basic validation for username and email
    if (empty($username) || empty($email)) {
        $_SESSION['error'] = "Username and email are required.";
        header("Location: admin_account_settings.php");
    }

    // Validate if password is given
    if (!empty($password)) {
        // Check if confirm password is also provided
        if (empty($confirm_password)) {
            $_SESSION['error'] = "Confirm Password is required when changing the password.";
            header("Location: admin_account_settings.php");
        } elseif ($password !== $confirm_password) {
            $_SESSION['error'] = "Password and Confirm Password do not match.";
            header("Location: admin_account_settings.php");
        } else {
            // Hash the new password
            $hashed_password = md5($password);
        }
    }

    // If there are no errors, proceed with the update
    if (empty($_SESSION['error'])) {
        // Prepare SQL based on whether password is updated
        if (!empty($password) && isset($hashed_password)) {
            // Update with password
            $sql = "UPDATE admin SET username = ?, email = ?, password = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $username, $email, $hashed_password, $_SESSION['email']);
            $updated_with_password = true;
        } else {
            // Update without password
            $sql = "UPDATE admin SET username = ?, email = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $username, $email, $_SESSION['email']);
            $_SESSION['username'] =  $username;
            $_SESSION['email'] = $email;
        }

        // Execute the query and check for success
        if ($stmt->execute()) {
            // Close statement and redirect to logout.php
            $stmt->close();

            //if user update with password
            if($updated_with_password == true){
                header("Location: logout.php");
            }else{
                $_SESSION['success'] = "updated user information!";
                header("Location: admin_account_settings.php");
            }
            
            
            exit;
        } else {
            $_SESSION['error'] = "An error occurred while updating. Please try again.";
        }
    }

    // If there were errors, store them in session and redirect back
    if (!empty($_SESSION['error'])) {
        header("Location: admin_account_settings.php");
        exit;
    }
}
?>
