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
            <h1>Schedule Registration</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Register Trainer Schedule Form</h5>
                            <br />

                            <?php

                                $trainer_id = "";
                                $trainDate = "";
                                $startTime = "";
                                $endTime = "";
                                $errorMsg = array();
                                $role_trainer = "trainer";

                                include('include/connection.php');

                                //check form submit - trainer register]\
                                if(isset($_POST) && !empty($_POST)){

                                    //get post data
                                    //print_r($_POST);
                                    $trainer_id = $_POST['trainer_id'];
                                    $trainDate  = $_POST['trainDate'];
                                    $startTime  = $_POST['startTime'];
                                    $endTime    = $_POST['endTime'];

                                    //check value for each data
                                    if($trainer_id == "" && empty($trainer_id)){
                                        array_push($errorMsg,"Please select trainer.");
                                    }

                                    if($trainDate == "" && empty($trainDate)){
                                        array_push($errorMsg,"Please select slot date.");
                                    }

                                    if($startTime == "" && empty($startTime)){
                                        array_push($errorMsg,"Please select slot start time.");
                                    }

                                    if($endTime == "" && empty($endTime)){
                                        array_push($errorMsg,"Please select slot end time.");
                                    }

                                    
                                    //check if there is no error occurred, insert data into db
                                    if(empty($errorMsg)){

                                        $sqlInsert = "INSERT INTO trainer_schedule 
                                                        (trainer_id,trainDate,startTime,endTime) 
                                                        VALUES ('$trainer_id','$trainDate','$startTime','$endTime')";

                                        if ($conn->query($sqlInsert) === TRUE) {
                                                                                
                                            $_POST = array();

                                            echo '<div class="p-2 text-success"><b>Trainer schedule have been successfully registered.</b></div>';

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
                            <form method="post" action="schedule_register.php">
                                <div class="row mb-3">
                                    <label for="trainer_id" class="col-sm-2 col-form-label">Trainer Name</label>
                                    <div class="col-sm-10">
                                        <select name="trainer_id" class="form-select"
                                            aria-label="Default select example">
                                            <option value="">Select Trainer</option>
                                            <?php
                                                $selected = "";
                                                while($trainerData = $resultTrainer->fetch_assoc()) {
                                                
                                                    if(isset($_POST['trainer_id']) && $trainerData['id'] == $_POST['trainer_id']){
                                                        $selected = "selected";
                                                    }

                                                    echo '<option '.$selected.' value="'.$trainerData['id'].'">'.$trainerData['name'] . " #" . $trainerData['gen_id'] .'</option>';

                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="trainDate" class="col-sm-2 col-form-label">Slot Date</label>
                                    <div class="col-sm-10">
                                        <input name="trainDate" type="date" class="form-control" id="trainDate"
                                            value="<?php if(isset($_POST['trainDate'])){echo $_POST['trainDate'];} ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="startTime" class="col-sm-2 col-form-label">Start Time</label>
                                    <div class="col-sm-10">
                                        <input name="startTime" type="time" class="form-control" id="startTime"
                                            value="<?php if(isset($_POST['startTime'])){echo $_POST['startTime'];} ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="endTime" class="col-sm-2 col-form-label">End Time</label>
                                    <div class="col-sm-10">
                                        <input name="endTime" type="time" class="form-control" id="endTime"
                                            value="<?php if(isset($_POST['endTime'])){echo $_POST['endTime'];} ?>">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form><!-- End Horizontal Form -->

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