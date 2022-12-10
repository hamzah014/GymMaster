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
                <div class="card info-card sales-card">
                    <div class="card-body row">

                        <div class="pt-5 col-12 text-center">
                            <div>
                                <h3>Here is the diet plan that we recommend our member to follow : </h3>
                                <img src="assets/img/diet/diet1.png" alt="" style="width:50%">
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