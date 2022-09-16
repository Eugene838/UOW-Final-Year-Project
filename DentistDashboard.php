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

        .img1 {
            width: 50px;
            height: 90px;
            position: relative;
            z-index: 1;
            top: -350px;
            left: 45px;
        }

        .img2 {
            width: 50px;
            height: 90px;
            position: relative;
            z-index: 1;
            top: -350px;
            left: 45px;
        }

        .img3 {
            width: 50px;
            height: 90px;
            position: relative;
            z-index: 1;
            top: -350px;
            left: 40px;
        }

        .img4 {
            width: 40px;
            height: 90px;
            position: relative;
            z-index: 1;
            top: -350px;
            left: 28px;
        }

        .img5 {
            width: 40px;
            height: 90px;
            position: relative;
            z-index: 1;
            top: -350px;
            left: 18px;
        }

        .img6 {
            width: 40px;
            height: 100px;
            position: relative;
            z-index: 1;
            top: -350px;
            left: 10px;
        }

        .img7 {
            width: 40px;
            height: 90px;
            position: relative;
            z-index: 1;
            top: -350px;
            left: -2px;
        }

        .img8 {
            width: 40px;
            height: 90px;
            position: relative;
            z-index: 1;
            top: -350px;
            left: -12px;
        }

        .img9 {
            width: 40px;
            height: 90px;
            position: relative;
            z-index: 1;
            top: -350px;
            left: -18px;
        }

        .img10 {
            width: 40px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -350px;
            left: -30px;
        }

        .img11 {
            width: 40px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -355px;
            left: -42px;
        }

        .img12 {
            width: 40px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -355px;
            left: -52px;
        }

        .img13 {
            width: 40px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -355px;
            left: -62px;
        }

        .img14 {
            width: 45px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -355px;
            left: -68px;
        }

        .img15 {
            width: 45px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -355px;
            left: -68px;
        }

        .img16 {
            width: 45px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -355px;
            left: -75px;
        }

        .img17 {
            width: 45px;
            height: 60px;
            position: relative;
            z-index: 2;
            top: -320px;
            left: 50px;
        }

        .img18 {
            width: 55px;
            height: 70px;
            position: relative;
            z-index: 2;
            top: -315px;
            left: 40px;
        }

        .img19 {
            width: 55px;
            height: 70px;
            position: relative;
            z-index: 2;
            top: -315px;
            left: 40px;
        }

        .img20 {
            width: 35px;
            height: 70px;
            position: relative;
            z-index: 2;
            top: -315px;
            left: 35px;
        }

        .img21 {
            width: 35px;
            height: 70px;
            position: relative;
            z-index: 2;
            top: -315px;
            left: 30px;
        }

        .img22 {
            width: 35px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -308px;
            left: 25px;
        }

        .img23 {
            width: 35px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -308px;
            left: 20px;
        }

        .img24 {
            width: 35px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -308px;
            left: 12px;
        }

        .img25 {
            width: 35px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -308px;
            left: 0px;
        }

        .img26 {
            width: 35px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -308px;
            left: -5px;
        }

        .img27 {
            width: 35px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -308px;
            left: -10px;
        }

        .img28 {
            width: 35px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -308px;
            left: -15px;
        }

        .img29 {
            width: 35px;
            height: 90px;
            position: relative;
            z-index: 2;
            top: -308px;
            left: -22px;
        }

        .img30 {
            width: 50px;
            height: 75px;
            position: relative;
            z-index: 2;
            top: -315px;
            left: -28px;
        }

        .img31 {
            width: 50px;
            height: 70px;
            position: relative;
            z-index: 2;
            top: -315px;
            left: -30px;
        }

        .img32 {
            width: 50px;
            height: 65px;
            position: relative;
            z-index: 2;
            top: -315px;
            left: -38px;
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
                        <th width ="10%" scope="col">Appointment No.</th>
                        <th width ="10%" scope="col">Dentist Name</th>
                        <th width ="10%" scope="col">Patient ID</th>
                        <th width ="10%" scope="col">Name of Patient</th>
                        <th width ="10%" scope="col">Appointment Reason</th>
                        <th width ="10%" scope="col">Appointment Time</th>
                        <th width ="10%" scope="col">Appointment Status</th>
                        <th width ="10%" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id = $_SESSION['Emp_ID'];
                    $stmt2 = $db->connect()->prepare("SELECT * FROM appointment_table WHERE appt_date = CURRENT_DATE() AND `status` = 'In Queue' and `dentist_id` = '$id'");
                    $stmt2->execute();

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
                                //'<td><button type="button" class="btn btn-primary attendBtn" data-bs-toggle="modal" data-bs-target="#attendBtn">Attend <i class="bi bi-check-circle"></i></button></td>' .
                                '<td><button type="button" class="btn btn-primary" onclick="location.href=\'AttendPatient.php?appointment_id=' . $queue['appointment_id'] . '&patient_id=' . $patientID . '\'">Attend <i class="bi bi-check-circle"></i></button></td>' .
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
                        <th width ="10%" scope="col">Appointment No.</th>
                        <th width ="10%" scope="col">Dentist Name</th>
                        <th width ="10%" scope="col">Patient ID</th>
                        <th width ="10%" scope="col">Name of Patient</th>
                        <th width ="10%" scope="col">Appointment Reason</th>
                        <th width ="10%" scope="col">Appointment Time</th>
                        <th width ="10%" scope="col">Appointment Status</th>
                        <th width ="10%" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id = $_SESSION['Emp_ID'];
                    $stmt = $db->connect()->prepare("SELECT * FROM appointment_table WHERE appt_date = CURRENT_DATE() AND `status` = 'Booked' and `dentist_id` = '$id'");
                    $stmt->execute();

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
                                '<td><button type="button" class="btn btn-danger cancelBtn" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel <i class="bi bi-exclamation-diamond"></i></button></td>' .
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
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
            <?php unset($_SESSION['alert']); ?>
        }, 3000);
    });
</script>