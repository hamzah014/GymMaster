<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Member Register";
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
            <h1>Member Registration</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Register Form</h5>
                            <br />

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
                                    
                                    $name       = $_POST['name'];
                                    $username   = $_POST['username'];
                                    $password   = $_POST['password'];
                                    $address    = $_POST['address'];
                                    
                                    if(empty($name) && $name==""){
                                        array_push($errorMsg,"Please enter name.");
                                    }
                                
                                    if(empty($address) && $address==""){
                                        array_push($errorMsg,"Please enter address.");
                                    }
                                
                                    if(empty($username) && $username==""){
                                        array_push($errorMsg,"Please enter email.");
                                    }else{
                                    
                                        //check the username is exist or not
                                        $getUser = "SELECT username FROM users where username='$username'";
                                        $resultUser = $conn->query($getUser);
                                    
                                        //if username is exist, add error message
                                        if ($resultUser->num_rows > 0) {
                                        array_push($errorMsg,"Your email has been taken.");
                                        }
                                    
                                    }
                                
                                    if(empty($password) && $password==""){
                                        array_push($errorMsg,"Please enter password.");
                                    }
                                
                                    //check if there is no error occurred, insert data into db
                                    if(empty($errorMsg)){
                                    
                                        $gen_id = "MMR" . rand(1000,9999);
                                        $role = "member";
                                        $hashpassword = hash('sha256', $password);
                                    
                                        $sqlInsertUser = "INSERT INTO users (gen_id,username,password,name,role) VALUES ('$gen_id','$username','$hashpassword','$name','$role')";
                                        
                                        if ($conn->query($sqlInsertUser) === TRUE) {
                                        
                                        $last_id = $conn->insert_id;
                                        
                                        $sqlInsertProfile = "INSERT INTO users_profile (user_id,email,address) VALUES ('$last_id','$username','$address')";
                                        if ($conn->query($sqlInsertProfile) === TRUE) {
                                        
                                            $_POST = array();
                                        
                                            echo '<div class="p-1 text-success"><b>Member have been successfully registered.</b></div>';
                                        
                                        }
                                    
                                        } else {
                                            array_push($errorMsg,"Error occurred while inserting data. Please submit the registration again.");
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

                            <!-- Horizontal Form -->
                            <form method="post" action="member_register.php">
                                <p><b>General Information</b></p>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <textarea name="address" id="address" class="form-control"
                                            style="height: 100px"><?php if(isset($_POST['address'])){echo $_POST['address'];} ?></textarea>
                                    </div>
                                </div>
                                <br />
                                <p><b>Login Credential</b></p>
                                <div class="row mb-3">
                                    <label for="username" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="username" class="form-control" id="username"
                                            value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="password" class="form-control" id="password">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
                            <!-- End Horizontal Form -->

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