<?php 
    //check there is post schedule_id
    //redirect to index.php if do not exist
    if(isset($_GET['payid']) && !empty($_GET['payid'])){

        //print_r($_GET);
        include('include/connection.php');

        $appBook = "approved"; 
        $rejectBook = "rejected"; 

        $now = date('Y-m-d H:i:s');

        $payid = $_GET['payid'];
        $status = $_GET['status']; // 1 = approve, 0 = reject

        //update the approval status
        if($status == 1){
            $sqlUpdate = "UPDATE payment
                         SET status='$appBook', approveDateTime='$now'
                         WHERE id = '$payid'";

        }elseif($status == 0){
            
            $sqlUpdate = "UPDATE payment
                         SET status='$rejectBook', approveDateTime='$now'
                         WHERE id = '$payid'";
        } 
        
        //echo $sqlInsert;
        $resultUpdate = $conn->query($sqlUpdate);

        if($resultUpdate == true){
                                
            echo '<script>alert("Payment has been approved.");</script>';
            echo '<script>window.location.href="payment_list.php"</script>';

        }else{
            echo '<script>alert("Error occurred. Please try again.");</script>';
            echo '<script>window.location.href="payment_list.php"</script>';

        }


    }else{
        header("Location:index.php");
    }


?>