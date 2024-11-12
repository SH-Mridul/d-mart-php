<?php
    require 'php_files/login_check.php'; 
    require 'php_files/database_connection.php'; 

    // Fetch categories from the database
    $categories_sql = "SELECT id, name FROM categories WHERE status = 1";
    $categories = $conn->query($categories_sql);

    // Check if a category ID is set in the URL
    $categoryCondition = "";
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $category_id = $_GET['id'];
        $categoryCondition = "AND c.id = $category_id";
    }

    // Fetch products with an optional filter by category
    $product_sql = "
        SELECT 
            p.id AS product_id,
            p.name AS product_name,
            p.image_path AS image,
            p.price AS price,
            p.status,
            b.name AS brand_name,
            GROUP_CONCAT(DISTINCT CONCAT(c.id, ':', c.name) ORDER BY c.name ASC SEPARATOR ', ') AS category_names,
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
            $categoryCondition
        GROUP BY 
            p.id
        ORDER BY 
            p.name ASC;
    ";

    // Execute the query
    $products = $conn->query($product_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D-Mart - Find your footware</title>
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet">
  <link rel="preload" href="./assets/images/hero-banner.png" as="image">

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


          <li class="nav-action">
          <a href="javascript:void(0);" class="nav-action-btn">
              <ion-icon name="person-outline" aria-hidden="true"></ion-icon>
              <span class="nav-action-text">Account</span>
          </a>

          <!-- Dropdown Menu -->
          <ul class="dropdown-menu">
              <li style="color: green;"><?php echo $_SESSION['name']; ?></li>
              <li> <a href="order_status.php">Order Status and Details</a></li>
              <li><a class="btn" href="php_files/logout.php">Logout</a></li>
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

  <input type="hidden" id = "name" value = "<?php echo $_SESSION['name'];?>">
  <input type="hidden" id = "email" value = "<?php echo $_SESSION['email'];?>">
  <input type="hidden" id= "user_type" value = "<?php echo $_SESSION['user_type'];?>">


  <main>
    <article>

      <section class="section hero" style="background-image: url('./assets/images/banner-2.jpg')">
        <div class="container">

          <h2 class="h1 hero-title">
            New<strong>Shoes Collection</strong>
          </h2>

          <p class="hero-text">
            Competently expedite alternative benefits whereas leading-edge catalysts for change. Globally leverage
            existing an
            expanded array of leadership.
          </p>

        </div>
      </section>
       
      <section class="section product">
        <div class="container">

          <ul class="product-list">

            <?php while ($product = $products->fetch_assoc()) {?>
            <li class="product-item" id="<?php echo 'product_'.$product['product_id']; ?>" data-id="<?php echo $product['product_id']; ?>">
              <div class="product-card" tabindex="0">
                <figure class="card-banner">
                  <img src="<?php echo '..//backend/'.$product['image'];?>" width="312" height="350" loading="lazy"
                    alt="Running Sneaker Shoes" class="image-contain" id="<?php echo 'product_'.$product['product_id'].'_image_url'; ?>"  data-image-url="<?php echo '..//backend/'.$product['image'];?>">
                </figure>

                <div class="card-content">

                  <div class="card-cat">
                    <?php
                      $counter = 0;
                      $categories = explode(',', $product['category_names']);
                      foreach ($categories as $category) {
                        list($category_id, $category_name) = explode(':', $category);
                        if($counter < count( $categories)-1){
                           echo "<a href='index.php?id=".htmlspecialchars($category_id)."' class='card-cat-link'>" . htmlspecialchars($category_name) . "</a> /";
                        }else{
                           echo "<a href='#' class='card-cat-link'>" . htmlspecialchars($category_name) . "</a>";
                        }

                        $counter++;
                      }
                    ?>
                   
                    
                    <!-- <a href="#" class="card-cat-link">Women</a> -->
                  </div>

                  <h3 class="h3 card-title">
                    <a href="#" id="<?php echo 'product_'.$product['product_id'].'_name'?>"><?php echo htmlspecialchars($product['product_name'])?></a>
                  </h3>

                  <data class="card-price" value="<?php echo htmlspecialchars($product['price'])?>" id="<?php echo 'product_'.$product['product_id'].'_price'?>">৳<?php echo htmlspecialchars($product['price'])?></data>
                  <center><a type="button" style="background-color:black; color: white; padding: 8px 10px; border: none; border-radius: 4px; font-size: 14px; margin-top: 20px; width: 130px; cursor: pointer;" onclick="storeProductData('<?php echo 'product_'.$product['product_id']; ?>')">Details</a></center>
                </div>

              </div>
            </li>

              <?php } ?>
          </ul>

        </div>
      </section>

    </article>
  </main>


  <footer class="footer">

    <div class="footer-bottom">
      <div class="container">

        <p class="copyright">
          &copy; 2024 <a href="#" class="copyright-link">Nusayba Haque Jerin</a>. All Rights Reserved
        </p>

      </div>
    </div>

  </footer>


  <a href="#top" class="go-top-btn" data-go-top>
    <ion-icon name="arrow-up-outline"></ion-icon>
  </a>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get data from hidden input fields
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const userType = document.getElementById('user_type').value;

        // Create an object for the current user
        const currentUser = {
            name: name,
            email: email,
            user_type: userType,
            is_login: true
        };

        // Store currentUser in sessionStorage
        sessionStorage.setItem("currentUser", JSON.stringify(currentUser));
    });
</script>

  <script src="./assets/js/script.js"></script>
  <script src="./assets/js/index.js"></script>
  <script src="./assets/js/login_check.js"></script>

  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>