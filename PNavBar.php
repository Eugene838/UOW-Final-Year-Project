<?php
session_start();

?>



<!doctype html>
<html lang="en">

<head>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .logoutBtn {
            float: right;
        }

        .container {
            position: absolute;
        }

        #header {
            background: #464545;
            height: 100px;
            margin-right: 0;
        }

        #header .brand {
            background: #464545;
            float: left;
            width: 300px;
            min-height: 80px;
            padding: 0 0 0 10px;
            position: relative;
            margin-top: 10px;
        }

        #header .user-nav {
            float: right;
            padding-top: 23px;
            padding-right: 20px;
        }

        #header .toggle-navigation.toggle-left {
            margin: 30px 0 0 20px;
            display: inline-block;
            color: white;
        }

        #sidebar-wrapper {
            width: 18rem;
            min-height: 170vh;
            background-color: #41505e;
            color: #fff;
            position: absolute;
        }

        #sidebar-wrapper .bi {
            padding-right: 1rem;
        }

        .list-group-item {
            background-color: transparent;
            color: #fff;
            border: 1px solid #ddd;
            width: 18rem;
        }

        #btn {
            width: 150px;
        }

        @media (max-width:768px) {
            #sidebar-wrapper {
                margin-left: -18rem;
                transition: all 0.3s ease;
            }

            #sidebar-wrapper.toggled {
                margin-left: 0;
                transition: all 0.3s ease;
            }

            #content-wrapper.toggled {
                margin-left: 0;
                transition: all 0.3s ease;
            }
        }

        @media (min-width:769px) {
            #sidebar-wrapper.toggled {
                margin-left: -18rem;
                transition: all 0.3s ease;
            }

            #sidebar-wrapper {
                transition: all 0.3s ease;
            }

            #content-wrapper.toggled {
                margin-left: 0;
                transition: all 0.3s ease;
            }

            #content-wrapper {
                transition: all 0.3s ease;
            }
        }
    </style>
</head>

<body>
    <div id="container" class="sidebar-mini">
        <header id="header">
            <!-- logo -->
            <div class="brand">
                <a href="PatientDashboard.php">
                    <img src="img/Logo1.png" alt="" width="275" height="70">
                </a>
                <?php
                // switch ($_SESSION['Status']) {
                //     case "Active":
                //         echo ' <a href="PatientDashboard.php">
                //             <img src="img/Logo1.png" alt="" width="275" height="70">
                //         </a>';
                //         break;
                // }
                ?>
            </div>
            <div id="open-sidebar" class="toggle-navigation toggle-left">
                <button type="button" class="btn btn-default" onclick="toggle()">
                    <i style="color:white" class="bi bi-list"></i>
                </button>
            </div>
            <div class="user-nav row mt-2">
                <div class="logoutBtn col-2 float-end">
                    <button class="btn btn-secondary" type="submit" name="logout" onclick="location.href = 'Logout.php';">Logout!</button>
                </div>
            </div>
    </div>
    </header>
    <div id="wrapper" class="active">
        <div id="sidebar-wrapper" class="border-right">
            <div class="list-group list-group-flush">
                <?php
                if (isset($_SESSION['Name'])) {
                    echo '<p class="text-center fs-4 mt-3">Name: ' . $_SESSION['Name'] . '</p>';
                }
                ?>
                <a href="PatientDashboard.php" class="list-group-item list-group-item-action"><i class="bi bi-house-fill"></i>Home</a>
                <a href="PProfile.php" class="list-group-item list-group-item-action"><i class="bi bi-person-fill"></i>Profile</a>
                <a href="PAppointments.php" class="list-group-item list-group-item-action"><i class="bi bi-calendar-event-fill"></i>Appointments</a>
                <!-- <a data-bs-toggle="modal" data-bs-target="#searchUserBackDrop" class="list-group-item list-group-item-action"><i class="bi bi-search"></i>Search</a> -->
                <a href="PRecords.php" class="list-group-item list-group-item-action"><i class="bi bi-clipboard-check-fill"></i>Past Treatment Records</a>
            </div>
        </div>
</body>

</html>

<script>
    const toggle = () => {
        // document.getElementById("sidebar-wrapper").style.width = "-18";
        document.getElementById("sidebar-wrapper").classList.toggle("toggled");

        document.getElementById("content-wrapper").classList.toggle("toggled");
    }
</script>