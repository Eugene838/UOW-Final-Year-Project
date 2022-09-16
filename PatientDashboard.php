<?php

use Sabberworm\CSS\Value\Value;

$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'PNavBar.php';
include 'Patient.php';
include 'CalculateDistance.php';

$key = 'AIzaSyDn_BBteHjo-xypOucpdAqUC_tNhpE7XLA';
$patientPostal = $_SESSION['Patient_PostalCode'];
$url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $patientPostal . '&key=' . $key . '&sensor=false';
$response = file_get_contents($url);
$data = json_decode($response, true);
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_URL, $url);
// $result = curl_exec($ch);
// curl_close($ch);
// $data = json_decode($result, true);
$patientLatitude;
$patientLongitude;
$getDistance = new CalculateDistance();
if ($data["status"] == "OK") {
    //print_r($data);
    $patientLatitude = $data["results"][0]['geometry']['location']['lat'];
    $patientLongitude = $data["results"][0]['geometry']['location']['lng'];
} else {
    echo "Unable to get your address location.";
}
?>

<html>

<head>
    <title> Patient Page </title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- JQuery stuff -->
    <!-- <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" /> -->
    <!-- JQuery CSS ui -->
    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <style>
        p,
        td {
            font-family: garamond;
            font-size: 14pt;
        }

        table {
            width: 50%;
            background-color: white;
            text-align: left;
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
            <h1 class="text-center"> <b> Clinic Information </b></h1>

            <div class="w-10" style="float:right;">
                <p>
                    <label class="ml-2">Distance Filter: </label><input class="pl-3" type="text" id="live_range_val" readonly style="border:0; font-weight:bold;">
                </p>
                <div id="val-range" style="width:200px; float:right; margin-bottom:10px;"></div>
            </div>

            <?php include "Search.php"; ?>

            <table class="table table-hover ps-1" id="searchTable">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Clinic Name</th>
                        <th scope="col">Dentist Name</th>
                        <th scope="col">Clinic Address</th>
                        <th scope="col">Specialization</th>
                        <th scope="col">Area</th>
                        <th scope="col" id="dist">Distance from you</th>
                        <th scope="col" style="display:none">Dentist ID</th>
                        <th scope="col" style="width: 160px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($schedules)) {
                        foreach ($schedules as $schedule) {
                            $clinicPostal = $schedule['postal_code'];
                            $newUrl = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $clinicPostal . '&key=' . $key . '&sensor=false';
                            $newResponse = file_get_contents($newUrl);
                            $newData = json_decode($newResponse, true);
                            // $ch = curl_init();
                            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            // curl_setopt($ch, CURLOPT_URL, $newUrl);
                            // $response = curl_exec($ch);
                            // $newData = json_decode($response, true);
                            // curl_close($ch);
                            echo
                            '<tr>' .
                                '<td>' . $schedule['Company'] . '</td>' .
                                '<td>' . $schedule['First_Name'] . ' ' . $schedule['Last_Name'] . '</td>' .
                                '<td>' . $schedule['clinic_address'] . ', Singapore ' . $schedule['postal_code'] . '</td>' .
                                '<td>' . $schedule['Specialization'] . '</td>';
                                if ($newData["status"] == "OK") {
                                    $clinicArea = $newData["results"][0]['address_components'][1]['long_name'];
                                    $clinicLatitude = $newData["results"][0]['geometry']['location']['lat'];
                                    $clinicLongitude = $newData["results"][0]['geometry']['location']['lng'];
                                    $distanceAway = round($getDistance->distance($patientLatitude, $patientLongitude, $clinicLatitude, $clinicLongitude), 2);
                                    echo '<td>' . $clinicArea . '</td>';
                                    echo '<td>' . $distanceAway . ' KM' . '</td>';
                                } else {
                                    echo '<td>Error!</td>';
                                    echo '<td>Error!</td>';
                                }
                            echo
                                '<td style=display:none>' . $schedule['Emp_ID'] . '</td>' .
                                '<td><button type="button" class="btn btn-secondary viewSchedule"> View Schedule <i class="bi bi-plus-square"></i> </button></td>' .
                                '</tr>';
                        }
                    } else {
                        echo '<tr><td span="6">No clinics available.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<!-- ✅ load jQuery UI ✅ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</html>