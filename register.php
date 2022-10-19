<!DOCTYPE html>
<html lang="en">

<head>
  <?php
    $title = "Register Account";
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
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <?php 


                    $name = "";
                    $username = "";
                    $password = "";
                    $terms = "";
                    $errorMsg = array();

                    //check the post data either exist or not
                    //if exist - verify each data
                    if(isset($_POST) && !empty($_POST)){

                      include('include/connection.php');

                      //print_r($_POST);

                      $name     = $_POST['name'];
                      $username = $_POST['username'];
                      $password = $_POST['password'];

                      if(empty($name) && $name==""){
                        array_push($errorMsg,"Please enter name.");
                      }

                      if(empty($username) && $username==""){
                        array_push($errorMsg,"Please enter username.");
                      }else{

                        //check the username is exist or not
                        $getUser = "SELECT username FROM users where username='$username'";
                        $resultUser = $conn->query($getUser);

                        //if username is exist, add error message
                        if ($resultUser->num_rows > 0) {
                          array_push($errorMsg,"Your username has been taken.");
                        }

                      }

                      if(empty($password) && $password==""){
                        array_push($errorMsg,"Please enter password.");
                      }

                      if(!isset($_POST['terms'])){
                        array_push($errorMsg,"Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy.");
                      }

                      //check if there is no error occurred, insert data into db
                      if(empty($errorMsg)){

                        $gen_id = "CUST" . rand(1000,9999);
                        $role = "customer";
                        $hashpassword = hash('sha256', $password);

                        $sqlInsertUser = "INSERT INTO users (gen_id,username,password,name,role) VALUES ('$gen_id','$username','$hashpassword','$name','$role')";
                        
                        if ($conn->query($sqlInsertUser) === TRUE) {

                          $last_id = $conn->insert_id;

                          $sqlInsertProfile = "INSERT INTO users_profile (user_id) VALUES ('$last_id')";
                          if ($conn->query($sqlInsertProfile) === TRUE) {

                            $_POST = array();
  
                            echo '<div class="p-1 text-success"><b>Registration have been successful.</b></div>';

                          }

                        } else {
                          array_push($errorMsg,"Error occurred while inserting data. Please submit the registration again.");
                        }

                      }


                    }

                    //show error message if there is any error catch
                    if(!empty($errorMsg)){

                      echo '<div class="pt-1 pb-1">';
                      echo '  <ul>';
                      
                      foreach($errorMsg as $key=>$value){
                        echo '    <li class="text-danger">'.$value.'</li>';
                      }

                      echo '  </ul>';
                      echo '</div>';


                    }
                  
                  ?>


                  <form class="row g-3" method="post" action="register.php">
                    <div class="col-12">
                      <label for="yourName" class="form-label">Your Name</label>
                      <input type="text" name="name" class="form-control" id="name" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>">
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" id="username" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>">
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="text" name="password" class="form-control" id="password" >
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" id="terms" value="accept">
                        <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="login.php">Log in</a></p>
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