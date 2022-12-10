<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "MET Calculator";
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
            <h1>MET CALCULATOR</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Calculate Calories Burn</h5>
                            <br/>

                            <?php

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

                                $errorMsg = array();

                                //check form submit - trainer register]\
                                if(isset($_POST) && !empty($_POST)){

                                    include('include/connection.php');

                                    //get post data
                                    //print_r($_POST);
                                    $met = $_POST['met'];
                                    $hours = $_POST['hours'];
                                    $minutes = $_POST['minutes'];
                                    $weight = $_POST['weight'];

                                    //check value for each data
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

                                        $_POST = array();

                                        $level = $metarray[$met][1];
                                    
                                        $totalMinit = $minutes + (60 * $hours);

                                        $total = $totalMinit * $level * 3.5 * $weight;

                                        $calorie = $total / 200;

                                        echo '<h3><b>Total Calories Burned :</b> '.$calorie.' kcal</h3>';
                                  
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


                            <!-- Horizontal Form -->
                            <form method="post" action="met_calculator.php">
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Activity</label>
                                    <div class="col-sm-10">
                                        <select name="met" class="form-select"
                                            aria-label="Default select example">
                                            <option value="">Select Activity</option>
                                            <?php
                                                $no = 0;
                                                $tag = 99;
                                                if(isset($_POST['met'])){
                                                    $tag = $_POST['met'];
                                                } 

                                                foreach($metarray as $value){
                                                    $name  = $value[0];
                                                    $lvl   = $value[1];

                                                    $select = "";

                                                    if($tag == $no){
                                                        $select = 'selected';
                                                    }

                                                    echo '<option '.$select.' value="'.$no.'">'.$name.'</option>';

                                                    $no++;

                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="hours" class="col-sm-2 col-form-label">Duration</label>
                                    <div class="col-sm-5">
                                        <div class="input-group mb-3">
                                            <input id="hours" name="hours" type="number" class="form-control" value="<?php if(isset($_POST['hours'])){echo $_POST['hours'];} ?>"
                                                aria-label="Duration hours" aria-describedby="basic-addon2">
                                            <span class="input-group-text" id="basic-addon2">hours</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="input-group mb-3">
                                            <input id="minutes" name="minutes" type="number" class="form-control" value="<?php if(isset($_POST['minutes'])){echo $_POST['minutes'];} ?>"
                                                aria-label="Duration Minutes" aria-describedby="basic-addon2">
                                            <span class="input-group-text" id="basic-addon2">minutes</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="weight" class="col-sm-2 col-form-label">Weight (KG)</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="weight" class="form-control" id="weight" value="<?php if(isset($_POST['weight'])){echo $_POST['weight'];} ?>">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Calculate</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
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