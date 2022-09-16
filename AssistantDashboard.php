<?php
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
            <h2><u>Waiting in queue</u></h2>
            <table class="table table-hover ps-1">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Appointment No.</th>
                        <th scope="col">Dentist Name</th>
                        <th scope="col">Patient ID</th>
                        <th scope="col">Name of Patient</th>
                        <th scope="col">Appointment Reason</th>
                        <th scope="col">Appointment Time</th>
                        <th scope="col">Appointment Status</th>
                        <!-- <th scope="col">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt2 = $db->connect()->prepare("SELECT * FROM appointment_table WHERE appt_date = CURRENT_DATE() AND `status` = 'In Queue' and `Company` = ?");
                    $stmt2->execute([$company]);

                    if ($stmt2->rowCount() > 0) {
                        $inQueue = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($inQueue as $queue) {
                            $patientID = $queue['patient_id'];
                            $pd = $db->connectWix()->prepare("SELECT * FROM wixPatients WHERE Patient_ID = '$patientID'");
                            $pd->execute();
                            $patientDetail = $pd->fetchAll(PDO::FETCH_ASSOC);
                            $temp = (explode("-", $queue['appt_time']));
                            $start_time = $temp[0];
                            $end_time = $temp[1];
                            echo
                            '<tr>' .
                                '<td>' . $queue['appointment_id'] . '</td>' .
                                '<td>' . $queue['dentist_name'] . '</td>' .
                                '<td>' . $queue['patient_id'] . '</td>' .
                                '<td>' . $patientDetail[0]['First_Name'] . ' ' . $patientDetail[0]['Last_Name'] . '</td>' .
                                '<td>' . $queue['appt_reason'] . '</td>' .
                                '<td>' .  date('g:i A', strtotime($start_time)) . ' - ' . date('g:i A', strtotime($end_time)) . '</td>' .
                                // '<td>' . date('g:i A', strtotime($queue['appt_time'])) . '</td>' .
                                '<td>' . $queue['status'] . '</td>' .
                                // '<td><button type="button" class="btn btn-primary createBtn1" data-bs-toggle="modal" data-bs-target="#createBtn">Attend <i class="bi bi-check-circle"></i></button></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td colspan="8" style="text-align:center"><b>No patients in queue.</b></td>' .
                            '</tr>';
                    }

                    ?>
                </tbody>
            </table>
            <h2><u>Today's Appointment</u></h2>
            <table class="table table-hover ps-1">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Appointment No.</th>
                        <th scope="col">Dentist Name</th>
                        <th scope="col">Patient ID</th>
                        <th scope="col">Name of Patient</th>
                        <th scope="col">Appointment Reason</th>
                        <th scope="col">Appointment Time</th>
                        <th scope="col">Appointment Status</th>
                        <!-- <th scope="col">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $stmt = $db->connect()->prepare("SELECT * FROM appointment_table WHERE appt_date = CURRENT_DATE() AND `status` = 'Booked' and `Company` = ?");
                    $stmt->execute([$company]);

                    if ($stmt->rowCount() > 0) {
                        $todayAppt = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($todayAppt as $appt) {
                            $patientID = $appt['patient_id'];
                            $stmt2 = $db->connectWix()->prepare("SELECT * FROM wixPatients WHERE Patient_ID = '$patientID'");
                            $stmt2->execute();
                            $patientDetail = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                            $temp = (explode("-", $appt['appt_time']));
                            $start_time = ($temp[0]);
                            $end_time = ($temp[1]);
                            echo
                            '<tr>' .
                                '<td>' . $appt['appointment_id'] . '</td>' .
                                '<td>' . $appt['dentist_name'] . '</td>' .
                                '<td>' . $appt['patient_id'] . '</td>' .
                                '<td>' . $patientDetail[0]['First_Name'] . ' ' . $patientDetail[0]['Last_Name'] . '</td>' .
                                '<td>' . $appt['appt_reason'] . '</td>' .
                                '<td>' .  date('g:i A', strtotime($start_time)) . ' - ' . date('g:i A', strtotime($end_time)) . '</td>' .
                                // '<td>' . date('g:i A', strtotime($appt['appt_time'])) . '</td>' .
                                '<td>' . $appt['status'] . '</td>' .
                                // '<td><button type="button" class="btn btn-danger cancelBtn" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel <i class="bi bi-exclamation-diamond"></i></button></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td colspan="8" style="text-align:center"><b>No appointments for today.</b></td>' .
                            '</tr>';
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>