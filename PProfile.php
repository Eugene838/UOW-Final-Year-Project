<?php
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'PNavBar.php';
include 'Patient.php';
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
    <div id="content-wrapper" class="w-100 p-3 content-wrapper">

        <?php
        if (isset($_SESSION['alert'])) {
            echo $_SESSION['alert'];
        }

        if (isset($patientInfo)) {
            foreach ($patientInfo as $patient) {
                echo
                '
                <h1><b><u>My Information</u></b></h1>
                    <div class="row g-3 pt-3">
                        <div class="col-2">
                            <label for="FName" class="form-label">First Name</label>
                            <input type="text" readonly class="form-control" id="FName" value=" ' . $patient['First_Name'] . '">
                        </div>
                        <div class="col-2">
                            <label for="LName" class="form-label">Last Name</label>
                            <input type="text" readonly class="form-control" id="LName" value=" ' . $patient['Last_Name'] . '">
                        </div>
                    </div>
                    <div class="row g-3 pt-3">
                        <div class="col-2">
                            <label for="NRIC" class="form-label">NRIC</label>
                            <input type="text" readonly class="form-control" id="NRIC" value=" ' . $patient['NRIC_PNum'] . '">
                        </div>
                        <div class="col-2">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" readonly class="form-control" name="Date" id="Date" value="' . date('Y-m-d', strtotime($patient['Birth_Date'])) . '">
                        </div>
                    </div>
                    <div class="row g-3 pt-3">
                        <div class="col-2">
                            <label for="Nationality" class="form-label">Nationality</label>
                            <input type="text" readonly class="form-control" id="Nationality" value=" ' . $patient['Nationality'] . '">
                        </div>
                        <div class="col-2">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" readonly class="form-control" Name="Email" id="Email" value=" ' . $patient['Email'] . '">
                        </div>
                    </div>
                    <div class="row g-3 pt-3">
                        <div class="col-2">
                            <label for="PNum" class="form-label">Phone number</label>
                            <input type="text" readonly class="form-control" name="PNum" id="PNum" value=" ' . $patient['Phone_Num'] . '">
                        </div>
                        <div class="col-2">
                            <label for="PNum" class="form-label">Postal Code</label>
                            <input type="text" readonly class="form-control" name="PostalCode" id="PostalCode" value=" ' . $patient['postal_code'] . '">
                        </div>
                    </div>
                    <div class="row g-3 pt-3">
                        <div class="col-4">
                            <label class="form-label">Address</label>
                            <textarea readonly class="form-control" name="Address" id="Address" rows="4">' . $patient['Address'] . '</textarea>
                        </div>
                    </div>
                ';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert-msg">Error! Please try again <i class="bi bi-person-check"></i></div>';
        }
        ?>
        <div class="d-grid col-4 pt-3">
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal">Edit</button>
        </div>
    </div>
    <!-- Update Patient Info Modal -->
    <div class="modal fade" id="updateProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Your Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" method="POST" novalidate>
                    <div class="modal-body row">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="FName" id="FName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+[\'-]?)+$" value="<?php echo $patientInfo[0]['First_Name']; ?>" required>
                                <div class="invalid-feedback">
                                    Please enter first name.
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="LName" id="LName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+[\'-]?)+$" value="<?php echo $patientInfo[0]['Last_Name']; ?>" required>
                                <div class="invalid-feedback">
                                    Please enter last name.
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">NRIC</label>
                                <input type="text" readonly class="form-control" id="NRIC" value="<?php echo $patientInfo[0]['NRIC_PNum']; ?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Birth date</label>
                                <input type="date" readonly class="form-control" name="Date" id="Date" value="<?php echo date('Y-m-d', strtotime($patientInfo[0]['Birth_Date'])); ?>">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <input type="email" class="form-control" Name="Email" id="Email" value="<?php echo $patientInfo[0]['Email']; ?>" required>
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Phone number</label>
                                <input type="text" class="form-control" name="PNum" id="PNum" pattern="[8-9]{1}[0-9]{7}" value="<?php echo $patientInfo[0]['Phone_Num']; ?>" required>
                                <div class="invalid-feedback">
                                    Please enter a valid singapore mobile number.
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="Address" id="Address" required><?php echo $patientInfo[0]['Address']; ?></textarea>
                                <div class="invalid-feedback">
                                    Please enter a valid residential address.
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Postal Code</label>
                                <input type="text" class="form-control" name="PostalCode" id="PostalCode" pattern="[0-9]{6}" value="<?php echo $patientInfo[0]['postal_code']; ?>" required>
                                <div class="invalid-feedback">
                                    Please enter valid postal code.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-lg btn-primary" name="update">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
            <?php unset($_SESSION['alert']); ?>
        }, 3500);
    });

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