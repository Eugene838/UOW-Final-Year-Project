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
            <div class="row g-3">
                <div class="col-3">
                    <h2><u>Patient Treatment Records</u></h2>
                </div>
            </div>
            <?php include "Search.php"; ?>
            <table class="table table-hover ps-1 mt-3" id="searchTable">
                <thead class="table-dark">
                    <tr>
                    <th scope="col" style="width: 100px">Record ID</th>
                        <th scope="col">Name</th>
                        <th scope="col" style="width: 110px">NRIC</th>
                        <!-- <th scope="col" style="display:none">Phone Number</th> -->
                        <!-- <th scope="col">Date of Birth</th> -->
                        <th scope="col" style="width: 110px">Date of Visit</th>
                        <th scope="col">Type of service</th>
                        <th scope="col" style="display:none">Treatment Description</th>
                        <th scope="col" style="display:none">Materials used</th>
                        <th scope="col" style="display:none">Dentist/Assistants 1</th>
                        <th scope="col" style="display:none">Dentist/Assistants 2</th>
                        <th scope="col" style="width: 100px">View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($recept_patient_records)) {
                        foreach ($recept_patient_records as $record) {
                            echo
                            '<tr>' .
                                '<td scope="row">' . $record['Record_ID'] . '</th>' .
                                '<td>' . $record['First_Name'] . ' ' . $record['Last_Name'] . '</td>' .
                                '<td>' . $record['NRIC_PNum'] . '</td>' .
                                // '<td style="display:none">' . $record['Phone_Num'] . '</td>' .
                                //'<td>' . date('d-m-Y', strtotime($record['Birth_Date'])) . '</td>' .
                                '<td>' . date('d-m-Y', strtotime($record['Treatment_Date'])) . '</td>' .
                                '<td>' . $record['Treatment_Type'] . '</td>' .
                                '<td style="display:none">' . $record['Treatment_details'] . '</td>' .
                                '<td style="display:none">' . $record['Material_used'] . '</td>' .
                                '<td style="display:none">' . $record['Doctor/Assistant 1'] . '</td>' .
                                '<td style="display:none">' . $record['Doctor/Assistant 2'] . '</td>' .
                                '<td><button type="button" class="btn btn-secondary viewPatRecBtn" data-bs-toggle="modal" data-bs-target="#recept_viewPatRec">View  <i class="bi bi-eye"></i></button></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td class="text-center" colspan="11"><b>No patient records.</b></td>' .
                            '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>