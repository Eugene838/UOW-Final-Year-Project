<?php
ob_start();
include 'db_connection.php';
include 'Navbar.php';
if (!isset($_SESSION['Role']) && empty($_SESSION['Role'])) {
    header("Location: index.php");
} else {
    $name = $_SESSION['Name'];
    $company = $_SESSION['Company'];
    $db = new DB_Connect();
    $stmt = $db->connectWix()->prepare("SELECT `clinic_uen` FROM `wixClients` where `clinic_name` = ?");
    $stmt->execute([$company]);
    if ($stmt->rowCount() > 0) {
        $currentUEN = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error! Please try again <i class="bi bi-person-check"></i></div>';
    }
}

if (isset($_POST["updateBtn"])) {
    // echo "here";
    $clinicName = $_POST['clinicName'];
    $clinicUEN = $_POST['clinicUEN'];
    $clinicContact = $_POST['clinicContact'];
    $specialization = $_POST['Specialization'];
    $clinicAddress = $_POST['clinicAddress'];
    $clinicPostal = $_POST['clinicPostal'];

    $stmt = $db->connectWix()->prepare("UPDATE `wixClients` set `clinic_name` = ?, `clinic_contact` = ?,`clinic_specialization` = ?, `clinic_address` = ?, `postal_code` = ? where `clinic_uen` = ?");
    $stmt->execute([$clinicName,$clinicContact,$specialization,$clinicAddress,$clinicPostal,$clinicUEN]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Your information has been successfully updated! <i class="bi bi-person-check"></i></div>';
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error! Please try again <i class="bi bi-person-check"></i></div>';
    }
}
?>

<html>

<head>
    <title>Clinic Information</title>
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

        .bd-example {
            position: relative;
            padding: 1rem;
            margin: 1rem -5rem 0;

        }

        .bd-example {
            padding: 1.5rem;
            margin-right: 0;
            margin-left: 0;
            border-width: 5px;
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
    <div class="w-100 p-3 content-wrapper" id="content-wrapper">

        <?php
        if (isset($_SESSION['alert'])) {
            echo $_SESSION['alert'];
        }
        
        $db = new DB_Connect();
        $stmt = $db->connectWix()->prepare("SELECT * FROM wixClients where `clinic_uen` = ?");
        $stmt->execute([$currentUEN[0]['clinic_uen']]);

        if ($stmt->rowCount() > 0) {
            $caProfile = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "<span class='d-block p-2 bg-danger text-white text-center'>Error!</span>";
        }
        if (isset($caProfile)) {
            echo
            '
                <h1><b>Clinic\'s Information</b></h1>
                <div class="row g-3 pt-3">
                    <div class="col-2">
                        <label class="form-label">Clinic Name</label>
                        <input type="text" readonly class="form-control" name="clinicName" id="clinicName" value="' . $caProfile[0]['clinic_name'] . '">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Clinic UEN</label>
                        <input type="text" readonly class="form-control" name="clinicUEN" id="clinicUEN" value="' . $caProfile[0]['clinic_uen'] . '">
                    </div>
                </div>
                <div class="row g-3 pt-3">
                    <div class="col-2">
                        <label class="form-label">Clinic Contact Number</label>
                        <input type="text" readonly class="form-control" name="clinicContact" id="clinicContact" value="' . $caProfile[0]['clinic_contact'] . '">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Clinic Specialization</label>
                        <input type="text" readonly class="form-control" name="Specialization" id="Specialization" value="' . $caProfile[0]['clinic_specialization'] . '">
                    </div>
                </div>
                <div class="row g-3 pt-3">
                    <div class="col-2">
                        <label class="form-label">Clinic Address</label>
                        <textarea class="form-control" readonly name="clinicAddress" id="clinicAddress">' . $caProfile[0]['clinic_address'] . '</textarea>
                    </div>
                    <div class="col-2">
                        <label class="form-label">Postal Code</label>
                        <input type="text" readonly class="form-control" name="clinicPostal" id="clinicPostal" value="' . $caProfile[0]['postal_code'] . '">
                    </div>
                </div>
                ';
        }
        ?>
        <div class="d-grid col-4 pt-3">
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateClinicModal">Edit</button>
        </div>
    </div>
    <?php
    if (isset($caProfile)) {
        echo
        '
        <!-- Update Clinic Info Modal -->
        <div class="modal fade" id="updateClinicModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Clinic Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="needs-validation" method="POST" novalidate>
                        <div class="modal-body row">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label">Clinic Name</label>
                                    <input type="text" class="form-control" name="clinicName" id="clinicName" value="' . $caProfile[0]['clinic_name'] . '" required>
                                    <div class="invalid-feedback">
                                        Please enter clinic name.
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Clinic UEN</label>
                                    <input type="text" readonly class="form-control" name="clinicUEN" id="clinicUEN" value="' . $caProfile[0]['clinic_uen'] . '">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label">Clinic Contact Number</label>
                                    <input type="text" class="form-control" name="clinicContact" id="clinicContact" pattern="[689]{1}[0-9]{7}" value="' . $caProfile[0]['clinic_contact'] . '" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid singapore contact number.
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Clinic Specialization</label>
                                    <input type="text" class="form-control" name="Specialization" id="Specialization" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+[\'-]?)+$" value="' . $caProfile[0]['clinic_specialization'] . '" required>
                                    <div class="invalid-feedback">
                                        Please enter clinic specialization.
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="clinicAddress" id="clinicAddress" required>' . $caProfile[0]['clinic_address'] . '</textarea>
                                    <div class="invalid-feedback">
                                        Please enter clinic address.
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" name="clinicPostal" id="clinicPostal" pattern="[0-9]{6}" value="' . $caProfile[0]['postal_code'] . '" required>
                                    <div class="invalid-feedback">
                                        Please enter clinic postal code.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-lg btn-primary" name="updateBtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        ';
    }
    ?>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
            <?php unset($_SESSION['alert']); ?>
        }, 3500);
    });

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