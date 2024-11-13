<?php 
    require 'login_check.php';
    require 'database_connection.php';
    // Query to select orders with specific conditions
    $pending_order_sql = "SELECT id, name, total_amount FROM orders WHERE status = 1 AND order_status = 0";
    $pending_order_result = mysqli_query($conn, $pending_order_sql);

    $confirm_order_sql = "SELECT id, name, total_amount FROM orders WHERE status = 1 AND order_status = 1";
    $confirm_order_result = mysqli_query($conn, $confirm_order_sql);

    $ondelivary_order_sql = "SELECT id, name, total_amount FROM orders WHERE status = 1 AND order_status = 2";
    $ondelivary_order_result = mysqli_query($conn, $ondelivary_order_sql);

    $deliverd_order_sql = "SELECT id, name, total_amount FROM orders WHERE status = 1 AND order_status = 3";
    $deliverd_order_result = mysqli_query($conn, $deliverd_order_sql);
?>
<!DOCTYPE html>
<html lang="en">
<!-- header -->
<?php require 'assets/header.php'; ?>
<body class="day-mode">

    <!-- Navbar -->
    <?php require 'assets/menu.php'; ?>

    <!-- Dashboard Wrapper to Center the Content -->
    <h2 class="dashboard-title mt-4">Orders</h2>
    <div class="container">
        <!-- Row to align content in Bootstrap grid -->
        <div class="row mt-4">
            <div class="col-md-12 mb-4">
                <div class="card card-user-info">
                    <div class="card-body">
                        <!-- notification -->
                        <?php if(isset($_SESSION['success'])) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                            </div>
                        <?php } ?>

                        <?php if(isset($_SESSION['error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <!-- Left Tab Menu -->
                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-p-order" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Pending Order</button>
                                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-c-order" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Confirmed Order</button>
                                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-p-d" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">On Delivery Process</button>
                                    <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-d-d" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Delivered</button>
                                </div>
                            </div>

                            <!-- Tab Content Area -->
                            <div class="col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                <!-- pending order -->
                                <div class="tab-pane fade show active" id="v-pills-p-order" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped table-bordered table-sm table-hover"> 
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Total Amount</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        if(mysqli_num_rows($pending_order_result) > 0) {
                                                            $counter = 1;
                                                            while($row = mysqli_fetch_assoc($pending_order_result)) {
                                                                echo "<tr>";
                                                                echo "<th scope='row'>" . $counter . "</th>";
                                                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['total_amount']) . "</td>";
                                                                echo "<td><a href='order_details.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Full Details</a></td>";
                                                                echo "</tr>";
                                                                $counter++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No orders found</td></tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- confirm order -->
                                    <div class="tab-pane fade" id="v-pills-c-order" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped table-bordered table-sm table-hover"> 
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Total Amount</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        if(mysqli_num_rows($confirm_order_result) > 0) {
                                                            $counter = 1;
                                                            while($row = mysqli_fetch_assoc($confirm_order_result)) {
                                                                echo "<tr>";
                                                                echo "<th scope='row'>" . $counter . "</th>";
                                                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['total_amount']) . "</td>";
                                                                echo "<td><a href='order_details.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Full Details</a></td>";
                                                                echo "</tr>";
                                                                $counter++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No orders found</td></tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <!-- on delivery process order -->
                                    <div class="tab-pane fade" id="v-pills-p-d" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped table-bordered table-sm table-hover"> 
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Total Amount</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        if(mysqli_num_rows($ondelivary_order_result) > 0) {
                                                            $counter = 1;
                                                            while($row = mysqli_fetch_assoc($ondelivary_order_result)) {
                                                                echo "<tr>";
                                                                echo "<th scope='row'>" . $counter . "</th>";
                                                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['total_amount']) . "</td>";
                                                                echo "<td><a href='order_details.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Full Details</a></td>";
                                                                echo "</tr>";
                                                                $counter++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No orders found</td></tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>



                                    <!-- deliverd order -->
                                    <div class="tab-pane fade" id="v-pills-d-d" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped table-bordered table-sm table-hover"> 
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Total Amount</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        if(mysqli_num_rows($deliverd_order_result) > 0) {
                                                            $counter = 1;
                                                            while($row = mysqli_fetch_assoc($deliverd_order_result)) {
                                                                echo "<tr>";
                                                                echo "<th scope='row'>" . $counter . "</th>";
                                                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['total_amount']) . "</td>";
                                                                echo "<td><a href='order_details.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Full Details</a></td>";
                                                                echo "</tr>";
                                                                $counter++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4' class='text-center'>No orders found</td></tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
