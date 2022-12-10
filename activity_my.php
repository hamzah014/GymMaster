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

                                $met = "";
                                $hours = "";
                                $minutes = "";
                                $weight = "";

                                include('include/connection.php');

                                $errorMsg = array();

                                //check form submit - trainer register]\
                                if(isset($_POST) && !empty($_POST)){

                                    //get post data
                                    print_r($_POST);
                                    $activity_date = $_POST['activity_date'];
                                    $met = $_POST['met'];
                                    $hours = $_POST['hours'];
                                    $minutes = $_POST['minutes'];
                                    $weight = $_POST['weight'];

                                    //check value for each data
                                    if($activity_date == "" && empty($activity_date)){
                                        array_push($errorMsg,"Please enter activity date.");
                                    }
                                    
                                    if($met == "" && empty($met)){
                                        array_push($errorMsg,"Please select activity.");
                                    }

                                    if($hours == "" && empty($hours)){
                                        array_push($errorMsg,"Please enter hours.");
                                    }
                                    
                                    if($minutes == "" && empty($minutes)){
                                        array_push($errorMsg,"Please enter minutes.");
                                    }

                                    if($weight == "" && empty($weight)){
                                        array_push($errorMsg,"Please enter weight.");
                                    }
                                    
                                    //check if there is no error occurred, insert data into db
                                    if(empty($errorMsg)){

                                        $level = 0;

                                        foreach($metarray as $metval){

                                            if($metval[0] == $met ){

                                                $level = $metval[1];

                                            }

                                        }

                                        //insert into db
                                        $sqlInsert = "INSERT INTO calorieActivities (user_id,activity_date,metName,metValue,durationHour,durationMinute,weight) 
                                        VALUES ('$iduser','$activity_date','$met','$level','$hours','$minutes','$weight')";      
                                        
                                        //echo $sqlInsert;
                                        $resultInsert = $conn->query($sqlInsert);

                                        if($resultInsert == true){

                                            echo '<script>alert("Your activity has been successfully added.");</script>';
                                            echo '<script>window.location.href="activity_my.php"</script>';

                                        }else{
                                            echo '<script>alert("Error occurred. Please try again.");</script>';
                                            echo '<script>window.location.href="activity_my.php"</script>';

                                        }
                                        

                                        $_POST = array();
                                  
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

                            <!-- Default Accordion -->
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed bg-info" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Add Activity
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <form method="post" action="activity_my.php">
                                                <div class="row mb-3">
                                                    <label for="weight" class="col-sm-2 col-form-label">Date of Activity</label>
                                                    <div class="col-sm-10">
                                                        <input type="date" name="activity_date" class="form-control" id="activity_date"
                                                            value="<?php if(isset($_POST['activity_date'])){echo $_POST['activity_date'];} ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="name" class="col-sm-2 col-form-label">Activity</label>
                                                    <div class="col-sm-10">
                                                        <select name="met" class="form-select" aria-label="Default select example">
                                                            <option value="">Select Activity</option>
                                                            <?php
                                                                $tag = "";
                                                                if(isset($_POST['met'])){
                                                                    $tag = $_POST['met'];
                                                                } 

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
                                                    <label for="hours" class="col-sm-2 col-form-label">Duration</label>
                                                    <div class="col-sm-5">
                                                        <div class="input-group mb-3">
                                                            <input id="hours" name="hours" type="number" class="form-control"
                                                                value="<?php if(isset($_POST['hours'])){echo $_POST['hours'];} ?>"
                                                                aria-label="Duration hours" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">hours</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <div class="input-group mb-3">
                                                            <input id="minutes" name="minutes" type="number" class="form-control"
                                                                value="<?php if(isset($_POST['minutes'])){echo $_POST['minutes'];} ?>"
                                                                aria-label="Duration Minutes" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">minutes</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="weight" class="col-sm-2 col-form-label">Weight (KG)</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" name="weight" class="form-control" id="weight"
                                                            value="<?php if(isset($_POST['weight'])){echo $_POST['weight'];} ?>">
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Add Activity</button>
                                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                                </div>
                                            </form><!-- End Horizontal Form -->
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button bg-warning" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            List Activity
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse show"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <!-- Table with stripped rows -->
                                            <table class="table datatable table-bordered table-hover">
                                                <thead>
                                                    <tr class="table-secondary">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Date of Activity</th>
                                                        <th scope="col">Activity Name</th>
                                                        <th scope="col">MET</th>
                                                        <th scope="col">Duration</th>
                                                        <th scope="col">Weight</th>
                                                        <th scope="col">Calories Burned (kcal)</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                        //get all Activity data from db
                                                        $count = 0;
                                                        $totalCalorie = 0;

                                                        $getActivity = "SELECT * FROM calorieactivities 
                                                                        where user_id='$iduser'";
                                                        $resultActivity = $conn->query($getActivity);

                                                        //if trainer data exist, show in list table
                                                        if ($resultActivity->num_rows > 0) {

                                                            while($dataActivity= $resultActivity->fetch_assoc()) {
                                                                
                                                                $count++;
                                                                $actid = $dataActivity['id'];
                                                                $activity_date = $dataActivity['activity_date'];
                                                                $metName = $dataActivity['metName'];
                                                                $metValue = $dataActivity['metValue'];
                                                                $durationHour = $dataActivity['durationHour'];
                                                                $durationMinute = $dataActivity['durationMinute'];
                                                                $weight = $dataActivity['weight'];
                                                            
                                                                $totalMinit = $durationMinute + (60 * $durationHour);

                                                                $total = $totalMinit * $metValue * 3.5 * $weight;

                                                                $calorie = $total / 200;

                                                                $totalCalorie += $calorie;

                                                    ?>  
                                                            <tr>
                                                                <th scope="row"><?php echo $count; ?></th>
                                                                <td><?php echo $activity_date; ?></td>
                                                                <td><?php echo $metName; ?></td>
                                                                <td><?php echo $metValue; ?></td>
                                                                <td>
                                                                    <p><?php echo $durationHour; ?> Hours</p>
                                                                    <p><?php echo $durationMinute; ?> Minutes</p>
                                                                </td>
                                                                <td><?php echo $weight; ?></td>
                                                                <td><?php echo $calorie; ?></td>
                                                                <td>
                                                                    <a class="btn btn-primary" href="activity_edit.php?uid=<?php echo $actid;?>">Edit</a>
                                                                    <a class="btn btn-danger" href="activity_delete.php?delete_id=<?php echo $actid;?>">Delete</a>
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
                                            <h4>Total Burned Calories : <?php echo $totalCalorie; ?> kcal</h4>
                                            <!-- End Table with stripped rows -->
                                        </div>
                                    </div>
                                
                                </div>
                            </div><!-- End Default Accordion Example -->


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