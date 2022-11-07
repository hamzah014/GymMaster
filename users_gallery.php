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
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Gallery</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <?php 

            //define all variable data that will be displayed
            $role = $_SESSION['role'];
            $id = $_SESSION['id'];

            //print_r($_SESSION);

            include('include/connection.php');

            //get user data gallery
            //check the user id match in db
            $getUser = "SELECT * FROM gallery where member_id='$id'";
            $resultUser = $conn->query($getUser);


        ?>

        <section class="section">
            <div class="row align-items-top">

                <div class="col-12 align-items-right pb-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal"><i
                            class="bi bi-camera"></i> Post Gallery</button>

                    <a class="btn btn-info" href="gallery_preview.php?member_id=<?php echo $id; ?>"><i class="bi bi-eye"></i> Preview Gallery</a>
                </div>

                <?php

                    if ($resultUser->num_rows > 0) {

                        while($userdata = $resultUser->fetch_assoc()) {

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
                            <p class="card-text text-center"><a href="gallery_delete.php?delete_id=<?php echo $gid; ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</a></p>
                        </div>
                    </div><!-- End Card with an image on top -->
                </div>


                <?php
                        }

                    }else{
                        echo '<div>';
                        echo '    <p class="bg-secondary text-center text-white">You have not post anything yet.</p>';
                        echo '</div>';
                    }


                ?>

            </div>

            <div class="modal fade" id="largeModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Post Your Gallery</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <!-- Horizontal Form -->
                            <form method="post" action="gallery_upload.php" enctype="multipart/form-data">

                                <input type="text" name="member_id" class="form-control d-none" id="member_id"
                                    value="<?php echo $id; ?>">

                                <div class="row mb-3">
                                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title" class="form-control" id="title" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea required name="description" id="description" class="form-control" style="height: 100px"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="imageFile" class="col-sm-2 col-form-label">Upload Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" required name="imageFile" class="form-control" id="imageFile"
                                            accept="image/*">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
                            <!-- End Horizontal Form -->

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div><!-- End Large Modal-->


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