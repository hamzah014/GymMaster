<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Dashboard";
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
            <h1>Dashboard</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">
                    <div class="row">

                        <?php
                            include('include/connection.php');

                            //get all data from users
                            $totalUser = 0;
                            $totalTrainer = 0;
                            $totalMember = 0;

                            $sqlSearch = "SELECT * FROM users";
                            $resultSearch = $conn->query($sqlSearch);

                            if($resultSearch->num_rows > 0){

                                while($searchData = $resultSearch->fetch_assoc()) {

                                    $totalUser++;

                                    if($searchData['role']=='trainer'){
                                        $totalTrainer++;
                                    }elseif($searchData['role']=='member'){
                                        $totalMember++;
                                    }

                                }
                            }

                        ?>

                        <!-- Customers Card -->
                        <div class="col-4">

                            <div class="card info-card customers-card align-items-center">

                                <div class="card-body">
                                    <h5 class="card-title">Total Users</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $totalUser; ?></h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Sales Card -->
                        <div class="col-4">
                            <div class="card info-card sales-card align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title">Total Trainer</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-award"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $totalTrainer; ?></h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-4">
                            <div class="card info-card revenue-card align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title">Total Members</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-badge"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $totalMember; ?></h6>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->



                    </div><!-- End News & Updates -->

                </div><!-- End Right side columns -->

            </div>
        </section>

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">
                    <div class="row">
                        
                        <div class="col-6">
                            <div class="card info-card sales-card align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title">Video Tutorial : 9 Exercises To Build A Big Back - Gym Body Motivation</h5>

                                    <div class="d-flex align-items-center">
                                        <div>
                                            <iframe class="vd-gallery"  src="https://www.youtube.com/embed/s8taXR3mYa8" title="9 Exercises To Build A Big Back - Gym Body Motivation" 
                                                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="card info-card sales-card align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title">Video Tutorial : Beginner Full Body Gym Workout</h5>

                                    <div class="d-flex align-items-center">
                                        <div>
                                                <iframe class="vd-gallery"  src="https://www.youtube.com/embed/0iaMFDNII3E" title="10 Days Burn BELLY FAT CHALLENGE | KIAT JUD DAI" frameborder="0" 
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="card info-card sales-card align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title">Video Tutorial : HOW TO USE GYM EQUIPMENT | Lower Body Machine</h5>

                                    <div class="d-flex align-items-center">
                                        <div>
                                            <iframe class="vd-gallery" src="https://www.youtube.com/embed/CIxNJbit9BA" title="Half An Hour Weight Loss - 30 Min Home Workout To Burn Fat" frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="card info-card sales-card align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title">Video Tutorial : Beginner's Guide to the Gym | DO's and DON'Ts</h5>

                                    <div class="d-flex align-items-center">
                                        <div>
                                            <iframe class="vd-gallery" src="https://www.youtube.com/embed/EKUNGQ4LmH8" title="Beginner's Guide to the Gym | DO's and DON'Ts"
                                                 frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>



                    </div><!-- End News & Updates -->

                </div><!-- End Right side columns -->

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