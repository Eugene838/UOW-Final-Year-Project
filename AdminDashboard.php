<?php
ob_start();
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'db_connection.php';
include 'Navbar.php';
include 'Admin.php';
$count = "0";
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
		<div class="w-100 p-3">
			<?php
			if (isset($_SESSION['alert'])) {
				echo $_SESSION['alert'];
			}
			?>
			<div class="row g-3">
				<div class="col-3">
					<h2><u>Staff Accounts</u></h2>
				</div>
			</div>
			<div class="col-6">
				<?php include "Search.php"; ?>
			</div>
			<div class="col">
				<button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createAcc">Create New User Account <i class="bi bi-plus-square"></i></button>
			</div>
		</div>
		<table id="searchTable" class="table table-hover ps-1 mt-2">
			<thead class="table-dark">
				<tr>
					<th scope="col" style="width: 100px">ID</th>
					<th scope="col">Name</th>
					<th scope="col">Username</th>
					<th scope="col" id="password" style="border-right:none;">Password</th>
					<th scope="col" id="password" style="border-left:none;"></th>
					<th scope="col" >NRIC/Passport No.</th>
					<th scope="col" style="display:none">Gender</th>
					<th scope="col" style="width: 200px">DOB</th>
					<th scope="col" style="display:none">Address</th>
					<th scope="col">Phone Number</th>
					<th scope="col">Email</th>
					<th scope="col" style="width: 200px">Roles</th>
					<th scope="col" style="display:none">Specialization</th>
					<th scope="col" style="width: 100px" id="view">View/Edit</th>
					<th scope="col" style="width: 120px">Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (isset($users)) {
					$count = "1";
					foreach ($users as $user) {
						echo
						'<tr>' .
							'<td scope="row"><b>' . $user['Emp_ID'] . '</b></td>' .
							'<td class="firstName">' . $user['First_Name'] . ' ' . $user['Last_Name'] . '</td>' .
							'<td>' . $user['username'] . '</td>' .
							'<td style="border-right:none;"><input type="password" value="' . $user['password'] . '" style="border:none;" id="password' . $count . '" readonly></td>' .
							'<td style="border-left:none;"><i toggle="#password-field" class="bi bi-eye-slash-fill float-end toggle-password"></i></td>' .
							'<td>' . $user['NRIC_PNum'] . '</td>' .
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
						++$count;
					}
				} else {
					echo
					'<tr>' .
						'<td class="text-center" colspan="11"><b>No accounts has been created.</b></td>' .
						'</tr>';
				}
				?>
			</tbody>
		</table>

		<?php
		if (isset($_SESSION['temp'])) {
			echo '<form method="POST"><button type="submit" class="btn btn-secondary mt-2" name="allUsers">Back</button></form>';
		}
		?>
	</div>
	</div>
</body>
<script>
	$(".toggle-password").on('mousedown', function() {
		var self = $(this).closest("tr").find("td input[type='password']").val();
		$(this).removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
		$(this).closest("tr").find("td input[type='password']").attr('type', 'text');
	}).on('mouseup', function() {
		var self = $(this).closest("tr").find("td input[type='password']").val();
		$(this).removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
		$(this).closest("tr").find("td input[type='text']").attr('type', 'password');
	});
	$(document).ready(function() {
		setTimeout(function() {
			$(".alert").alert('close');
			<?php unset($_SESSION['alert']); ?>
		}, 3000);
	});
</script>

</html>