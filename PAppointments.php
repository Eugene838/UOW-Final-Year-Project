<?php
include 'db_connection.php';
include 'PNavBar.php';
$patID = $_SESSION['Patient_ID'];
$db = new DB_Connect();

if (isset($_POST['deleteYes'])) {
    $appt_id = $_POST['dApptID'];
    $stmt = $db->connect()->prepare("DELETE from appointment_table where patient_id = '$patID' and appointment_id = '$appt_id'");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $msg = '<div class="alert alert-success" role="alert-msg" id="alert">Appointment has been successfully deleted! <i class="bi bi-trash-fill"></i></div>';
    } else {
        $msg = '<div class="alert alert-danger" role="alert-msg" id="alert">Error! Please try again <i class="bi bi-trash-fill"></i></div>';
    }
}

?>
<html>

<head>
    <title> Patient Page </title>

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

        body {
            background-image: url('img/AdminBackground.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        table {
            width: 50%;
            background-color: white;
            text-align: left;
        }

        td,
        th {
            border: 1px solid #ddd;
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
        if (isset($msg)) {
            echo $msg;
        }
        ?>
        <div class="w-100 p-3">
            <h2><b> Today's Appointments </b></h2>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="display:none">Schedule ID</th>
                        <th scope="col">Appointment Number</th>
                        <th scope="col">Dentist ID</th>
                        <th scope="col">Dentist Name</th>
                        <th scope="col">Appointment Date</th>
                        <th scope="col">Appointment Day</th>

                        <th scope="col">Appointment Time</th>
                        <th scope="col">Appointment Reason</th>
                        <th scope="col">Status</th>
                        <th scope="col">Delete </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt1 = $db->connect()->prepare("SELECT * from appointment_table where patient_id = $patID and appt_date = CURRENT_DATE() and appt_time > CURRENT_TIME()  order by `appt_date` desc");
                    $stmt1->execute();
                    // print_r($stmt1);
                    if ($stmt1->rowCount() > 0) {
                        $todayAppts = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                        if (isset($todayAppts)) {
                            foreach ($todayAppts as $appt) {
                                echo
                                '<tr>' .
                                    '<td style=display:none>' . $appt['appointment_id'] . '</td>' .
                                    '<td>' . $appt['appt_number'] . '</td>' .

                                    '<td>' . $appt['dentist_id'] . '</td>' .
                                    '<td>' . $appt['dentist_name'] . '</td>' .
                                    '<td>' . $appt['appt_date'] . '</td>' .
                                    '<td>' . $appt['appt_day'] . '</td>' .
                                    '<td>' . $appt['appt_time'] . '</td>' .
                                    '<td>' . $appt['appt_reason'] . '</td>' .
                                    $status = '';
                                if ($appt['status'] == 'Booked') {
                                    $status = '<span class="badge bg-warning">' . $appt['status'] . '</span>';
                                }
                                if ($appt['status'] == 'Cancelled') {
                                    $status = '<span class="badge bg-danger">' . $appt['status'] . '</span>';
                                }
                                if ($appt['status'] == 'In Queue') {
                                    $status = '<span class="badge bg-primary">' . $appt['status'] . '</span>';
                                }
                                if ($appt['status'] == 'Completed') {
                                    $status = '<span class="badge bg-info">' . $appt['status'] . '</span>';
                                }
                                if ($appt['status'] == 'Paid') {
                                    $status = '<span class="badge bg-success">' . $appt['status'] . '</span>';
                                }
                                echo '<td>' . $status . '</td>' .
                                    '<td><button type="button" class="btn btn-danger deleteBtn" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete <i class="bi bi-trash-fill"></i></button></td>' .
                                    // print_r($status);
                                    '</tr>';
                            }
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td colspan="8"><b>You have no appointments today.</b></td>' .
                            '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <h2><b> Upcoming Appointments </b></h2>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="display:none">Schedule ID</th>
                        <th scope="col">Appointment Number</th>
                        <th scope="col">Dentist ID</th>
                        <th scope="col">Dentist Name</th>
                        <th scope="col">Appointment Date</th>
                        <th scope="col">Appointment Day</th>

                        <th scope="col">Appointment Time</th>
                        <th scope="col">Appointment Reason</th>
                        <th scope="col">Status</th>
                        <th scope="col">Delete </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->connect()->prepare("SELECT * from appointment_table where patient_id = $patID and appt_date > CURRENT_DATE() order by `appt_date` desc");
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $appts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($appts as $appt) {
                            echo
                            '<tr>' .
                                '<td style=display:none>' . $appt['appointment_id'] . '</td>' .
                                '<td>' . $appt['appt_number'] . '</td>' .

                                '<td>' . $appt['dentist_id'] . '</td>' .
                                '<td>' . $appt['dentist_name'] . '</td>' .
                                '<td>' . $appt['appt_date'] . '</td>' .
                                '<td>' . $appt['appt_day'] . '</td>' .
                                '<td>' . $appt['appt_time'] . '</td>' .
                                '<td>' . $appt['appt_reason'] . '</td>' .
                                $status = '';
                            if ($appt['status'] == 'Booked') {
                                $status = '<span class="badge bg-warning">' . $appt['status'] . '</span>';
                            }
                            if ($appt['status'] == 'Cancelled') {
                                $status = '<span class="badge bg-danger">' . $appt['status'] . '</span>';
                            }
                            if ($appt['status'] == 'In Queue') {
                                $status = '<span class="badge bg-primary">' . $appt['status'] . '</span>';
                            }
                            if ($appt['status'] == 'Completed') {
                                $status = '<span class="badge bg-info">' . $appt['status'] . '</span>';
                            }
                            if ($appt['status'] == 'Paid') {
                                $status = '<span class="badge bg-success">' . $appt['status'] . '</span>';
                            }
                            echo '<td>' . $status . '</td>' .
                                // print_r($status);
                                '<td><button type="button" class="btn btn-danger deleteBtn" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete <i class="bi bi-trash-fill"></i></button></td>' .

                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td colspan="8"><b>No upcoming appointments.</b></td>' .
                            '</tr>';
                    }
                    ?>
                </tbody>

            </table>
            <h2><b> Past Appointments </b></h2>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="display:none">Schedule ID</th>
                        <th scope="col">Appointment Number</th>
                        <th scope="col">Dentist ID</th>
                        <th scope="col">Dentist Name</th>
                        <th scope="col">Appointment Date</th>
                        <th scope="col">Appointment Day</th>

                        <th scope="col">Appointment Time</th>
                        <th scope="col">Appointment Reason</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt1 = $db->connect()->prepare("SELECT * from appointment_table where patient_id = $patID and (appt_date < CURRENT_DATE() or (appt_date = CURRENT_DATE() and CURRENT_TIME() > appt_time)) order by `appt_date` desc");
                    $stmt1->execute();
                    // print_r($stmt1);
                    if ($stmt1->rowCount() > 0) {
                        $pastAppts = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($pastAppts as $appt) {
                            echo
                            '<tr>' .
                                '<td style=display:none>' . $appt['appointment_id'] . '</td>' .
                                '<td>' . $appt['appt_number'] . '</td>' .

                                '<td>' . $appt['dentist_id'] . '</td>' .
                                '<td>' . $appt['dentist_name'] . '</td>' .
                                '<td>' . $appt['appt_date'] . '</td>' .
                                '<td>' . $appt['appt_day'] . '</td>' .
                                '<td>' . $appt['appt_time'] . '</td>' .
                                '<td>' . $appt['appt_reason'] . '</td>' .
                                $status = '';
                            if ($appt['status'] == 'Booked') {
                                $status = '<span class="badge bg-warning">' . $appt['status'] . '</span>';
                            }
                            if ($appt['status'] == 'Cancelled') {
                                $status = '<span class="badge bg-danger">' . $appt['status'] . '</span>';
                            }
                            if ($appt['status'] == 'In Queue') {
                                $status = '<span class="badge bg-primary">' . $appt['status'] . '</span>';
                            }
                            if ($appt['status'] == 'Completed') {
                                $status = '<span class="badge bg-info">' . $appt['status'] . '</span>';
                            }
                            if ($appt['status'] == 'Paid') {
                                $status = '<span class="badge bg-success">' . $appt['status'] . '</span>';
                            }
                            echo '<td>' . $status . '</td>' .
                                // print_r($status);
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td colspan="8"><b>No past appointments.</b></td>' .
                            '</tr>';
                    }

                    ?>
                </tbody>

            </table>
        </div>
    </div>
    <!-- Delete Appointment Modal -->
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Delete Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input class="form-label" name="dApptNum" id="dApptNum" hidden>
                        <input class="form-label" name="dApptID" id="dApptID" hidden>
                        <p class="fw-bold">Are you sure to delete this appointment?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-lg btn-danger" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-lg btn-success" name="deleteYes">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
        }, 3000);
    });

    $('.deleteBtn').click(function() {
        $apptID = $(this).closest('tr').find('td:nth-child(1)').text();
        $('#dApptID').val($apptID);
    });
</script>

</html>