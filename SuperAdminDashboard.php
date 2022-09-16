<?php
ob_start();
include 'db_connection.php';
include 'Navbar.php';
$db = new DB_Connect();
if (!isset($_SESSION['Role']) && empty($_SESSION['Role'])) {
	header("Location: index.php");
} else {
	/*
	if (!isset($_SESSION['temp']) && empty($_SESSION['temp'])) {

		$db = new DB_Connect();
		// unset($users);

		$stmt = $db->connectWix()->prepare("SELECT * FROM `wixClients` where `status`='Pending'");
		$stmt2 = $db->connectWix()->prepare("SELECT * FROM `wixClients` where `status`='Active'");
		$stmt3 = $db->connectWix()->prepare("SELECT * FROM `wixClients` where `status`='Inactive'");
		$stmt->execute();
		$stmt2->execute();
		$stmt3->execute();
		$errormsg = '';
		$rowCount = '';

		if ($stmt->rowCount() > 0 || $stmt2->rowCount() > 0 || $stmt3->rowCount() > 0) {
			$pendingAcc = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$activeAcc = $stmt2->fetchAll(PDO::FETCH_ASSOC);
			$inactiveAcc = $stmt3->fetchAll(PDO::FETCH_ASSOC);
		}
	} else {
		$temp = $_SESSION['temp'];
		$errormsg = $_SESSION['errorMsg'];
		$rowCount = $_SESSION['rowCount'];
	}
	*/
}

if (isset($_POST["approveBtn"])) {
	$clinicUEN = $_POST['clinicUEN'];
	$stmt = $db->connectWix()->prepare("UPDATE `wixClients` SET `status`='Active' WHERE `clinic_uen` = '$clinicUEN'");
	$stmt->execute();

	if ($stmt->rowCount() > 0) {
		$_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Account has been successfully approved! <i class="bi bi-person-check"></i></div>';
		//$alertMsg = '<div class="alert alert-success" role="alert-msg" id="alert">Account has been successfully approved! <i class="bi bi-person-check"></i></div>';
	} else {
		$_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg" id="alert">Error! Please try again <i class="bi bi-person-check"></i></div>';
		//$alertMsg = '<div class="alert alert-danger" role="alert-msg" id="alert">Error! Please try again <i class="bi bi-person-check"></i></div>';
	}
}
if (isset($_POST["rejectBtn"])) {
	$rejectUEN = $_POST['rejectUEN'];
	$stmt = $db->connectWix()->prepare("UPDATE `wixClients` SET `status`='Rejected' WHERE `clinic_uen` = '$rejectUEN'");
	$stmt->execute();

	if ($stmt->rowCount() > 0) {
		$_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Account has been rejected! <i class="bi bi-person-check"></i></div>';
	} else {
		$_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg" id="alert">Error! Please try again <i class="bi bi-person-check"></i></div>';
	}
}
if (isset($_POST["deactivateBtn"])) {
	$deactiveUEN = $_POST['deactiveUEN'];
	$stmt = $db->connectWix()->prepare("UPDATE `wixClients` SET `status`='Inactive' WHERE `clinic_uen` = '$deactiveUEN'");
	$stmt->execute();

	if ($stmt->rowCount() > 0) {
		$_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg">Account has been removed from subscription! <i class="bi bi-person-check"></i></div>';
		//$alertMsg = '<div class="alert alert-success" role="alert-msg">Account has been removed from subscription! <i class="bi bi-person-check"></i></div>';
	} else {
		$_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error! Please try again <i class="bi bi-person-check"></i></div>';
		//$alertMsg = '<div class="alert alert-danger" role="alert-msg">Error! Please try again <i class="bi bi-person-check"></i></div>';
	}
}
if (isset($_POST["reinstateBtn"])) {
	$reinstateUEN = $_POST['reinstateUEN'];
	$stmt = $db->connectWix()->prepare("UPDATE `wixClients` SET `status`='Active' WHERE `clinic_uen` = '$reinstateUEN'");
	$stmt->execute();

	if ($stmt->rowCount() > 0) {
		$_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg">Account has been successfully reinstated! <i class="bi bi-person-check"></i></div>';
	} else {
		$_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error! Please try again <i class="bi bi-person-check"></i></div>';
	}
}
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
	</style>
</head>

<body>
	<div id="content-wrapper" class="content-wrapper">
		<div class="w-100 p-3">
			<div class="container-fluid mb-3">
				<?php
				if (isset($_SESSION['alert'])) {
					echo $_SESSION['alert'];
				}
				?>
				<h2><u>Active Subscriptions</u></h2>
				<table class="table">
					<thead class="table-dark">
						<tr>
							<th scope="col">Clinic Name</th>
							<th scope="col">Clinic UEN No.</th>
							<th scope="col" style="width: 100px">Clinic Contact Number</th>
							<th scope="col">Clinic Address</th>
							<th scope="col">Clinic Specialization</th>
							<th scope="col">Applicant Name</th>
							<th scope="col" style="width: 100px">Applicant Contact Number</th>
							<th scope="col">Email</th>
							<th scope="col" style="width: 100px">Status</th>
							<th scope="col" style="width: 140px">Actions</th>
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
								'<td><button type="button" class="btn btn-danger deactivateBtn" data-bs-toggle="modal" data-bs-target="#deactivateModal">Deactivate <i class="bi bi-trash"></i></button></td>' .
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
				<h2><u>Pending Approval</u></h2>
				<table class="table">
					<thead class="table-dark">
						<tr>
							<th scope="col" style="width: 180px">Clinic Name</th>
							<th scope="col">Clinic UEN No.</th>
							<th scope="col" style="width: 100px">Clinic Contact Number</th>
							<th scope="col" style="width: 250px">Clinic Address</th>
							<th scope="col">Clinic Specialization</th>
							<th scope="col" >Applicant Name</th>
							<th scope="col" style="width: 100px">Applicant Contact Number</th>
							<th scope="col">Email</th>
							<th scope="col" style="width: 100px">Status</th>
							<th scope="col" colspan="2">Actions</th>
						</tr>
					</thead>
					<?php
					$stmt = $db->connectWix()->prepare("SELECT * FROM `wixClients` where `status`='Pending'");
					$stmt->execute();

					if ($stmt->rowCount() > 0) {
						$pendingAcc = $stmt->fetchAll(PDO::FETCH_ASSOC);
						foreach ($pendingAcc as $acc) {
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
								'<td><span class="badge bg-secondary">' . $acc['status'] . '</span></td>' .
								'<td><button type="button" class="btn btn-success approveBtn" data-bs-toggle="modal" data-bs-target="#approveModal">Approve <i class="bi bi-journal-check"></i></button></td>' .
								'<td><button type="button" class="btn btn-danger rejectBtn" data-bs-toggle="modal" data-bs-target="#rejectModal">Reject <i class="bi bi-trash"></i></button></td>' .
								'</tr>';
						}
					} else {
						echo
						'<tr>' .
							'<td class="text-center" colspan="11"><b>No pending approval accounts.</b></td>' .
							'</tr>';
					}
					?>
				</table>
				<h2><u>Expired Subscriptions</u></h2>
				<table class="table">
					<thead class="table-dark">
						<tr>
							<th scope="col" style="width: 180px">Clinic Name</th>
							<th scope="col">Clinic UEN No.</th>
							<th scope="col" style="width: 100px">Clinic Contact Number</th>
							<th scope="col">Clinic Address</th>
							<th scope="col">Clinic Specialization</th>
							<th scope="col">Applicant Name</th>
							<th scope="col" style="width: 100px">Applicant Contact Number</th>
							<th scope="col">Email</th>
							<th scope="col" style="width: 100px">Status</th>
							<th scope="col" style="width: 180px">Actions</th>
						</tr>
					</thead>
					<?php
					$stmt3 = $db->connectWix()->prepare("SELECT * FROM `wixClients` where `status`='Inactive'");
					$stmt3->execute();

					if ($stmt3->rowCount() > 0) {
						$inactiveAcc = $stmt3->fetchAll(PDO::FETCH_ASSOC);
						foreach ($inactiveAcc as $acc) {
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
								'<td><span class="badge bg-warning text-dark">' . $acc['status'] . '</span></td>' .
								'<td><button type="button" class="btn btn-secondary reinstateBtn" data-bs-toggle="modal" data-bs-target="#reinstateModal">Reinstate Account <i class="bi bi-wrench"></i></button></td>' .
								'</tr>';
						}
					} else {
						echo
						'<tr>' .
							'<td class="text-center" colspan="11"><b>No inactive accounts.</b></td>' .
							'</tr>';
					}
					?>
				</table>
			</div>
		</div>
	</div>
	<!-- Account Approval Modal -->
	<div class="modal fade" id="approveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST">
					<div class="modal-body row">
						<div class="col-5">
							<p>Approve clinic account?</p>
						</div>
						<div class="col-12">
							<input class="form-label" name="clinicUEN" id="clinicUEN" hidden>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-lg btn-primary" name="approveBtn">Approve</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Reject Account Modal -->
	<div class="modal fade" id="rejectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Reject Clinic Application</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST">
					<div class="modal-body">
						<input class="form-label" name="rejectUEN" id="rejectUEN" hidden>
						<p class="fw-bold">Do you want to reject this clinic's application?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-lg btn-danger" data-bs-dismiss="modal">No</button>
						<button type="submit" class="btn btn-lg btn-success" name="rejectBtn">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Deactivate Account Modal -->
	<div class="modal fade" id="deactivateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Remove from Subscription</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST">
					<div class="modal-body">
						<input class="form-label" name="deactiveUEN" id="deactiveUEN" hidden>
						<p class="fw-bold">Are you sure to remove account from subscription?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-lg btn-danger" data-bs-dismiss="modal">No</button>
						<button type="submit" class="btn btn-lg btn-success" name="deactivateBtn">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Reinstate Account Modal -->
	<div class="modal fade" id="reinstateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Reinstate Account</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST">
					<div class="modal-body">
						<input class="form-label" name="reinstateUEN" id="reinstateUEN" hidden>
						<p class="fw-bold">Are you sure to reinstate this account?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-lg btn-danger" data-bs-dismiss="modal">No</button>
						<button type="submit" class="btn btn-lg btn-success" name="reinstateBtn">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
	$(document).ready(function() {
		setTimeout(function() {
			$(".alert").alert('close');
			<?php unset($_SESSION['alert']);?>
		}, 3000);
	});

	$('.approveBtn').click(function() {
		var clinicUEN = $(this).closest('tr').find('td:nth-child(2)').text();
		$('#clinicUEN').val(clinicUEN);
	});

	$('.rejectBtn').click(function() {
		var clinicUEN = $(this).closest('tr').find('td:nth-child(2)').text();
		$('#rejectUEN').val(clinicUEN);
	});

	$('.deactivateBtn').click(function() {
		var clinicUEN = $(this).closest('tr').find('td:nth-child(2)').text();
		$('#deactiveUEN').val(clinicUEN);
	});

	$('.reinstateBtn').click(function() {
		var clinicUEN = $(this).closest('tr').find('td:nth-child(2)').text();
		$('#reinstateUEN').val(clinicUEN);
	});

	function showDiv(divId, element) {
		document.getElementById(divId).style.display = element.value == 'Dentist' ? 'block' : 'none';
	}
	var checkPattern = function() {
		if ($('#edit_role').val() == 'Dentist') {
			$('#edit_special').show();
		} else $('#edit_special').hide();
	}

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