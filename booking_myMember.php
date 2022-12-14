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
                            <p class="text-primary">
                                <i class="bi bi-info-circle"></i> If you have made 2nd payment, please keep update with payment status on See Details. <br/>
                                <i class="bi bi-info-circle"></i> If your status is rejected, please go to counter and show the details to claim your deposit. <br/>
                            </p>
                            <!-- Table with stripped rows -->
                            <table class="table datatable table-bordered table-hover">
                                <thead>
                                    <tr class="table-secondary">
                                        <th scope="col">#</th>
                                        <th scope="col">Booking ID</th>
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
                                        $member_id = $userData['id'];

                                        include('include/connection.php');

                                        //get all trainer data from db
                                        $role_trainer = "trainer";
                                        $count = 0;

                                        $sqlSearch = "SELECT booking.id as bookid,booking.trainer_id,booking.member_id,booking.bookcode,booking.schedule_id,booking.applyDateTime,
                                                        booking.approveTrainer,booking.approveAdmin,booking.rateTrainer,booking.status as book_status,
                                                        trainer_schedule.id as trainid, trainer_schedule.trainer_id, trainer_schedule.trainDate, trainer_schedule.startTime,
                                                        trainer_schedule.endTime, trainer_schedule.status as schedule_status 
                                                        FROM booking 
                                                        INNER JOIN trainer_schedule ON booking.schedule_id = trainer_schedule.id
                                                        where booking.member_id = $member_id";

                                        $resultSearch = $conn->query($sqlSearch);
                
                                        //if trainer data exist, show in list table
                                        if ($resultSearch->num_rows > 0) {

                                            while($searchData = $resultSearch->fetch_assoc()) {
                                                
                                                $count++;
                                                $bookid = $searchData['bookid'];
                                    ?>  

                                        <tr>
                                            <th scope="row"><?php echo $count; ?></th>
                                            <td><?php echo $searchData['bookcode']; ?></td>
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
                                            </td>
                                            <td>
                                                <?php
                                                    //get amount payment
                                                    $statusApp = 'approved';

                                                    $sqlSearch4 = "SELECT *
                                                    FROM payment
                                                    WHERE book_id='$bookid' && status='$statusApp'";
                                
                                                    $resultSearch4 = $conn->query($sqlSearch4);
                                                    $payQuantity = $resultSearch4->num_rows;
                                                    //echo $payQuantity;
                                                ?>
                                                
                                                <a <?php if($currentStatus=='pending' || $currentStatus=='rejected'){echo 'hidden';} ?> class="btn btn-primary btn-sm" href="booking_detail.php?detail_id=<?php echo $searchData['bookid']; ?>">See Details</a>
                                                <a <?php if($searchData['rateTrainer']>0){echo 'hidden';} ?> class="btn btn-info btn-sm" href="booking_rate.php?bookid=<?php echo $searchData['bookid']; ?>">Rate Session</a>
                                                <a <?php if($payQuantity==2 || $currentStatus=='rejected'){echo 'hidden';} ?> class="btn btn-success btn-sm" href="booking_paymentComplete.php?bookid=<?php echo $searchData['bookid']; ?>&member_id=<?php echo $member_id; ?>&trainer_id=<?php echo $searchData['trainer_id']; ?>">Complete Payment</a>
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