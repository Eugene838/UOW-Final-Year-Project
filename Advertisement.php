<?php
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'Mail/mime.php';
include 'Mail/email.php';
include 'Navbar.php';
include 'Admin.php';
include 'Mail/PearsMail.php';
require "PHPMailer/Exception.php";
$db = new DB_Connect();

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';
?>
<?php
if (isset($_POST["send"])) {

    $ext = PHPMailer::mb_pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    //Define a safe location to move the uploaded file to, preserving the extension
    $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['file']['name'])) . '.' . $ext;
    $fileName = $_FILES['file']['name'];
    $stmt = $db->connectWix()->prepare("SELECT Email FROM wixPatients");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $send_mail = new Sendmail();
        $to = $row['Email'];
        if ($send_mail->blast($to, $uploadfile, $fileName, $company)) {

            echo '<script type="text/javascript">';
            echo 'alert("Your advertisement has been successfully sent");';
            echo 'window.location.href = "AdminDashboard.php";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Your advertisement has been successfully sent");';
            echo 'window.location.href = "AdminDashboard.php";';
            echo '</script>';
        }
    }
}


?>

<html>

<head>
    <title> Advertisement </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .files input {
            outline: 2px dashed #92b0b3;
            outline-offset: -10px;
            -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
            transition: outline-offset .15s ease-in-out, background-color .15s linear;
            padding: 120px 0px 85px 35%;
            text-align: center;
            margin: 0;
            width: 100%;
        }

        .files input:focus {
            outline: 2px dashed #92b0b3;
            outline-offset: -10px;
            -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
            transition: outline-offset .15s ease-in-out, background-color .15s linear;
            border: 1px solid #92b0b3;
        }

        .files {
            position: relative
        }

        .files:after {
            pointer-events: none;
            position: absolute;
            top: 60px;
            left: 0;
            width: 50px;
            right: 0;
            height: 56px;
            content: "";
            background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
            display: block;
            margin: 0 auto;
            background-size: 100%;
            background-repeat: no-repeat;
        }

        .color input {
            background-color: #f1f1f1;
        }

        .files:before {
            position: absolute;
            bottom: 10px;
            left: -75px;
            pointer-events: none;
            width: 100%;
            right: 0;
            height: 57px;
            content: " or drag it here. ";
            display: block;
            margin: 0 auto;
            color: #2ea591;
            font-weight: 600;
            text-transform: capitalize;
            text-align: center;
        }

        #myProgress {
            width: 100%;
            background-color: #ddd;
        }

        #myBar {
            width: 10%;
            height: 30px;
            background-color: #04AA6D;
            text-align: center;
            line-height: 30px;
            color: white;
        }
    </style>
</head>

<body>
    <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate="">
        <div id="content-wrapper" class="w-100 p-3 content-wrapper">
            <h1><b><u>Advertisement</u></b></h1>
            <div class="col-6">
                <label class="form-label">Subject:</label>
                <input class="form-control" name="subject" required id="subject" autocomplete="off"></input>
                <div class="invalid-feedback">
                    Enter a subject header.
                </div>
            </div>
            <div class="col-6">
                <label class="form-label">Body:</label>
                <textarea class="form-control" name="body" id="body" required rows="4" autocomplete="off"></textarea>
                <div class="invalid-feedback">
                    Enter a message for your recipient(s).
                </div>
            </div>
            <div class="col-6 form-group files">
                <label>Upload your files (Leave blank if empty) </label>
                <input type="file" class="form-control" accept=".doc,.docx, .pdf" name="file" id="file" />
            </div>

            <div class="d-grid col-6 pt-3">
                <button type="submit" class="btn btn-primary btn-block" name="send">Send</button>
            </div>
        </div>
    </form>
</body>
<script>
    //Validations
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