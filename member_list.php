<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $title = "Member List";
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
            <h1>Member List</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">


                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Member Data</h5>

                            <!-- Table with stripped rows -->
                            <table class="table datatable table-bordered">
                                <thead>
                                    <tr class="table-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Member ID</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include('include/connection.php');

                                        //get all trainer data from db
                                        $role_member = "member";
                                        $count = 0;

                                        $getMember = "SELECT * FROM users 
                                                        INNER JOIN users_profile ON users.id = users_profile.user_id
                                                        where role='$role_member'";
                                        $resultMember = $conn->query($getMember);
                
                                        //if trainer data exist, show in list table
                                        if ($resultMember->num_rows > 0) {

                                            $dataMember = $resultMember->fetch_assoc();
                                            //print_r($dataMember);
                                            $count++;

                                            echo '<tr>';
                                            echo '    <th scope="row">'.$count.'</th>';
                                            echo '    <td>'.$dataMember['gen_id'].'</td>';
                                            echo '    <td>'.$dataMember['name'].'</td>';
                                            echo '    <td>'.$dataMember['username'].'</td>';
                                            echo '    <td>'.$dataMember['email'].'</td>';
                                            echo '    <td>'.$dataMember['address'].'</td>';
                                    ?>
                                                    <td>
                                                        <button class="btn btn-info">Edit</button>
                                                        <button class="btn btn-danger">Delete</button>
                                                    </td>

                                    <?php
                                            echo '</tr>';
                                            
                                        }else{

                                            echo '<tr>';
                                            echo '    <td colspan="5" class="bg-danger text-center text-white">Sorry, there is no data yet.</td>';
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