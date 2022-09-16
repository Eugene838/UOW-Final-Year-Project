<?php
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'PNavBar.php';
include 'Patient.php';
?>
<!doctype html>
<html lang="en">

<head>
    <title> Patient Page </title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
    <div class="content-wrapper" id="content-wrapper">
        <div class="w-100 p-3">
            <button class="btn btn-secondary float-left" type="submit" name="backBtn" onclick="location.href = 'calendar.php?DentistID=<?php echo $dentistID ?>'"><i class="bi bi-arrow-left"></i> Back </button>
            <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); ?></h1>
            <hr>
            <?php
            if (isset($msg)) {
                echo $msg;
            }

            ?>
            <div class="row">
                <?php
                if (isset($schedules)) {
                    foreach ($schedules as $schedule) {
                        foreach ($schedule as $ts) {

                ?>
                            <div class="timeslots col-md-2 p-4 border border-dark text-center bg-light">
                                <div class="form-group">
                                    <?php if (in_array($ts, $bookings)) { ?>
                                        <button class="btn btn-danger"><?php echo $ts; ?></button>

                                    <?php } else { ?>
                                        <button class="btn btn-success bookAppt" data-timeslot="<?php echo $ts ?>"><?php echo $ts; ?></button>

                                    <?php } ?>

                                </div>
                            </div>
                    <?php
                        }
                    }
                } else {
                    ?>
                    <div class="col-md-2 p-4">
                        <div class="form-group">
                            <div class="btn btn-danger">No available timeslots</div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="modal fade" id="patientBookAppt" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h5 class="modal-title" id="staticBackdropLabel">Make New Appointment</h5> -->
                        <h4 class="modal-title" id="modal_title">Make New Appointment</h4>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" method="POST" novalidate>

                            <h4 class="text-center">Patient Details</h4>
                            <table class="table">
                                <?php
                                if (isset($patientInfo)) {
                                    foreach ($patientInfo as $patient) {
                                    }
                                ?>
                                    <tr>
                                        <th width="40%" class="text-right">Patient Name</th>
                                        <td><?php echo $patient['First_Name'] . ' ' . $patient['Last_Name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th width="40%" class="text-right">Contact No.</th>
                                        <td><?php echo $patient['Phone_Num']; ?></td>
                                    </tr>
                                    <tr>
                                        <th width="40%" class="text-right">Address</th>
                                        <td><?php echo $patient['Address']; ?></td>
                                    </tr>
                                <?php
                                } else {
                                ?>
                                    <tr>
                                        <th width="40%" class="text-right">Patient Name</th>
                                        <td style="color:red">No available information</td>
                                    </tr>
                                    <tr>
                                        <th width="40%" class="text-right">Contact No.</th>
                                        <td style="color:red">No available information</td>
                                    </tr>
                                    <tr>
                                        <th width="40%" class="text-right">Address</th>
                                        <td style="color:red">No available information</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                            <hr />
                            <h4 class="text-center">Appointment Details for <span id="slot"></span></h4>
                            <table class="table">
                                <tr>
                                    <th width="40%" class="text-right" style="vertical-align:middle">Dentist Name</th>
                                    <td><?php echo $dentist_Name; ?></td>
                                </tr>
                                <tr>
                                    <th width="40%" class="text-right" style="vertical-align:middle">Appointment Date</th>
                                    <td><?php echo date('m/d/Y', strtotime($date)); ?></td>
                                </tr>
                                <tr>
                                    <th width="40%" class="text-right" style="vertical-align:middle">Appointment Day</th>
                                    <td><?php echo date('l', strtotime($date)); ?></td>
                                </tr>
                                <tr>
                                    <th width="40%" class="text-right" style="vertical-align:middle">Time slot</th>
                                    <td><input type="text" style="width:200px; border:0;" id="timeslot" name="timeslot"></input></td>
                                </tr>
                                <tr style="display:none">
                                    <th width="40%" class="text-right" style="vertical-align:middle;">Schedule ID</th>
                                    <td><?php echo $schID; ?></td>
                                </tr>
                                <tr style="display:none">
                                    <th width="40%" class="text-right" style="vertical-align:middle;">Company</th>
                                    <td><?php echo $company; ?></input></td>
                                </tr>
                            </table>
                            <div class="form-group">
                                <label><b>Reason for Appointment</b></label>
                                <textarea name="reason_for_appointment" id="reason_for_appointment" class="form-control" required rows="5"></textarea>
                            </div>
                            <!-- <div class="mb-3" id="empID">
                        <label class="form-label">Employee ID</label>
                        <input type="text" class="form-control" name="searchEmpID">
                    </div> -->
                            <button type="submit" class="btn btn-primary float-end" name="BookBtn">Book</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>