<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Trainer List";
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
            <h1>Trainer List</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">


                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Trainer Data</h5>

                            <!-- Table with stripped rows -->
                            <table class="table datatable table-bordered table-hover">
                                <thead>
                                    <tr class="table-secondary">
                                        <th scope="col">#</th>
                                        <th scope="col">Trainer ID</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Date of Birth</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include('include/connection.php');

                                        //get all trainer data from db
                                        $role_trainer = "trainer";
                                        $count = 0;

                                        $getTrainer = "SELECT * FROM users 
                                                        INNER JOIN users_profile ON users.id = users_profile.user_id
                                                        where users.role='$role_trainer'";
                                        $resulTrainer = $conn->query($getTrainer);
                
                                        //if trainer data exist, show in list table
                                        if ($resulTrainer->num_rows > 0) {

                                            while($dataTrainer = $resulTrainer->fetch_assoc()) {
                                                
                                                $count++;
                                                

                                                echo '<tr>';
                                                echo '    <th scope="row">'.$count.'</th>';
                                                echo '    <td>'.$dataTrainer['gen_id'].'</td>';
                                                echo '    <td>'.$dataTrainer['name'].'</td>';
                                                echo '    <td>'.$dataTrainer['birthDate'].'</td>';
                                                echo '    <td>'.$dataTrainer['username'].'</td>';
                                                echo '    <td>'.$dataTrainer['address'].'</td>';
                                    ?>  
                                                <td>
                                                    <a class="btn btn-info" href="users_edit.php?edit_id=<?php echo $dataTrainer['user_id']; ?>&edit_role=<?php echo $role_trainer; ?>">Edit</a>
                                                    <a class="btn btn-danger" href="users_delete.php?delete_id=<?php echo $dataTrainer['user_id']; ?>&delete_role=<?php echo $role_trainer; ?>">Delete</a>
                                                </td>
                                                
                                    <?php   
                                                echo '</tr>';
                                            
                                            }

                                        }else{

                                            echo '<tr>';
                                            echo '    <td colspan="10" class="bg-danger text-center text-white">Sorry, there is no data yet.</td>';
                                            echo '</tr>';

                                        }

                                    ?>

                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>
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