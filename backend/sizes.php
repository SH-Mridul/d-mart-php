<?php 
    require 'login_check.php';
    require 'database_connection.php';

    // Query to fetch brands with status 1
    $sql = "SELECT id, name FROM sizes WHERE status = 1";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<!-- header -->
<?php require 'assets/header.php'; ?>
<body class="day-mode">

    <!-- Navbar -->
    <?php require 'assets/menu.php'; ?>

    <!-- Dashboard Wrapper to Center the Content -->
    <h2 class="dashboard-title mt-4">Sizes</h2>
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

                        <table class="table table-striped table-bordered table-sm table-hover table-responsive mt-3">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $sl = 1; // Serial number counter
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $sl++ . "</td>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td>
                                                <a href='edit_size.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'>Edit</a>
                                                <a href='delete_size.php?id=" . $row['id'] . "' 
                                                    class='btn btn-danger btn-sm' 
                                                    onclick=\"return confirm('Are you sure you want to delete this size?');\">
                                                    Delete
                                                </a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>No sizes available</td></tr>";
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
