<?php 
    //check there is post schedule_id
    //redirect to index.php if do not exist
    if(isset($_GET['schedule_id']) && !empty($_GET['schedule_id'])){

        //print_r($_GET);
        include('include/connection.php');

        $schedule_id = $_GET['schedule_id'];
        $member_id = $_GET['member_id'];
        $trainer_id = $_GET['trainer_id'];
                                    
        $bookcode = "BK" . rand(1000,9999);

        $now = date("Y-m-d H:i:s");

        $status = 'pending';

        //apply booking by using student id
        $sqlInsert = "INSERT INTO booking (trainer_id,member_id,bookcode,schedule_id,applyDateTime,approveTrainer,approveAdmin,status) 
        VALUES ('$trainer_id','$member_id','$bookcode','$schedule_id','$now','$status','$status','$status')";      
        
        //echo $sqlInsert;
        $resultInsert = $conn->query($sqlInsert);

        if($resultInsert == true){

            echo '<script>alert("Booking has been registered successfully.");</script>';
            echo '<script>window.location.href="booking_myMember.php"</script>';

        }else{
            echo '<script>alert("Error occurred. Please try again.");</script>';
            echo '<script>window.location.href="booking_myMember.php"</script>';

        }


    }else{
        header("Location:index.php");
    }


?>