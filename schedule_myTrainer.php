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
                
                <?php

                    //get member id from db - refer top_nav.php
                    $trainerid = $userData['id'];

                    $errorMsg = array();
                    $role_trainer = "trainer";

                    $resultSearch = "";
                    $resultUser = "";
                    $dataUser = "";
                    $dataExist = "no";

                    include('include/connection.php');

                    $sqlSearch = "SELECT * 
                        FROM trainer_schedule
                        WHERE trainer_id = '$trainerid'";


                    $resultSearch = $conn->query($sqlSearch);

                
                ?>
                
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Schedule Table</h5>

                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr class="table-secondary">
                                        <th scope="col">#</th>
                                        <th scope="col">Slot Date</th>
                                        <th scope="col">Start Time</th>
                                        <th scope="col">End Time</th>
                                        <th scope="col">Availability</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        $no = 0;
                                        while($searchData = $resultSearch->fetch_assoc()) {

                                            $no++;
                
                                    ?>

                                    <tr>
                                        <th scope="row"><?php echo $no; ?></th>
                                        <td><?php echo $searchData['trainDate']; ?></td>
                                        <td><?php echo $searchData['startTime']; ?></td>
                                        <td><?php echo $searchData['endTime']; ?></td>
                                        <td><?php echo ucfirst($searchData['status']); ?></td>
                                        <td>
                                            
                                            <a class="btn btn-primary btn-sm" href="schedule_detail.php?detail_id=<?php echo $searchData['id']; ?>">See Details</a>
                                               
                                        </td>
                                    </tr>

                                    <?php


                                        }

                                    ?>

                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

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