<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <?php

            //show the menu following user role - admin,member,trainer

            $roleuser = $_SESSION['role'];

            //admin menu begin
            if($_SESSION['role']=='admin'){

        ?>
        <?php
            }
            //admin menu end

            //trainer menu begin
            elseif($_SESSION['role']=='trainer'){

        ?>
        <?php

            }
            //trainer menu end

            //member menu begin
            elseif($_SESSION['role']=='member'){

        ?>
        <?php

            }
            //member menu end

        ?>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#trainer-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-award"></i><span>Trainer</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="trainer-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="trainer_register.php">
                        <i class="bi bi-circle"></i><span>Register Trainer</span>
                    </a>
                </li>
                <li>
                    <a href="trainer_list.php">
                        <i class="bi bi-circle"></i><span>List of Trainer</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#schedule-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-calendar"></i><span>Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="schedule-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="schedule_register.php">
                        <i class="bi bi-circle"></i><span>Register Trainer Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="schedule_search.php">
                        <i class="bi bi-circle"></i><span>Table Trainer Schedule</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#members-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-badge"></i><span>Members</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="members-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="member_register.php">
                        <i class="bi bi-circle"></i><span>Register Members</span>
                    </a>
                </li>
                <li>
                    <a href="member_list.php">
                        <i class="bi bi-circle"></i><span>List of Members</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#booking-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-calendar-check"></i><span>Booking</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="booking-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="#">
                        <i class="bi bi-circle"></i><span>List of Booking</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-circle"></i><span>My Booking</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->


    </ul>

</aside>