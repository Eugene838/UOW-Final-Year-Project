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

        body {
            background-image: url('img/AdminBackground.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
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

        .list-group{
            font-family: garamond;
            font-size: 18px;
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
                <?php
                switch ($_SESSION['Role']) {
                    case "Dentist":
                        echo '<a href="DentistDashboard.php">
                            <img src="img/Logo1.png" alt="" width="275" height="70" />
                        </a>';
                        break;
                    case "Receptionist":
                        echo '<a href="ReceptionistDashboard.php">
                            <img src="img/Logo1.png" alt="" width="275" height="70" />
                        </a>';
                        break;
                    case "Dentist Assistant":
                        echo '<a href="AssistantDashboard.php">
                            <img src="img/Logo1.png" alt="" width="275" height="70" />
                        </a>';
                        break;
                    case "Clinic Admin":
                        echo '<a href="AdminDashboard.php">
                            <img src="img/Logo1.png" alt="" width="275" height="70" />
                        </a>';
                        break;
                    case "Super Admin":
                        echo '<a href="SuperAdminDashBoard.php">
                            <img src="img/Logo1.png" alt="" width="275" height="70" />
                        </a>';
                        break;
                }
                ?>
            </div>
            <div id="open-sidebar" class="toggle-navigation toggle-left">
                <button type="button" class="btn " onclick="toggle()">
                    <i style="color:white" class="bi bi-list"></i>
                </button>
            </div>
            <div class="user-nav row mt-2">
                <div class="logoutBtn col-2 float-end">
                    <button class="btn btn-secondary" type="submit" name="logout" onclick="location.href = 'Logout.php';">Logout!</button>
                </div>
            </div>
        </header>
        <div id="wrapper" class="active">
            <div id="sidebar-wrapper" class="border-right">
                <div class="list-group list-group-flush">
                    <?php
                    echo '<p class="text-center fs-4 mt-3">Name: ' . $_SESSION['Name'] . '</p>';
                    echo '<p class="text-center fs-6">Role: ' . $_SESSION['Role'] . '</p>';
                    if ($_SESSION['Role'] != "Super Admin") {
                        echo '<p class="text-center fs-6">Company: ' . $_SESSION['Company'] . '</p>';
                    }
                    //echo '<a class="list-group-item list-group-item-action"></a>';
                    switch ($_SESSION['Role']) {
                        case "Dentist":
                            echo
                            '
                            <a href="DentistDashboard.php" class="list-group-item list-group-item-action"><i class="bi bi-house-fill"></i>Home</a>
                            <a href="Profile.php" class="list-group-item list-group-item-action"><i class="bi bi-person-fill"></i>Profile</a>
                            <!--<a data-bs-toggle="modal" data-bs-target="#searchUserBackDrop" class="list-group-item list-group-item-action"><i class="bi bi-search"></i>Search</a>-->
                            <a href="DentistSchedule.php" class="list-group-item list-group-item-action"><i class="bi bi-person-lines-fill"></i>Schedule</a>
                            <a href="PatientRecords.php" class="list-group-item list-group-item-action"><i class="bi bi-clipboard2-heart-fill"></i>Records</a>
                            <a class="list-group-item list-group-item-action" href="DentistPatient.php"><i class="bi bi-file-person-fill"></i>Patients</a> 
                            
                            ';
                            break;
                        case "Dentist Assistant":
                            echo
                            '
                            <a href="AssistantDashboard.php" class="list-group-item list-group-item-action"><i class="bi bi-house-fill"></i>Home</a>
                            <a href="Profile.php" class="list-group-item list-group-item-action"><i class="bi bi-person-fill"></i>Profile</a>
                            <!--<a data-bs-toggle="modal" data-bs-target="#searchUserBackDrop" class="list-group-item list-group-item-action"><i class="bi bi-search"></i>Search</a>-->
                            <a href="viewRecords.php" class="list-group-item list-group-item-action"><i class="bi bi-clipboard2-heart-fill"></i>Records</a>
                            <a class="list-group-item list-group-item-action" href="viewPatients.php"><i class="bi bi-file-person-fill"></i>Patients</a>          
                                        
                            ';
                            break;
                        case "Receptionist":
                            echo
                            '
                            <a href="ReceptionistDashboard.php" class="list-group-item list-group-item-action"><i class="bi bi-house-fill"></i>Home</a>
                            <a href="Profile.php" class="list-group-item list-group-item-action"><i class="bi bi-person-fill"></i>Profile</a>
                            <a href="ViewPatientProfile.php" class="list-group-item list-group-item-action"><i class="bi bi-file-person-fill"></i>Patients</a>
                            <a href="ReceptionistViewRecords.php" class="list-group-item list-group-item-action"><i class="bi bi-clipboard2-heart-fill"></i>Records</a>
                            <a href="Schedule.php" class="list-group-item list-group-item-action"><i class="bi bi-person-lines-fill"></i>Schedule</a>
                            <!--<a data-bs-toggle="modal" data-bs-target="#searchUserBackDrop" class="list-group-item list-group-item-action"><i class="bi bi-search"></i>Search</a>-->
                            <a href="view_products.php" class="list-group-item list-group-item-action"><i class="bi bi-cart-fill"></i>Products</a>
                            <a href="invoice_list.php" class="list-group-item list-group-item-action"><i class="bi bi-receipt"></i>Invoices</a>
                            ';
                            break;
                        case "Clinic Admin":
                            echo
                            '
                            <a href="AdminDashboard.php" class="list-group-item list-group-item-action"><i class="bi bi-house-fill"></i>Home</a>
                            <a href="Profile.php" class="list-group-item list-group-item-action"><i class="bi bi-person-fill"></i>Profile</a>
                            <a href="ClinicInfo.php" class="list-group-item list-group-item-action"><i class="bi bi-building"></i>Clinic Information</a>
                            <a href="Advertisement.php" class="list-group-item list-group-item-action"><i class="bi bi-badge-ad-fill"></i>Advertisement</a>
                            <!--<a data-bs-toggle="modal" data-bs-target="#searchUserBackDrop" class="list-group-item list-group-item-action"><i class="bi bi-search"></i>Search</a>-->
                            ';
                            break;
                        case "Super Admin":
                            echo
                            '
                            <a href="SuperAdminDashboard.php" class="list-group-item list-group-item-action"><i class="bi bi-house-fill"></i>Home</a>
                            <a href="Profile.php" class="list-group-item list-group-item-action"><i class="bi bi-person-fill"></i>Profile</a>
                            <a href="ManageCompany.php" class="list-group-item list-group-item-action"><i class="bi bi-building"></i>Manage Clinics</a>
                            <!--<a data-bs-toggle="modal" data-bs-target="#searchUserBackDrop" class="list-group-item list-group-item-action"><i class="bi bi-search"></i>Search</a>-->
                            <!-- <a class="list-group-item list-group-item-action"><form method="POST"><i class="bi bi-view-list"></i>View all<button class="btn" id="btn" name="allUsers"></button></form></a> -->
                            ';
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    const toggle = () => {
        document.getElementById("sidebar-wrapper").classList.toggle("toggled");

        document.getElementById("content-wrapper").classList.toggle("toggled");
    }
</script>