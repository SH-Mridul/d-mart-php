<?php  
    require 'login_check.php';
    require 'database_connection.php';

    // Get order_id from GET request
    $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Fetch main order details
    $order_query = "
        SELECT o.id, o.user_id, o.name, o.email, o.contact_number, o.address, o.total_amount, o.order_status, o.order_date_time,
               u.name AS user_name, u.email AS user_email
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.id = $order_id AND o.status = 1";
    $order_result = $conn->query($order_query);
    $order = $order_result->fetch_assoc();

    // Fetch order items from order_details, products, and sizes tables
    $details_query = "
        SELECT od.product_id, od.price, od.size_id, od.quantity, p.name AS product_name, p.image_path, s.name AS size_name
        FROM order_details od
        JOIN products p ON od.product_id = p.id
        JOIN sizes s ON od.size_id = s.id
        WHERE od.order_id = $order_id AND od.status = 1";
    $details_result = $conn->query($details_query);
?>

<!DOCTYPE html>
<html lang="en">
<!-- header -->
<?php require 'assets/header.php'; ?>
<body class="day-mode">

    <!-- Navbar -->
    <?php require 'assets/menu.php'; ?>

    <!-- Order Details Wrapper -->
    <div class="container mt-5">
        <h2 class="dashboard-title">Order Details</h2>

        <?php if ($order): ?>
            <!-- User Information Form -->
            <div class="card card-user-info mb-4">
                <div class="card-body">
                    <h5>User Information</h5>
                    <form class="row g-3 text-start text-light">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($order['user_name']) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Email:</label>
                            <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($order['user_email']) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Contact Number:</label>
                            <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($order['contact_number']) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Order Status:</label>
                            <select class="form-control form-control-sm" disabled>
                                <option value="0" <?php if ($order['order_status'] == 0) echo 'selected'; ?>>Pending Order</option>
                                <option value="1" <?php if ($order['order_status'] == 1) echo 'selected'; ?>>Confirmed Order</option>
                                <option value="2" <?php if ($order['order_status'] == 2) echo 'selected'; ?>>On Delivery Process</option>
                                <option value="3" <?php if ($order['order_status'] == 3) echo 'selected'; ?>>Delivered</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label class="form-label">Order Date:</label>
                            <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars(date("F j, Y, g:i a", strtotime($order['order_date_time']))) ?>" readonly>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label class="form-label">Address:</label>
                            <textarea class="form-control form-control-sm" readonly><?= htmlspecialchars($order['address']) ?></textarea>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Order Information Table -->
            <div class="card">
                <div class="card-body">
                    <h5>Order Information</h5>
                    <table class="table table-striped table-bordered table-sm table-hover">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sl = 1;
                                $total = 0;
                                while ($item = $details_result->fetch_assoc()):
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                            ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><img src="<?= htmlspecialchars($item['image_path']) ?>" alt="Product Image" style="width: 50px; height: auto;"></td>
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= htmlspecialchars($item['size_name']) ?></td>
                                <td><?= htmlspecialchars($item['price']) ?></td>
                                <td><?= htmlspecialchars($item['quantity']) ?></td>
                                <td><?= htmlspecialchars($subtotal) ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <tr>
                                <td colspan="6" class="text-end"><strong>Total Amount</strong></td>
                                <td><strong><?= htmlspecialchars($total) ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PDF Generation Button -->
            <div class="text-center mt-4 mb-3">
                <form action="order_confirm.php" method="POST" target="_blank">
                    <input type="hidden" name="order_id" value="<?= $order_id ?>">
                    <?php if($order['order_status'] == 0){ ?>
                        <button type="submit" class="btn btn-danger btn-sm">Confirm Order</button>
                    <?php } ?>

                     <?php if($order['order_status'] == 1){ ?>
                        <button type="submit" class="btn btn-danger btn-sm">On Delivery Order</button>
                    <?php } ?>

                     <?php if($order['order_status'] == 2){ ?>
                        <button type="submit" class="btn btn-danger btn-sm">Deliverd</button>
                    <?php } ?>
                </form>
            </div>

        <?php else: ?>
            <p class="text-center text-danger">Order not found or invalid order ID.</p>
        <?php endif; ?>

    </div>

    <!-- Bootstrap JavaScript Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
