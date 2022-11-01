<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Dashboard";
        include_once('include/header.php');
    ?>

</head>

<body>

    <!-- ======= Header ======= -->
    <?php include('include/top_nav.php'); ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php include('include/side_nav.php'); ?>
    <!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Trainer Registration</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Register Form</h5>
                            <br/>

                            <?php

                                $name = "";
                                $birthDate = "";
                                $address = "";
                                $email = "";
                                $errorMsg = array();
                                $role_trainer = "trainer";

                                //check form submit - trainer register]\
                                if(isset($_POST) && !empty($_POST)){

                                    include('include/connection.php');

                                    //get post data
                                    //print_r($_POST);
                                    $name = $_POST['name'];
                                    $birthDate = $_POST['birthDate'];
                                    $address = $_POST['address'];
                                    $email = $_POST['email'];
                                    $password = $_POST['password'];

                                    //check value for each data
                                    if($name == "" && empty($name)){
                                        array_push($errorMsg,"Please enter full name.");
                                    }

                                    if($birthDate == "" && empty($birthDate)){
                                        array_push($errorMsg,"Please enter date of birth.");
                                    }
                                    
                                    if($address == "" && empty($address)){
                                        array_push($errorMsg,"Please enter address.");
                                    }

                                    if($email == "" && empty($email)){
                                        array_push($errorMsg,"Please enter email.");
                                    }else{
                                        
                                        //check the email is exist or not
                                        $getUser = "SELECT username FROM users where username='$email' and role='$role_trainer'";
                                        $resultUser = $conn->query($getUser);
                
                                        //if email is exist, add error message
                                        if ($resultUser->num_rows > 0) {
                                            //echo 'taken';
                                            array_push($errorMsg,"Your email has been taken.");
                                        }

                                    }

                                    if(empty($password) && $password==""){
                                      array_push($errorMsg,"Please enter password.");
                                    }

                                    
                                    //check if there is no error occurred, insert data into db
                                    if(empty($errorMsg)){
                                    
                                      $gen_id = "TRN" . rand(1000,9999);
                                      $hashpassword = hash('sha256', $password);
                                    
                                      $sqlInsertUser = "INSERT INTO users (gen_id,username,password,name,role) VALUES ('$gen_id','$email','$hashpassword','$name','$role_trainer')";
                                    
                                      if ($conn->query($sqlInsertUser) === TRUE) {
//
                                        $last_id = $conn->insert_id;
//
                                        $sqlInsertProfile = "INSERT INTO users_profile (user_id,email,address,birthDate) VALUES ('$last_id','$email','$address','$birthDate')";
                                        if ($conn->query($sqlInsertProfile) === TRUE) {
                                        
                                          $_POST = array();
                                        
                                          echo '<div class="p-1 bg-success text-white"><b>Registration have been successful.</b></div>';
                                        
                                        }
                                    
                                      } else {
                                        array_push($errorMsg,"Error occurred while inserting data. Please submit the registration again.");
                                      }
                                  
                                    }



                                }

                                //show error message if there is any error catch
                                if(!empty($errorMsg)){
            
                                  echo '<div class="pt-1 pb-1">';
                                  echo '<p class="text-danger">Please complete the form to proceed registration.</p>';
                                  echo '  <ul>';
                                  
                                  foreach($errorMsg as $key=>$value){
                                    echo '    <li class="text-danger">'.$value.'</li>';
                                  }
            
                                  echo '  </ul>';
                                  echo '</div>';
            
            
                                }

                            ?>


                            <!-- Horizontal Form -->
                            <form method="post" action="trainer_register.php">
                                <p><b>General Information</b></p>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" id="name" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="birthDate" class="col-sm-2 col-form-label">Date of Birth</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="birthDate" class="form-control" id="birthDate" value="<?php if(isset($_POST['birthDate'])){echo $_POST['birthDate'];} ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <textarea name="address" id="address" class="form-control" style="height: 100px"><?php if(isset($_POST['address'])){echo $_POST['address'];} ?></textarea>
                                    </div>
                                </div>
                                <br/>
                                <p><b>Login Credential</b></p>
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="email" class="form-control" id="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" class="form-control" id="password">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form><!-- End Horizontal Form -->

                        </div>
                    </div>

                </div><!-- End Right side columns -->

            </div>
        </section>

    </main><!-- End #main -->


    <!-- ======= Footer ======= -->
    <?php include('include/footer.php'); ?>
    <!-- End Footer-->

    <!-- ======= Script ======= -->
    <?php include('include/script.php'); ?>
    <!-- End Script-->

</body>

</html>