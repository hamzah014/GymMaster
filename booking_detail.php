<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Trainer Schedule";
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
            <h1>Schedule Table</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Schedule Information</h5>

                            <!-- Default Tabs -->
                            <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link w-100 active" id="member-tab" data-bs-toggle="tab"
                                        data-bs-target="#member-justified" type="button" role="tab"
                                        aria-controls="member" aria-selected="false">Booking Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link w-100" id="schedule-tab" data-bs-toggle="tab"
                                        data-bs-target="#schedule-justified" type="button" role="tab" aria-controls="schedule"
                                        aria-selected="true">Schedule Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link w-100" id="trainer-tab" data-bs-toggle="tab"
                                        data-bs-target="#trainer-justified" type="button" role="tab"
                                        aria-controls="trainer" aria-selected="false">Trainer Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link w-100" id="payment-tab" data-bs-toggle="tab"
                                        data-bs-target="#payment-justified" type="button" role="tab"
                                        aria-controls="payment" aria-selected="false">Payment Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link w-100" id="review-tab" data-bs-toggle="tab"
                                        data-bs-target="#review-justified" type="button" role="tab"
                                        aria-controls="review" aria-selected="false">Review/Followup</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link w-100" id="rate-tab" data-bs-toggle="tab"
                                        data-bs-target="#rate-justified" type="button" role="tab"
                                        aria-controls="rate" aria-selected="false">Session Rate</button>
                                </li>
                            </ul>

                            <?php 

                                include('include/connection.php');

                                //get all data from db
                                $detail_id = $_GET['detail_id'];  

                                //get data trainer_schedule db
                                $sqlSearch = "SELECT booking.id as bookid,booking.trainer_id,booking.member_id,booking.bookcode,booking.schedule_id,booking.applyDateTime,
                                            booking.approveTrainer,booking.approveAdmin,booking.rateTrainer,booking.status as book_status,booking.rateReview,booking.rateTrainer,
                                            trainer_schedule.id as trainid, trainer_schedule.trainer_id, trainer_schedule.trainDate, trainer_schedule.startTime,
                                            trainer_schedule.endTime, trainer_schedule.status as schedule_status 
                                            FROM booking 
                                            INNER JOIN trainer_schedule ON booking.schedule_id = trainer_schedule.id
                                            where booking.id = $detail_id LIMIT 1";

                                        
                                $resultSearch = $conn->query($sqlSearch);
                                $searchData = $resultSearch->fetch_assoc();

                                $trainDate = $searchData['trainDate'];
                                $startTime = $searchData['startTime'];
                                $endTime = $searchData['endTime'];
                                $trainer_id = $searchData['trainer_id'];

                                //get data trainer(users - users_profile)
                                $sqlSearch2 = "SELECT * FROM users
                                                INNER JOIN users_profile ON users.id = users_profile.user_id
                                                where users.id='$trainer_id' LIMIT 1";

                                        
                                $resultSearch2 = $conn->query($sqlSearch2);
                                $trainerData = $resultSearch2->fetch_assoc();

                                $gen_id = $trainerData['gen_id'];
                                $username = $trainerData['username'];
                                $name = $trainerData['name'];
                                $address = $trainerData['address'];
                                $birthDate = $trainerData['birthDate'];
                                $profilePic = $trainerData['profilePic'];

                                //get data booking
                                $sqlSearch3 = "SELECT booking.id as bookid,booking.trainer_id,booking.member_id,booking.bookcode,booking.schedule_id,booking.applyDateTime,
                                                booking.approveTrainer,booking.approveAdmin,booking.rateTrainer,booking.status as book_status,booking.rateReview,booking.rateTrainer,
                                                users.id as userid, users.gen_id, users.username, users.name,
                                                users_profile.*
                                                FROM booking
                                                INNER JOIN users ON booking.member_id = users.id
                                                INNER JOIN users_profile ON booking.member_id = users_profile.user_id
                                                where booking.id='$detail_id' LIMIT 1";

                                        
                                $resultSearch3 = $conn->query($sqlSearch3);

                                //get data booking
                                $sqlSearch4 = "SELECT booking.id as bookid,booking.trainer_id,booking.member_id,booking.bookcode,booking.schedule_id,booking.applyDateTime,
                                                booking.approveTrainer,booking.approveAdmin,booking.rateTrainer,booking.status as book_status,
                                                payment.*
                                                FROM booking
                                                INNER JOIN payment ON booking.id = payment.book_id
                                                where booking.id='$detail_id'";

                                        
                                $resultSearch4 = $conn->query($sqlSearch4);
                                
                                //get followup data db
                                $sqlSearch4 = "SELECT * FROM followup 
                                            WHERE book_id='$detail_id' LIMIT 1";

                                $resultSearch5 = $conn->query($sqlSearch4);
                                $reviewCount = $resultSearch5->num_rows;

                            ?>

                            <div class="tab-content pt-2" id="schedulefiedContent">
                                <div class="tab-pane fade show active  p-3" id="member-justified" role="tabpanel"
                                    aria-labelledby="member-tab">
                                    
                                    <?php
                                        if ($resultSearch3->num_rows > 0) {

                                    ?>

                                    <!-- Table with stripped rows -->
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="table-secondary">
                                                <th scope="col">#</th>
                                                <th scope="col">Booking ID</th>
                                                <th scope="col">Member Info</th>
                                                <th scope="col">Apply Date</th>
                                                <th scope="col">Approval</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                    <?php
                                            $count = 0;

                                            while($dataBooking = $resultSearch3->fetch_assoc()) {
                                                
                                                $count++;

                
                                   ?>

                                            <tr>
                                                <th scope="row"><?php echo $count; ?></th>
                                                <td><?php echo $dataBooking['bookcode']; ?></td>
                                                <td>
                                                    <b>Name :</b> <?php echo $dataBooking['name']; ?> 
                                                    <hr/>
                                                    <b>Tag ID :</b> #<?php echo $dataBooking['gen_id']; ?> 
                                                    <hr/>
                                                    <b>Username</b> <?php echo $dataBooking['username']; ?> 
                                                </td>
                                                <td><?php echo $dataBooking['applyDateTime']; ?></td>
                                                
                                                <?php
                                                    //define status approveTrainer and approveAdmin
                                                    $appAdmin = $dataBooking['approveAdmin'];
                                                    $appTrainer = $dataBooking['approveTrainer'];
                                                ?>

                                                <td>
                                                    Trainer :
                                                    <?php
                                                        if($appTrainer=='yes'){
                                                            echo '<i class="bi bi-check-circle me-1"></i>';
                                                        }elseif($appTrainer=='no'){
                                                            echo '<i class="bi bi-x-circle me-1"></i>';

                                                        }else{
                                                            echo ' - ';
                                                        }
                                                    ?>
                                                    Admin
                                                    <?php
                                                        if($appAdmin=='yes'){
                                                            echo '<i class="bi bi-check-circle me-1"></i>';
                                                        }elseif($appAdmin=='no'){
                                                            echo '<i class="bi bi-x-circle me-1"></i>';

                                                        }else{
                                                            echo ' - ';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                <?php 
                                                    $bgstatus = "";
                                                    $currentStatus = $dataBooking['book_status'];
                                                    //set background class by their current status
                                                    if($currentStatus == 'pending'){

                                                        $bgstatus = "secondary";

                                                    }elseif($currentStatus == 'approved'){

                                                        $bgstatus = "success";

                                                    }elseif($currentStatus == 'rejected'){

                                                        $bgstatus = "danger";

                                                    }elseif($currentStatus == 'completed'){

                                                        $bgstatus = "primary";

                                                    }else{

                                                        $bgstatus = "secondary";

                                                    }
                                                ?>
                                                <span class="badge bg-<?php echo $bgstatus; ?>"><?php echo ucfirst($currentStatus); ?></span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm" href="gallery_preview.php?member_id=<?php echo $dataBooking['member_id']; ?>">View Gallery</a>
                                                </td>
                                            </tr>
            
                                   <?php

                                            }

                                    ?>
                                            
                                        </tbody>
                                    </table>
                                    <!-- End Table with stripped rows -->

                                    <?php
                                        
                                        }else{
                                            echo '
                                            <div class="row">
                                                <div class="col-12 text-white text-center bg-secondary p-2"><b>Sorry, there is no booking made for this schedule.</b></div>
                                            </div>';
                                        }


                                    ?>

                                </div>
                                <div class="tab-pane fade p-3" id="schedule-justified" role="tabpanel"
                                    aria-labelledby="schedule-tab">

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label "><b>Schedule Date</b></div>
                                        <div class="col-lg-9 col-md-8"><?php echo $trainDate; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label"><b>Start Time</b></div>
                                        <div class="col-lg-9 col-md-8"><?php echo $startTime; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label"><b>End Time</b></div>
                                        <div class="col-lg-9 col-md-8"><?php echo $endTime; ?></div>
                                    </div>

                                </div>
                                <div class="tab-pane fade p-3" id="trainer-justified" role="tabpanel"
                                    aria-labelledby="trainer-tab">

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label "><b>Profile Picture</b></div>
                                        <div class="col-lg-9 col-md-8">
                                            
                                            <?php 
                                                $dirProfile = "assets/img/profile/";
                                                if($profilePic == ""){
                                            ?>

                                            <img src="assets/img/user_profile.png" alt="Profile" class="rounded-circle" style="width:10%">
                                                
                                            <?php
                                                }else{
                                            ?>

                                            <img src="<?php echo $dirProfile.$profilePic ?>" alt="Profile" class="rounded-circle" style="width:10%">
                                                
                                            <?php
                                                }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label "><b>Full Name</b></div>
                                        <div class="col-lg-9 col-md-8"><?php echo $name; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label"><b>Date of Birth</b></div>
                                        <div class="col-lg-9 col-md-8"><?php echo $birthDate; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label"><b>Address</b></div>
                                        <div class="col-lg-9 col-md-8"><?php echo $address; ?></div>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane fade p-3" id="payment-justified" role="tabpanel"
                                    aria-labelledby="payment-tab">

                                    <?php
                                        //print_r($resultSearch4);
                                    ?>
                                    
                                    <?php
                                    if ($resultSearch4->num_rows > 0) {

                                        ?>
        
                                        <!-- Table with stripped rows -->
                                        <table class="table table-bordered table-hover text-center">
                                            <thead>
                                                <tr class="table-secondary">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Amount (RM)</th>
                                                    <th scope="col">Resit Document</th>
                                                    <th scope="col">Payment Date</th>
                                                    <th scope="col">Approval Date</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                $count2 = 0;
                                                $dirResit = "assets/resit/";

                                                while($datapayment = $resultSearch4->fetch_assoc()) {
                                                    
                                                    $count2++;

                                                    $amount = $datapayment['amount'];
                                                    $resitFile = $datapayment['resitFile'];
                                                    $submitDateTime = $datapayment['submitDateTime'];
                                                    $approveDateTime = $datapayment['approveDateTime'];
                                                    $status = $datapayment['status'];

                                            ?>

                                                <tr>
                                                    <td><?php echo $count2; ?></td>
                                                    <td><?php echo $amount; ?></td>
                                                    <td><a href="<?php echo $dirResit . $resitFile; ?>" target="_blank"><u>View Resit</u></a></td>
                                                    <td><?php echo $submitDateTime; ?></td>
                                                    <td>
                                                        <?php 
                                                            if($status=='approved'){
                                                                echo $approveDateTime;
                                                            }else{
                                                                echo '-';
                                                            }
                                                        ?>
                                                    </td>
                                                <td>
                                                <?php 
                                                    $bgstatus = "";
                                                    $currentStatus = $status;
                                                    //set background class by their current status
                                                    if($currentStatus == 'pending'){

                                                        $bgstatus = "secondary";

                                                    }elseif($currentStatus == 'approved'){

                                                        $bgstatus = "success";

                                                    }elseif($currentStatus == 'rejected'){

                                                        $bgstatus = "danger";

                                                    }
                                                ?>
                                                <span class="badge bg-<?php echo $bgstatus; ?>"><?php echo ucfirst($currentStatus); ?></span>
                                                </td>
                                                </tr>

                                            <?php
                                                }
                                            ?>
                                            
                                            </tbody>
                                        </table>
                                    <!-- End Table with stripped rows -->

                                    
                                    <?php
                                        }else{
                                            echo '
                                            <div class="row">
                                                <div class="col-12 text-white text-center bg-secondary p-2"><b>Sorry, there is no payment made for this schedule yet.</b></div>
                                            </div>';
                                        }

                                    ?>
                                    
                                </div>

                                <div class="tab-pane fade p-3" id="review-justified" role="tabpanel"
                                    aria-labelledby="review-tab">

                                    <div class="row">
                                        <div class="col-12 label "><b>Review/Followup :</b></div>
                                        <hr/>
                                        <div class="col-12">
                                            <?php
                                                if($reviewCount > 0){
                                                    $dataReview = $resultSearch5->fetch_assoc();

                                                    echo $dataReview['review'];

                                                }else{
                                                    echo '<span class="text-danger">No review/followup yet by trainer.</span>';
                                                }
                                            ?>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade p-3" id="rate-justified" role="tabpanel"
                                    aria-labelledby="rate-tab">

                                    <h3>Rating by Member</h3>

                                    <div class="row">
                                        <div class="col-md-12 label ">
                                            <b>Rating : </b>
                                            <?php
                                                $rateTrainer = $searchData['rateTrainer'];
                                                $rateReview = $searchData['rateReview'];
                                                if($rateTrainer > 0){
                                                    echo $rateTrainer . ' <i class="bi bi-star-fill"></i>';

                                                }else{
                                                    echo '<span class="text-danger">No rating yet by member.</span>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 label ">
                                            <b>Review : </b>
                                            <?php
                                                if($rateTrainer > 0){
                                                    echo $rateReview;

                                                }else{
                                                    echo '<span class="text-danger">No review yet by member.</span>';
                                                }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                                
                            </div><!-- End Default Tabs -->

                            

                            <div class="pt-5">
                                <a href="schedule_search.php" class="btn btn-secondary" <?php if($roleuser!="admin"){echo 'hidden';} ?>>Back to Search</a>
                                <a href="booking_myTrainer.php" class="btn btn-secondary" <?php if($roleuser!="trainer"){echo 'hidden';} ?>>Back to My Booking</a>
                                <a href="schedule_myTrainer.php" class="btn btn-secondary" <?php if($roleuser!="trainer"){echo 'hidden';} ?>>Back to My Schedule</a>
                            </div>

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