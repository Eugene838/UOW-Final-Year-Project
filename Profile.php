<?php
ob_start();
include 'db_connection.php';
include 'Navbar.php';
if (!isset($_SESSION['Role']) && empty($_SESSION['Role'])) {
    header("Location: index.php");
} else {
    $name = $_SESSION['Name'];
    $id = $_SESSION['Emp_ID'];
    $db = new DB_Connect();
}

if (isset($_POST["updateBtn"])) {
    // echo "here";
    $fname = $_POST['FName'];
    $lname = $_POST['LName'];
    $Email = $_POST['Email'];
    $PNum = $_POST['PNum'];
    $Address = $_POST['Address'];

    $stmt = $db->connectWix()->prepare("UPDATE `wixClients` set `first_name` = '$fname', `last_name` = '$lname',`email` = '$Email', `contact_number` = '$PNum', `address` = '$Address' where `Emp_ID` = $id");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Your information has been successfully updated! <i class="bi bi-person-check"></i></div>';
    } else {
        $stmt = $db->connect()->prepare("UPDATE `user_table` set `First_Name` = '$fname', `Last_Name` = '$lname', `Email` = '$Email', `Phone_Num` = 
        '$PNum', `Address` = '$Address' where `Emp_ID` = $id");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Your information has been successfully updated! <i class="bi bi-person-check"></i></div>';
        } else {
            $_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error! Please try again <i class="bi bi-person-check"></i></div>';
        }
    }
}
?>

<html>

<head>
    <title>Your Profile</title>
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
        $stmt = $db->connect()->prepare("SELECT * FROM user_table where `Emp_ID` = $id");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $empProfile = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $db->connectWix()->prepare("SELECT * FROM wixClients where `Emp_ID` = $id");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $caProfile = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo "<span class='d-block p-2 bg-danger text-white text-center'>Error!</span>";
            }
        }
        if (isset($empProfile)) {
            foreach ($empProfile as $profile) {
                echo
                '
                <h1><b>My Information</b></h1>
                <div class="row g-3 pt-3">
                    <div class="col-2">
                        <label class="form-label">First Name</label>
                        <input type="text" readonly class="form-control" id="FName" value="' . $profile['First_Name'] . '">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Last Name</label>
                        <input type="text" readonly class="form-control" id="LName" value="' . $profile['Last_Name'] . '">
                    </div>
                </div>
                <div class="row g-3 pt-3">
                    <div class="col-2">
                        <label class="form-label">NRIC</label>
                        <input type="text" readonly class="form-control" id="NRIC" value="' . $profile['NRIC_PNum'] . '">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Birth date</label>
                        <input type="date" readonly class="form-control" name="Date" id="Date" value="' . $profile['Birth_Date'] . '">
                    </div>
                </div>
                <div class="row g-3 pt-3">
                    <div class="col-2">
                        <label for="inputEmail4" class="form-label">Email</label>
                        <input type="email" readonly class="form-control" Name="Email" id="Email" value="' . $profile['Email'] . '">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Phone number</label>
                        <input type="text" readonly class="form-control" name="PNum" id="PNum" value="' . $profile['Phone_Num'] . '">
                    </div>
                </div>
                <div class="row g-3 pt-3">
                    <div class="col-4">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" readonly name="Address" id="Address">' . $profile['Address'] . '</textarea>
                    </div>
                </div>
                ';
            }
            echo
            '
            <div class="d-grid col-4 pt-3">
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal">Edit</button>
            </div>
            ';

            echo
            '
            <!-- Update Profile Modal -->
            <div class="modal fade" id="updateProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Update My Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="needs-validation" method="POST" novalidate>
                            <div class="modal-body row">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="FName" id="FName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+[\'-]?)+$" value="' . $empProfile[0]['First_Name'] . '" required>
                                        <div class="invalid-feedback">
                                            Please enter first name.
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="LName" id="LName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+[\'-]?)+$" value="' . $empProfile[0]['Last_Name'] . '" required>
                                        <div class="invalid-feedback">
                                            Please enter last name.
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label">NRIC</label>
                                        <input type="text" readonly class="form-control" id="NRIC" pattern="[A-Za-z][0-9]{7}[A-Za-z]" value="' . $empProfile[0]['NRIC_PNum'] . '" required>
                                        <div class="invalid-feedback">
                                            Please enter a valid NRIC/Passport No.
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" readonly class="form-control" name="Date" id="Date" value="' . $empProfile[0]['Birth_Date'] . '" required>
                                        <div class="invalid-feedback">
                                            Please select a date.
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label for="inputEmail4" class="form-label">Email</label>
                                        <input type="email" class="form-control" Name="Email" id="Email" value="' . $empProfile[0]['Email'] . '" required>
                                        <div class="invalid-feedback">
                                            Please enter a valid email address.
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Phone number</label>
                                        <input type="text" class="form-control" name="PNum" id="PNum" pattern="[8-9]{1}[0-9]{7}" value="' . $empProfile[0]['Phone_Num'] . '" required>
                                        <div class="invalid-feedback">
                                            Please enter a valid singapore mobile number.
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="Address" id="Address" required>' . $empProfile[0]['Address'] . '</textarea>
                                        <div class="invalid-feedback">
                                            Please enter a residential address.
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
        } else if (isset($caProfile)) {
            foreach ($caProfile as $profile) {
                echo
                '
                <h1><b>My Information</b></h1>
                <div class="row g-3 pt-3">
                    <div class="col-2">
                        <label class="form-label">First Name</label>
                        <input type="text" readonly class="form-control" name="FName" id="FName" value="' . $profile['first_name'] . '">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Last Name</label>
                        <input type="text" readonly class="form-control" name="LName" id="LName" value="' . $profile['last_name'] . '">
                    </div>
                </div>
                <div class="row g-3 pt-3">
                    <div class="col-2">
                        <label class="form-label">NRIC</label>
                        <input type="text" readonly class="form-control" id="NRIC" value="' . $profile['NRIC_PNum'] . '">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Birth date</label>
                        <input type="date" readonly class="form-control" name="Date" id="Date" value="' . $profile['Birth_Date'] . '">
                    </div>
                </div>
                <div class="row g-3 pt-3">
                    <div class="col-2">
                        <label for="inputEmail4" class="form-label">Email</label>
                        <input type="email" readonly class="form-control" Name="Email" id="Email" value="' . $profile['email'] . '">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Phone number</label>
                        <input type="text" readonly class="form-control" name="PNum" id="PNum" value="' . $profile['contact_number'] . '">
                    </div>
                </div>
                <div class="row g-3 pt-3">
                    <div class="col-4">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" readonly name="Address" id="Address">' . $profile['address'] . '</textarea>
                    </div>
                </div>
                ';
            }
            echo
            '
            <div class="d-grid col-4 pt-3">
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal">Edit</button>
            </div>
            ';
            
            echo
            '
            <!-- Update Profile Modal -->
            <div class="modal fade" id="updateProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Update My Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="needs-validation" method="POST" novalidate>
                            <div class="modal-body row">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="FName" id="FName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+[\'-]?)+$" value="' . $caProfile[0]['first_name'] . '" required>
                                    <div class="invalid-feedback">
                                        Please enter first name.
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="LName" id="LName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+[\'-]?)+$" value="' . $caProfile[0]['last_name'] . '" required>
                                    <div class="invalid-feedback">
                                        Please enter last name.
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 pt-3">
                                <div class="col-6">
                                    <label class="form-label">NRIC</label>
                                    <input type="text" readonly class="form-control" id="NRIC" value="' . $caProfile[0]['NRIC_PNum'] . '">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Birth date</label>
                                    <input type="date" readonly class="form-control" name="Date" id="Date" value="' . $caProfile[0]['Birth_Date'] . '">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">Email</label>
                                    <input type="email" class="form-control" Name="Email" id="Email" value="' . $caProfile[0]['email'] . '" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid email address.
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Phone number</label>
                                    <input type="text" class="form-control" name="PNum" id="PNum" pattern="[8-9]{1}[0-9]{7}" value="' . $caProfile[0]['contact_number'] . '" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid singapore mobile number.
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="Address" id="Address" required>' . $caProfile[0]['address'] . '</textarea>
                                    <div class="invalid-feedback">
                                        Please enter a residential address.
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
        <!-- <div class="d-grid col-4 pt-3">
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal">Edit</button>
        </div> -->
    </div>
    <?php
    // if(isset($empProfile)) {
        
    // }
    // if (isset($caProfile)) {
        
    // }
    ?>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
            <?php unset($_SESSION['alert']);?>
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