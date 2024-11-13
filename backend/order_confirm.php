<?php
// Include the login check and database connection files
require 'login_check.php';
require 'database_connection.php';

// Check if the form was submitted and order_id is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    
    // Ensure the order_id is a valid number (basic validation)
    if (is_numeric($order_id)) {
        // SQL query to get the current order status
        $sql = "SELECT order_status FROM orders WHERE id = ?";
        
        // Prepare the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("i", $order_id);
            
            // Execute the query
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($current_status);
            $stmt->fetch();

            // Check if we have the current status
            if ($stmt->num_rows > 0) {
                // Determine the new status based on the current status
                switch ($current_status) {
                    case 0:
                        $new_status = 1; // Pending to Confirmed
                        break;
                    case 1:
                        $new_status = 2; // Confirmed to On Delivery Process
                        break;
                    case 2:
                        $new_status = 3; // On Delivery Process to Delivered
                        break;
                    case 3:
                        // If already delivered, no change needed (optional)
                        $_SESSION['error'] = "This order is already delivered.";
                        header("Location: orders.php");
                        exit();
                    default:
                        $_SESSION['error'] = "Invalid order status.";
                        header("Location: orders.php");
                        exit();
                }

                // SQL query to update the order status
                $update_sql = "UPDATE orders SET order_status = ? WHERE id = ?";

                // Prepare the update SQL statement
                if ($update_stmt = $conn->prepare($update_sql)) {
                    // Bind parameters
                    $update_stmt->bind_param("ii", $new_status, $order_id);
                    
                    // Execute the update query
                    if ($update_stmt->execute()) {
                        $_SESSION['success'] = "Order status updated successfully.";
                    } else {
                        $_SESSION['error'] = "Error updating order status.";
                    }

                    // Close the update statement
                    $update_stmt->close();
                } else {
                    $_SESSION['error'] = "Error preparing the update query.";
                }
            } else {
                $_SESSION['error'] = "Order not found.";
            }

            // Close the result statement
            $stmt->close();
        } else {
            $_SESSION['error'] = "Error preparing the select query.";
        }
    } else {
        $_SESSION['error'] = "Invalid order ID.";
    }

    // Redirect back to the orders page
    header("Location: orders.php");
    exit();
} else {
    $_SESSION['error'] = "Order ID is missing.";
    header("Location: orders.php");
    exit();
}

// Close the database connection
$conn->close();
?>
