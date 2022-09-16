<?php
ob_start();
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'Navbar.php';
include 'Assistant.php';
?>
<html>

<head>
    <title>Dental Assistant Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        body {
            background-image: url('img/AdminBackground.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
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
            <h2><u>Patient Profiles</u></h2>
            <?php include "Search.php"; ?>

            <table class="table table-hover ps-1 mt-3" id = "searchTable">
                <thead class="table-dark">
                    <tr>
                        <!-- <th scope="col">Patient ID</th> -->
                        <th scope="col">Name</th>
                        <th scope="col" style="width: 100px">NRIC/Passport No.</th>
                        <th scope="col">Gender</th>
                        <th scope="col" style="width: 100px">Phone Number</th>
                        <th scope="col" style="width: 50px">Smoker?</th>
                        <th scope="col">Allergies?</th>
                        <th scope="col">Long Term Medications?</th>
                        <th scope="col">Existing Medication Conditions?</th>
                        <th scope="col">Emergency Contact Name</th>
                        <th scope="col" style="width: 100px">Emergency Contact Number</th>
                        <th scope="col" style="width: 100px" id = "emercontact">Emergency Contact Relation</th>
                        <!-- <th scope="col">Family ID</th> -->
                        <!-- <th scope="col" style="display:none">Treatment Details</th>
                        <th scope="col" style="display:none">Materials used</th>
                        <th scope="col" style="display:none">Dentists involved</th>
                        <th scope="col" style="display:none">Assistants involved</th> -->
                        <!-- <th scope="col" style="width: 100px">Action</th> -->
                    </tr>
                </thead>
                <?php
                // if (!isset($_SESSION['patientprof']) && empty($_SESSION['patientprof'])) {
                //     $company = $_SESSION['Company'];
                //     $stmt = $db->connectWix()->prepare("SELECT * FROM wixPatients");
                //     $stmt->execute();


                if (isset($da_patients_profile)) {
                    foreach ($da_patients_profile as $patients) {
                        echo
                        '<tr>' .
                            //'<td scope="row">' . $patients['Patient_ID'] . '</td>' .
                            '<td>' . $patients['First_Name'] . ' ' . $patients['Last_Name'] . '</td>' .
                            '<td>' . $patients['NRIC_PNum'] . '</td>' .
                            //'<td>' . date('d-m-Y', strtotime($patients['Birth_Date'])) . '</td>' .
                            //'<td>' . $patients['Address'] . '</td>' .
                            //'<td>' . $patients['Email'] . '</td>' .
                            '<td>' . $patients['Gender'] . '</td>' .
                            '<td>' . $patients['Phone_Num'] . '</td>' .
                            //'<td>' . $patients['Marital_Status'] . '</td>' .
                            //'<td>' . $patients['Occupation'] . '</td>' .
                            '<td>' . $patients['Smoker'] . '</td>';
                        if (!empty($patients['Allergies'])) {
                            echo '<td>' . $patients['Allergies'] . '</td>';
                        } else {
                            echo '<td>NA.</td>';
                        }
                        if (!empty($patients['Long_term_med'])) {
                            echo '<td>' . $patients['Long_term_med'] . '</td>';
                        } else {
                            echo '<td>NA.</td>';
                        }
                        if (!empty($patients['Existing_Med_Conds'])) {
                            echo '<td>' . $patients['Existing_Med_Conds'] . '</td>';
                        } else {
                            echo '<td>NA.</td>';
                        }
                        echo
                        '<td>' . $patients['Emer_Name'] . '</td>' .
                            '<td>' . $patients['Emer_Contact'] . '</td>' .
                            '<td>' . $patients['Emer_relation'] . '</td>' .
                            //'<td><button type="button" class="btn btn-secondary viewPatientProfile" data-bs-toggle="modal" data-bs-target="#viewPatientProfile">View <i class="bi bi-eye"></i></button></td>' .
                            //'<td><a class="btn btn-link" href="" role="button"><i class="bi bi-pencil-square"></i></a></td>' .
                            '</tr>';
                    }
                } else {
                    echo
                    '<tr>' .
                        '<td class="text-center" colspan="9"><b>No patient profiles.</b></td>' .
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
                //             //'<td scope="row">' . $patients['Patient_ID'] . '</td>' .
                //             '<td>' . $patients['First_Name'] . ' ' . $patients['Last_Name'] . '</td>' .
                //             '<td>' . $patients['Email'] . '</td>' .
                //             '<td>' . $patients['NRIC_PNum'] . '</td>' .
                //             '<td>' . $patients['Gender'] . '</td>' .
                //             '<td>' . $patients['Phone_Num'] . '</td>' .
                //             '<td>' . $patients['Address'] . '</td>' .
                //             '<td>' . $patients['Family_ID'] . '</td>' .
                //             '<td><button type="button" class="btn btn-secondary viewPatientProfile" data-bs-toggle="modal" data-bs-target="#viewPatientProfile">View <i class="bi bi-eye"></i></button></td>' .
                //             //'<td><a class="btn btn-link" href="" role="button"><i class="bi bi-pencil-square"></i></a></td>' .
                //             '</tr>';
                //     }
                // }
                ?>
                </tbody>
            </table>
            <?php
            // echo "$errormsg";
            // if ($rowCount == 1) {
            //     echo "<span class='d-block p-2 bg-success text-white text-center'>$rowCount result found!</span>";
            // } else if ($rowCount > 1) {
            //     echo "<span class='d-block p-2 bg-success text-white text-center'>$rowCount results found!</span>";
            // }
            ?>
            <!-- <form method="POST"><button type="submit" class="btn btn-secondary mt-2" name="allPatients">Back</button></form> -->
        </div>
    </div>
</body>

</html>