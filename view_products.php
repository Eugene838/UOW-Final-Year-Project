<?php
ob_start();
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'Navbar.php';
include 'Receptionist.php';
?>

<html>

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
        body {
            background-image: url('img/AdminBackground.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

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
        <?php
        if (isset($_SESSION['alert'])) {
            echo $_SESSION['alert'];
        }
        ?>
        <div class="w-100 p-3">
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
                        <th scope="col">Product ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Quantity Left</th>
                        <th scope="col" colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($products_list)) {
                        foreach ($products_list as $product) {
                            echo
                            '<tr>' .
                                '<td>' . $product['product_id'] . '</td>' .
                                '<td>' . $product['product_name'] . '</td>' .
                                '<td>' . "$" . $product['product_price'] . '</td>' .
                                '<td>' . $product['quantity'] . '</td>' .
                                '<td><button type="button" class="btn btn-secondary editProductBtn" data-bs-toggle="modal" data-bs-target="#editProduct"> Edit <i class="bi bi-pencil-square"></i></button></td>' .
                                '<td><button type="button" class="btn btn-danger delProductBtn" data-bs-toggle="modal" data-bs-target="#deleteProduct">Delete <i class="bi bi-trash"></i></button></td>' .

                                '</tr>';
                        }
                    } else {
                        echo
                        '<tr>' .
                            '<td class="text-center" colspan="6"><b>No products in inventory.</b></td>' .
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