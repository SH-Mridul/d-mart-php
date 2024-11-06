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
    <h2 class="dashboard-title mt-4">Admin List</h2>
    <div class="container">
        <!-- Row to align content in Bootstrap grid -->
        <div class="row mt-4">
            <div class="col-md-12 mb-4">
                <div class="card card-user-info">
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-sm table-hover table-responsive mt-3">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Fetch all admins from the database
                                    $sql = "SELECT id, username, email FROM admin";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $sl = 1; // Serial number
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $sl++ . "</td>";
                                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>No admins found.</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
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
