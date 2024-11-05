<?php 
    require 'login_check.php';
    require 'database_connection.php';
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
                            <h5>$125/-</h5>
                            <p>Total Pendings</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-cleared-payments">
                        <div class="card-body">
                            <h5>$0/-</h5>
                            <p>Cleared Payments</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-order-placed">
                        <div class="card-body">
                            <h5>12</h5>
                            <p>Order Placed</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-products-added">
                        <div class="card-body">
                            <h5>5</h5>
                            <p>Products Added</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-users">
                        <div class="card-body">
                            <h5>1</h5>
                            <p>Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-total-accounts">
                        <div class="card-body">
                            <h5>2</h5>
                            <p>Total Accounts</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-admin-users">
                        <div class="card-body">
                            <h5>1</h5>
                            <p>Admin Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-new-messages">
                        <div class="card-body">
                            <h5>3</h5>
                            <p>New Messages</p>
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