<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Trainer List";
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
            <h1>Trainer List</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">


                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Trainer Data</h5>
                            
                            <!-- Table with stripped rows -->
                            <table class="table datatable table-bordered table-striped table-hover text-center">
                                <thead>
                                    <tr class="table-secondary">
                                        <th scope="col">#</th>
                                        <th scope="col">Booking ID</th>
                                        <th scope="col">Amount (RM)</th>
                                        <th scope="col">Resit Document</th>
                                        <th scope="col">Payment Date</th>
                                        <th scope="col">Approval Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include('include/connection.php');
                                        

                                        //get data booking
                                        $sqlSearch4 = "SELECT booking.id as bookid,booking.trainer_id,booking.member_id,booking.bookcode,booking.schedule_id,booking.applyDateTime,
                                                        booking.approveTrainer,booking.approveAdmin,booking.rateTrainer,booking.status as book_status,
                                                        payment.*
                                                        FROM payment
                                                        INNER JOIN booking ON  payment.book_id = booking.id ORDER BY payment.id DESC";
        
                                                
                                        $resultSearch4 = $conn->query($sqlSearch4);
                
                                        //if trainer data exist, show in list table
                                        if ($resultSearch4->num_rows > 0) {
                                            $count2 = 0;
                                            $dirResit = "assets/resit/";

                                            while($datapayment = $resultSearch4->fetch_assoc()) {
                                                
                                                $count2++;

                                                $bookid = $datapayment['bookid'];
                                                $payid = $datapayment['id'];
                                                $bookcode = $datapayment['bookcode'];
                                                $amount = $datapayment['amount'];
                                                $resitFile = $datapayment['resitFile'];
                                                $submitDateTime = $datapayment['submitDateTime'];
                                                $approveDateTime = $datapayment['approveDateTime'];
                                                $status = $datapayment['status'];

                                        ?>

                                            <tr>
                                                <td><?php echo $count2; ?></td>
                                                <td><a href="booking_detail.php?detail_id=<?php echo $bookid; ?>" target="_blank"><?php echo $bookcode; ?></a></td>
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
                                                    
                                                <td>
                                                    <a class="btn btn-success btn-sm" href="payment_approveStatus.php?payid=<?php echo $payid; ?>&status=1">Approved</a>
                                                    <a class="btn btn-danger btn-sm" href="payment_approveStatus.php?payid=<?php echo $payid; ?>&status=0">Rejected</a>
                                                </td>
                                            </tr>

                                        <?php
                                            }
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