<?php
ob_start();
include 'db_connection.php';
include 'Navbar.php';

if (!isset($_SESSION['Role']) && empty($_SESSION['Role'])) {
    header("Location: index.php");
} else {
    $db = new DB_Connect();
}
?>

<html>

<head>
    <title> Manage Clinics Page </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    </style>
</head>

<body>
    <div id="content-wrapper" class="content-wrapper">
        <div class="w-100 p-3">
            <div class="container-fluid mb-3">
                <?php
                // if (isset($alertMsg)) {
                //     echo $alertMsg;
                // }
                ?>
                <h2><u>List of Active Clinics</u></h2>
                <?php include "Search.php";?>
                <table class="table" id="searchTable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Clinic Name</th>
							<th scope="col">Clinic UEN No.</th>
							<th scope="col" style="width: 200px">Clinic Contact Number</th>
							<th scope="col">Clinic Address</th>
							<th scope="col">Clinic Specialization</th>
							<th scope="col" style="width: 200px">Applicant Name</th>
							<th scope="col" style="width: 150px">Applicant Contact Number</th>
							<th scope="col" style="width: 400px">Email</th>
							<th scope="col" style="width: 100px">Status</th>
                            <th scope="col" style="width: 130px">Actions</th>
                        </tr>
                    </thead>
                    <?php
                    $stmt2 = $db->connectWix()->prepare("SELECT * FROM `wixClients` where `status`='Active'");
                    $stmt2->execute();

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
                                '<td>' . $acc['first_name'] . ' ' . $acc['last_name'] . '</td>' .
                                '<td>' . $acc['contact_number'] . '</td>' .
                                '<td>' . $acc['email'] . '</td>' .
                                '<td><span class="badge bg-success">' . $acc['status'] . '</span></td>' .
                                '<td><button type="button" class="btn btn-primary manageBtn">Manage <i class="bi bi-server"></i></button></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td class="text-center" colspan="11"><b>No active subscriptions.</b></td>' .
                            '</tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    $('.manageBtn').click(function() {
        $companyName = $(this).closest('tr').find('td:nth-child(1)').text();
        window.location = 'Company.php?Company=' + $companyName;
    });

    // function showDiv(divId, element) {
    //     document.getElementById(divId).style.display = element.value == 'Dentist' ? 'block' : 'none';
    // }
    // var checkPattern = function() {
    //     if ($('#edit_role').val() == 'Dentist') {
    //         $('#edit_special').show();
    //     } else $('#edit_special').hide();
    // }

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