<?php 
    //check there is post delete_id
    //redirect to index.php if do not exist
    if(isset($_GET['delete_id']) && !empty($_GET['delete_id'])){

        //print_r($_GET);
        include('include/connection.php');

        $id = $_GET['delete_id'];

        //delete users_profile data first        
        $sqlDelete = "DELETE FROM gallery WHERE id='$id'";
        $resultDelete = $conn->query($sqlDelete);

        echo '<script>alert("Gallery image has been deleted.");</script>';
        echo '<script>window.location.href="users_gallery.php";</script>';


    }else{
        header("Location:index.php");
    }


?>