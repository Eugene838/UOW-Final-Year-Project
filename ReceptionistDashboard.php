<?php
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
            <h2><u>Waiting in queue</u></h2>
            <table class="table table-hover ps-1">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 150px">Appointment No.</th>
                        <th scope="col">Dentist Name</th>
                        <th scope="col">Patient ID</th>
                        <th scope="col">Name of Patient</th>
                        <th scope="col">Appointment Reason</th>
                        <th scope="col" style="width: 180px">Appointment Time</th>
                        <th scope="col" style="width: 180px">Appointment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt3 = $db->connect()->prepare("SELECT * FROM appointment_table WHERE appt_date = CURRENT_DATE() AND `status` = 'In Queue' AND `Company` = ?");
                    $stmt3->execute([$company]);

                    if ($stmt3->rowCount() > 0) {
                        $inQueue = $stmt3->fetchAll(PDO::FETCH_ASSOC);

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
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td class="text-center" colspan="8"><b>No patients in queue.</b></td>' .
                            '</tr>';
                    }

                    ?>
                </tbody>
            </table>
            <h2><u>Today's Appointment</u></h2>
            <table class="table table-hover ps-1">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 150px">Appointment No.</th>
                        <th scope="col">Dentist Name</th>
                        <th scope="col">Patient ID</th>
                        <th scope="col">Name of Patient</th>
                        <th scope="col">Appointment Reason</th>
                        <th scope="col">Appointment Time</th>
                        <th scope="col">Appointment Status</th>
                        <th scope="col" style="width: 120px;">Arrived?</th>
                        <th scope="col" style="width: 200px;">Cancel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt2 = $db->connect()->prepare("SELECT * FROM appointment_table WHERE appt_date = CURRENT_DATE() AND `status` = 'Booked' AND `Company` = ?");
                    $stmt2->execute([$company]);

                    if ($stmt2->rowCount() > 0) {
                        $todayAppt = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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
                                '<td id="aPID">' . $appt['patient_id'] . '</td>' .
                                '<td>' . $patientDetail[0]['First_Name'] . ' ' . $patientDetail[0]['Last_Name'] . '</td>' .
                                '<td hidden>' . $patientDetail[0]['NRIC_PNum'] . '</td>' .
                                '<td hidden>' . $patientDetail[0]['Phone_Num'] . '</td>' .
                                '<td hidden>' . $patientDetail[0]['Address'] . '</td>' .
                                '<td>' . $appt['appt_reason'] . '</td>' .
                                '<td>' .  date('g:i A', strtotime($start_time)) . ' - ' . date('g:i A', strtotime($end_time)) . '</td>' .
                                // '<td>' . date('g:i A', strtotime($appt['appt_time'])) . '</td>' .
                                '<td>' . $appt['status'] . '</td>' .
                                '<td><button type="button" class="btn btn-success arriveBtn" data-bs-toggle="modal" data-bs-target="#patientArriveModal">Arrived <i class="bi bi-person-check"></i></button></td>' .
                                '<td><button type="button" class="btn btn-danger cancelBtn" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel Appointment <i class="bi bi-x-square"></i></button></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td class="text-center" colspan="9"><b>No appointments for today.</b></td>' .
                            '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <div class="row g-3 pt-4">
                <div class="col-4">
                    <h2><u>Pending Payments</u></h2>
                </div>
            </div>
            <table class="table table-hover ps-1">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 100px">Patient ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col" style="width: 180px">NRIC/Passport No.</th>
                        <th scope="col" style="width: 140px">Appointment ID</th>
                        <th scope="col" style="width: 180px">Attended by</th>
                        <th scope="col">Type of Service</th>
                        <th scope="col" style="width: 180px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->connect()->prepare("SELECT * FROM appointment_table WHERE appt_date = CURRENT_DATE() AND `status` = 'Completed' AND `Company` = ?");
                    $stmt->execute([$company]);

                    if ($stmt->rowCount() > 0) {
                        $completeAppt = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($completeAppt as $complete) {
                            $patientID = $complete['patient_id'];
                            $stmt2 = $db->connectWix()->prepare("SELECT * FROM wixPatients WHERE Patient_ID = '$patientID'");
                            $stmt2->execute();
                            $patientDetail = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                            $stmt3 = $db->connect()->prepare("SELECT Treatment_type FROM patient_record WHERE Treatment_Date = CURRENT_DATE() AND Patient_ID = '$patientID'");
                            $stmt3->execute();
                            $patientRecords = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                            echo
                            '<tr>' .
                                '<td>' . $complete['patient_id'] . '</td>' .
                                '<td>' . $patientDetail[0]['First_Name'] . ' ' . $patientDetail[0]['Last_Name'] . '</td>' .
                                '<td>' . $patientDetail[0]['NRIC_PNum'] . '</td>' .
                                '<td>' . $complete['appointment_id'] . '</td>' .
                                '<td>' . $complete['dentist_name'] . '</td>' .
                                '<td>' . $patientRecords[0]['Treatment_type'] . '</td>' .
                                '<td><button type="button" class="btn btn-success" onclick="location.href=\'create_invoice.php?patient_id=' . $patientID . '&appointment_id=' . $complete['appointment_id'] . '\'">Payment <i class="bi bi-currency-dollar"></i></button></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td class="text-center" colspan="9"><b>No pending payments.</b></td>' .
                            '</tr>';
                    }
                    ?>
                </tbody>
            </table>
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