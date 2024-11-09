<nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php"><b>D-Mart</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Product settings
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="productDropdown">
                            <li><a class="dropdown-item" href="brands.php">Brands</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="new_brand_add_form.php">Add New Brand</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="categories.php">Categories</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="new_category_add_form.php">Add New Category</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="sizes.php">Sizes</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="new_size_add_form.php">Add New Size</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Products</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Add New Product</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Messages</a></li>
                    <li class="nav-item">
                        <!-- Day/Night Mode Toggle Button with Icon -->
                        <button id="themeToggle" class="btn btn-link nav-link theme-toggle-icon">
                            <i id="toggleIcon" class="bi bi-moon"></i>
                        </button>
                    </li>
                    
                    <!-- User Icon with Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item text-success" href="admin_account_settings.php"><b><?php if(isset($_SESSION['username'])){ echo $_SESSION['username']; } ?></b></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="admin_list.php">Admin Users</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="new_admin_add_form.php">Add New Admin</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>