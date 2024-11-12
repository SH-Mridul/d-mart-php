<?php
require 'login_check.php'; 
require 'database_connection.php'; // Ensure this connects using mysqli
header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        $conn->autocommit(FALSE); // Turn off autocommit to start a transaction

        // Get user and order details from the form
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact_number = $_POST['contact_number'];
        $address = $_POST['address'];
        $total_amount = $_POST['total_amount'];

        // Insert into orders table
        $orderQuery = "INSERT INTO orders (user_id, name, email, contact_number, address, total_amount)
                       VALUES (?, ?, ?, ?, ?, ?)";
        $orderStmt = $conn->prepare($orderQuery);
        $orderStmt->bind_param("issssd", $user_id, $name, $email, $contact_number, $address, $total_amount);
        $orderStmt->execute();

        // Get the last inserted order_id
        $order_id = $conn->insert_id;

        // Prepare the query for inserting into order_details table
        $orderDetailsQuery = "INSERT INTO order_details (order_id, product_id, price, size_id, quantity)
                              VALUES (?, ?, ?, ?, ?)";
        $orderDetailsStmt = $conn->prepare($orderDetailsQuery);

        // Loop through the cart items and insert each item into order_details
        if (isset($_POST['cart']) && is_array($_POST['cart'])) {
            foreach ($_POST['cart'] as $item) {
                $product_id = $item['id'];
                $price = $item['price'];
                $size_id = $item['size'];
                $quantity = $item['quantity'];

                $orderDetailsStmt->bind_param("iidii", $order_id, $product_id, $price, $size_id, $quantity);
                $orderDetailsStmt->execute();
            }
        }

        // Commit the transaction
        $conn->commit();
        $conn->autocommit(TRUE); // Turn autocommit back on

        // Respond with success
        echo json_encode(['status' => 'success', 'message' => 'Order placed successfully']);
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Order failed', 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
