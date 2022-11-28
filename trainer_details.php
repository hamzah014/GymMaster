<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Trainer Details";
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
            <h1>Trainer Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Trainer</li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <?php 

            //define all variable data that will be displayed
            $id = $_GET['uid'];
            $gen_id = "";
            $name = "";
            $birthDate = "";
            $username = "";
            $address   = "";
            $details   = "";
            $profilePic = "";

            $dirProfile = "assets/img/profile/";

            //print_r($_SESSION);

            include('include/connection.php');

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
                $profilePic = $userData['profilePic'];


        ?>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-3">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center text-center">

                            <?php 
                                if($profilePic == ""){
                            ?>

                            <img src="assets/img/user_profile.png" alt="Profile" class="rounded-circle">
                            
                            <?php
                                }else{
                            ?>

                            <img src="<?php echo $dirProfile.$profilePic ?>" alt="Profile" class="rounded-circle">
                            
                            <?php
                                }
                            ?>
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
                                        data-bs-target="#profile-overview">Profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#review-overview">Review</button>
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

                                <div class="tab-pane fade pt-3" id="review-overview">
                                    <h5 class="card-title">Trainer Review</h5>

                                    <div class="row">

                                        <!-- Table with stripped rows -->
                                        <table class="table datatable table-bordered table-hover">
                                            <thead>
                                                <tr class="table-secondary">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Reviewer</th>
                                                    <th scope="col">Rating <i class="bi bi-star-fill"></i></th>
                                                    <th scope="col">Review/Comment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/connection.php');

                                                    //get all trainer data from db
                                                    $statusComp = "completed";
                                                    $count = 0;

                                                    $sqlState = "SELECT * 
                                                                FROM booking
                                                                INNER JOIN users ON booking.member_id = users.id
                                                                WHERE booking.status='$statusComp' AND booking.trainer_id ='$id' ";
                                                    $resultGet = $conn->query($sqlState);

                                                    //if trainer data exist, show in list table
                                                    if ($resultGet->num_rows > 0) {

                                                        while($dataGet = $resultGet->fetch_assoc()) {
                                                            
                                                            $count++;

                                                ?>  
                                                    <tr>
                                                        <th scope="row"><?php echo $count; ?></th>
                                                        <td><?php echo $dataGet['name']; ?></td>
                                                        <td>
                                                            <?php 
                                                                
                                                                $countStar =  $dataGet['rateTrainer']; 

                                                                echo $countStar . " ";

                                                                for($x=0;$x<$countStar;$x++){

                                                                    echo '<i class="bi bi-star-fill"></i>';

                                                                }
                                                            
                                                            ?>
                                                        </td>
                                                        <td><?php echo $dataGet['rateReview']; ?></td>
                                                    </tr>

                                                <?php   
                                                        
                                                        }

                                                    }else{

                                                        echo '<tr>';
                                                        echo '    <td colspan="10" class="bg-danger text-center text-white">Sorry, there is no review for this trainer yet.</td>';
                                                        echo '</tr>';

                                                    }

                                                ?>

                                            </tbody>
                                        </table>
                                        <!-- End Table with stripped rows -->
                                    </div>

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