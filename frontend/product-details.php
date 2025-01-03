<?php
require 'php_files/database_connection.php'; 
require 'php_files/login_check.php'; 

// Check if a product ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    
    // Query to get the sizes for the specified product
    $sizes_sql = "
        SELECT 
            s.id AS size_id, 
            s.name AS size_name
        FROM 
            product_sizes ps
        INNER JOIN 
            sizes s ON ps.size_id = s.id
        WHERE 
            ps.product_id = $product_id
        ORDER BY 
            s.name ASC;
    ";

    // Execute the query
    $sizes_result = $conn->query($sizes_sql);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Details | D-Mart</title>
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    .product-details {
      max-width: 1000px;
      margin: 50px auto;
      display: flex;
      align-items: flex-start;
      gap: 30px;
      padding: 20px;
    }
    .product-image {
      flex: 1;
      text-align: center;
    }
    .product-image img {
      width: 100%;
      max-width: 400px;
      border-radius: 8px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }
    .product-info {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .product-info h2 {
      font-size: 24px;
      color: #333;
      margin-bottom: 15px;
    }
    .product-info h3 {
      font-size: 28px;
      color: #333;
      margin-top: 10px;
      margin-bottom: 20px;
    }
    .product-info p {
      font-size: 20px;
      color: #555;
      margin: 10px 0;
    }
    .product-info label {
      font-size: 18px;
      color: #333;
      display: block;
      margin-top: 10px;
    }
    .product-info select {
      width: 100%;
      max-width: 200px;
      padding: 8px;
      margin-top: 5px;
      font-size: 16px;
    }
    .button-group {
      display: flex;
      gap: 20px;
      margin-top: 20px;
    }
    .button-group .btn {
      display: inline-block;
      padding: 10px 20px;
      font-size: 18px;
      text-align: center;
      color: #fff;
      background-color: #000;
      border-radius: 5px;
      text-decoration: none;
    }
    .button-group .btn:hover {
      background-color: #333;
    }
  </style>

    <style>
    /* Styling for the dropdown menu */
      .nav-action {
          position: relative;
      }

      .dropdown-menu {
          display: none; /* Hidden by default */
          position: absolute;
          top: 100%; /* Positions the dropdown below the button */
          left: 0;
          background-color: white;
          list-style: none;
          padding: 10px;
          border: 1px solid #ddd;
          box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
          width: 200px;
          z-index: 1000;
      }

      .nav-action:hover .dropdown-menu {
          display: block; /* Show the dropdown on hover */
      }

      .dropdown-menu li {
          padding: 8px 12px;
          cursor: pointer;
      }

      .dropdown-menu li a {
          color: #333;
          text-decoration: none;
      }

      .dropdown-menu li:hover {
          background-color: #f0f0f0;
      }

  </style>

</head>

<body>

  <!-- Header (Menu) -->
  <header class="header" data-header>
    <div class="container">
      <div class="overlay" data-overlay></div>

      <a href="index.php" class="logo">
         <h3>D-Mart</h3>
      </a>

      <button class="nav-open-btn" data-nav-open-btn aria-label="Open Menu">
        <ion-icon name="menu-outline"></ion-icon>
      </button>

      <nav class="navbar" data-navbar>
        <button class="nav-close-btn" data-nav-close-btn aria-label="Close Menu">
          <ion-icon name="close-outline"></ion-icon>
        </button>

        <a href="index.php" class="logo">
           <center><h3>D-Mart</h3></center>
        </a>

        <ul class="navbar-list">
          
          <li class="navbar-item">
            <a href="index.php" class="navbar-link">Home</a>
          </li>
          <!-- dynamic menu -->
          <?php  
            // Fetch categories from the database
              $query = "SELECT id,name FROM categories where status = 1";
              $result = $conn->query($query);

              // Check if categories exist and start outputting HTML
              if ($result->num_rows > 0) {
                  // Loop through each category and generate a navbar item for each
                  while ($row = $result->fetch_assoc()) {
                      echo '<li class="navbar-item"><a href="index.php?id='.$row['id'].'" class="navbar-link">' . htmlspecialchars($row['name']) . '</a></li>';
                  }
              } else {
                  echo '<li class="navbar-item"><a href="#" class="navbar-link">No Categories</a></li>';
              }

              // Close the database connection
              $conn->close();
          ?>
        </ul>

        <ul class="nav-action-list">
          <li><button class="nav-action-btn"><ion-icon name="search-outline" aria-hidden="true"></ion-icon><span class="nav-action-text">Search</span></button></li>
          <!-- <li><a href="Login.html" class="nav-action-btn"><ion-icon name="person-outline" aria-hidden="true"></ion-icon><span class="nav-action-text">Login / Register</span></a></li> -->
          
          <li class="nav-action">
          <a href="javascript:void(0);" class="nav-action-btn">
              <ion-icon name="person-outline" aria-hidden="true"></ion-icon>
              <span class="nav-action-text">Account</span>
          </a>

              <!-- Dropdown Menu -->
              <ul class="dropdown-menu">
                  <li id="loggedInUserName" style="color: green;"></li>
                  <li> <a href="order_status.php">Order Status and Details</a></li>
                  <li><a class="btn"  href="php_files/logout.php">Logout</a></li>
              </ul>
          </li>
        <li>
            <button class="nav-action-btn" onclick="cartDetails()">
              <ion-icon name="bag-outline" aria-hidden="true"></ion-icon>
              <data class="nav-action-text" value="0.00">Basket: <strong id="cart_price">৳0.00</strong></data>
              <data class="nav-action-badge" value="0" aria-hidden="true" id="cart_item">0</data>
            </button>
          </li>

        </ul>
      </nav>
    </div>
  </header>
  

  <!-- Product Details Section -->
  <div class="product-details">
    <!-- Product Image -->
    <div class="product-image">
      <img id="productImage" alt="Product Image">
    </div>

    <!-- Product Info -->
    <div class="product-info" style="margin-top: 100px;" id="chossen_product">
      <h2 style="display:none;" id="productId">Product ID: 1</h2>
      <h3 id="productName"></h3>
      <p id="productPrice"></p>

      <!-- Shoe Size Selection -->
      <label for="shoeSize">Select Size:</label>
      <select id="shoeSize">
        <?php 
          while ($size = $sizes_result->fetch_assoc()) {
             echo "<option data-size-id='".htmlspecialchars($size['size_id'])."' value='".htmlspecialchars($size['size_name'])."'>".htmlspecialchars($size['size_name'])."</option>";
          }
        ?>
      </select>

      <!-- Buttons -->
      <div class="button-group">
        <a href="#" class="btn" onclick="addToCart()" style="background-color:black; color: white; padding: 8px 10px; border: none; border-radius: 4px; font-size: 14px; margin-top: 20px; width: 100px; cursor: pointer;">Add to Cart</a>
        <a href="index.php" class="btn" style="background-color:black; color: white; padding: 8px 10px; border: none; border-radius: 4px; font-size: 14px; margin-top: 20px; width: 90px; cursor: pointer;">Go Back</a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-bottom">
      <div class="container">
        <p class="copyright">
          &copy; 2024 <a href="#" class="copyright-link">Nusayba Haque Jerin</a>. All Rights Reserved
        </p>
      </div>
    </div>
  </footer>

  <!-- JavaScript to Load Product Details -->

  <!-- External Scripts -->
  <script src="./assets/js/script.js"></script>
  <script src="./assets/js/details.js"></script>
  <script src="./assets/js/login_check.js"></script>

  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
