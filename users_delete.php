<?php 
    //check there is post delete_id
    //redirect to index.php if do not exist
    if(isset($_GET['delete_id']) && !empty($_GET['delete_id'])){

        //print_r($_GET);
        include('include/connection.php');

        $id = $_GET['delete_id'];
        $role = $_GET['delete_role'];

        //delete users_profile data first        
        $sqlDeleteProfile = "DELETE FROM users_profile WHERE user_id='$id'";
        $resultDeleteProfile = $conn->query($sqlDeleteProfile);

        //delete users data 
        $sqlDeleteAcc = "DELETE FROM users WHERE id='$id'";
        $resultDeleteAcc = $conn->query($sqlDeleteAcc);

        //echo $resultDeleteProfile;
        //echo $resultDeleteAcc;

        echo '<script>alert("'.ucfirst($role).' has been deleted.");</script>';
        echo '<script>window.history.back()</script>';


    }else{
        header("Location:index.php");
    }


?>