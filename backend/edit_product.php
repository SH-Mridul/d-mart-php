<?php 
    require 'login_check.php';
    require 'database_connection.php';

    // Get product ID from query parameter
    $product_id = isset($_GET['id']) ? $_GET['id'] : null;

    // Initialize product data variables
    $product_name = '';
    $image_path = '';
    $brand_id = '';
    $status = '';
    $selected_categories = [];
    $selected_sizes = [];

    // Fetch product details if ID is provided
    if ($product_id) {
        $product_query = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($product_query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product_result = $stmt->get_result();

        if ($product_result->num_rows > 0) {
            $product = $product_result->fetch_assoc();
            $product_name = $product['name'];
            $image_path = $product['image_path'];
            $brand_id = $product['brand_id'];
            $status = $product['status'];

            // Fetch selected categories for this product
            $category_query = "SELECT category_id FROM product_categories WHERE product_id = ?";
            $stmt = $conn->prepare($category_query);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $category_result = $stmt->get_result();
            while ($row = $category_result->fetch_assoc()) {
                $selected_categories[] = $row['category_id'];
            }

            // Fetch selected sizes for this product
            $size_query = "SELECT size_id FROM product_sizes WHERE product_id = ?";
            $stmt = $conn->prepare($size_query);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $size_result = $stmt->get_result();
            while ($row = $size_result->fetch_assoc()) {
                $selected_sizes[] = $row['size_id'];
            }
        } else {
            // Redirect or show an error if the product does not exist
            echo "Product not found.";
            exit;
        }
    } else {
        // Redirect if no product ID is provided
        echo "No product ID provided.";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php require 'assets/header.php'; ?>
<body class="day-mode">

    <?php require 'assets/menu.php'; ?>

    <h2 class="dashboard-title mt-4">Edit Product</h2>
    <div class="dashboard-wrapper">
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-12 mb-4">
                    <div class="card card-form p-4">
                        <h5 class="card-title text-center text-light">Edit Product Information</h5>
                        <form class="text-light p-4 m-4" method="post" enctype="multipart/form-data" action="update_product.php">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>">

                            <div class="form-group mb-3">
                                <label for="product_name">Product Name:</label>
                                <input type="text" class="form-control form-control-sm" name="product_name" id="product_name" placeholder="Enter product name" value="<?php echo htmlspecialchars($product_name); ?>" required>
                            </div>

                            <!-- Category Dropdown -->
                            <div class="form-group mb-3">
                                <label for="category">Category:</label>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="categorySelect" data-bs-toggle="dropdown" aria-expanded="false" style="width:100%">
                                        <?php
                                            $query = "SELECT * FROM categories";
                                            $result = $conn->query($query);
                                            while($row = $result->fetch_assoc()) {
                                               if(in_array($row['id'], $selected_categories)){
                                                echo $row['name'].',';
                                               }
                                            }
                                        ?>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="categorySelect" style="width:100%">
                                        <?php
                                            $query = "SELECT * FROM categories";
                                            $result = $conn->query($query);
                                            while($row = $result->fetch_assoc()) {
                                                $checked = in_array($row['id'], $selected_categories) ? 'checked' : '';
                                                echo "<li><input type='checkbox' class='form-check-input category-option' name='category[]' value='{$row['id']}' $checked> <label class='form-check-label'>{$row['name']}</label></li>";
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Brand Dropdown -->
                            <div class="form-group mb-3">
                                <label for="brand">Brand:</label>
                                <select class="form-control form-control-sm" name="brand" id="brand" required>
                                    <option disabled>--- select brand ---</option>
                                    <?php
                                        $query = "SELECT * FROM brand";
                                        $result = $conn->query($query);
                                        while($row = $result->fetch_assoc()) {
                                            $selected = $row['id'] == $brand_id ? 'selected' : '';
                                            echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <!-- Size Dropdown -->
                            <div class="form-group mb-3">
                                <label for="size">Size:</label>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="sizeSelect" data-bs-toggle="dropdown" aria-expanded="false" style="width:100%">
                                        <?php
                                            $query = "SELECT * FROM sizes";
                                            $result = $conn->query($query);
                                            while($row = $result->fetch_assoc()) {
                                                if(in_array($row['id'], $selected_sizes)){
                                                    echo $row['name'].',';
                                                }
                                            }
                                        ?>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="sizeSelect" style="width:100%">
                                        <?php
                                            $query = "SELECT * FROM sizes";
                                            $result = $conn->query($query);
                                            while($row = $result->fetch_assoc()) {
                                                $checked = in_array($row['id'], $selected_sizes) ? 'checked' : '';
                                                echo "<li><input type='checkbox' class='form-check-input size-option' name='size[]' value='{$row['id']}' $checked> <label class='form-check-label'>{$row['name']}</label></li>";
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="product_image">Product Picture:</label>
                                <input type="file" class="form-control form-control-sm" name="product_image" id="product_image" accept="image/*">
                                <?php if ($image_path): ?>
                                    <img id="image_preview" src="<?php echo htmlspecialchars($image_path); ?>" alt="Image Preview" style="width:100px; margin-top:10px;">
                                <?php else: ?>
                                    <img id="image_preview" src="#" alt="Image Preview" style="display:none; width:100px; margin-top:10px;">
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                        
                        <?php if(isset($_SESSION['success']) && !empty($_SESSION['success'])){ ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                            </div>
                        <?php } ?>

                        <?php if(isset($_SESSION['error']) && !empty($_SESSION['error'])){ ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php } ?>

                        <script>
                            // Preview image
                            document.getElementById('product_image').addEventListener('change', function(event) {
                                const image = document.getElementById('image_preview');
                                image.src = URL.createObjectURL(event.target.files[0]);
                                image.style.display = 'block';
                            });

                            // Update dropdown button text for Category and Size
                            function updateDropdownText(dropdownId, optionClass, defaultText) {
                                const selectedOptions = Array.from(document.querySelectorAll(optionClass + ':checked'))
                                    .map(option => option.nextElementSibling.innerText);
                                
                                const dropdownButton = document.getElementById(dropdownId);
                                dropdownButton.textContent = selectedOptions.length > 0 ? selectedOptions.join(', ') : defaultText;
                            }

                            // Event listeners for Category and Size options
                            document.querySelectorAll('.category-option').forEach(option => {
                                option.addEventListener('change', () => updateDropdownText('categorySelect', '.category-option', 'Select Category'));
                            });

                            document.querySelectorAll('.size-option').forEach(option => {
                                option.addEventListener('change', () => updateDropdownText('sizeSelect', '.size-option', 'Select Size'));
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
     <script src="assets/js/script.js"></script>
</body>
</html>
