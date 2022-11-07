<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "My Gallery";
        include_once('include/header.php');
    ?>
</head>

<body>
    <!-- ======= Header ======= -->
    <?php include('include/top_nav.php'); ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php include('include/side_nav.php'); ?>
    <!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Gallery</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Preview</li>
                    <li class="breadcrumb-item active">Gallery</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <?php 
            $id = "";
            //define all variable data that will be displayed
            if(isset($_GET['member_id']) && !empty($_GET['member_id'])){
                $id = $_GET['member_id'];
            }else{
                header("Location:index.php");
            }

            //print_r($_SESSION);

            include('include/connection.php');

            //get user data gallery
            //check the user id match in db
            $getUser = "SELECT *            
                        FROM gallery
                        INNER JOIN users ON gallery.member_id = users.id
                        where gallery.member_id='$id'";
            $resultUser = $conn->query($getUser);
            $resultUser2 = $conn->query($getUser);


        ?>

        <section class="section">
            <div class="row align-items-top">
                <?php

                    if ($resultUser->num_rows > 0) {
                        
                        $data = $resultUser->fetch_assoc();

                        echo '<h3>'.$data['name'].'\'s Gallery</h3>';

                        while($userdata = $resultUser2->fetch_assoc()) {

                            $foldername = "assets/img/gallery/";

                            $gid = $userdata['id'];
                            $memid = $userdata['member_id'];
                            $title = $userdata['title'];
                            $imageFile = $userdata['imageFile'];
                            $description = $userdata['description'];

                ?>

                <div class="col-3">

                    <!-- Card with an image on top -->
                    <div class="card">
                        <img class="card-img-top img-gallery" alt="<?php echo $title; ?>"
                            src="<?php echo $foldername . $imageFile; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $title; ?></h5>
                            <p class="card-text">
                                <?php echo $description; ?>
                            </p>
                        </div>
                    </div><!-- End Card with an image on top -->
                </div>


                <?php
                        }

                    }else{
                        echo '<div>';
                        echo '    <p class="bg-secondary text-center text-white">This member have not post anything yet.</p>';
                        echo '</div>';
                    }


                ?>

            </div>


        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include('include/footer.php'); ?>
    <!-- End Footer-->

    <!-- ======= Script ======= -->
    <?php include('include/script.php'); ?>
    <!-- End Script-->

</body>

</html>