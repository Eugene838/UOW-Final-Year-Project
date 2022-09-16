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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background-image: url('img/AdminBackground.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

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
            <!-- <nav class="navbar navbar-light bg-transparent">
                <div class="container-fluid mb-3">

                    <h2><u>Dentist Schedules</u></h2>
                    <form class="d-flex">
                    </form>
                    <button type="button" name="add_exam" id="add_doctor_schedule" class="btn btn-success btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#addSch">Add Schedule <i class="bi bi-plus-circle"></i>
                </div>
            </nav> -->
            <div class="row g-3">
                <div class="col-4">
                    <h2><u>Dentist Schedules</u></h2>
                </div>
                <div class="col-8">
                    <button type="button" name="add_exam" id="add_doctor_schedule" class="btn btn-success btn-circle float-end" data-bs-toggle="modal" data-bs-target="#addSch">Add Schedule <i class="bi bi-plus-circle"></i>
                </div>
            </div>
            <table class="table table-hover ps-1">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="display:none">Schedule ID</th>
                        <th scope="col">Dentist Name</th>
                        <th scope="col">Schedule Date</th>
                        <th scope="col">Schedule Day</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">End Time</th>
                        <th scope="col">Consulting Time</th>
                        <th scope="col" colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($schedules)) {
                        foreach ($schedules as $schedule) {
                            echo
                            '<tr>' .
                                '<td style=display:none>' . $schedule['schedule_id'] . '</td>' .
                                '<td>' . $schedule['First_Name'] .  ' ' . $schedule['Last_Name'] . '</td>' .
                                '<td>' . $schedule['schedule_date'] . '</td>' .
                                '<td>' . $schedule['schedule_day'] . '</td>' .
                                '<td>' . $schedule['schedule_start_time'] . '</td>' .
                                '<td>' . $schedule['schedule_end_time'] . '</td>' .
                                '<td>' . $schedule['avg_consult_time'] . '</td>' .
                                '<td><button type="button" class="btn btn-secondary editSch" data-bs-toggle="modal" data-bs-target="#editSch">Edit <i class="bi bi-pencil-square"></i></button></td>' .
                                '<td><button type="button" class="btn btn-danger deleteSch" data-bs-toggle="modal" data-bs-target="#deleteSch">Delete <i class="bi bi-trash"></i></button></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td class="text-center" colspan="9"><b>No available schedule for the month.</b></td>' .
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