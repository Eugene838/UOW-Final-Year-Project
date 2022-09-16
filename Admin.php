<?php

$company = $_SESSION['Company'];

if (!isset($_SESSION['Role']) && empty($_SESSION['Role'])) {
	header("Location: index.php");
} else {
	if ($path == "AdminDashboard" || $path == "SuperAdmin") {
		if (isset($_POST["allUsers"])) {
			unset($_SESSION['temp']);
			$db = new DB_Connect();

			$stmt = $db->connect()->prepare("SELECT * FROM user_table WHERE `Role` != 'Super Admin' AND `Company` = ?");
			$stmt->execute([$company]);

			if ($stmt->rowCount() > 0) {
				$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		if (isset($_POST["ca_createBtn"])) {
			$db = new DB_Connect();
			$stmt = $db->connect()->prepare("SELECT MAX(Emp_ID) from user_table where Role='Dentist'");
			$stmt->execute();
			$empID = $stmt->fetch()[0] + 1;

			$firstname = $_POST['fname'];
			$lastname = $_POST['lname'];
			$username = $_POST['add_username'];
			$password = $_POST['add_password'];
			$nric = $_POST['add_nric'];
			$gender = $_POST['add_gender'];
			$dob = $_POST['add_dob'];
			$address = $_POST['add_address'];
			$mobileNum = $_POST['add_mobileNum'];
			$email = $_POST['add_email'];
			$role = $_POST['add_role'];
			$specialization = $_POST['add_special'];

			if ($role == "Clinic Admin") {
				$stmt = $db->connect()->prepare("SELECT MAX(Emp_ID) from user_table where Role='Clinic Admin'");
				$stmt->execute();
				$maxempID = $stmt->fetch()[0];
				if ($maxempID == 0) {
					$empID = '5001';
				} else {
					$empID = $maxempID + 1;
				}
			} elseif ($role == "Dentist") {
				$stmt = $db->connect()->prepare("SELECT MAX(Emp_ID) from user_table where Role='Dentist'");
				$stmt->execute();
				$maxempID = $stmt->fetch()[0];
				if ($maxempID == 0) {
					$empID = '1001';
				} else {
					$empID = $maxempID + 1;
				}
			} elseif ($role == "Dentist Assistant") {
				$stmt = $db->connect()->prepare("SELECT MAX(Emp_ID) from user_table where Role='Dentist Assistant'");
				$stmt->execute();
				$maxempID = $stmt->fetch()[0];
				if ($maxempID == 0) {
					$empID = '2001';
				} else {
					$empID = $maxempID + 1;
				}
			} elseif ($role == "Receptionist") {
				$stmt = $db->connect()->prepare("SELECT MAX(Emp_ID) from user_table where Role='Receptionist'");
				$stmt->execute();
				$maxempID = $stmt->fetch()[0];
				if ($maxempID == 0) {
					$empID = '3001';
				} else {
					$empID = $maxempID + 1;
				}
			}

			$stmt = $db->connect()->prepare("INSERT INTO `user_table`(`Emp_ID`, `First_Name`, `Last_Name`, `username`, `password`, `NRIC_PNum`, `Gender`, `Birth_Date`, `Address`, `Phone_Num`, `Email`, `Role`, `Specialization`, `Company`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$stmt->execute([$empID, $firstname, $lastname, $username, $password, $nric, $gender, $dob, $address, $mobileNum, $email, $role, $specialization, $company]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg">Account successfully created! <i class="bi bi-person-check"></i></div>';
			} else {
				$_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error. Unable to create account! <i class="bi bi-exclamation-circle"></i></div>';
			}
		}
		if (isset($_POST["ca_updateBtn"])) {
			$db = new DB_Connect();
			$empID = $_POST['userID'];
			$first = $_POST['firstName'];
			$last = $_POST['lastName'];
			$username = $_POST['edit_username'];
			$password = $_POST['edit_password'];
			$nric = $_POST['edit_nric'];
			$gender = $_POST['gender'];
			$bday = $_POST['edit_dob'];
			$hpNum = $_POST['mobileNum'];
			$email = $_POST['emailAdd'];
			$addr = $_POST['address'];
			$special = $_POST['e_special'];

			$stmt = $db->connect()->prepare("UPDATE `user_table` SET `First_Name`=?,`Last_Name`=?,`username`=?,`password`=?,
			`NRIC_PNum`=?,`Gender`=?,`Birth_Date`=?,`Address`=?,`Phone_Num`=?,`Email`=?,`Specialization`=? WHERE `Emp_ID`=?");
			$stmt->execute([$first, $last, $username, $password, $nric, $gender, $bday, $addr, $hpNum, $email, $special, $empID]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg">Account information has been updated! <i class="bi bi-person-check"></i></div>';
			} else {
				$_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error! Fail to update account information! <i class="bi bi-exclamation-circle"></i></div>';
			}
		}
		if (isset($_POST["ca_deleteBtn"])) {
			$db = new DB_Connect();
			$empID = $_POST['dUserID'];

			$stmt = $db->connect()->prepare("DELETE FROM `user_table` WHERE `Emp_ID`=? ");
			$stmt->execute([$empID]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg">Account has been successfully deleted! <i class="bi bi-trash"></i></div>';
			} else {
				$_SESSION['alert'] = '<div class="alert alert-danger" role="alert-msg">Error occured! Unable to delete account! <i class="bi bi-exclamation-circle"></i></div>';
			}
		}
	}
	if (!isset($_SESSION['temp']) && empty($_SESSION['temp'])) {
		$db = new DB_Connect();
		// unset($users);
		$stmt = $db->connect()->prepare("SELECT * FROM user_table WHERE `Role` != 'Super Admin' AND `Company` = ?");
		$stmt->execute([$company]);

		if ($stmt->rowCount() > 0) {
			$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	} else {
		$users = $_SESSION['temp'];
	}
}

?>
<!-- Create Account Form Modal -->
<div class="modal fade" id="createAcc" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Enter User details</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="needs-validation" method="POST" novalidate>
					<div class="mb-3">
						<label class="form-label">First Name</label>
						<input type="text" class="form-control" name="fname" id="fname" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
						<div class="invalid-feedback">
							Please enter first name.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Last Name</label>
						<input type="text" class="form-control" name="lname" id="lname" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
						<div class="invalid-feedback">
							Please enter last name.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Username</label>
						<input type="text" class="form-control" name="add_username" id="add_username" required>
						<div class="invalid-feedback">
							Please enter a username.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" class="form-control" name="add_password" id="add_password" required>
						<div class="invalid-feedback">
							Please enter a password.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">NRIC/Passport No.</label>
						<input type="text" class="form-control" name="add_nric" id="add_nric" pattern="[A-Za-z][0-9]{7}[A-Za-z]" required>
						<div class="invalid-feedback">
							Please enter a valid NRIC/Passport No.
						</div>
					</div>
					<div class="mb-2">
						<label class="form-label">Gender</label><br>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="add_gender" id="add_genderM" value="M" required>
							<label class="form-check-label" for="inlineRadio1">Male</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="add_gender" id="add_genderF" value="F" required>
							<label class="form-check-label" for="inlineRadio2">Female</label>
						</div>
						<div class="form-check p-0">
							<input type="radio" name="add_gender" style="display: none;" required>
							<div class="invalid-feedback">
								Please choose a gender.
							</div>
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Birth date</label>
						<input type="date" class="form-control" name="add_dob" id="add_dob" required>
						<div class="invalid-feedback">
							Please select a date.
						</div>
					</div>
					<div class="mb-3">
						<div class="form-outline mb-3">
							<label class="form-label">Address</label>
							<textarea class="form-control" rows="5" name="add_address" id="add_address" required></textarea>
							<div class="invalid-feedback">
								Please enter a residential address.
							</div>
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Phone Number</label>
						<input type="text" class="form-control" pattern="[8-9]{1}[0-9]{7}" name="add_mobileNum" id="add_mobileNum" required>
						<div class="invalid-feedback">
							Please enter a valid singapore mobile number.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Email Address</label>
						<input type="email" class="form-control" name="add_email" id="add_email" required>
						<div class="invalid-feedback">
							Please enter a valid email address.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Role</label>
						<select class="form-select" aria-label="Default select example" name="add_role" id="add_role" onchange="showDiv('special_add', this)" required>
							<option value="">Choose a role</option>
							<option value="Clinic Admin">Clinic Admin</option>
							<option value="Dentist">Dentist</option>
							<option value="Dentist Assistant">Dentist Assistant</option>
							<option value="Receptionist">Receptionist</option>
						</select>
						<div class="invalid-feedback">
							Please select a role.
						</div>
					</div>
					<div class="mb-3" style="display: none" id='special_add'>
						<label class="form-label">Specialization</label>
						<select class="form-select" aria-label="Default select example" name="add_special" id="add_special" required>
							<option selected="selected" value="NULL">Choose a specialization</option>
							<option value="General Dentist">General Dentist</option>
							<option value="Pedodontist">Pedodontist</option>
							<option value="Orthodontist">Orthodontist</option>
							<option value="Periodontist">Periodontist</option>
							<option value="Endodontist">Endodontist</option>
							<option value="Oral Pathologist">Oral Pathologist</option>
							<option value="Prosthodontist">Prosthodontist</option>
						</select>
						<div class="invalid-feedback">
							Please choose a specialization.
						</div>
					</div>
					<button type="submit" class="btn btn-primary" name="ca_createBtn">Create Account</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Edit Account Modal -->
<div class="modal fade" id="editAcc" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Update User details</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="needs-validation" method="POST" novalidate>
					<div class="mb-3">
						<label class="form-label">User ID</label>
						<input type="text" class="form-control" name="userID" id="userID" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label">First Name</label>
						<input type="text" class="form-control" name="firstName" id="firstName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
						<div class="invalid-feedback">
							Please enter first name.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Last Name</label>
						<input type="text" class="form-control" name="lastName" id="lastName" pattern="^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$" required>
						<div class="invalid-feedback">
							Please enter last name.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Username</label>
						<input type="text" class="form-control" name="edit_username" id="edit_username" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" class="form-control" name="edit_password" id="edit_password" required>
						<span toggle="#password1" class="bi bi-eye-slash-fill field-icon toggle-password"></span>
					</div>
					<div class="mb-3">
						<label class="form-label">NRIC/Passport No.</label>
						<input type="text" class="form-control" name="edit_nric" id="edit_nric" pattern="[A-Za-z][0-9]{7}[A-Za-z]" required>

						<div class="invalid-feedback">
							Please enter a valid NRIC/Passport No.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Phone Number</label>
						<input type="text" class="form-control" name="mobileNum" id="mobileNum" pattern="[8-9]{1}[0-9]{7}" required>
						<div class="invalid-feedback">
							Please enter a valid singapore mobile number.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Email Address</label>
						<input type="email" class="form-control" name="emailAdd" id="emailAdd" required>
						<div class="invalid-feedback">
							Please enter a valid email address.
						</div>
					</div>
					<div class="mb-3">
						<div class="form-outline mb-3">
							<label class="form-label">Address</label>
							<textarea class="form-control" rows="5" name="address" id="address" required></textarea>
							<div class="invalid-feedback">
								Please enter a residential address.
							</div>
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Gender</label><br>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="gender" id="male" value="M" required>
							<label class="form-check-label" for="inlineRadio1">Male</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="gender" id="female" value="F" required>
							<label class="form-check-label" for="inlineRadio2">Female</label>
						</div>
						<div class="form-check p-0">
							<input type="radio" name="gender" style="display: none;" required>
							<div class="invalid-feedback">
								Please choose a gender.
							</div>
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Birth date</label>
						<input type="date" class="form-control" name="edit_dob" id="edit_dob" required>
						<div class="invalid-feedback">
							Please select a date.
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label">Role</label>
						<select class="form-select" aria-label="Default select example" name="role" id="edit_role" disabled>
							<option selected>Choose a role</option>
							<option value="Clinic Admin">Clinic Admin</option>
							<option value="Dentist">Dentist</option>
							<option value="Dentist Assistant">Dentist Assistant</option>
							<option value="Receptionist">Receptionist</option>
						</select>
					</div>
					<div class="mb-3" id='edit_special'>
						<label class="form-label">Specialization</label>
						<select class="form-select" aria-label="Default select example" name="e_special" id="e_special" required>
							<option selected="selected" value="NULL">Choose a specialization</option>
							<option value="General Dentist">General Dentist</option>
							<option value="Pedodontist">Pedodontist</option>
							<option value="Orthodontist">Orthodontist</option>
							<option value="Periodontist">Periodontist</option>
							<option value="Endodontist">Endodontist</option>
							<option value="Oral Pathologist">Oral Pathologist</option>
							<option value="Prosthodontist">Prosthodontist</option>
						</select>
						<div class="invalid-feedback">
							Please choose a specialization.
						</div>
					</div>
					<!-- <button type="submit" class="btn btn-danger float-start" name="ca_deleteBtn">Delete Account</button> -->
					<button type="submit" class="btn btn-primary float-end" name="ca_updateBtn">Update Account</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Delete Account Confirmation Modal -->
<div class="modal fade" id="deleteAcc" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog col-6">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Account</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST">
				<div class="modal-body">
					Are you sure you want to delete this account?
					<div class="form-group row mt-3">
						<label for="staticID" class="col-4 col-form-label"><b>Employee ID:</b></label>
						<div class="col-sm-2">
							<input type="text" class="form-control-plaintext" name="dUserID" id="dUserID" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label for="staticID" class="col-4 col-form-label"><b>Name:</b></label>
						<div class="col-sm-5">
							<input type="text" class="form-control-plaintext" id="dName" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label for="staticID" class="col-4 col-form-label text-nowrap"><b>NRIC/Passport No.:</b></label>
						<div class="col-sm-5">
							<input type="text" class="form-control-plaintext" id="dNRIC" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label for="staticID" class="col-4 col-form-label text-nowrap"><b>Email:</b></label>
						<div class="col-sm-5">
							<input type="text" class="form-control-plaintext" id="dEmail" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label for="staticID" class="col-4 col-form-label text-nowrap"><b>Role:</b></label>
						<div class="col-sm-5">
							<input type="text" class="form-control-plaintext" id="dRole" readonly>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger" name="ca_deleteBtn">Confirm</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script>
	$(document).ready(function() {
		$('.editBtn').click(function() {
			$eID = $(this).closest('tr').find('td:nth-child(1)').text().trim();
			$name = $(this).closest('tr').find('td:nth-child(2)').text().trim();
			$splitName = $name.split(/(?<=^\S+)\s/);
			$first = $splitName[0];
			$last = $splitName[1];
			$username = $(this).closest('tr').find('td:nth-child(3)').text().trim();
			$password = $(this).closest("tr").find("td input[type='password']").val();
			$nric = $(this).closest('tr').find('td:nth-child(6)').text().trim();
			$mobileNum = $(this).closest('tr').find('td:nth-child(10)').text().trim();
			$gender = $(this).closest('tr').find('td:nth-child(7)').text().trim();
			$dob = $(this).closest('tr').find('td:nth-child(8)').text().trim();
			$address = $(this).closest('tr').find('td:nth-child(9)').text().trim();
			$email = $(this).closest('tr').find('td:nth-child(11)').text().trim();
			$role = $(this).closest('tr').find('td:nth-child(12)').text().trim();
			$special = $(this).closest('tr').find('td:nth-child(13)').text().trim();
			$('#userID').val($eID);
			$('#firstName').val($first);
			$('#lastName').val($last);
			$('#edit_username').val($username);
			$('#edit_password').val($password);
			$('#edit_nric').val($nric);
			$('#mobileNum').val($mobileNum);
			$('#emailAdd').val($email);
			$('#address').val($address);
			$('#edit_dob').val($dob);
			$('#edit_role').val($role);
			$('#e_special').val($special);

			if ($gender == "M") {
				$("#male").prop("checked", true);
			} else {
				$("#female").prop("checked", true);
			}

			$('#role').on('change', checkPattern);
			checkPattern();
		});

		$('.deleteBtn').click(function() {
			$eID = $(this).closest('tr').find('td:nth-child(1)').text();
			$name = $(this).closest('tr').find('td:nth-child(2)').text().trim();
			$nric = $(this).closest('tr').find('td:nth-child(6)').text().trim();
			$email = $(this).closest('tr').find('td:nth-child(11)').text().trim();
			$role = $(this).closest('tr').find('td:nth-child(12)').text().trim();
			//console.log($eID);
			$('#dUserID').val($eID);
			$('#dName').val($name);
			$('#dNRIC').val($nric);
			$('#dEmail').val($email);
			$('#dRole').val($role);
		});
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
	$(".toggle-password").on('mousedown', function() {
		document.getElementById('edit_password').setAttribute('type', 'text');
		$(this).removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
	}).on('mouseup', function() {
		document.getElementById('edit_password').setAttribute('type', 'password');
		$(this).removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
	});
</script>