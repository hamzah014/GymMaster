<?php   
    
    session_start(); //assessing
    
    session_unset(); //unset the session
    
    session_destroy(); //destroy the session
    
    //redirect to dashboard page
    echo '<script>alert("You has successfully sign out.");</script>';
    echo "<script>window.location.href='index.php';</script>";

    exit;

?>