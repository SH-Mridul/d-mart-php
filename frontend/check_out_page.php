<?php
    require 'php_files/login_check.php'; 
    require 'php_files/database_connection.php'; 
    $categories_sql = "SELECT id, name FROM categories WHERE status = 1";
    $categories = $conn->query($categories_sql);
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

    /* Table styling */
    .cart-table {
        width: 80%;
        margin-left: 25%;
        margin-right: 10%;
        padding-top: 30px;
        border-collapse: collapse;
        
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

  <!-- form css -->
  <style>
    /* Styling for the form container */
        .user-form {
            width: 100%;
            max-width: 80%;
            margin: 30px auto;
            padding: 30px;
            border-radius: 12px;
            background-color: #e8f9f5;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Form title */
        .user-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form labels */
        .user-form label {
            display: block; /* Ensures labels are displayed above input fields */
            margin-bottom: 10px;
            margin-left: 13px;
            font-size: 16px;
            color: #333;
            font-weight: bold;
            text-align:left;
            /* padding-left;100px; */
        }

        /* Input fields styling */
        .user-form input[type="text"],
        .user-form input[type="email"],
        .user-form textarea {
            width: calc(100% - 20px);
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #9dd5c0;
            border-radius: 8px;
            font-size: 16px;
            background-color: #ffffff;
            color: #333;
            outline: none;
            transition: border-color 0.3s;
        }

        .user-form input[type="text"]:focus,
        .user-form input[type="email"]:focus,
        .user-form textarea:focus {
            border-color: #39b889;
        }

        /* Textarea adjustment */
        .user-form textarea {
            resize: vertical;
            height: 100px;
        }

        /* Button styling */
        .user-form .checkout-btn {
            padding: 12px 20px;
            background-color: #39b889;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .user-form .checkout-btn:hover {
            background-color: #2f9e72;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .user-form {
                width: 90%;
                padding: 20px;
            }
            .user-form input[type="text"],
            .user-form input[type="email"],
            .user-form textarea {
                font-size: 14px;
            }
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
                            <li><a href="order_status.php">Order Status and Details</a></li>
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
    <h2>Your Cart</h2>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Size</th>
                <th>Product Quantity</th>
                <th>Product Price</th>
                <th>Total Price</th>
                <!-- <th>Remove</th> -->
            </tr>
        </thead>
        <tbody id="cart_items">
            <!-- Example static row for demonstration, replace with dynamic data as needed -->
            <tr>
                <td><img src="product-image-url.jpg" alt="Product Image"></td>
                <td>6</td>
                <td>1</td>
                <td>৳1880.00</td>
                <td>৳1880.00</td>
                <!-- <td><button class="remove-btn">Remove</button></td> -->
            </tr>
        </tbody>
    </table>
    <!-- <button  onclick="checkout()" class="checkout-btn">Proceed to Checkout</button> -->
</section>


<section class="user-form">
    <h2>Your Information</h2>
    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
        <input type="hidden" name="total_amount" id="total_amount_form">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo $_SESSION['name']; ?>"  placeholder="Enter your name" required>
        
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Enter your email" value="<?php echo $_SESSION['email']; ?>" id="email" required>
        
        <label for="contact_number">Contact Number</label>
        <input type="text" name="contact_number" placeholder="Enter your contact number" id="contact_number" required>
        
        <label for="address">Address</label>
        <textarea name="address" id="address" rows="4" placeholder="Enter your address" required></textarea>
        
        <button type="submit" class="checkout-btn">Checkout</button>
    </form>
</section>


    <!-- <script></script> -->
    <script src="./assets/js/check_out.js"></script>
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/login_check.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
