<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Activity";
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
            <h1>My Activity</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Calculate Calories Burn</h5>
                            <br />

                            <?php
                                
                                $iduser = $_SESSION['id'];

                                $metarray = array(
                                                array("Aerobics, Step: high impact", 7.0),
                                                array("Cycling, Stationary: moderate", 8.0),
                                                array("Calisthenics: moderate", 3.5),
                                                array("Circuit Training: general", 8.0),
                                                array("Elliptical Trainer: general", 5.0),
                                                array("Rowing, Stationary: moderate", 5.0),
                                                array("Ski Machine: general", 6.0),
                                                array("Stair Step Machine: general", 8.0),
                                                array("Stretching, Hatha Yoga", 2.5),
                                                array("Weight Lifting: general", 5.0),
                                                array("Weight Lifting: vigorous", 6.0)
                                            );

                                //formula = (Time(minit) * MET * 3.5 * weight(kg) ) / 200

                                $id = "";
                                $activity_date = "";
                                $metName = "";
                                $metValue = 0;
                                $durationHour = "";
                                $durationMinute = "";
                                $weight = "";

                                include('include/connection.php');

                                $errorMsg = array();

                                //check form submit - trainer register]
                                //print_r($_GET);
                                
                                if(isset($_GET['uid']) && !empty($_GET['uid'])){

                                    include('include/connection.php');
                                    
                                    $id = $_GET['uid'];
                                    
                                    
                                    //check the id in db
                                    $getData = "SELECT * FROM calorieActivities 
                                        where id='$id'";

                                    $resultData = $conn->query($getData);
                                    //print_r($resultData);

                                    //if users id is exist, return all user data
                                    if ($resultData->num_rows > 0) {
                                        
                                        $dataActivity = $resultData->fetch_assoc();

                                        $id = $dataActivity['id'];
                                        $activity_date = $dataActivity['activity_date'];
                                        $metName = $dataActivity['metName'];
                                        $metValue = $dataActivity['metValue'];
                                        $durationHour = $dataActivity['durationHour'];
                                        $durationMinute = $dataActivity['durationMinute'];
                                        $weight = $dataActivity['weight'];


                                    }else{
                                        echo '<script>alert("Activity detail does not exist. Please try again.");</script>';
                                        echo '<script>window.history.back()</script>';
                                    }


                                }elseif(isset($_POST) && !empty($_POST)){

                                    //get post data
                                    //print_r($_POST);
                                    $id = $_POST['id'];
                                    $activity_date = $_POST['activity_date'];
                                    $metName = $_POST['metName'];
                                    $durationHour = $_POST['durationHour'];
                                    $durationMinute = $_POST['durationMinute'];
                                    $weight = $_POST['weight'];

                                    //check value for each data
                                    if($activity_date == "" && empty($activity_date)){
                                        array_push($errorMsg,"Please enter activity date.");
                                    }
                                    
                                    if($metName == "" && empty($metName)){
                                        array_push($errorMsg,"Please select activity.");
                                    }

                                    if($durationHour == "" && empty($durationHour)){
                                        array_push($errorMsg,"Please enter hours.");
                                    }
                                    
                                    if($durationMinute == "" && empty($durationMinute)){
                                        array_push($errorMsg,"Please enter minutes.");
                                    }

                                    if($weight == "" && empty($weight)){
                                        array_push($errorMsg,"Please enter weight.");
                                    }
                                    
                                    //check if there is no error occurred, insert data into db
                                    if(empty($errorMsg)){

                                        foreach($metarray as $metval){

                                            if($metval[0] == $metName ){

                                                $metValue = $metval[1];

                                            }

                                        }

                                        //insert into db
                                    
                                        $sqlUpdate = "UPDATE calorieactivities
                                                         SET 
                                                         activity_date='$activity_date',
                                                         metName='$metName',
                                                         metValue='$metValue',
                                                         durationHour='$durationHour',
                                                         durationMinute='$durationMinute',
                                                         weight='$weight'
                                                         WHERE id='$id' ";
                                        
                                        if ($conn->query($sqlUpdate) === TRUE) {
                                            
                                            echo '<div class="p-1 text-success"><b>Activity details have been successfully updated.</b></div>';
                                    
                                        } else {
                                            array_push($errorMsg,"Error occurred while inserting data. Please submit the form again.");
                                        }
                                        
                                  
                                    }



                                }

                                //show error message if there is any error catch
                                if(!empty($errorMsg)){
 
                                  echo '<div class="pt-1 pb-1">';
                                  echo '<p class="text-danger">Please complete the form to proceed calculation.</p>';
                                  echo '  <ul>';
                                  
                                  foreach($errorMsg as $key=>$value){
                                    echo '    <li class="text-danger">'.$value.'</li>';
                                  }
            
                                  echo '  </ul>';
                                  echo '</div>';
            
            
                                }


                            ?>
                            <form method="post" action="activity_edit.php">
                                <input type="text" name="id" id="id" value="<?php echo $id; ?>" class="d-none">
                                <div class="row mb-3">
                                    <label for="weight" class="col-sm-2 col-form-label">Date of Activity</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="activity_date" class="form-control" id="activity_date"
                                            value="<?php echo $activity_date; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Activity</label>
                                    <div class="col-sm-10">
                                        <select name="metName" class="form-select" aria-label="Default select example">
                                            <option value="">Select Activity</option>
                                            <?php
                                                $tag = $metName;

                                                foreach($metarray as $value){
                                                    $name  = $value[0];
                                                    $lvl   = $value[1];

                                                    $select = "";

                                                    if($tag == $name){
                                                        $select = 'selected';
                                                    }

                                                    echo '<option '.$select.' value="'.$name.'">'.$name.'</option>';

                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="durationHour" class="col-sm-2 col-form-label">Duration</label>
                                    <div class="col-sm-5">
                                        <div class="input-group mb-3">
                                            <input id="durationHour" name="durationHour" type="number" class="form-control"
                                                value="<?php echo $durationHour; ?>"
                                                aria-label="Duration hours" aria-describedby="basic-addon2">
                                            <span class="input-group-text" id="basic-addon2">hours</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="input-group mb-3">
                                            <input id="durationMinute" name="durationMinute" type="number" class="form-control"
                                                value="<?php echo $durationMinute;  ?>"
                                                aria-label="Duration Minute" aria-describedby="basic-addon2">
                                            <span class="input-group-text" id="basic-addon2">minutes</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="weight" class="col-sm-2 col-form-label">Weight (KG)</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="weight" class="form-control" id="weight"
                                            value="<?php echo $weight;  ?>">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Update Activity</button>
                                    <a href="activity_my.php" class="btn btn-secondary">Back to My Activity</a>
                                </div>
                            </form><!-- End Horizontal Form -->


                            <!-- Horizontal Form -->
                            

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