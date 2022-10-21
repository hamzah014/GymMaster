<!DOCTYPE html>
<html lang="en">

<head>

  <?php
    $title = "Login";
    include_once('include/header.php');
  ?>

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block"><?php echo $systemName; ?></span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">LOGIN - ADMIN</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <?php 

                    $username = "";
                    $password = "";
                    $errorMsg = array();

                    //check the post data either exist or not
                    //if exist - verify each data
                    if(isset($_POST) && !empty($_POST)){
                    
                      include('include/connection.php');
                    
                      //print_r($_POST);
                    
                      $username = $_POST['username'];
                      $password = $_POST['password'];
                      
                      if(empty($username) && $username==""){
                        array_push($errorMsg,"Please enter username.");
                      }
                    
                      if(empty($password) && $password==""){
                        array_push($errorMsg,"Please enter password.");
                      }
                      
                      //check if there is no error occurred, check data on db
                      if(empty($errorMsg)){

                        $hashpassword = hash('sha256', $password);

                        //check the username and password match in db
                        $getUser = "SELECT * FROM admins where username='$username' and password='$hashpassword'";
                        $resultUser = $conn->query($getUser);
                      
                        //if there's data matched
                        if ($resultUser->num_rows > 0) {

                          //get users data
                          $userData = $resultUser->fetch_assoc();
          
                          //set session for admin - username, id
                          $_SESSION['id']         = $userData['id'];
                          $_SESSION['username']   = $userData['username'];
                          $_SESSION['role']       = "admin";
          
                          //redirect to dashboard page
                          echo '<script>alert("Hi, '.$userData['name'].'!");</script>';
                          echo "<script>window.location.href='index.php';</script>";
                          exit;

                        } else {
                          array_push($errorMsg,"Your username and password is incorrect.");
                        }

                      
                      }
                    
                    
                    }
                  
                    //show error message if there is any error catch
                    if(!empty($errorMsg)){
                    
                      echo '<div class="pt-1 pb-1">';
                      echo '<p class="text-danger">Please refer the error before completing the submission.</p>';
                      echo '  <ul>';

                      foreach($errorMsg as $key=>$value){
                        echo '    <li class="text-danger">'.$value.'</li>';
                      }
                    
                      echo '  </ul>';
                      echo '</div>';
                    
                    
                    }
                  
                  ?>


                  <form class="row g-3 needs-validation" method="post" action="loginAdmin.php">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" id="username" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>">
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password">
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Are you Members? <a href="login.php">Login Here</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>