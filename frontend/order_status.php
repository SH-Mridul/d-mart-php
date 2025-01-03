<?php
    require 'php_files/login_check.php'; 
    require 'php_files/database_connection.php'; 
    $categories_sql = "SELECT id, name FROM categories WHERE status = 1";
    $categories = $conn->query($categories_sql);

    $user_id = $_SESSION['id'];

        // Query to fetch orders for the current user
        $orders_sql = "SELECT id, total_amount, contact_number, order_date_time, order_status FROM orders WHERE user_id = ?";
        $stmt = $conn->prepare($orders_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D-Mart - Cart Details</title>
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="./assets/css/style.css">
   <style>
    /* Container to center the table */
    .table_container {
        text-align: center;
        padding: 20px;
    }

    table td{
        background-color: #ccd9ff;
    }

    /* Table styling */
    .cart-table {
        width: 850px;
        margin-left: 370px ;
        /* margin-right: 20%; */
        padding-top: 30px;
        border-collapse: collapse;
        /* background-color: red; */
        
    }

    /* Uniform styling for header and cells */
    .cart-table th, .cart-table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
        width: 150px;
        height: 100px;
    }

    /* Header row styling */
    .cart-table th {
        background-color: #f2f2f2;
        font-weight: bold;
        align-items: center;
    }

    /* Image styling for consistent sizing */
    .cart-table img {
        width: 80px;
        height: 80px;
        object-fit: cover;
    }

    /* Remove button styling */
    .remove-btn {
        background-color: #ff4d4d;
        color: white;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 4px;
    }

    /* Checkout button styling */
    .checkout-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: green;
        color: white;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        border-radius: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .cart-table {
            width: 100%;
        }
        .cart-table th, .cart-table td {
            font-size: 14px;
            padding: 8px;
        }
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

<body id="top">
    <header class="header" data-header>
        <div class="container">
            <div class="overlay" data-overlay></div>
            <a href="./index.php" class="logo">
                <h3>D-Mart</h3>
            </a>
            <button class="nav-open-btn" data-nav-open-btn aria-label="Open Menu">
                <ion-icon name="menu-outline"></ion-icon>
            </button>
            <nav class="navbar" data-navbar>
                <button class="nav-close-btn" data-nav-close-btn aria-label="Close Menu">
                    <ion-icon name="close-outline"></ion-icon>
                </button>
                <a href="./index.php" class="logo">
                    <center>
                        <h3>D-Mart</h3>
                    </center>
                </a>
                <ul class="navbar-list">
                    <li class="navbar-item"><a href="./index.php" class="navbar-link">Home</a></li>
                     <!-- dynamic menu -->
                    <?php  
                        // Loop through each category and generate a navbar item for each
                        while ($category = $categories->fetch_assoc()) {
                            echo '<li class="navbar-item"><a href="index.php?id='.$category['id'].'" class="navbar-link">' . htmlspecialchars($category['name']) . '</a></li>';
                        }
                    ?>
                </ul>
                <ul class="nav-action-list">
                    <li>
                        <button class="nav-action-btn">
                            <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
                            <span class="nav-action-text">Search</span>
                        </button>
                    </li>


                    <!-- <li>
                        <a href="Login.html" class="nav-action-btn">
                            <ion-icon name="person-outline" aria-hidden="true"></ion-icon>
                            <span class="nav-action-text">Login / Register</span>
                        </a>
                    </li> -->


                    <li class="nav-action">
                        <a href="javascript:void(0);" class="nav-action-btn">
                            <ion-icon name="person-outline" aria-hidden="true"></ion-icon>
                            <span class="nav-action-text">Account</span>
                        </a>

                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu">
                            <li id="loggedInUserName" style="color: green;"></li>
                            <li> <a href="order_status.php">Order Status and Details</a></li>
                            <li><a class="btn" onclick="logoutUser()" id="logoutBtn">Logout</a></li>
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

    
<section class="table_container">
    <h2>Your Orders</h2>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total Amount (৳)</th>
                <th>Contact Number</th>
                <th>Order Date</th>
                <th>Order Status</th>
            </tr>
        </thead>
        <tbody id="cart_items">
            <?php while ($order = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo '৳'.htmlspecialchars($order['total_amount']); ?></td>
                    <td><?php echo htmlspecialchars($order['contact_number']); ?></td>
                    <td><?php echo htmlspecialchars(date("F j, Y, g:i a", strtotime($order['order_date_time']))); ?></td>
                    <td>
                        <?php 
                           if($order['order_status'] == 0){
                            echo "Pending";
                           }else if($order['order_status'] == 1){
                             echo "Confirmed Order";
                           }else if($order['order_status'] == 2){
                             echo "On Delivery Process";
                           }else{
                            echo "<span style='color:green; font-weight: bold;'>Delivered</span>";
                           }
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/login_check.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
