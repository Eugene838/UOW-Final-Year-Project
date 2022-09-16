<?php
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'Navbar.php';
include 'Dentist.php';
?>

<html>

<head>
    <title> Dentist Page </title>
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
        <?php
        if (isset($_SESSION['alert'])) {
            echo $_SESSION['alert'];
        }
        ?>
        <div class="w-100 p-3">
            <div class="row g-3">
                <h2><u>Patient Records</u></h2>
                <?php include "Search.php"; ?>

            </div>
            <table class="table table-hover ps-1 mt-3" id="searchTable">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 100px">Record ID</th>
                        <th scope="col" style="width: 100px">Patient ID</th>
                        <th scope="col">Name of Patient</th>
                        <th scope="col">Date of treatment</th>
                        <th scope="col">Type of service</th>
                        <th scope="col">Treatment Description</th>
                        <th scope="col">Materials used</th>
                        <th scope="col" style="width: 180px; display:none">Company</th>
                        <th scope="col" style="width: 180px">Dentist Name</th>
                        <th scope="col" style="width: 180px">Assistant Name</th>
                        <th scope="col" style="width: 180px; display:none">Remarks</th>
                        <th scope="col" style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['dentistpatientrecords'])) {
                        $dentist_patient_records = $_SESSION['dentistpatientrecords'];
                    }
                    if (isset($dentist_patient_records)) {
                        foreach ($dentist_patient_records as $record) {
                            echo
                            '<tr>' .
                                '<td>' . $record['Record_ID'] . '</td>' .
                                '<td>' . $record['Patient_ID'] . '</td>' .
                                '<td>' . $record['First_Name'] . ' ' . $record['Last_Name'] . '</td>' .
                                '<td>' . $record['Treatment_Date'] . '</td>' .
                                '<td>' . $record['Treatment_type'] . '</td>' .
                                '<td>' . $record['Treatment_details'] . '</td>' .
                                '<td>' . $record['Material_used'] . '</td>' .
                                '<td style="display: none;">' . $record['Company'] . '</td>' .
                                '<td>' . $record['Doctor/Assistant 1'] . '</td>' .
                                '<td>' . $record['Doctor/Assistant 2'] . '</td>' .
                                '<td style="display: none;">' . $record['Remarks'] . '</td>' .
                                '<td><button type="button" class="btn btn-secondary editBtn" data-bs-toggle="modal" data-bs-target="#editRecordsModal">View/Edit <i class="bi bi-pencil-square"></i></button></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td colspan="10" style="text-align:center"><b>No patient records.</b></td>' .
                            '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <?php
            if (isset($_SESSION['dentistpatientrecords'])) {
                echo '<form method="POST"><button type="submit" class="btn btn-secondary mt-2" name="allRecords">Show all records</button></form>';
            }
            ?>
        </div>
    </div>
</body>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
            <?php unset($_SESSION['alert']); ?>
        }, 3000);
    });
</script>

</html>