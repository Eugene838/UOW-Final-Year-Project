<?php
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'Invoice.php';
include 'db_connection.php';
include 'Navbar.php';
include 'Receptionist.php';
$invoice = new Invoice();
?>

<head>

    <title> Receptionist Page </title>
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
                <div class="col-2">
                    <h2><u>Invoice List</u></h2>
                </div>
                <div class="col-10">
                    <button class="btn btn-primary float-end" type="submit" onclick="location.href = 'create_invoice.php';">Issue invoice</button>
                </div>
                <?php include "Search.php"; ?>
            </div>
            <table class="table table-hover ps-1" id="searchTable">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 100px">Invoice No.</th>
                        <th scope="col" style="width: 200px">Create Date</th>
                        <th scope="col" style="width: 100px">Email</th>
                        <th scope="col" style="width: 200px">Customer's Name</th>
                        <th scope="col" style="width: 200px">Customer's Address</th>
                        <th scope="col" style="width: 100px">Invoice Total</th>
                        <th scope="col" style="width: 100px" id="print">Print</th>
                        <th scope="col" style="width: 100px" id="view">View</th>
                        <th scope="col" style="width: 100px">Send Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $invoiceList = $invoice->getInvoiceList($company);
                    if (isset($invoiceList) && !empty($invoiceList)) {
                        foreach ($invoiceList as $invoiceDetails) {
                            $invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["order_date"]));
                            echo
                            '<tr>' .
                                '<td>' . $invoiceDetails['order_id'] . '</td>' .
                                '<td>' . $invoiceDate . '</td>' .
                                '<td>' . $invoiceDetails['Email'] . '</td>' .
                                '<td>' . $invoiceDetails['order_receiver_name'] . '</td>' .
                                '<td>' . $invoiceDetails['order_receiver_address'] . '</td>' .
                                '<td>' . $invoiceDetails['order_total_after_tax'] . '</td>' .
                                '<td><a href="print_invoice.php?invoice_id=' . $invoiceDetails["order_id"] . '" target="_blank" title="Print Invoice"><span class="bi bi-printer"></span></a></td>' .
                                '<td><a href="edit_invoice.php?update_id=' . $invoiceDetails["order_id"] . '"  title="Edit Invoice"><span class="bi bi-eye"></span></a></td>' .
                                '<td><a href="send_invoice.php?invoice_id=' . $invoiceDetails["order_id"] . '"  title="Send Invoice"><span class="bi bi-envelope"></span></a></td>' .
                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td class="text-center" colspan="9"><b>No invoice found.</b></td>' .
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