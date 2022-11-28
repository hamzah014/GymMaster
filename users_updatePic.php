<?php

    //check there is post member_id
    //redirect to index.php if do not exist
    if(isset($_POST['user_id']) && !empty($_POST['user_id'])){


        include('include/connection.php');


        $user_id = $_POST['user_id'];
        

        $name_photo = $_FILES["imageFile"]["name"];
	    $dir = "assets/img/profile/";
	    $ext=pathinfo($name_photo, PATHINFO_EXTENSION);
        
	    $target_file = $dir . basename($name_photo);
	    $uploadOk = 1;
	    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $renameImage = date("d-m-Y his") .  "." . $ext ;

        if(move_uploaded_file( $_FILES["imageFile"]["tmp_name"],$dir . $renameImage)){

            //add gallery data into db
            $sqlInsert = "UPDATE users_profile SET profilePic='$renameImage' WHERE user_id='$user_id'";      
            
            //echo $sqlInsert;
            $resultInsert = $conn->query($sqlInsert);

            //echo $resultInsert;

            if($resultInsert == true){

                echo '<script>alert("Your profile picture has been successfully updated.");</script>';
                echo '<script>window.location.href="users_profile.php"</script>';

            }else{
                echo '<script>alert("Error occurred. Please try again.");</script>';
                echo '<script>window.location.href="users_profile.php"</script>';

            }
        
        
        
        }
        

    
    
    }else{
        header("Location:index.php");
    }


?>