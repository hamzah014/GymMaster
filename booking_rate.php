<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Review Session";
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
            <h1>Review Session</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Review Session</h5>
                            <br />

                            <?php
                            
                                $bookid = "";
                                $errorMsg = array();

                                include('include/connection.php');

                                //check form submit - trainer register]\
                                if(isset($_POST) && !empty($_POST)){

                                    $bookid = $_POST['bookid'];
                                    $rateReview = $_POST['rateReview'];
                                    $rateTrainer = $_POST['rateTrainer'];
                            
                                    $now = date("Y-m-d H:i:s");

                                    //apply booking by using student id
                                    $sqlInsert = "UPDATE booking SET rateTrainer='$rateTrainer',rateReview='$rateReview'
                                                WHERE id='$bookid'";      
                                    
                                    //echo $sqlInsert;
                                    $resultInsert = $conn->query($sqlInsert);
                                
                                    if($resultInsert == true){
                                        echo '<script>alert("Thank you for your review.");</script>';
                                        echo '<script>window.location.href="booking_myMember.php"</script>';
                                
                                    }else{
                                        echo '<script>alert("Error occurred. Please try again.");</script>';
                                        echo '<script>window.location.href="booking_myMember.php"</script>';
                                
                                    }

                                }elseif(isset($_GET['bookid']) && !empty($_GET['bookid'])){
                                    
                                                                
                                    $bookid = $_GET['bookid'];
                                    

                                    $sqlSearch = "SELECT booking.id as bookid,booking.trainer_id,booking.member_id,booking.bookcode,booking.schedule_id,booking.applyDateTime,
                                    booking.approveTrainer,booking.approveAdmin,booking.rateTrainer,booking.status as book_status,
                                    trainer_schedule.id as trainid, trainer_schedule.trainer_id, trainer_schedule.trainDate, trainer_schedule.startTime,
                                    trainer_schedule.endTime, trainer_schedule.status as schedule_status,
                                    users.id as userid,users.gen_id,users.name
                                    FROM booking 
                                    INNER JOIN trainer_schedule ON booking.schedule_id = trainer_schedule.id
                                    INNER JOIN users ON trainer_schedule.trainer_id = users.id
                                    where booking.id = $bookid";

                                    $resultSearch = $conn->query($sqlSearch);
                                    $searchData = $resultSearch->fetch_assoc();

                                    $member_id = $searchData['member_id'];

                                    $getMember = "SELECT * FROM users WHERE id='$member_id' LIMIT 1";

                                    $resultSearch2 = $conn->query($getMember);
                                    $searchData2 = $resultSearch2->fetch_assoc();


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
                                        <th scope="row">Member/Trainee</th>
                                        <td><?php echo $searchData2['name']; ?> #<?php echo $searchData2['gen_id']; ?></td>
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

                            <p><b>Please leave a review for the session.</b></p>

                            <p class="text-info bold-text"> 
                            </p>
                            <!-- Horizontal Form -->
                            <form method="post" action="booking_rate.php" enctype="multipart/form-data">

                                <input class="d-none" name="bookid" type="text" id="bookid" value="<?php echo $bookid; ?>">

                                <div class="row mb-3">
                                    <label for="rateTrainer" class="col-sm-2 col-form-label">Rate Trainer <i class="bi bi-star-fill"></i> :</label>
                                    <div class="col-sm-10">
                                        <select name="rateTrainer" class="form-select" aria-label="Default select example" required>
                                            <option value="">Select Rate</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="rateReview" class="col-sm-2 col-form-label">Review : </label>
                                    <div class="col-sm-10">
                                        <textarea name="rateReview" class="form-control" id="rateReview" required></textarea>
                                    </div>
                                </div>

                                <hr/>

                                <div class="">
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