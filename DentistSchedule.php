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
            <h2><u>Dentist Schedule</u></h2>
            <table class="table table-hover ps-1">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="display:none">Schedule ID</th>
                        <th scope="col">Schedule Date</th>
                        <th scope="col">Schedule Day</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">End Time</th>
                        <th scope="col">Consulting Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($schedule)) {
                        foreach ($schedule as $schedule) {
                            echo
                            '<tr>' .
                                '<td style=display:none>' . $schedule['schedule_id'] . '</td>' .
                                '<td>' . $schedule['schedule_date'] . '</td>' .
                                '<td>' . $schedule['schedule_day'] . '</td>' .
                                '<td>' . $schedule['schedule_start_time'] . '</td>' .
                                '<td>' . $schedule['schedule_end_time'] . '</td>' .
                                '<td>' . $schedule['avg_consult_time'] . '</td>' .
                                '</tr>';
                        }
                    } else {
                        echo '<tr>' .
                            '<td colspan="10" style="text-align:center"><b>No available schedule. Please look for receptionist to add.</b></td>' .
                            ' </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>