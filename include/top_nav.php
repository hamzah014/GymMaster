<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block"><?php echo $systemName; ?></span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <?php

        //get user information
        //check either session data is exist or not
        if(isset($_SESSION) && !empty($_SESSION)){
            
            include('include/connection.php');

            $id = $_SESSION['id'];
            $username = "";
            $name = "";
            $role = $_SESSION['role'];
            $profilePic = "user_profile.png"; //default profile picture

            $dirProfile = "assets/img/profile/";

            if($role == 'admin'){
                //get admin data by id match in db
                $getUser = "SELECT * FROM admins where id='$id' LIMIT 1";

            }else{
                //get user data by id match in db
                $getUser = "SELECT * FROM users
                            INNER JOIN users_profile ON users.id = users_profile.user_id
                            where users.id='$id' LIMIT 1";

            }
            
            //get user data from query
            $resultUser = $conn->query($getUser);
            
            //get users data
            $userData = $resultUser->fetch_assoc();
            //print_r($userData);

            //assign user data to variable for easy access
            $username = $userData['username'];
            $name = $userData['name'];

            if($role == 'admin'){
                $tag = "ADMIN";

            }else{
                $tag = $userData['gen_id'];

                if($userData['profilePic'] != ""){
                    $profilePic = $userData['profilePic'];
                }

            }

        }else{
            header("Location:index.php");
        }

    ?>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <!-- <i class="bi bi-person-circle"></i> -->
                    <img src="<?php echo $dirProfile.$profilePic; ?>" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $username; ?></span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $name; ?></h6>
                        <span><?php echo ucwords($role) . " #" . $tag; ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users_profile.php">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li <?php if($role!='member'){echo 'hidden';} ?>>
                        <a class="dropdown-item d-flex align-items-center" href="users_gallery.php">
                            <i class="bi bi-camera"></i>
                            <span>My Gallery</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>