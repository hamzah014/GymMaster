<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Diet Plan";
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
            <h1>Diet Plan Information</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="card info-card sales-card align-items-center">
                    <div class="card-body row">

                        <div class="align-items-center pt-5 col-md-6 text-center">
                            <div>
                                <img src="assets/img/diet/diet1.png" alt="" srcset="">
                            </div>
                        </div>
                        <div class="align-items-center pt-5 col-md-6 text-center">
                            <div>
                                <img src="assets/img/diet/diet3.png" alt="" srcset="">
                            </div>
                        </div>
                        <div class="align-items-center pt-5 col-md-12 text-center">
                            <div>
                                <img src="assets/img/diet/diet2.png" alt="" srcset="">
                            </div>
                        </div>
                    </div>

                </div>

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