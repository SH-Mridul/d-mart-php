<?php 
    session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Login Template</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #4CAF50;
            margin: 0;
            padding: 0;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .login-card .form-control {
            height: 50px;
            font-size: 16px;
        }

        .btn-success {
            background-color: #4CAF50;
            border: none;
        }

        .btn-success:hover {
            background-color: #45a049;
        }

        .card-body a {
            color: #4CAF50;
            text-decoration: none;
        }

        .card-body a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card login-card">
        <div class="card-body">
            <h4 class="text-center mb-4">Admin Login</h4>
            <form action="login_user.php" method = "post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="email address" name = "email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="password" name = "password">
                </div>

                <div class="mx-auto" style="width: 200px;">
                    <span class="text-danger text-center">
                        <?php 
                            if(isset($_SESSION['error'])){ 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']); 
                            }
                        ?>
                    </span>

                    <span class="text-success text-center">
                        <?php 
                            if(isset($_SESSION['success'])){ 
                                echo $_SESSION['success'];
                                unset($_SESSION['success']); 
                            }
                        ?>
                    </span>
                </div>
                
                <button type="submit" class="btn btn-success btn-block mt-2">LOGIN</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
