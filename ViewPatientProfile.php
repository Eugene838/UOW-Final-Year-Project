<?php
ob_start();
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'Navbar.php';
include 'Receptionist.php';
?>

<html>

<head>
    <title> Receptionist Page </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        p,
        td {
            font-family: garamond;
            font-size: 14pt;
        }

        td,
        th {
            border: 1px solid #ddd;
        }

        table {
            width: 50%;
            background-color: white;
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .errorMsg {
            color: red;
        }

        .button {
            position: absolute;
            left: 100px;
            top: 100px;
            background-color: #9E989B;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .button {
            border-radius: 12px;
        }

        body {
            background-image: url('img/AdminBackground.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .form-outline {
            background-color: white;

        }

        .topnav input[type=text] {
            border: 5px solid #ccc;
        }

        .content-wrapper {
            transition: all 0.3s ease;
            margin-left: 288px;
        }

        .list-group-item {
            background-color: transparent;
            color: #fff;
            border: 1px solid #ddd;
            width: 18rem;
        }
    </style>
</head>

<body>
    <div id="content-wrapper" class="content-wrapper">
        <div class="w-100 p-3">
            <?php
            if (isset($_SESSION['alert'])) {
                echo $_SESSION['alert'];
            }
            ?>
            <div class="row g-3">
                <div class="col-2">
                    <h2><u>Patient Profiles</u></h2>
                </div>
            </div>
            <?php include "Search.php"; ?>

            <table class="table table-hover ps-1 mt-3" id="searchTable">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 100px">Patient ID</th>
                        <th scope="col">Name</th>
                        <th scope="col" style="width: 400px">Email</th>
                        <th scope="col" style="width: 180px">NRIC/Passport No.</th>
                        <th scope="col" style="width: 100px">Gender</th>
                        <th scope="col" style="width: 180px">Phone Number</th>
                        <th scope="col">Address</th>
                        <!-- <th scope="col" style="width: 180px">Family ID</th> -->
                        <th scope="col" style="width: 180px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($recept_patients_profile)) {
                        foreach ($recept_patients_profile as $patients) {
                            echo
                            '<tr>' .
                                '<td scope="row">' . $patients['Patient_ID'] . '</td>' .
                                '<td>' . $patients['First_Name'] . ' ' . $patients['Last_Name'] . '</td>' .
                                '<td>' . $patients['Email'] . '</td>' .
                                '<td>' . $patients['NRIC_PNum'] . '</td>' .
                                '<td>' . $patients['Gender'] . '</td>' .
                                '<td>' . $patients['Phone_Num'] . '</td>' .
                                '<td>' . $patients['Address'] . '</td>' .
                                //'<td>' . $patients['Family_ID'] . '</td>' .
                                '<td><button type="button" class="btn btn-secondary editViewPatientProfileBtn">View/Edit <i class="bi bi-pencil-square"></i></button></td>' .
                                //'<td><a class="btn btn-link" href="" role="button"><i class="bi bi-pencil-square"></i></a></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td colspan="9"><b>No patient profiles.</b></td>' .
                            '</tr>';
                    }
                    // } else {
                    //     $addSuccess = '';
                    //     $patients_profile =  $_SESSION['patientprof'];
                    //     $errormsg = $_SESSION['errorMsg'];
                    //     $rowCount = $_SESSION['rowCount'];

                    //     foreach ($patients_profile as $patients) {
                    //         echo
                    //         '<tr>' .
                    //             '<td scope="row">' . $patients['Patient_ID'] . '</td>' .
                    //             '<td>' . $patients['First_Name'] . ' ' . $patients['Last_Name'] . '</td>' .
                    //             '<td>' . $patients['Email'] . '</td>' .
                    //             '<td>' . $patients['NRIC_PNum'] . '</td>' .
                    //             '<td>' . $patients['Gender'] . '</td>' .
                    //             '<td>' . $patients['Phone_Num'] . '</td>' .
                    //             '<td>' . $patients['Address'] . '</td>' .
                    //             '<td>' . $patients['Family_ID'] . '</td>' .
                    //             '<td><button type="button" class="btn btn-secondary editViewPatientProfileBtn">View/Edit <i class="bi bi-pencil-square"></i></button></td>' .
                    //             //'<td><a class="btn btn-link" href="" role="button"><i class="bi bi-pencil-square"></i></a></td>' .
                    //             '</tr>';
                    //     }
                    // }
                    ?>
                </tbody>
            </table>
            <?php
            // echo "$errormsg";
            // echo "$addSuccess";
            // if ($rowCount == 1) {
            //     echo "<span class='d-block p-2 bg-success text-white text-center'>$rowCount result found!</span>";
            // } else if ($rowCount >= 1) {
            //     echo "<span class='d-block p-2 bg-success text-white text-center'>$rowCount results found!</span>";
            // }
            // unset($_SESSION['successAdd']);
            // unset($_SESSION['patientprof']);
            ?>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
            <?php unset($_SESSION['alert']); ?>
        }, 3000);
    });
</script>