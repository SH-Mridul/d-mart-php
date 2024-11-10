<?php 
    require 'login_check.php';
    require 'database_connection.php';

    // Query to fetch products along with their brand, categories, and sizes
    $sql = "
            SELECT 
                p.id AS product_id,
                p.name AS product_name,
                p.image_path as image,
                p.status,
                b.name AS brand_name,
                GROUP_CONCAT(DISTINCT c.name ORDER BY c.name ASC SEPARATOR ', ') AS category_names,
                GROUP_CONCAT(DISTINCT s.name ORDER BY s.name ASC SEPARATOR ', ') AS size_names
            FROM 
                products p
            LEFT JOIN 
                brand b ON p.brand_id = b.id
            LEFT JOIN 
                product_categories pc ON p.id = pc.product_id
            LEFT JOIN 
                categories c ON pc.category_id = c.id
            LEFT JOIN 
                product_sizes ps ON p.id = ps.product_id
            LEFT JOIN 
                sizes s ON ps.size_id = s.id
            WHERE 
                p.status = 1
            GROUP BY 
                p.id
            ORDER BY 
                p.name ASC;
         ";

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
    <h2 class="dashboard-title mt-4">Products</h2>
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
                                    <th>Product Name</th>
                                    <th>Product Image</th>
                                    <th>Brand</th>
                                    <th>Categories</th>
                                    <th>Sizes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $sl = 1; // Serial number counter
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td class='pt-4'>" . $sl++ . "</td>";
                                        echo "<td class='pt-4'>" . htmlspecialchars($row['product_name']) . "</td>";
                                        echo "<td><img src='" . htmlspecialchars($row["image"])."' style='width:80px;'>.</td>";
                                        
                                        echo "<td class='pt-4'>" . htmlspecialchars($row['brand_name']) . "</td>";
                                        
                                        // Display categories as badges
                                        echo "<td class='pt-4'>";
                                        $categories = explode(',', $row['category_names']);
                                        foreach ($categories as $category) {
                                            echo "<span class='badge bg-primary me-1'>" . htmlspecialchars($category) . "</span>";
                                        }
                                        echo "</td>";
                                        
                                        // Display sizes as badges
                                        echo "<td class='pt-4'>";
                                        $sizes = explode(',', $row['size_names']);
                                        foreach ($sizes as $size) {
                                            echo "<span class='badge bg-secondary me-1'>" . htmlspecialchars($size) . "</span>";
                                        }
                                        echo "</td>";
                                        
                                        // Action buttons
                                        echo "<td class='pt-4'>
                                                <a href='edit_product.php?id=" . $row['product_id'] . "' class='btn btn-success btn-sm'>Edit</a>
                                                <a href='delete_product.php?id=" . $row['product_id'] . "' 
                                                    class='btn btn-danger btn-sm' 
                                                    onclick=\"return confirm('Are you sure you want to delete this product?');\">
                                                    Delete
                                                </a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No products available</td></tr>";
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
