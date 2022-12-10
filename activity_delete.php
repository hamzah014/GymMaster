<?php 
    //check there is post delete_id
    //redirect to index.php if do not exist
    if(isset($_GET['delete_id']) && !empty($_GET['delete_id'])){

        //print_r($_GET);
        include('include/connection.php');

        $id = $_GET['delete_id'];

        //delete users_profile data first        
        $sqlDeleteProfile = "DELETE FROM calorieActivities WHERE id='$id'";
        $resultDeleteProfile = $conn->query($sqlDeleteProfile);

        echo '<script>alert("Activity has been deleted.");</script>';
        echo '<script>window.history.back()</script>';


    }else{
        header("Location:index.php");
    }


?>