<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Booking Payment";
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
            <h1>Booking Payment</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Payment Booking Form</h5>
                            <br />

                            <?php
                            
                                $schedule_id = "";
                                $member_id = "";
                                $trainer_id = "";
                                $errorMsg = array();

                                include('include/connection.php');

                                //check form submit - trainer register]\
                                if(isset($_POST) && !empty($_POST)){

                                    $schedule_id = $_POST['schedule_id'];
                                    $member_id = $_POST['member_id'];
                                    $trainer_id = $_POST['trainer_id'];
                                    $amount = $_POST['amount'];

                                    //print_r($_POST);
                                                                
                                    $bookcode = "BK" . rand(1000,9999);
                            
                                    $now = date("Y-m-d H:i:s");
                            
                                    $status = 'pending';

                                    $resitFile = $_FILES["resitFile"]["name"];
                                    $dir = "assets/resit/";
                                    $ext = pathinfo($resitFile, PATHINFO_EXTENSION);
                                    
                                    $target_file = $dir . basename($resitFile);
                                    $uploadOk = 1;
                                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                                    $renameFile = date("d-m-Y his") .  "." . $ext ;

                                    if(move_uploaded_file( $_FILES["resitFile"]["tmp_name"],$dir . $renameFile)){

                                        //apply booking by using student id
                                        $sqlInsert = "INSERT INTO booking (trainer_id,member_id,bookcode,schedule_id,applyDateTime,approveTrainer,approveAdmin,status) 
                                        VALUES ('$trainer_id','$member_id','$bookcode','$schedule_id','$now','$status','$status','$status')";      
                                        
                                        //echo $sqlInsert;
                                        $resultInsert = $conn->query($sqlInsert);
                                
                                        if($resultInsert == true){

                                            $book_id = $conn->insert_id;

                                            //echo "bid =" . $book_id;

                                            $sqlInsert2 = "INSERT INTO payment (book_id,amount,resitFile,submitDateTime,status) 
                                            VALUES ('$book_id','$amount','$renameFile','$now','$status')";      
                                            
                                            //echo $sqlInsert;
                                            $resultInsert2 = $conn->query($sqlInsert2);

                                            //print $resultInsert2;

                                            if($resultInsert2 == true){
                                
                                                echo '<script>alert("Booking has been registered successfully.");</script>';
                                                echo '<script>window.location.href="booking_myMember.php"</script>';

                                            }else{
                                                echo '<script>alert("Error occurred. Please try again.");</script>';
                                                echo '<script>window.location.href="booking_myMember.php"</script>';
                                    
                                            }
                                
                                        }else{
                                            echo '<script>alert("Error occurred. Please try again.");</script>';
                                            echo '<script>window.location.href="booking_myMember.php"</script>';
                                
                                        }
                                    
                                    
                                    
                                    }

                                }elseif(isset($_GET['schedule_id']) && !empty($_GET['schedule_id'])){
                                    
                                                                
                                    $schedule_id = $_GET['schedule_id'];
                                    $member_id = $_GET['member_id'];
                                    $trainer_id = $_GET['trainer_id'];
                                    

                                    $sqlSearch = "SELECT trainer_schedule.id as trainid, trainer_schedule.trainer_id, trainer_schedule.trainDate, trainer_schedule.startTime,
                                    trainer_schedule.endTime, trainer_schedule.status as schedule_status,
                                    users.id as userid,users.gen_id,users.name 
                                    FROM trainer_schedule 
                                    INNER JOIN users ON trainer_schedule.trainer_id = users.id LIMIT 1";

                                    $resultSearch = $conn->query($sqlSearch);
                                    $searchData = $resultSearch->fetch_assoc();


                                }else{
                                    header("Location:booking_myMember.php");
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

                            ?>

                            <table class="table table-hover table-bordered table-sm text-center" style="width:40%">
                                <tbody>
                                    <tr class="table-secondary">
                                        <th scope="row" colspan="2">Schedule Session Information</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Trainer</th>
                                        <td><?php echo $searchData['name']; ?> #<?php echo $searchData['gen_id']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Slot Date</th>
                                        <td><?php echo $searchData['trainDate']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Slot Time</th>
                                        <td><?php echo $searchData['startTime']; ?> - <?php echo $searchData['endTime']; ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <hr/>

                            <p><b>Deposit Payment Form</b></p>

                            <p class="text-info bold-text">
                                <b><i> ** <br/>
                                This the list of amount payment before and after completing session slot.
                                <br/>
                                Deposit/1st Payment : RM100 
                                <br/>
                                Balance/2nd Payment : RM100
                                <br/>** </i></b> 
                            </p>
                            <!-- Horizontal Form -->
                            <form method="post" action="booking_payment.php" enctype="multipart/form-data">

                                <input class="d-none" name="schedule_id" type="text" id="schedule_id" value="<?php echo $schedule_id; ?>">
                                <input class="d-none" name="member_id" type="text" id="member_id" value="<?php echo $member_id; ?>">
                                <input class="d-none" name="trainer_id" type="text" id="trainer_id" value="<?php echo $trainer_id; ?>">

                                <div class="row mb-3">
                                    <label for="resitFile" class="col-sm-2 col-form-label">Upload Resit Payment</label>
                                    <div class="col-sm-10">
                                        <input name="resitFile" type="file" class="form-control" id="resitFile" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                    <div class="col-sm-10">

                                        <div class="input-group mb-3">
                                            <span class="input-group-text">RM</span>
                                            <input type="text" class="form-control" name="amount" readonly value="100">
                                        </div>
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