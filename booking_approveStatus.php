<?php 
    //check there is post schedule_id
    //redirect to index.php if do not exist
    if(isset($_GET['bookid']) && !empty($_GET['bookid'])){

        //print_r($_GET);
        include('include/connection.php');

        $yes = "yes";
        $no = "no";
        $appBook = "approved"; 
        $rejectBook = "rejected"; 
        $booked = "booked"; 

        $bookid = $_GET['bookid'];
        $status = $_GET['status']; // 1 = approve, 0 = reject
        $role = $_GET['role']; // 1 = admin , 2 = trainer

        $bothApprove = 0; // 1 - yes, 0 = no

        //get booking data
        $sqlGet = "SELECT * FROM booking WHERE id='$bookid' LIMIT 1";
        $resultGet = $conn->query($sqlGet);
        $getData = $resultGet->fetch_assoc();
        $schedule_id = $getData['schedule_id'];

        //update the approval status
        //check the role first
        if($role == 1){

            if($status == 1){
                $sqlUpdate = "UPDATE booking
                             SET approveAdmin='$yes'
                             WHERE id = '$bookid'";
            }elseif($status == 0){
                
                $sqlUpdate = "UPDATE booking
                             SET approveAdmin='$no', approveTrainer='$no', status='$rejectBook'
                             WHERE id = '$bookid'";
            }

        }elseif($role == 2){

            if($status == 1){
                $sqlUpdate = "UPDATE booking
                             SET approveTrainer='$yes', status='$appBook' 
                             WHERE id = '$bookid'";

                $bothApprove = 1;

            }elseif($status == 0){
                
                $sqlUpdate = "UPDATE booking
                             SET approveTrainer='$no', status='$rejectBook'
                             WHERE id = '$bookid'";
            }

        }    
        
        //echo $sqlInsert;
        $resultUpdate = $conn->query($sqlUpdate);

        if($resultUpdate == true){

            if($bothApprove == 1){

                $sqlUpdate2 = "UPDATE trainer_schedule
                                SET status='$booked'
                                WHERE id='$schedule_id'";

                $resultUpdate2 = $conn->query($sqlUpdate2);

            }

            echo '<script>alert("Booking has been registered successfully.");</script>';

        }else{
            echo '<script>alert("Error occurred. Please try again.");</script>';

        }

        if($role == 1){
            echo '<script>window.location.href="booking_list.php"</script>';
        }
        elseif($role == 2){
            echo '<script>window.location.href="booking_myTrainer.php"</script>';
        }


    }else{
        header("Location:index.php");
    }


?>