<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>D-Mart|Registration</title>
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <style>
      /* Make the section fill the viewport height */
      section {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      /* Ensure the card content fits within the viewport */
      .card {
        max-height: 90vh;
        overflow: scroll;
      }
    </style>
  </head>
  <body>

  <?php session_start(); ?>

  <!-- Set default values in case session variables are not set -->
  <input type="hidden" id="notification_error" value="<?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?>">
  <input type="hidden" id="notification_success" value="<?php echo isset($_SESSION['success']) ? $_SESSION['success'] : ''; ?>">

  <?php 
    // Unset session variables after using them
    unset($_SESSION['error']);
    unset($_SESSION['success']);
  ?>


    <section class="bg-light p-3 p-md-4 p-xl-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-xxl-11">
            <div class="card border-light-subtle shadow-sm">
              <div class="row g-0">
                <div class="col-12 col-md-6">
                  <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy" src="./images/reg.avif" alt="Welcome to the registration page">
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                  <div class="col-12 col-lg-11 col-xl-10">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                      <div class="row">
                        <h4 class="mb-5 p-4 text-center border rounded border-dark bg-success text-light">Join Our</h4>
                        <div class="col-12">
                          <div class="d-flex gap-3 flex-column">
                            <a href="#!" class="btn btn-lg btn-outline-dark">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                                <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                              </svg>
                              <span class="ms-2 fs-6">Sign up with Google</span>
                            </a>
                          </div>
                          <p class="text-center mt-4 mb-5">Or sign up with</p>
                        </div>
                      </div>
                        <form action="php_files/registration_user.php" id="regForm" method = "post">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Enter Name">
                                 <span id="nameError"></span>
                            </div>

                            <div class="form-group mb-3">
                                <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Enter Email Address">
                                 <span id="emailError"></span>
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" class="form-control form-control-sm" name="password" id="password" placeholder="Enter password">
                                 <span id="passError"></span>
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" class="form-control form-control-sm" name="confirm_password" id="confirmPassword" placeholder="Confirm your password">
                                 <span id="conPassError"></span>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="terms">
                                <label class="form-check-label" for="terms">I agree to the Terms and Conditions</label>
                                <br><span id="termsError"></span>
                            </div>

                           <div class="col-12">
                            <div class="d-grid">
                              <button class="btn btn-dark btn-sm" type="submit">Register Now</button>
                            </div>
                          </div>
                        </form>
                      
                      <div class="row">
                        <div class="col-12">
                          <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                            <a href="./login.html" class="link-secondary text-decoration-none">Already have an account? Log in</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script src="assets/js/registration.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Get the value from the element with a specific ID
        var error     = document.getElementById('notification_error').value;
        var success   = document.getElementById('notification_success').value;
        
       if(error.length !== 0){
        setTimeout(function() {
            alert(error);
        }, 500); 
       }

       if(success.length !== 0){
        setTimeout(function() {
            alert(success);
        }, 500); 
       }
    });

    </script>
  </body>
</html>
