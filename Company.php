<script>
    function searchFunction(event) {
        var input, filter, table, tr, td, i, txtValue;
        filter = event.target.value.toUpperCase();

        if (event.target.id == "recept-searchPatientProfile") {
            rows = document.querySelector("#recept-patientProfileTable tbody").rows;
            //console.log(document.querySelector("#recept-patientProfileTable tbody").rows[0].cells.length);
        } else if (event.target.id == "recept-searchTreatmentRecord") {
            rows = document.querySelector("#recept-treatmentRecordTable tbody").rows;
            //console.log(document.querySelector("#recept-treatmentRecordTable tbody").rows[0].cells.length);
        } else if (event.target.id == "da-searchPatientProfile") {
            rows = document.querySelector("#da-patientProfileTable tbody").rows;
        } else if (event.target.id == "da-searchTreatmentRecord") {
            rows = document.querySelector("#da-treatmentRecordTable tbody").rows;
        } else if (event.target.id == "dentist-searchPatientProfile") {
            rows = document.querySelector("#dentist-patientProfileTable tbody").rows;
        } else if (event.target.id == "dentist-searchTreatmentRecord") {
            rows = document.querySelector("#dentist-treatmentRecordTable tbody").rows;
        } else if (event.target.id == "ca-searchStaffAcc") {
            rows = document.querySelector("#ca-staffAccTable tbody").rows;
        } else {
            console.log("error");
        }

        for (i = 0; i < rows.length; i++) {
            tds = rows[i].getElementsByTagName("td");
            var matches = false;
            for (j = 0; j < tds.length; j++) {
                if (tds[j]) {
                    txtValue = tds[j].textContent || tds[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        matches = true;
                    }
                }
            }

            if (matches == true) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }

    }
</script>
<?php
ob_start();
include 'db_connection.php';
include 'Navbar.php';
$count = "0";
if (!isset($_SESSION['Role']) && empty($_SESSION['Role'])) {
    header("Location: index.php");
} else {
    $companyName = $_GET['Company'];
    $_SESSION['Company'] = $_GET['Company'];
    $path = "SuperAdmin";
    $db = new DB_Connect();
    include 'Dentist.php';
    include 'Assistant.php';
    include 'Admin.php';
    include 'Receptionist.php';
    include 'Invoice.php';
    $invoice = new Invoice();
}
if (isset($_POST['editClinic'])) {
    $clinicName = $_POST['clinicName'];
    $clinicUEN = $_POST['clinicUEN'];
    $clinicContact = $_POST['clinicContact'];
    $clinicAddress = $_POST['clinicAddress'];
    $clinicSpecial = $_POST['clinicSpecialization'];
    $clinicUsername = $_POST['clinicUsername'];
    $clinicPassword = $_POST['clinicPassword'];
    $applicant_fn = $_POST['clinic_applicant_FN'];
    $applicant_ln = $_POST['clinic_applicant_LN'];
    $applicant_contact = $_POST['clinic_applicant_contact'];
    $applicant_email = $_POST['clinic_applicant_email'];
    $applicant_address = $_POST['clinic_applicant_address'];

    $stmt = $db->connectWix()->prepare("UPDATE `wixClients` SET `first_name`=?,`last_name`=?,`contact_number`=?,`email`=?, `address`=?,
				`username`=?,`password`=?,`clinic_name`=?,`clinic_contact`=?,`clinic_uen`=?,`clinic_specialization`=?,`clinic_address`=? WHERE `clinic_uen`=?");
    $stmt->execute([$applicant_fn, $applicant_ln, $applicant_contact, $applicant_email, $applicant_address, $clinicUsername, $clinicPassword, $clinicName, $clinicContact, $clinicUEN, $clinicSpecial, $clinicAddress, $clinicUEN]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Clinic information updated successfully! <i class="bi bi-person-check"></i></div>';
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg" id="alert">Error! Please try again <i class="bi bi-person-check"></i></div>';
    }
}
?>
<html>

<head>
    <title> Administrator Page </title>
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

        .search {
            border: 1px solid black;
            width: 40%;
            padding: 5px 15px 5px 15px;

        }

        .field-icon {
            float: right;
            margin-right: 20px;
            margin-top: -30px;
            position: relative;
            z-index: 2;

        }
    </style>
</head>

<body>
    <div id="content-wrapper" class="content-wrapper">
        <div class="w-100 p-3 ">
            <div class="container-fluid mb-3">
                <?php
                if (isset($_SESSION['alert'])) {
                    echo $_SESSION['alert'];
                }
                ?>
                <?php echo '<h2><u>Company: ' . $companyName . '</u></h2>'; ?>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Clinic Name</th>
                            <th scope="col">Clinic UEN No.</th>
                            <th scope="col">Clinic Contact Number</th>
                            <th scope="col">Clinic Address</th>
                            <th scope="col">Clinic Specialization</th>
                            <th scope="col">Username</th>
                            <th scope="col" colspan="2" style="width: 150px">Password</th>
                            <th scope="col">Applicant Name</th>
                            <th scope="col" style="width: 150px">Phone Number</th>
                            <th scope="col">Email</th>
                            <th scope="col">Applicant Address</th>
                            <th scope="col" style="width: 80px">Status</th>
                            <th scope="col" style="width: 120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt2 = $db->connectWix()->prepare("SELECT * FROM `wixClients` where `status`='Active' and `clinic_name`=?");
                        $stmt2->execute([$companyName]);

                        if ($stmt2->rowCount() > 0) {
                            $activeAcc = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($activeAcc as $acc) {
                                echo
                                '<tr>' .
                                    '<td>' . $acc['clinic_name'] . '</td>' .
                                    '<td>' . $acc['clinic_uen'] . '</td>' .
                                    '<td>' . $acc['clinic_contact'] . '</td>' .
                                    '<td>' . $acc['clinic_address'] . '</td>' .
                                    '<td>' . $acc['clinic_specialization'] . '</td>' .
                                    '<td>' . $acc['username'] . '</td>' .
                                    '<td style="border-right:none;"><input type="password" value="' . $acc['password'] . '" style="border:none;" id="password" readonly></td>' .
                                    '<td style="border-left:none;"><i toggle="#password-field" class="bi bi-eye-slash-fill float-end toggle-password"></i></td>' .
                                    '<td>' . $acc['first_name'] . ' ' . $acc['last_name'] . '</td>' .
                                    '<td>' . $acc['contact_number'] . '</td>' .
                                    '<td>' . $acc['email'] . '</td>' .
                                    '<td>' . $acc['address'] . '</td>' .
                                    '<td><span class="badge bg-success">' . $acc['status'] . '</span></td>' .
                                    '<td><button type="button" class="btn btn-primary btn-sm editClinic" data-bs-toggle="modal" data-bs-target="#editClinic">Edit Clinic <i class="bi bi-pencil-square"></i></button></td>' .
                                    '</tr>';
                            }
                            echo
                            '</tbody>
                    </table>
                    ';
                        } else {
                            echo
                            '<tr>' .
                                '<td class="text-center" colspan="11"><b>No active subscriptions.</b></td>' .
                                '</tr>';
                            echo
                            '</tbody>
                        </table>
                        ';
                        }
                        ?>
                </table>
                <h2><u>Employees Information</u></h2>
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Empolyee ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Username</th>
                            <th scope="col" colspan="2">Password</th>
                            <th scope="col">NRIC/Passport No.</th>
                            <th scope="col" style="width: 50px">Gender</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Address</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Specialization</th>
                            <th scope="col" style="width: 80px">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt2 = $db->connect()->prepare("SELECT * FROM `user_table` where `Company`=?");
                        $stmt2->execute([$companyName]);

                        if ($stmt2->rowCount() > 0) {
                            $empAcc = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($empAcc as $acc) {
                                echo
                                '<tr>' .
                                    '<td>' . $acc['Emp_ID'] . '</td>' .
                                    '<td>' . $acc['First_Name'] . ' ' . $acc['Last_Name'] . '</td>' .
                                    '<td>' . $acc['username'] . '</td>' .
                                    '<td style="border-right:none;"><input type="password" value="' . $acc['password'] . '" style="border:none;" id="password" readonly></td>' .
                                    '<td style="border-left:none;"><i toggle="#password-field" class="bi bi-eye-slash-fill float-end toggle-password"></i></td>' .
                                    '<td>' . $acc['NRIC_PNum'] . '</td>' .
                                    '<td>' . $acc['Gender'] . '</td>' .
                                    '<td>' . $acc['Birth_Date'] . '</td>' .
                                    '<td>' . $acc['Address'] . '</td>' .
                                    '<td>' . $acc['Phone_Num'] . '</td>' .
                                    '<td>' . $acc['Email'] . '</td>' .
                                    '<td>' . $acc['Role'] . '</td>' .
                                    '<td>' . $acc['Specialization'] . '</td>' .
                                    '<td><span class="badge bg-success">' . $acc['status'] . '</span></td>' .
                                    //'<td><button type="button" class="btn btn-primary">Manage <i class="bi bi-server"></i></button></td>' .
                                    '</tr>';
                            }
                            echo
                            '</tbody>
                        </table>
                        ';
                        } else {
                            echo
                            '<tr>' .
                                '<td class="text-center" colspan="11"><b>No active subscriptions.</b></td>' .
                                '</tr>';
                            echo
                            '</tbody>
                        </table>
                        ';
                        }
                        ?>
                </table>
                <div class="d-grid gap-2 d-lg-block">
                    <form method="POST">
                        <h2 class="d-inline-block align-middle">View Role: </h2>
                        <button type="submit" class="btn btn-secondary cAdminBtn" name="cAdminBtn">Clinic Admin</button>
                        <button type="submit" class="btn btn-secondary recepBtn" name="recepBtn">Receptionist</button>
                        <button type="submit" class="btn btn-secondary dentalAssistBtn" name="dentalAssistBtn">Dental Assistant</button>
                        <button type="submit" class="btn btn-secondary dentistBtn" name="dentistBtn">Dentist</button>
                    </form>
                </div>
            </div>
            <?php

            // Clinic Admin button
            if (isset($_POST["cAdminBtn"])) {

                echo
                '
                <div class="row g-3">
                    <h2><u>Staff Accounts</u></h2>
                    <div class="col-6">
                        <h5 class="d-inline-block align-middle">Search <i class=\'bi bi-search\'></i></h5>
                        <input class="search" type="text" id="ca-searchStaffAcc" placeholder="Search...">
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#createAcc">Create New User Account <i class="bi bi-plus-square"></i></button>
                    </div>
                </div>
                    <table class="table table-hover ps-1" id="ca-staffAccTable">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" style="width: 100px">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col" colspan="2">Password</th>
                                <th scope="col">NRIC/Passport No.</th>
                                <th scope="col" style="display:none">Gender</th>
                                <th scope="col" style="width: 200px">DOB</th>
                                <th scope="col" style="display:none">Address</th>
                                <th scope="col" style="width: 400px">Phone Number</th>
                                <th scope="col" style="width: 400px">Email</th>
                                <th scope="col" style="width: 200px">Roles</th>
                                <th scope="col" style="display:none">Specialization</th>
                                <th scope="col" style="width: 100px">View/Edit</th>
                                <th scope="col" style="width: 140px">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            ';
                if (isset($users)) {
                    foreach ($users as $user) {
                        echo
                        '<tr>' .
                            '<td scope="row">' . $user['Emp_ID'] . '</td>' .
                            '<td class="firstName">' . $user['First_Name'] . ' ' . $user['Last_Name'] . '</td>' .
                            '<td>' . $user['username'] . '</td>' .
                            '<td style="border-right:none;"><input type="password" value="' . $user['password'] . '" style="border:none;" id="password" readonly></td>' .
                            '<td style="border-left:none;"><i toggle="#password-field" class="bi bi-eye-slash-fill float-end toggle-password"></i></td>' .
                            //'<td><div class="d-inline-block align-middle accPassword" id="password">' . $acc['password'] . '</div><i class="bi bi-eye-slash-fill float-end" id="toggle-password"></i></td>' .
                            '<td>' . $user['NRIC_PNum'] .
                            '<td style=display:none>' . $user['Gender'] . '</td>' .
                            '<td>' . $user['Birth_Date'] . '</td>' .
                            '<td style=display:none>' . $user['Address'] . '</td>' .
                            '<td>' . $user['Phone_Num'] . '</td>' .
                            '<td>' . $user['Email'] . '</td>' .
                            '<td>' . $user['Role'] . '</td>' .
                            '<td style=display:none>' . $user['Specialization'] . '</td>' .
                            '<td><button type="button" class="btn btn-secondary editBtn" data-bs-toggle="modal" data-bs-target="#editAcc">Edit <i class="bi bi-pencil-square"></i></button></td>' .
                            '<td><button type="button" class="btn btn-danger deleteBtn" data-bs-toggle="modal" data-bs-target="#deleteAcc">Delete <i class="bi bi-trash"></i></button></td>' .
                            '</tr>';
                    }
                    echo
                    '</tbody>
                    </table>
                    ';
                } else {
                    echo
                    '<tr>' .
                        '<td class="text-center" colspan="11"><b>No accounts has been created.</b></td>' .
                        '</tr>';
                    echo
                    '</tbody>
                        </table>
                        ';
                }
                echo
                '
                <script>
                document.querySelector(\'#ca-searchStaffAcc\').addEventListener(\'keyup\', searchFunction, false);
                </script>
                ';
            }

            // Receptionist button
            if (isset($_POST["recepBtn"])) {

                // Receptionist Patient profile table
                echo
                '
                <div class="row g-3">
                    <h2><u>Patient Profiles</u></h2>
                    <div class="col-6 mb-3">
                        <h5 class="d-inline-block align-middle">Search <i class=\'bi bi-search\'></i></h5>
                        <input class="search" type="text" id="recept-searchPatientProfile" placeholder="Search...">
                    </div>
                    <!-- <div class="col-6 mb-3">
                        <button class="btn btn-primary float-end" type="submit" name="logout" onclick="location.href = \'CreatePatientProfile.php\';">Create New Patient Profile <i class="bi bi-plus-square"></i></button>
                    </div> -->
                </div>
                <table class="table table-hover ps-1" id="recept-patientProfileTable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 100px">Patient ID</th>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 400px">Email</th>
                            <th scope="col" style="width: 180px">NRIC/Passport No.</th>
                            <th scope="col" style="width: 100px">Gender</th>
                            <th scope="col" style="width: 180px">Phone Number</th>
                            <th scope="col">Address</th>
                            <!-- <th scope="col" style="width: 180px">Family ID</th> -->
                            <th scope="col" style="width: 180px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                if (isset($recept_patients_profile)) {
                    foreach ($recept_patients_profile as $patients) {
                        echo
                        '<tr>' .
                            '<td scope="row">' . $patients['Patient_ID'] . '</td>' .
                            '<td>' . $patients['First_Name'] . ' ' . $patients['Last_Name'] . '</td>' .
                            '<td>' . $patients['Email'] . '</td>' .
                            '<td>' . $patients['NRIC_PNum'] . '</td>' .
                            '<td>' . $patients['Gender'] . '</td>' .
                            '<td>' . $patients['Phone_Num'] . '</td>' .
                            '<td>' . $patients['Address'] . '</td>' .
                            //'<td>' . $patients['Family_ID'] . '</td>' .
                            '<td><button type="button" class="btn btn-secondary editViewPatientProfileBtn">View/Edit <i class="bi bi-pencil-square"></i></button></td>' .
                            '</tr>';
                    }
                    echo
                    '</tbody>
                    </table>
                    ';
                } else {
                    echo
                    '<tr>' .
                        '<td class="text-center" colspan="8"><b>No patient profiles.</b></td>' .
                        '</tr>';
                    echo
                    '</tbody>
                    </table>
                    ';
                }

                // Receptionist Patient Treatment Records
                echo
                '
                <div class="row g-3">
                    <h2><u>Patient Treatment Records</u></h2>
                    <div class="col-6 mb-3">
                        <h5 class="d-inline-block align-middle">Search <i class=\'bi bi-search\'></i></h5>
                        <input class="search" type="text" id="recept-searchTreatmentRecord" placeholder="Search...">
                    </div>
                </div>
                <table class="table table-hover ps-1" id="recept-treatmentRecordTable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 100px">Record ID</th>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 110px">NRIC/Passport No.</th>
                            <!-- <th scope="col" style="display:none">Phone Number</th> -->
                            <!-- <th scope="col">Date of Birth</th> -->
                            <th scope="col" style="width: 110px">Date of Visit</th>
                            <th scope="col">Type of service</th>
                            <th scope="col" style="display:none">Treatment Description</th>
                            <th scope="col" style="display:none">Materials used</th>
                            <th scope="col" style="display:none">Dentist/Assistants 1</th>
                            <th scope="col" style="display:none">Dentist/Assistants 2</th>
                            <th scope="col" style="width: 100px">View</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                if (isset($recept_patient_records)) {
                    foreach ($recept_patient_records as $record) {
                        echo
                        '<tr>' .
                            '<td scope="row">' . $record['Record_ID'] . '</td>' .
                            '<td>' . $record['First_Name'] . ' ' . $record['Last_Name'] . '</td>' .
                            '<td>' . $record['NRIC_PNum'] . '</td>' .
                            // '<td style="display:none">' . $record['Phone_Num'] . '</td>' .
                            //'<td>' . date('d-m-Y', strtotime($record['Birth_Date'])) . '</td>' .
                            '<td>' . date('d-m-Y', strtotime($record['Treatment_Date'])) . '</td>' .
                            '<td>' . $record['Treatment_Type'] . '</td>' .
                            '<td style="display:none">' . $record['Treatment_details'] . '</td>' .
                            '<td style="display:none">' . $record['Material_used'] . '</td>' .
                            '<td style="display:none">' . $record['Doctor/Assistant 1'] . '</td>' .
                            '<td style="display:none">' . $record['Doctor/Assistant 2'] . '</td>' .
                            '<td><button type="button" class="btn btn-secondary viewPatRecBtn" data-bs-toggle="modal" data-bs-target="#recept_viewPatRec">View  <i class="bi bi-eye"></i></button></td>' .
                            '</tr>';
                    }
                    echo
                    '</tbody>
                    </table>
                    ';
                } else {
                    echo
                    '<tr>' .
                        '<td class="text-center" colspan="9"><b>No patient records.</b></td>' .
                        '</tr>';
                    echo
                    '</tbody>
                    </table>
                    ';
                }
                // Receptionist Schedule Table
                echo
                '
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
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
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
                    echo
                    '</tbody>
                    </table>
                    ';
                } else {
                    echo
                    '<tr>' .
                        '<td class="text-center" colspan="11"><b>No available schedule for the month.</b></td>' .
                        '</tr>';
                    echo
                    '</tbody>
                    </table>
                    ';
                }
                // Receptionist Product table
                echo
                '
                <div class="row g-3">
                    <div class="col-4">
                        <h2><u>Remaining stocks</u></h2>
                    </div>
                    <div class="col-8">
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addProduct">Add new product <i class="bi bi-plus-square"></i></button>
                    </div>
                </div>
                <table class="table table-hover ps-1">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="display:none">Product ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Quantity Left</th>
                            <th scope="col" style="width: 120px;">Edit</th>
                            <th scope="col" style="width: 120px;">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                ';

                if (isset($products_list)) {
                    foreach ($products_list as $product) {
                        echo
                        '<tr>' .
                            '<td style=display:none>' . $product['product_id'] . '</td>' .
                            '<td>' . $product['product_name'] . '</td>' .
                            '<td>' . "$" . $product['product_price'] . '</td>' .
                            '<td>' . $product['quantity'] . '</td>' .
                            '<td><button type="button" class="btn btn-secondary editProductBtn" data-bs-toggle="modal" data-bs-target="#editProduct"> Edit <i class="bi bi-pencil-square"></i></button></td>' .
                            '<td><button type="button" class="btn btn-danger delProductBtn" data-bs-toggle="modal" data-bs-target="#deleteProduct">Delete <i class="bi bi-trash"></i></button></td>' .

                            '</tr>';
                    }
                    echo
                    '</tbody>
                    </table>
                    ';
                } else {
                    echo
                    '<tr>' .
                        '<td class="text-center" colspan="6"><b>No products in inventory.</b></td>' .
                        '</tr>';
                    echo
                    '</tbody>
                    </table>
                    ';
                }

                // Receptionist Invoice table
                echo
                '
                <div class="row g-3">
                    <div class="col-4">
                        <h2><u>Invoice lists</u></h2>
                    </div>
                    <div class="col-8">
                        <button class="btn btn-primary float-end" type="submit" onclick="location.href = \'create_invoice.php\';">Issue invoice</button>
                    </div>
                </div>
                <table class="table table-hover ps-1">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 100px">Invoice No.</th>
                            <th scope="col" style="width: 200px">Create Date</th>
                            <th scope="col" style="width: 200px">Customer Name</th>
                            <th scope="col" style="width: 100px">Invoice Total</th>
                            <th scope="col" style="width: 50px">Print</th>
                            <th scope="col" style="width: 50px">View</th>
                            <th scope="col" style="width: 50px">Send</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                $invoiceList = $invoice->getInvoiceList($companyName);
                if (isset($invoiceList) && !empty($invoiceList)) {
                    foreach ($invoiceList as $invoiceDetails) {
                        $invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["order_date"]));
                        echo
                        '<tr>' .
                            '<td>' . $invoiceDetails['order_id'] . '</td>' .
                            '<td>' . $invoiceDate . '</td>' .
                            '<td>' . $invoiceDetails['order_receiver_name'] . '</td>' .
                            '<td>' . $invoiceDetails['order_total_after_tax'] . '</td>' .
                            '<td><a href="print_invoice.php?invoice_id=' . $invoiceDetails["order_id"] . '" target="_blank" title="Print Invoice"><span class="bi bi-printer"></span></a></td>' .
                            '<td><a href="edit_invoice.php?update_id=' . $invoiceDetails["order_id"] . '"  title="Edit Invoice"><span class="bi bi-pencil-square"></span></a></td>' .
                            '<td><a href="send_invoice.php?invoice_id=' . $invoiceDetails["order_id"] . '"  title="Send Invoice"><span class="bi bi-envelope"></span></a></td>' .
                            '</tr>';
                    }
                    echo
                    '</tbody>
                    </table>
                    ';
                } else {
                    echo
                    '<tr>' .
                        '<td class="text-center" colspan="6"><b>No invoice found.</b></td>' .
                        '</tr>';
                    echo
                    '</tbody>
                    </table>
                    ';
                }
                echo
                '
                <script>
                document.querySelector(\'#recept-searchPatientProfile\').addEventListener(\'keyup\', searchFunction, false);
                document.querySelector(\'#recept-searchTreatmentRecord\').addEventListener(\'keyup\', searchFunction, false);
                </script>
                ';
            }

            // Dental Assistant button
            if (isset($_POST["dentalAssistBtn"])) {
                //$_SESSION['Company'] = $_GET['Company'];

                echo
                '
                <div class="row g-3">
                    <h2><u>Patient Profiles</u></h2>
                    <div class="col-6 mb-3">
                        <h5 class="d-inline-block align-middle">Search <i class=\'bi bi-search\'></i></h5>
                        <input class="search" type="text" id="da-searchPatientProfile" placeholder="Search...">
                    </div>
                </div>
                <table class="table table-hover ps-1" id="da-patientProfileTable">
                    <thead class="table-dark">
                        <tr>
                            <!-- <th scope="col">Patient ID</th> -->
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
                            <!-- <th scope="col">Family ID</th> -->
                            <!-- <th scope="col" style="display:none">Treatment Details</th>
                            <th scope="col" style="display:none">Materials used</th>
                            <th scope="col" style="display:none">Dentists involved</th>
                            <th scope="col" style="display:none">Assistants involved</th> -->
                            <!-- <th scope="col" style="width: 100px">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                ';
                if (isset($da_patients_profile)) {
                    foreach ($da_patients_profile as $patients) {
                        echo
                        '<tr>' .
                            '<td>' . $patients['First_Name'] . ' ' . $patients['Last_Name'] . '</td>' .
                            '<td>' . $patients['NRIC_PNum'] . '</td>' .
                            '<td>' . $patients['Gender'] . '</td>' .
                            '<td>' . $patients['Phone_Num'] . '</td>' .
                            '<td>' . $patients['Smoker'] . '</td>';
                        if (!empty($patients['Allergies'])) {
                            echo '<td>' . $patients['Allergies'] . '</td>';
                        } else {
                            echo '<td>NA.</td>';
                        }
                        if (!empty($patients['Long_term_med'])) {
                            echo '<td>' . $patients['Long_term_med'] . '</td>';
                        } else {
                            echo '<td>NA.</td>';
                        }
                        if (!empty($patients['Existing_Med_Conds'])) {
                            echo '<td>' . $patients['Existing_Med_Conds'] . '</td>';
                        } else {
                            echo '<td>NA.</td>';
                        }
                        echo
                        '<td>' . $patients['Emer_Name'] . '</td>' .
                            '<td>' . $patients['Emer_Contact'] . '</td>' .
                            '<td>' . $patients['Emer_relation'] . '</td>' .
                            '</tr>';
                    }
                    echo
                    '</tbody>
                    </table>
                    ';
                } else {
                    echo
                    '<tr>' .
                        '<td class="text-center" colspan="9"><b>No patient profiles.</b></td>' .
                        '</tr>';
                    echo
                    '</tbody>
                    </table>
                    ';
                }
                echo
                '
                <div class="row g-3">
                    <h2><u>Patient Treatment Records</u></h2>
                    <div class="col-6 mb-3">
                        <h5 class="d-inline-block align-middle">Search <i class=\'bi bi-search\'></i></h5>
                        <input class="search" type="text" id="da-searchTreatmentRecord" placeholder="Search...">
                    </div>
                </div>
                <table class="table table-hover ps-1" id="da-treatmentRecordTable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 100px">Record ID</th>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 110px">NRIC</th>
                            <th scope="col" style="width: 110px">Date of Visit</th>
                            <th scope="col">Type of service</th>
                            <th scope="col" style="display:none">Treatment Description</th>
                            <th scope="col" style="display:none">Materials used</th>
                            <th scope="col" style="display:none">Dentist/Assistants 1</th>
                            <th scope="col" style="display:none">Dentist/Assistants 2</th>
                            <th scope="col" style="width: 100px">View</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                if (isset($da_patient_records)) {
                    foreach ($da_patient_records as $record) {
                        echo
                        '<tr>' .
                            '<th scope="row">' . $record['Record_ID'] . '</th>' .
                            '<td>' . $record['First_Name'] . ' ' . $record['Last_Name'] . '</td>' .
                            '<td>' . $record['NRIC_PNum'] . '</td>' .
                            '<td>' . date('d-m-Y', strtotime($record['Treatment_Date'])) . '</td>' .
                            '<td>' . $record['Treatment_Type'] . '</td>' .
                            '<td style="display:none">' . $record['Treatment_details'] . '</td>' .
                            '<td style="display:none">' . $record['Material_used'] . '</td>' .
                            '<td style="display:none">' . $record['Doctor/Assistant 1'] . '</td>' .
                            '<td style="display:none">' . $record['Doctor/Assistant 2'] . '</td>' .
                            '<td><button type="button" class="btn btn-secondary viewRecBtn" data-bs-toggle="modal" data-bs-target="#viewAcc">View  <i class="bi bi-eye"></i></button></td>' .
                            '</tr>';
                    }
                    echo
                    '</tbody>
                    </table>
                    ';
                } else {
                    echo
                    '<tr>' .
                        '<td class="text-center" colspan="11"><b>No patient records.</b></td>' .
                        '</tr>';
                    echo
                    '</tbody>
                    </table>
                    ';
                }
                echo
                '
                <script>
                document.querySelector(\'#da-searchPatientProfile\').addEventListener(\'keyup\', searchFunction, false);
                document.querySelector(\'#da-searchTreatmentRecord\').addEventListener(\'keyup\', searchFunction, false);
                </script>
                ';
            }

            // Dentist button
            if (isset($_POST["dentistBtn"])) {
                // $path = "SuperAdmin";
                //$_SESSION['Company'] = $_GET['Company'];
                // $company = $_SESSION['Company'];
                if (isset($_SESSION['dentistpatientrecords'])) {
                    $dentist_patient_records = $_SESSION['dentistpatientrecords'];
                }
                echo
                '
                <div class="row g-3">
                    <h2><u>Patient Profiles</u></h2>
                    <div class="col-6 mb-3">
                        <h5 class="d-inline-block align-middle">Search <i class=\'bi bi-search\'></i></h5>
                        <input class="search" type="text" id="dentist-searchPatientProfile" placeholder="Search...">
                    </div>
                </div>
                <table class="table table-hover ps-1" id="dentist-patientProfileTable">
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
                            <th scope="col" style="width: 120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
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
                            '<td><button type="button" class="btn btn-success createBtn" data-bs-toggle="modal" data-bs-target="#createBtn">Create <i class="bi bi-file-earmark-plus"></i></button></td>' .
                            '</tr>';
                    }
                    echo
                    '</tbody>
                    </table>
                    ';
                } else {
                    echo
                    '<tr>' .
                        '<td colspan="6" style="text-align:center"><b>No patients profile.</b></td>' .
                        '</tr>';
                    echo
                    '</tbody>
                    </table>
                    ';
                }
                echo
                '
                <div class="row g-3">
                    <h2><u>Patient Treatment Records</u></h2>
                    <div class="col-6 mb-3">
                        <h5 class="d-inline-block align-middle">Search <i class=\'bi bi-search\'></i></h5>
                        <input class="search" type="text" id="dentist-searchTreatmentRecord" placeholder="Search...">
                    </div>
                </div>
                <table class="table table-hover ps-1" id="dentist-treatmentRecordTable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 100px">Record ID</th>
                            <th scope="col" style="width: 100px">Patient ID</th>
                            <th scope="col">Name of Patient</th>
                            <th scope="col">Date of treatment</th>
                            <th scope="col">Type of service</th>
                            <th scope="col">Description</th>
                            <th scope="col">Materials</th>
                            <th scope="col">Company</th>
                            <th scope="col" style="width: 180px">Dentist/Assistants 1</th>
                            <th scope="col" style="width: 180px">Dentist/Assistants 2</th>
                            <th scope="col" style="width: 160px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
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
                            '<td>' . $record['Company'] . '</td>' .
                            '<td>' . $record['Doctor/Assistant 1'] . '</td>' .
                            '<td>' . $record['Doctor/Assistant 2'] . '</td>' .
                            '<td style="display: none;">' . $record['Remarks'] . '</td>' .
                            '<td><button type="button" class="btn btn-secondary editBtn" data-bs-toggle="modal" data-bs-target="#editRecordsModal">View/Edit <i class="bi bi-pencil-square"></i></button></td>' .
                            '</tr>';
                    }
                    echo
                    '</tbody>
                    </table>
                    ';
                    //<form method="POST"><button type="submit" class="btn btn-secondary mt-2" name="allRecords">Back</button></form>
                } else {
                    echo
                    '<tr>
                        <td colspan="10" style="text-align:center"><b>No patient records.</b></td>
                        </tr>';
                    echo
                    '</tbody>
                    </table>
                    ';
                    //<form method="POST"><button type="submit" class="btn btn-secondary mt-2" name="allRecords">Back</button></form>
                }
                if (isset($_SESSION['dentistpatientrecords'])) {
                    echo '<form method="POST"><button type="submit" class="btn btn-secondary mt-2" name="allRecords">Show all records</button></form>';
                }
                echo
                '
                <script>
                document.querySelector(\'#dentist-searchPatientProfile\').addEventListener(\'keyup\', searchFunction, false);
                document.querySelector(\'#dentist-searchTreatmentRecord\').addEventListener(\'keyup\', searchFunction, false);
                </script>
                ';
            }
            ?>
        </div>
    </div>
    <!-- Edit Clinic Modal -->
    <div class="modal fade" id="editClinic" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Clinic details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" method="POST" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Clinic Name</label>
                            <input type="text" class="form-control" name="clinicName" id="clinicName" required>
                            <div class="invalid-feedback">
                                Please enter clinic name.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Clinic UEN No.</label>
                            <input type="text" class="form-control" name="clinicUEN" id="clinicUEN" required>
                            <div class="invalid-feedback">
                                Please enter clinic UEN.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Clinic Contact Number</label>
                            <input type="text" class="form-control" name="clinicContact" id="clinicContact" pattern="[689]{1}[0-9]{7}" required>
                            <div class="invalid-feedback">
                                Please enter a valid singapore mobile number.
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-outline mb-3">
                                <label class="form-label">Clinic Address</label>
                                <textarea class="form-control" rows="5" name="clinicAddress" id="clinicAddress" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter clinic address.
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Clinic Specialization</label>
                            <input type="text" class="form-control" name="clinicSpecialization" id="clinicSpecialization" required>
                            <div class="invalid-feedback">
                                Please enter clinic specialization.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="clinicUsername" id="clinicUsername" required>
                            <div class="invalid-feedback">
                                Please enter username.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="clinicPassword" id="clinicPassword" required>
                            <div class="invalid-feedback">
                                Please enter password.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="clinic_applicant_FN" id="clinic_applicant_FN" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
                            <div class="invalid-feedback">
                                Please enter first name.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="clinic_applicant_LN" id="clinic_applicant_LN" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
                            <div class="invalid-feedback">
                                Please enter last name.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="clinic_applicant_contact" id="clinic_applicant_contact" pattern="[8-9]{1}[0-9]{7}" required>
                            <div class="invalid-feedback">
                                Please enter a valid singapore mobile number.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="clinic_applicant_email" id="clinic_applicant_email" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-outline mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" rows="5" name="clinic_applicant_address" id="clinic_applicant_address" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter your address.
                                </div>
                            </div>
                        </div>
                        <!-- <button type="submit" class="btn btn-danger float-start" name="ca_deleteBtn">Delete Account</button> -->
                        <button type="submit" class="btn btn-primary float-end" name="editClinic">Update Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
            <?php unset($_SESSION['alert']); ?>
        }, 3000);
    });
    $('.editClinic').click(function() {

        $clinicName = $(this).closest('tr').find('td:nth-child(1)').text().trim();
        $clinicUEN = $(this).closest('tr').find('td:nth-child(2)').text().trim();
        $clinicContact = $(this).closest('tr').find('td:nth-child(3)').text().trim();
        $clinicAdd = $(this).closest('tr').find('td:nth-child(4)').text().trim();
        $clinicSpecial = $(this).closest('tr').find('td:nth-child(5)').text().trim();
        $username = $(this).closest('tr').find('td:nth-child(6)').text().trim();
        $password = $(this).closest('tr').find("td input[type='password']").val();
        $applicantName = $(this).closest('tr').find('td:nth-child(9)').text().trim();
        $applicantContact = $(this).closest('tr').find('td:nth-child(10)').text().trim();
        $applicantEmail = $(this).closest('tr').find('td:nth-child(11)').text().trim();
        $applicantAddress = $(this).closest('tr').find('td:nth-child(12)').text().trim();
        $splitName = $applicantName.split(/(?<=^\S+)\s/);
        $first = $splitName[0];
        $last = $splitName[1];
        $('#clinicName').val($clinicName);
        $('#clinicUEN').val($clinicUEN);
        $('#clinicContact').val($clinicContact);
        $('#clinicAddress').val($clinicAdd);
        $('#clinicSpecialization').val($clinicSpecial);
        $('#clinicUsername').val($username);
        $('#clinicPassword').val($password);
        $('#clinic_applicant_FN').val($first);
        $('#clinic_applicant_LN').val($last);
        $('#clinic_applicant_contact').val($applicantContact);
        $('#clinic_applicant_email').val($applicantEmail);
        $('#clinic_applicant_address').val($applicantAddress);

    });
    $(".toggle-password").on('mousedown', function() {
        var self = $(this).closest("tr").find("td input[type='password']").val();
        $(this).removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
        $(this).closest("tr").find("td input[type='password']").attr('type', 'text');
        //$(this).toggleClass("bi-eye-fill bi-eye-slash-fill");
    }).on('mouseup', function() {
        var self = $(this).closest("tr").find("td input[type='password']").val();
        $(this).removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
        $(this).closest("tr").find("td input[type='text']").attr('type', 'password');
        //$(this).toggleClass("bi-eye-fill bi-eye-slash-fill");
    });

    function showDiv(divId, element) {
        document.getElementById(divId).style.display = element.value == 'Dentist' ? 'block' : 'none';
    }
    var checkPattern = function() {
        if ($('#edit_role').val() == 'Dentist') {
            $('#edit_special').show();
        } else $('#edit_special').hide();
    }

    function refreshPage() {
        window.location.reload();
    }
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })();
</script>

</html>