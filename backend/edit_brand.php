<?php 
    require 'login_check.php';
    require 'database_connection.php';

    // Check if brand ID is provided in the URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        
        // Fetch the brand details from the database
        $sql = "SELECT name FROM brand WHERE id = ? AND status = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if the brand exists
        if ($result->num_rows > 0) {
            $brand = $result->fetch_assoc();
        } else {
            // Redirect if brand is not found
            $_SESSION['error'] = "Brand not found.";
            header("Location: brands.php"); // Redirect to brand list page
            exit();
        }
        
        $stmt->close();
    } else {
        // Redirect if no ID is provided
        $_SESSION['error'] = "Brand id not provided!";
        header("Location: brands.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<!-- header -->
<?php require 'assets/header.php'; ?>
<body class="day-mode">

    <!-- Navbar -->
    <?php require 'assets/menu.php'; ?>

    <!-- Dashboard Wrapper to Center the Content -->
    <h2 class="dashboard-title mt-4">Update Brand</h2>
    <div class="dashboard-wrapper">
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-12 mb-4">
                    <div class="card card-form p-4">
                        <h5 class="card-title text-center text-light">Update Brand Information Form</h5>
                        <form class="text-light p-4 m-4" method="post" action="update_brand.php">
                            <div class="form-group mb-3">
                                <label for="name">Brand Name :</label>
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                                <input type="text" class="form-control form-control-sm" name="name" id="name" value="<?php echo htmlspecialchars($brand['name']); ?>" placeholder="Enter brand name">
                            </div>

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
                            
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </form>
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
