<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Booking List";
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
            <h1>Booking List</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">


                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">My Booking List</h5>
                            <!-- Table with stripped rows -->
                            <table class="table datatable table-bordered table-hover">
                                <thead>
                                    <tr class="table-secondary">
                                        <th scope="col">#</th>
                                        <th scope="col">Booking ID</th>
                                        <th scope="col">Member Info</th>
                                        <th scope="col">Apply Date/Time</th>
                                        <th scope="col">Schedule Date</th>
                                        <th scope="col">Session Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                        //get member id from db - refer top_nav.php
                                        $trainerid = $userData['id'];

                                        include('include/connection.php');

                                        //get all trainer data from db
                                        $role_trainer = "trainer";
                                        $count = 0;

                                        $sqlSearch = "SELECT booking.id as bookid,booking.trainer_id,booking.member_id,booking.bookcode,booking.schedule_id,booking.applyDateTime,
                                                        booking.approveTrainer,booking.approveAdmin,booking.rateTrainer,booking.status as book_status,
                                                        trainer_schedule.id as trainid, trainer_schedule.trainer_id, trainer_schedule.trainDate, trainer_schedule.startTime,
                                                        trainer_schedule.endTime, trainer_schedule.status as schedule_status,
                                                        users.id as userid, users.gen_id, users.username, users.name 
                                                        FROM booking 
                                                        INNER JOIN users ON booking.member_id = users.id
                                                        INNER JOIN trainer_schedule ON booking.schedule_id = trainer_schedule.id
                                                        where booking.trainer_id = $trainerid";

                                        $resultSearch = $conn->query($sqlSearch);
                
                                        //if trainer data exist, show in list table
                                        if ($resultSearch->num_rows > 0) {

                                            while($searchData = $resultSearch->fetch_assoc()) {
                                                
                                                $count++;

                                                $bookId = $searchData['bookid'];

                                                $getFollowup = "SELECT * FROM followup WHERE book_id='$bookId'";
                                                $resultSearch2 = $conn->query($getFollowup);
                                                $reiewCount = $resultSearch2->num_rows;
                                    ?>  

                                        <tr>
                                            <th scope="row"><?php echo $count; ?></th>
                                            <td><?php echo $searchData['bookcode']; ?></td>
                                            <td><?php echo $searchData['name'] . " #" . $searchData['gen_id']; ?></td>
                                            <td><?php echo $searchData['applyDateTime']; ?></td>
                                            <td><?php echo $searchData['trainDate']; ?></td>
                                            <td><?php echo $searchData['startTime']. " - " .$searchData['endTime']; ?></td>
                                            <td>
                                                <?php 
                                                    $bgstatus = "";
                                                    $currentStatus = $searchData['book_status'];
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
                                                <hr/>

                                                <?php
                                                    //define status approveTrainer and approveAdmin
                                                    $appAdmin = $searchData['approveAdmin'];
                                                    $appTrainer = $searchData['approveTrainer'];
                                                ?>
                                                <p>
                                                    Admin : 
                                                    <?php
                                                        if($appAdmin=='yes'){
                                                            echo '<i class="bi bi-check-circle me-1"></i>';
                                                        }elseif($appAdmin=='no'){
                                                            echo '<i class="bi bi-x-circle me-1"></i>';

                                                        }else{
                                                            echo ' - ';
                                                        }
                                                    ?>
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
                                                </p>
                                            </td>
                                            <td>
                                                <?php
                                                    //define status approveTrainer and approveAdmin
                                                    $appAdmin = $searchData['approveAdmin'];
                                                    $appTrainer = $searchData['approveTrainer'];

                                                    if($appAdmin=="pending"){
                                                        echo '<span class="badge bg-secondary">Waiting for admin approval.</span>';
                                                    }elseif($appAdmin=='no'){
                                                        echo '<span class="badge bg-danger">Booking has been rejected by admin.</span>';
                                                    }elseif($appTrainer=='no'){
                                                        echo '<span class="badge bg-danger">Booking has been rejected by trainer.</span>';
                                                    }
                                                    
                                                    if($currentStatus=="pending" && $appAdmin == 'yes'){
                                                ?>

                                                <a class="btn btn-success btn-sm" href="booking_approveStatus.php?bookid=<?php echo $searchData['bookid']; ?>&status=1&role=2">Approved</a>
                                                <a class="btn btn-danger btn-sm" href="booking_approveStatus.php?bookid=<?php echo $searchData['bookid']; ?>&status=0&role=2">Rejected</a>
                                            
                                                <?php
                                                    }elseif($currentStatus=="approved" || $currentStatus=='completed'){
                                                ?>

                                                <a class="btn btn-info btn-sm" href="booking_detail.php?detail_id=<?php echo $searchData['bookid']; ?>">See Details</a>
                                                <a <?php if($reiewCount>0){echo 'hidden';} ?> class="btn btn-success btn-sm" href="booking_trainerReview.php?bookid=<?php echo $searchData['bookid']; ?>">Session Note</a>
                                            
                                                <?php
                                                    }
                                                ?>

                                            </td>
                                        </tr>
                                                
                                    <?php   
                                            }

                                        }else{

                                            echo '<tr>';
                                            echo '    <td colspan="10" class="bg-danger text-center text-white">Sorry, there is no data yet.</td>';
                                            echo '</tr>';

                                        }

                                    ?>

                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

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