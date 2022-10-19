<?php
    
    session_start();
    
    //check session exist or not
    if(empty($_SESSION)){

        //navigate to login page if session not exist
        header("Location:login.php");
        echo 'session takada';

    }else{
        //navigate to home page if session exist
        header("Location:dashboard.php");
        echo 'session ada';
    }
            

?>