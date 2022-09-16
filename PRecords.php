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

        table {
            width: 50%;
            background-color: white;
            text-align: left;
        }

        td,
        th {
            border: 1px solid #ddd;
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
            <h2><b> Past Treatment Records </b></h2>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="display:none">Record ID</th>
                        <th scope="col">Dentist Name</th>
                        <th scope="col">Assistant Name</th>

                        <th scope="col">Clinic Name</th>
                        <th scope="col">Treatment Date</th>
                        <th scope="col">Treatment Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ID = $_SESSION['Patient_ID'];

                    $stmt1 = $db->connect()->prepare("SELECT Record_ID, `Doctor/Assistant 1`, `Doctor/Assistant 2`, Company, Treatment_Date, Treatment_type from patient_record where patient_id = $ID");
                    $stmt1->execute();
                    if ($stmt1->rowCount() > 0) {
                        $patPastRec = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($patPastRec as $pastRec) {
                                echo
                                '<tr>' .
                                    '<td style=display:none>' . $pastRec['Record_ID'] . '</td>' .
                                    '<td>' . $pastRec['Doctor/Assistant 1'] . '</td>' .
                                    '<td>' . $pastRec['Doctor/Assistant 2'] . '</td>' .


                                    '<td>' . $pastRec['Company'] . '</td>' .
                                    '<td>' . $pastRec['Treatment_Date'] . '</td>' .
                                    '<td>' . $pastRec['Treatment_type'] . '</td>' .

                                '</tr>';
                            }
                        }
                    else {
                        echo
                        '<tr>' .
                            '<td colspan="8"><b>You have no past treatment records.</b></td>' .
                        '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>