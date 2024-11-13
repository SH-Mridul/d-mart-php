<?php 
    require 'login_check.php';
    require 'database_connection.php';
    $total_pending_amount_sql = "SELECT SUM(total_amount) AS total_amount FROM orders WHERE status = 1 AND order_status != 3;";
    $total_pending_amount = $conn->query($total_pending_amount_sql);
    $total_pending_row = $total_pending_amount->fetch_assoc();
    $total_p = $total_pending_row['total_amount'];

    $total_cleared_amount_sql = "SELECT SUM(total_amount) AS total_amount FROM orders WHERE status = 1 AND order_status = 3;";
    $total_cleared_amount = $conn->query($total_cleared_amount_sql);
    $total_cleared_row = $total_cleared_amount->fetch_assoc();
    $total_c = $total_cleared_row['total_amount'];

    $total_orders_sql = "SELECT COUNT(*) AS total_orders FROM orders where status = 1";
    $total_orders_result = $conn->query($total_orders_sql);
    $total_orders_row = $total_orders_result->fetch_assoc();
    $total_orders = $total_orders_row['total_orders'];

    $total_products_sql = "SELECT COUNT(*) AS total_products FROM products where status = 1";
    $total_products_result = $conn->query($total_products_sql);
    $total_products_row = $total_products_result->fetch_assoc();
    $total_products = $total_products_row['total_products'];

    $total_users_sql = "SELECT COUNT(*) AS total_users FROM users where status = 1";
    $total_users_result = $conn->query($total_users_sql);
    $total_users_row = $total_users_result->fetch_assoc();
    $total_users = $total_users_row['total_users'];

    $total_admin_sql = "SELECT COUNT(*) AS total_admin FROM admin where status = 1";
    $total_admin_result = $conn->query($total_admin_sql);
    $total_admin_row = $total_admin_result->fetch_assoc();
    $total_admin = $total_admin_row['total_admin'];

    $total_on_process_sql = "SELECT COUNT(*) AS on_process FROM orders where status = 1 and order_status != 3";
    $total_on_process_result = $conn->query($total_on_process_sql);
    $total_on_process_row = $total_on_process_result->fetch_assoc();
    $total_on_process = $total_on_process_row['on_process'];

    $total_deliverd_sql = "SELECT COUNT(*) AS on_deliverd FROM orders where status = 1 and order_status = 3";
    $total_deliverd_result = $conn->query($total_deliverd_sql);
    $total_deliverd_row = $total_deliverd_result->fetch_assoc();
    $total_deliverd = $total_deliverd_row['on_deliverd'];
?>
<!DOCTYPE html>
<html lang="en">
<!-- header -->
 <?php require 'assets/header.php'; ?>
<body class="day-mode">

    <!-- Navbar -->
    <?php require 'assets/menu.php'; ?>

    <!-- Dashboard Wrapper to Center the Content -->
     <h2 class="dashboard-title mt-4">DASHBOARD</h2>
    <div class="dashboard-wrapper">
        <div class="container">
            <!-- Dashboard Cards -->
            <div class="row mt-4">
                <div class="col-md-3 mb-4">
                    <div class="card card-total-pendings">
                        <div class="card-body">
                            <h5><?php echo !is_null($total_p) ? $total_p : '0'; ?>/-</h5>
                            <p>Total Pendings</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-cleared-payments">
                        <div class="card-body">
                            <h5><?php echo !is_null($total_c) ? $total_c : '0'; ?>/-</h5>
                            <p>Cleared Payments</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-order-placed">
                        <div class="card-body">
                            <h5><?php echo !is_null($total_orders) ? $total_orders : '0'; ?></h5>
                            <p>Order Placed</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-products-added">
                        <div class="card-body">
                            <h5><?php echo !is_null($total_products) ? $total_products : '0'; ?></h5>
                            <p>Products Added</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-users">
                        <div class="card-body">
                            <h5><?php echo !is_null($total_users) ? $total_users : '0'; ?></h5>
                            <p>Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-admin-users">
                        <div class="card-body">
                            <h5><?php echo !is_null($total_admin) ? $total_admin : '0'; ?></h5>
                            <p>Admin Users</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card card-total-accounts">
                        <div class="card-body">
                            <h5><?php echo !is_null($total_on_process) ? $total_on_process : '0'; ?></h5>
                            <p>On Process Order</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card card-new-messages">
                        <div class="card-body">
                            <h5><?php echo !is_null($total_deliverd) ? $total_deliverd : '0'; ?></h5>
                            <p>Deliverd Orders</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript for Day/Night Mode Toggle -->
     <script src="assets/js/script.js"></script>
</body>
</html>