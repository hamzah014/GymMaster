<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "My Profile";
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
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <?php 

            //define all variable data that will be displayed
            $role = $_SESSION['role'];
            $id = $_SESSION['id'];
            $gen_id = "";
            $name = "";
            $birthDate = "";
            $username = "";
            $address   = "";
            $details   = "";

            //print_r($_SESSION);

            include('include/connection.php');

            //get user data profile by their role, and assign value to variable above
            if($_SESSION['role']=='admin'){

                //check the admin id match in db
                $getUser = "SELECT * FROM admins where id='$id'";
                $resultUser = $conn->query($getUser);

                $userData = $resultUser->fetch_assoc();

                $gen_id = "ADM123";
                $username = $userData['username'];
                $name = $userData['name'];

            }else{

                //check the trainer/member id match in db
                $getUser = "SELECT * FROM users
                INNER JOIN users_profile ON users.id = users_profile.user_id
                where users.id='$id' ";
                $resultUser = $conn->query($getUser);

                $userData = $resultUser->fetch_assoc();

                $gen_id = $userData['gen_id'];
                $username = $userData['username'];
                $name = $userData['name'];
                $address = $userData['address'];
                $birthDate = $userData['birthDate'];
                $details = $userData['details'];

            }


        ?>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-3">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center text-center">

                            <img src="assets/img/user_profile.png" alt="Profile" class="rounded-circle">
                            <h3 class=""><b><?php echo $name; ?></b></h3>
                            <h3><?php echo ucwords($role); ?> #<?php echo $gen_id; ?></h3>
                        </div>
                    </div>

                </div>

                <div class="col-xl-9">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Overview</button>
                                </li>

                                <li class="nav-item" <?php if($role=='admin'){echo 'hidden';} //hide the menu for admin ?> >
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                        Profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Change Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $name; ?></div>
                                    </div>

                                    <div class="row" <?php if($role=='admin'){echo 'hidden';} //hidden birthdate for admin ?>>
                                        <div class="col-lg-3 col-md-4 label">Date of Birth</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $birthDate; ?></div>
                                    </div>
                                    <div class="row" <?php if($role=='admin'){echo 'hidden';} //hidden address for admin ?>>
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $address; ?></div>
                                    </div>
                                    <div class="row" <?php if($role=='admin'){echo 'hidden';} //hidden details for admin ?> >
                                        <div class="col-lg-3 col-md-4 label">Description/Bio</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $details; ?>
                                        </div>
                                    </div>

                                    <h5 class="card-title">Account Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $username; ?></div>
                                    </div>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <?php
                                        $errorMsg = array();

                                        //check the post data either exist or not
                                        //if exist - verify each data
                                        if(isset($_POST['id']) && !empty($_POST['id'])){
                                        
                                            include('include/connection.php');
                                        
                                            //print_r($_POST);
                                        
                                            $id             = $_POST['id'];
                                            $name           = $_POST['name'];
                                            $username       = $_POST['username'];
                                            $address        = $_POST['address'];
                                            $birthDate        = $_POST['birthDate'];
                                            $details        = $_POST['details'];
                                            $edit_role      = $_POST['edit_role'];
                                        
                                            if(empty($name) && $name==""){
                                                array_push($errorMsg,"Please enter name.");
                                            }

                                            if($birthDate == "" && empty($birthDate)){
                                                array_push($errorMsg,"Please enter date of birth.");
                                            }
                                        
                                            if(empty($address) && $address==""){
                                                array_push($errorMsg,"Please enter address.");
                                            }
                                        
                                            if(empty($username) && $username==""){
                                                array_push($errorMsg,"Please enter email.");
                                            }else{
                                            
                                                //check the username is exist or not
                                                if($edit_role != 'admin'){

                                                    $getUser = "SELECT username FROM users where username='$username' AND id != '$id'";
                                                    $resultUser = $conn->query($getUser);
                                            
                                                    //if username is exist, add error message
                                                    if ($resultUser->num_rows > 0) {
                                                        array_push($errorMsg,"The email has been taken.");
                                                    }

                                                }
                                            
                                            }
                                        
                                            //check if there is no error occurred, insert data into db
                                            if(empty($errorMsg)){
                                            
                                                $sqlUpdateUser = "UPDATE users
                                                                 SET username='$username',name='$name'
                                                                 WHERE id='$id' ";

                                                if($edit_role == 'admin'){
                                                    $sqlUpdateProf = true;
                                                }else{
    
                                                    $sqlUpdateProf = "UPDATE users_profile
                                                                     SET 
                                                                     address='$address',
                                                                     birthDate='$birthDate',
                                                                     details='$details'
                                                                     WHERE user_id='$id' ";

                                                }

                                                if ($conn->query($sqlUpdateUser) == TRUE && $conn->query($sqlUpdateProf) == TRUE) {
                                                
                                                    echo '<script>alert("User profile have been successfully updated.");</script>';
                                                    echo '<script>window.location.href="users_profile.php"</script>';
                                                
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

                                    <!-- Profile Edit Form -->
                                    <form method="post" action="users_profile.php">
                                        <h5 class="card-title">Profile Details</h5>
                                        <input class="d-none" type="text" name="id" value="<?php echo $id; ?>">
                                        <input class="d-none" type="text" name="edit_role" value="<?php echo $role; ?>">
                                        <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-lg-3 col-form-label">Full
                                                Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="name" type="text" class="form-control" id="name"
                                                    value="<?php echo $name; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="birthDate" class="col-md-4 col-lg-3 col-form-label">Date of Birth</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="birthDate" type="date" class="form-control" id="birthDate"
                                                    value="<?php echo $birthDate; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="address" class="form-control" <?php if($role=='admin'){echo 'disabled';} //disabled address for admin ?> id="address"
                                                    style="height: 100px"><?php echo $address; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="details" class="col-md-4 col-lg-3 col-form-label">Description/Bio</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="details" class="form-control tinymce-editor" <?php if($role=='admin'){echo 'hidden';} //disabled address for admin ?> 
                                                    id="details"><?php echo $details; ?></textarea>
                                            </div>
                                        </div>

                                        <h5 class="card-title">Account Details</h5>
                                        <div class="row mb-3">
                                            <label for="username"
                                                class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="username" type="text" class="form-control" id="username"
                                                    value="<?php echo $username; ?>">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form method="post" action="users_profile.php">

                                    <?php
                                        $errorMsg2 = array();

                                        //check the post data either exist or not
                                        //if exist - verify each data
                                        if(isset($_POST['updatePass_id']) && !empty($_POST['updatePass_id'])){
                                        
                                            include('include/connection.php');
                                        
                                            //print_r($_POST);
                                        
                                            $id               = $_POST['updatePass_id'];
                                            $edit_role        = $_POST['edit_role'];
                                            $newPass1         = $_POST['newPass1'];
                                            $newPass2         = $_POST['newPass2'];
                                        
                                            if(empty($newPass1) && $newPass1==""){
                                                array_push($errorMsg2,"Please enter new password.");
                                            }
                                        
                                            if(empty($newPass2) && $newPass2==""){
                                                array_push($errorMsg2,"Please enter re-enter new password.");
                                            }
                                        
                                            //check if there is no error occurred, insert data into db
                                            if(empty($errorMsg2)){

                                                if($newPass1 != $newPass2){
                                                    array_push($errorMsg2,"The password do not match.");
                                                }else{

                                                    $hashpassword = hash('sha256', $newPass1);
    
                                                    if($edit_role == 'admin'){
                                                    
                                                        $sqlUpdateUser = "UPDATE admins
                                                                         SET password='$hashpassword'
                                                                         WHERE id='$id' ";
                                                    }else{
                                                    
                                                        $sqlUpdateUser = "UPDATE users
                                                                         SET password='$hashpassword'
                                                                         WHERE id='$id' ";
    
                                                    }
    
                                                    if ($conn->query($sqlUpdateUser) == TRUE) {
                                                    
                                                        echo '<script>alert("User password have been successfully updated.");</script>';
                                                        echo '<script>window.location.href="users_profile.php"</script>';
                                                    
                                                    } else {
                                                        array_push($errorMsg2,"Error occurred while inserting data. Please submit the registration again.");
                                                    }

                                                }
                                            
                                            
                                            }
                                        
                                        
                                        }
                                    
                                        //show error message if there is any error catch
                                        if(!empty($errorMsg2)){
                                        
                                            echo '<div class="pt-1 pb-1">';
                                            echo '<p class="text-danger">Please refer the error before completing the submission.</p>';
                                            echo '  <ul>';
                                        
                                            foreach($errorMsg2 as $key=>$value){
                                                echo '    <li class="text-danger">'.$value.'</li>';
                                            }
                                        
                                            echo '  </ul>';
                                            echo '</div>';
                                        
                                        
                                        }

                                    ?>

                                        <input class="d-none" type="text" name="updatePass_id" value="<?php echo $id; ?>">
                                        <input class="d-none" type="text" name="edit_role" value="<?php echo $role; ?>">
                                        <div class="row mb-3">
                                            <label for="newPass1" class="col-md-4 col-lg-3 col-form-label">New
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newPass1" type="password" class="form-control"
                                                    id="newPass1">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPass2" class="col-md-4 col-lg-3 col-form-label">Re-enter
                                                New Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newPass2" type="password" class="form-control"
                                                    id="newPass2">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
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