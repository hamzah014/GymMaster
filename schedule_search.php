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
                            <h5 class="card-title">Table of Trainer Schedule</h5>
                            <br />

                            <?php

                                $trainerid = "";
                                $trainDate = "";
                                $startTime = "";
                                $endTime = "";

                                $errorMsg = array();
                                $role_trainer = "trainer";

                                $resultSearch = "";
                                $resultUser = "";
                                $dataUser = "";
                                $dataExist = "no";

                                include('include/connection.php');

                                //check form submit - trainer register]\
                                if(isset($_POST) && !empty($_POST)){

                                    //get post data
                                    //print_r($_POST);
                                    $trainerid = $_POST['trainer_id'];

                                    //check value for each data
                                    if($trainerid == "" && empty($trainerid)){
                                        array_push($errorMsg,"Please select trainer.");
                                    }
                                    
                                    //check if there is no error occurred, insert data into db
                                    if(empty($errorMsg)){

                                        $sqlSearch = "SELECT * 
                                                    FROM trainer_schedule
                                                    WHERE trainer_id = '$trainerid'";

                                        $sqlUser = "SELECT * 
                                                    FROM users
                                                    WHERE id = '$trainerid'";

                                        
                                        $resultSearch = $conn->query($sqlSearch);

                                        $resultUser = $conn->query($sqlUser);
                                        $dataUser = $resultUser->fetch_assoc();

                                        if ($resultSearch->num_rows > 0) {
                                            $dataExist = "yes";

                                        }else {
                                            array_push($errorMsg,"Error occurred while inserting data. Please submit the registration again.");
                                        }
                                  
                                    }



                                }

                                //show error message if there is any error catch
                                if(!empty($errorMsg)){
            
                                  echo '<div class="pt-1 pb-1">';
                                  echo '<p class="text-danger">Please complete the form to proceed registration.</p>';
                                  echo '  <ul>';
                                  
                                  foreach($errorMsg as $key=>$value){
                                    echo '    <li class="text-danger">'.$value.'</li>';
                                  }
            
                                  echo '  </ul>';
                                  echo '</div>';
            
            
                                }

                                //get all trainer list from db
                                $getTrainer = "SELECT * FROM users where role='$role_trainer'";
                                $resultTrainer = $conn->query($getTrainer);

                            ?>


                            <!-- Horizontal Form -->
                            <form method="post" action="schedule_search.php">
                                <div class="row mb-3">
                                    <label for="trainer_id" class="col-sm-2 col-form-label">Trainer Name</label>
                                    <div class="col-sm-10">
                                        <select name="trainer_id" class="form-select"
                                            aria-label="Default select example">
                                            <option <?php if($resultTrainer->num_rows < 1){echo 'selected';} ?> value="">Select Trainer</option>
                                            <?php
                                                while($trainerData = $resultTrainer->fetch_assoc()) {
                                                    $selected = "";
                                                
                                                    if(isset($_POST['trainer_id']) && $trainerData['id'] == $_POST['trainer_id']){
                                                        $selected = "selected";
                                                    }

                                                    echo '<option '.$selected.' value="'.$trainerData['id'].'">'.$trainerData['name'] . " #" . $trainerData['gen_id'] .'</option>';

                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="schedule_search.php" class="btn btn-secondary">Reset</a>
                                </div>
                            </form><!-- End Horizontal Form -->

                        </div>
                    </div>

                </div><!-- End Right side columns -->


                <?php

                    //show table if data exist in db
                    if($dataExist == 'yes'){

                ?>

                <hr />

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Schedule Table</h5>
                            <p><b>Trainer Name : </b><?php echo $dataUser['name']; ?></p>
                            <p><b>Trainer Tag : </b>#<?php echo $dataUser['gen_id']; ?></p>

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
                                            <a class="btn btn-info btn-sm" href="schedule_edit.php?edit_id=<?php echo $searchData['id']; ?>">Edit</a>
                                            <a class="btn btn-danger btn-sm" href="schedule_delete.php?delete_id=<?php echo $searchData['id']; ?>">Delete</a>
                                               
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


                <?php

                    }

                ?>

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