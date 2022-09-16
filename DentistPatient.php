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

        .diagram {
            width: 100%;
            height: 15vw;
            object-fit: cover;
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
            <div class="row g-3">
                <h2><u>Patient Profiles</u></h2>
                <div class="col-6 mb-3">
                    <?php include "Search.php"; ?>
                </div>
            </div>
            <table class="table table-hover ps-1 mt-3" id="searchTable">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" hidden>Patient ID</th>
                        <th scope="col">Name</th>
                        <th scope="col" style="width: 100px">NRIC/Passport No.</th>
                        <th scope="col">Gender</th>
                        <th scope="col" style="width: 100px">Phone Number</th>
                        <th scope="col" style="width: 50px">Smoker?</th>
                        <th scope="col">Allergies?</th>
                        <th scope="col">Long Term Medications?</th>
                        <th scope="col">Existing Medication Conditions?</th>
                        <th scope="col">Emergency Contact Name</th>
                        <th scope="col" style="width: 100px">Emergency Contact Number</th>
                        <th scope="col" style="width: 100px">Emergency Contact Relation</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($dentist_patient_profile)) {
                        foreach ($dentist_patient_profile as $patient) {
                            echo
                            '<tr>' .
                                '<td hidden>' . $patient['Patient_ID'] . '</td>' .
                                '<td>' . $patient['First_Name'] . ' ' . $patient['Last_Name'] . '</td>' .
                                '<td>' . $patient['NRIC_PNum'] . '</td>' .
                                '<td>' . $patient['Gender'] . '</td>' .
                                '<td>' . $patient['Phone_Num'] . '</td>' .
                                '<td>' . $patient['Smoker'] . '</td>';
                            if (!empty($patient['Allergies'])) {
                                echo '<td>' . $patient['Allergies'] . '</td>';
                            } else {
                                echo '<td>NA.</td>';
                            }
                            if (!empty($patient['Long_term_med'])) {
                                echo '<td>' . $patient['Long_term_med'] . '</td>';
                            } else {
                                echo '<td>NA.</td>';
                            }
                            if (!empty($patient['Existing_Med_Conds'])) {
                                echo '<td>' . $patient['Existing_Med_Conds'] . '</td>';
                            } else {
                                echo '<td>NA.</td>';
                            }
                            echo
                            '<td>' . $patient['Emer_Name'] . '</td>' .
                                '<td>' . $patient['Emer_Contact'] . '</td>' .
                                '<td>' . $patient['Emer_relation'] . '</td>' .
                                '<td><button type="button" class="btn btn-success createBtn" data-bs-toggle="modal" data-bs-target="#createBtn">Create <i class="bi bi-pencil-square"></i></button></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td colspan="6" style="text-align:center"><b>No patients profile.</b></td>' .
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