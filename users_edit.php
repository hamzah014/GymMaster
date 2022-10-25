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

        <?php
            //define role for edit user
            $edit_role   = "";

            if(isset($_GET['edit_role']) && !empty($_GET['edit_role'])){
                $edit_role = $_GET['edit_role'];

            }elseif(isset($_POST['edit_role']) && !empty($_POST['edit_role'])){
                $edit_role = $_POST['edit_role'];

            }
        ?>

        <div class="pagetitle">
            <h1><?php echo ucfirst($edit_role); ?> Profile</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit <?php echo ucfirst($edit_role); ?> Profile</h5>
                            <br />

                            <?php 

                                $id = "";
                                $name = "";
                                $username = "";
                                $address   = "";
                                $errorMsg = array();

                            
                                //get user data profile from db and display in form
                                if(isset($_GET['edit_id']) && !empty($_GET['edit_id'])){

                                    include('include/connection.php');
                                    
                                    $id = $_GET['edit_id'];
                                    $edit_role = $_GET['edit_role'];
                                    
                                    
                                    //check the username and password match in db
                                    $getUser = "SELECT * FROM users 
                                        INNER JOIN users_profile ON users.id = users_profile.user_id
                                        where users.id='$id'";
                                    $resultUser = $conn->query($getUser);

                                    //if users id is exist, return all user data
                                    if ($resultUser->num_rows > 0) {
                                        
                                        $dataUser = $resultUser->fetch_assoc();

                                        $name = $dataUser['name'];
                                        $username = $dataUser['username'];
                                        $address = $dataUser['address'];


                                    }else{
                                        echo '<script>alert("User ID does not exist. Please try again.");</script>';
                                        echo '<script>window.history.back()</script>';
                                    }


                                }


                                //check the post data either exist or not
                                //if exist - verify each data
                                elseif(isset($_POST['id']) && !empty($_POST['id'])){

                                    include('include/connection.php');
                                    
                                    //print_r($_POST);
                                    
                                    $id         = $_POST['id'];
                                    $name       = $_POST['name'];
                                    $username   = $_POST['username'];
                                    $address    = $_POST['address'];
                                    $edit_role    = $_POST['edit_role'];
                                    
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
                                        $getUser = "SELECT username FROM users where username='$username' AND id != '$id'";
                                        $resultUser = $conn->query($getUser);
                                    
                                        //if username is exist, add error message
                                        if ($resultUser->num_rows > 0) {
                                            array_push($errorMsg,"The email has been taken.");
                                        }
                                    
                                    }
                                
                                    //check if there is no error occurred, insert data into db
                                    if(empty($errorMsg)){
                                    
                                        $sqlUpdateUser = "UPDATE users
                                                         SET username='$username',name='$name'
                                                         WHERE id='$id' ";
                                    
                                        $sqlUpdateProf = "UPDATE users_profile
                                                         SET address='$address'
                                                         WHERE user_id='$id' ";
                                        
                                        if ($conn->query($sqlUpdateUser) === TRUE && $conn->query($sqlUpdateProf) === TRUE) {
                                            
                                            echo '<div class="p-1 text-success"><b>User profile have been successfully updated.</b></div>';
                                    
                                        } else {
                                            array_push($errorMsg,"Error occurred while inserting data. Please submit the registration again.");
                                        }
                                    
                                    }


                                }else{
                                    echo '<script>alert("You have no access here. Please try again.");</script>';
                                    echo '<script>window.history.back()</script>';
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
                            <form method="post" action="users_edit.php">
                                <p><b>General Information</b></p>
                                <input class="d-none" type="text" name="id" value="<?php echo $id; ?>">
                                <input class="d-none" type="text" name="edit_role" value="<?php echo $edit_role; ?>">
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="<?php echo $name; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <textarea name="address" id="address" class="form-control"
                                            style="height: 100px"><?php echo $address; ?></textarea>
                                    </div>
                                </div>
                                <br />
                                <p><b>Login Credential</b></p>
                                <div class="row mb-3">
                                    <label for="username" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="username" class="form-control" id="username"
                                            value="<?php echo $username; ?>">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                    <a class="btn btn-secondary" href="<?php if($edit_role=='member'){echo 'member_list.php';} else{echo 'trainer_list.php';} ?>">Cancel</a>
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