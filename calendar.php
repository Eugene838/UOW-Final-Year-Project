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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/bootstrap.min.css">
        <style>
            p,td {
                font-family: garamond;
                font-size: 14pt;
            }
            body {
                background-image: url('img/AdminBackground.png');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
            .content-wrapper{
            transition: all 0.3s ease;
            margin-left:288px;
            }
            .list-group-item{
                background-color:transparent;
                color: #fff;
                border: 1px solid #ddd;
                width:18rem;
            }
            @media only screen and (max-width: 760px),
            (min-device-width: 802px) and (max-device-width: 1020px) {

            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr {
                display: block;
            }

            .empty {
                display: none;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
            }

            td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }
            


            /*
            Label the data
            */
            td:nth-of-type(1):before {
                content: "Sunday";
            }
            td:nth-of-type(2):before {
                content: "Monday";
            }
            td:nth-of-type(3):before {
                content: "Tuesday";
            }
            td:nth-of-type(4):before {
                content: "Wednesday";
            }
            td:nth-of-type(5):before {
                content: "Thursday";
            }
            td:nth-of-type(6):before {
                content: "Friday";
            }
            td:nth-of-type(7):before {
                content: "Saturday";
            }


            }

            /* Smartphones (portrait and landscape) ----------- */

            @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            body {
                padding: 0;
                margin: 0;
            }
            }

            /* iPads (portrait and landscape) ----------- */

            @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
            body {
                width: 495px;
            }
            }

            @media (min-width:641px) {
            table {
                table-layout: fixed;
            }
            td {
                width: 33%;
            }
            }

            .row{
            margin-top: 20px;
            }

            .today{
            background:yellow;
            }
        </style>
    </head>
    <body>
    <div id="content-wrapper" class="w-75 p-3 content-wrapper"> 
        <div class="row"> 
            <div class="col-12"> 
                <div id="calendar"> 
                <?php 
                    $dateComponents = getdate();
                    if(isset($_GET['month']) && isset($_GET['year'])){
                        $month = $_GET['month'];
                        $year = $_GET['year'];
                    }
                    else{
                        $month = $dateComponents['mon']; 
                        $year = $dateComponents['year'];
                    } 
                    echo build_calendar($month,$year); 
                ?> 
                </div> 
            </div> 
        </div> 
    </div> 
</body>
</html>