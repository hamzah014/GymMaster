<?php

    //check there is post member_id
    //redirect to index.php if do not exist
    if(isset($_POST['member_id']) && !empty($_POST['member_id'])){


        include('include/connection.php');


        $member_id = $_POST['member_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        

        $name_photo = $_FILES["imageFile"]["name"];
	    $dir = "assets/img/gallery/";
	    $ext=pathinfo($name_photo, PATHINFO_EXTENSION);
        
	    $target_file = $dir . basename($name_photo);
	    $uploadOk = 1;
	    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $renameImage = date("d-m-Y his") .  "." . $ext ;

        if(move_uploaded_file( $_FILES["imageFile"]["tmp_name"],$dir . $renameImage)){

            //add gallery data into db
            $sqlInsert = "INSERT INTO gallery (member_id,title,imageFile,description) 
            VALUES ('$member_id','$title','$renameImage','$description')";      
            
            //echo $sqlInsert;
            $resultInsert = $conn->query($sqlInsert);

            if($resultInsert == true){

                echo '<script>alert("Your gallery image has been successfully added.");</script>';
                echo '<script>window.location.href="users_gallery.php"</script>';

            }else{
                echo '<script>alert("Error occurred. Please try again.");</script>';
                echo '<script>window.location.href="users_gallery.php"</script>';

            }
        
        
        
        }
        

    
    
    }else{
        header("Location:index.php");
    }


?>