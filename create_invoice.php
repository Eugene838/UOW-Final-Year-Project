<?php
ob_start();
$path = basename($_SERVER['PHP_SELF'], ".php");
include 'Navbar.php';
include 'Invoice.php';
include 'db_connection.php';
include 'Receptionist.php';
$invoice = new Invoice();

if (!empty($_POST['customerName']) && $_POST['customerName']) {
	$invoice->saveInvoice($_POST, $company);
	if ($_POST) {
		if(isset($_GET['patient_id']) && isset($_GET['appointment_id'])) {
			$patientID = $_GET['patient_id'];
			$apptID = $_GET['appointment_id'];
			$stmt = $db->connect()->prepare("UPDATE `appointment_table` SET `status`='Paid' WHERE `patient_id`=$patientID AND `appointment_id`=$apptID");
            $stmt->execute();
		}
		$_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Invoice has been successfully created! <i class="bi bi-receipt"></i></div>';
		if($_SESSION['Role'] == "Super Admin") {
			header("Location: Company.php?Company=" . $_SESSION['Company']);
		} else {
			header("Location: invoice_list.php");
		}
	} else {
		$_SESSION['alert'] = '<div class="alert alert-danger" role="alert">Error! Unable to create invoice. <i class="bi bi-exclamation-circle"></i></div>';
	}
}
?>
<style>
	body {
		background-image: url('img/AdminBackground.png');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-size: cover;
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

	#header .toggle-navigation.toggle-left {
		margin: 30px 0 0 20px;
		display: inline-block;
		color: white;
	}

	.errorMsg {
		color: red;
	}
</style>
<html>

<body>
	<title>New Invoice</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<div id="content-wrapper" class="content-wrapper">
		<?php
		if (isset($_SESSION['alert'])) {
			echo $_SESSION['alert'];
		}
		?>
		<div class="container content-invoice">
			<form action="" id="invoice-form" method="post" class="needs-validation" role="form" novalidate="">
				<div class="container-fluid col-12 mt-4 mb-4 bg-light">
					<input id="currency" type="hidden" value="$">
					<div class="row">
						<div class="col-xs-12">
							<h3>Recipient,</h3>
							<?php
							if(isset($_GET['patient_id'])) {
								$patientID = $_GET['patient_id'];
								$stmt = $db->connectWix()->prepare("SELECT * FROM wixPatients WHERE Patient_ID = '$patientID'");
								$stmt->execute();

								if($stmt->rowCount() > 0) {
									$patientDetail = $stmt->fetchAll(PDO::FETCH_ASSOC);

									echo
									'
									<div class="form-group">
										<input type="text" class="form-control" name="apptID" id="apptID" value = '.$_GET['appointment_id'].' readonly required>
										<div class="invalid-feedback">
											Please enter a name.
										</div>
										<br>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="customerName" id="customerName" placeholder="Name of recipient" value=" ' . $patientDetail[0]['First_Name'] . ' ' . $patientDetail[0]['Last_Name'] .'" required>
										<div class="invalid-feedback">
											Please enter a name.
										</div>
									</div>
									<br>
									<div class="form-group">
										<input type="text" class="form-control" name="customerEmail" id="customerEmail" placeholder="Recipient\'s email" value="' . $patientDetail[0]['Email'] . '" required autocomplete="off">
										<div class="invalid-feedback">
											Please enter a email.
										</div>
									</div>
									<br>
									<div class="form-group">
										<textarea class="form-control" rows="6" name="address" id="address" required placeholder="Recipient\'s Address">' . $patientDetail[0]['Address'] . '</textarea>
										<div class="invalid-feedback">
											Please select an address.
										</div>
									</div>
									';
								}
							} else {
								echo 
								'
								<div class="form-group">
										<input type="hidden" class="form-control" name="apptID" id="apptID" value = "0" readonly required>
										<div class="invalid-feedback">
											Please enter a name.
										</div>
										<br>
									</div>
								<div class="form-group">
									<input type="text" class="form-control" name="customerName" id="customerName" placeholder="Name of recipient" required>
									<div class="invalid-feedback">
										Please enter a name.
									</div>
								</div>
								<br>
								<div class="form-group">
									<input type="text" class="form-control" name="customerEmail" id="customerEmail" placeholder="Recipient\'s email" required autocomplete="off">
									<div class="invalid-feedback">
										Please enter a email.
									</div>
								</div>
								<br>
								<div class="form-group">
									<textarea class="form-control" rows="6" name="address" id="address" required placeholder="Recipient\'s Address"></textarea>
									<div class="invalid-feedback">
										Please select an address.
									</div>
								</div>
								';
							}
							?>
							
							<!-- <br>
							<td><select name="category" id="category" class="form-control" required autocomplete>
									<option value="0">Select CHAS type</option>
									<option value="Orange">Orange </option>
									<option value="Blue">Blue</option>
									<option value="Pink">Merdaka Generation</option>
									<option value="Red">Pioneer Generation</option>
								</select></td>
							<br> -->
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<table class="table table-bordered table-hover" id="invoiceItem1">
								<thead class="table-dark">
									<tr>
										<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
										<th width="15%">Service No</th>
										<th width="38%">Service Name</th>
										<th width="15%">Quantity</th>
										<th width="15%">Price</th>
										<th width="15%">Total</th>
									</tr>
								</thead>
								<tr>
									<td>
										<div class="itemRow1">
									</td>
									<td><input type="text" name="service_code_[]" id="service_code_1" class="form-control" autocomplete="off" oninput="GetDetail1(this.value, 1)"></td>
									<td><input type="text" name="service_type_[]" id='service_type_1' class="form-control" id='service_type_1' required readonly></input></td>
									<td><input type="number" name="serviceQuantity_[]" id="serviceQuantity_1" class="form-control price" required  autocomplete="off">
									<td><input type="number" name="price1_[]" id="price1_1" class="form-control price" readonly  autocomplete="off"></td>
									<td><input type="number" name="serviceTotal_[]" id="serviceTotal_1" readonly class="form-control price"  autocomplete="off"></td>
								</tr>

								<!-- <tr>
									<td>
										<div class="itemRow1">
									</td>
									<td><input type="text" name="service_code_2" id="service_code_2" class="form-control" autocomplete="off" readonly></td>
									<td>
										<select class="form-control" id='service_type_2' name="service_type_2" required onchange="GetDetail1(this.value,2)">
											<option value=''>Select Services</option>
										</select>
									</td>
									<td><input type="number" name="service_price" id="price1_1" class="form-control price" value="0" readonly autocomplete="off"></td>
								</tr> -->
							</table>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
								<button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
								<button class="btn btn-success" id="addRows1" type="button">+ Add</button>
							</div>
						</div>
						<div><br></div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<table class="table table-bordered table-hover" id="invoiceItem">
								<thead class="table-dark">
									<tr>
										<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
										<th width="15%">Item No</th>
										<th width="38%">Item Name</th>
										<th width="15%">Quantity</th>
										<th width="15%">Price</th>
										<th width="15%">Total</th>
									</tr>
								</thead>
								<tr>
									<td>
										<div class="itemRow">
									</td>
									<td><input type="text" value="" name="productCode[]" id="productCode_1" class="form-control" onkeyup="GetDetail(this.value, 1)" autocomplete="off">
										<div class="invalid-feedback">
											Enter 0 if nothing
										</div>
									</td>
									<td><input type="text" name="productName[]" id="productName_1" class="form-control" readonly autocomplete="off"></td>
									<td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off">
										<div class="invalid-feedback">
											Please select a quantity.
										</div>
									</td>
									<td><input type="number" name="price[]" id="price_1" class="form-control price" readonly autocomplete="off"></td>
									<td><input type="number" name="total[]" id="total_1" value="0" class="form-control total" readonly autocomplete="off"></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
							<button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
							<button class="btn btn-success" id="addRows" type="button">+ Add</button>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<h3>Notes:</h3>
							<div class="form-group">
								<textarea class="form-control txt" rows="5" name="notes" id="notes" required placeholder="Your Notes"></textarea>
								<div class="invalid-feedback">
									Enter "Nil" if none
								</div>
							</div>
							<br>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<span class="form-inline">
								<div class="form-group">
									<label>Subtotal: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">$</span>
										</div>
										<input value="" type="number" class="form-control" name="subTotal" id="subTotal" readonly placeholder="Subtotal">
									</div>
								</div>
								<div class="form-group">
									<label>Tax Rate: &nbsp;</label>
									<div class="input-group">
										<input value="0" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">%</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Tax Amount: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">$</span>
										</div>
										<input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" readonly placeholder="Tax Amount">
									</div>
								</div>
								<div class="form-group">
									<label>Total: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">$</span>
										</div>
										<input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" readonly placeholder="Total">
									</div>
								</div>
								<div class="form-group">
									<label>Amount Paid: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">$</span>
										</div>
										<input value="0" type="number" class="form-control" name="amountPaid" id="amountPaid" readonly autocomplete="off">
									</div>
								</div>
								<div class="form-group">
									<label>Amount Due: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">$</span>
										</div>
										<input value="" type="number" class="form-control" name="amountDue" id="amountDue" readonly placeholder="Amount Due">
									</div>
								</div>
							</span>
						</div>
						<input data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" value="Save Invoice" class="btn btn-success submit_btn invoice-save-btm">
					</div>
				</div>
			</form>
		</div>
	</div>
</body>




</html>

<script>
	// $(document).ready(function() {
	// 	setTimeout(function() {
	// 		$(".alert").alert('close');
	// 		<?php //unset($_SESSION['alert']); ?>
	// 	}, 3000);
	// });
</script>
<script>
	//dynamically adding of rows into the invoice product side
	var count = $(".itemRow").length;
	var count1 = $(".itemRow1").length;
	$(document).on('click', '#addRows', function() {
		count++;
		var htmlRows = '';
		htmlRows += '<thead>'
		htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
		htmlRows += '<td><input type="text" name="productCode[]" id="productCode_' + count + '" class="form-control" required onkeyup="GetDetail(this.value,' + count + ')" autocomplete="off">';
		htmlRows += '<td><input type="text" name="productName[]" id="productName_' + count + '" class="form-control" readonly autocomplete="off"></td>';
		htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count + '" class="form-control quantity"  autocomplete="off"> ';
		htmlRows += '<td><input type="number" name="price[]" id="price_' + count + '" class="form-control price" readonly autocomplete="off"></td>';
		htmlRows += '<td><input type="number" name="total[]" id="total_' + count + '" class="form-control total" readonly autocomplete="off"></td>';
		htmlRows += '</tr>';
		htmlRows += '</thead>';
		$('#invoiceItem').append(htmlRows);
	});
	$(document).on('click', '#addRows1', function() {
		count1++;
		var htmlRows = '';
		htmlRows += '<thead>'
		htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
		htmlRows += '<td><input class="form-control" type="text" name="service_code_[]" id="service_code_' + count1 + '" onkeyup="GetDetail1(this.value,' + count1 + ')" autocomplete="off"></td>';
		htmlRows += '<td><input type = "text" name="service_type_[]"class="form-control" id= "service_type_' + count1 + '"  required readonly autocomplete="off"></td>';
		htmlRows += '<td><input type="number" name="serviceQuantity_[]" id="serviceQuantity_' + count1 + '" class="form-control price" required  autocomplete="off"></td>';
		htmlRows += '<td><input type="number" name="price1_[]" id="price1_' + count1 + '" readonly class="form-control price"  autocomplete="off"></td>';
		htmlRows += '<td><input type="number" name="serviceTotal_[]" id="serviceTotal_' + count1 + '"readonly class="form-control price" autocomplete="off"></td>';

		htmlRows += '</tr>';
		htmlRows += '</thead>';
		$('#invoiceItem1').append(htmlRows);
	});
	$(document).on('click', '#removeRows', function() {
		$(".itemRow:checked").each(function() {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
		calculateTotal();
	});
	$(document).on('blur', "#taxRate", function() {
		calculateTotal();
	});

	$(document).on('blur', "[id^=quantity_]", function() {
		calculateTotal();
	});
	$(document).on('blur', "[id^=price_]", function() {
		calculateTotal();
	});

	$(document).on('blur', "[id^=price1_]", function() {
		calculateTotal();
	});
	$(document).on('blur', "[id^=serviceQuantity_]", function() {
		calculateTotal();
	});

	$(document).on('blur', "#service_type", function() {
		calculateTotal();
	});
	
	
	$(document).on('blur', "#amountPaid", function() {
		var amountPaid = $(this).val();
		var totalAftertax = $('#totalAftertax').val();
		if (amountPaid && totalAftertax) {
			totalAftertax = totalAftertax - amountPaid;
			$('#amountDue').val(totalAftertax);
		} else {
			$('#amountDue').val(totalAftertax);
		}
	});


	function calculateTotal() {
		var totalAmount = 0;
		var totalAmount1 = 0;
		var totalAmountbot = 0;
		var price1 = 0;
		var totalAmounttop = 0;
		$("[id^='price_']").each(function() {
			var id = $(this).attr('id');
			id = id.replace("price_", '');
			var price = $('#price_' + id).val();
			var quantity = $('#quantity_' + id).val();
			if (!quantity) {
				quantity = 1;
			}
			var total = price * quantity;
			$('#total_' + id).val(parseFloat(total));
			totalAmountbot += total

		});
		$("[id^='price1_']").each(function() {
			var id1 = $(this).attr('id');
			id1 = id1.replace("price1_", '');
			price1 = $('#price1_' + id1).val();
			var quantity = $('#serviceQuantity_' + id1).val();
			var total1 = price1 * quantity;
			$('#serviceTotal_' + id1).val(parseFloat(total1));
			totalAmounttop += total1;
		});


		var allTotal = parseFloat(totalAmountbot) + parseFloat(totalAmounttop)
		$('#subTotal').val(parseFloat(allTotal));
		var taxRate = $("#taxRate").val();
		var subTotal = $('#subTotal').val();
		if (subTotal) {
			var taxAmount = subTotal * taxRate / 100;
			$('#taxAmount').val(taxAmount);
			subTotal = parseFloat(subTotal) + parseFloat(taxAmount);
			$('#totalAftertax').val(subTotal);
			var amountPaid = $('#amountPaid').val();
			var totalAftertax = $('#totalAftertax').val();
			if (amountPaid && totalAftertax) {
				totalAftertax = totalAftertax - amountPaid;
				$('#amountPaid').val(amountPaid);
				$('#amountDue').val(totalAftertax);
			} else {
				$('#amountDue').val(subTotal);
			}
		}
	}
	//send product_id to invoice_automate and retrieve the product_name and product_price
	function GetDetail(str, value) {
		if (str.length == 0) {
			document.getElementById("productName_" + value + "").value = "";
			document.getElementById("price_" + value + "").value = "";
			return;
		} else {

			// Creates a new XMLHttpRequest object
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {

				// Defines a function to be called when
				// the readyState property changes
				if (this.readyState == 4 &&
					this.status == 200) {

					// Typical action to be performed
					// when the document is ready
					var myObj = JSON.parse(this.responseText);

					// Returns the response data as a
					// string and store this array in
					// a variable assign the value 
					// received to first name input field

					document.getElementById("productName_" + value + "").value = myObj[0];

					// Assign the value received to
					// last name input field
					document.getElementById(
						"price_" + value + "").value = myObj[1];
				}
			};
			var company = '<?php echo $_SESSION['Company'];?>';
			// xhttp.open("GET", "filename", true);
			xmlhttp.open("GET", "invoice_automate.php?product_id=" + str + "&company=" + company, true);

			// Sends the request to the server
			xmlhttp.send();
		}
	}
	//send service_type to service_automate.php and retrieve the price and code of the service
	function GetDetail1(str, value) {
		if (str.length == 0) {
			document.getElementById("service_code_" + value + "").value = "";

		} else {

			// Creates a new XMLHttpRequest object
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {

				// Defines a function to be called when
				// the readyState property changes
				if (this.readyState == 4 &&
					this.status == 200) {

					// Typical action to be performed
					// when the document is ready
					var myObj = JSON.parse(this.responseText);

					// Returns the response data as a
					// string and store this array in
					// a variable assign the value 
					// received to first name input field

					document.getElementById("price1_" + value + "").value = myObj[0];
					document.getElementById("service_type_" + value + "").value = myObj[1];
				}
			};

			// xhttp.open("GET", "filename", true);
			xmlhttp.open("GET", "service_automate.php?serviceCode=" + str, true);

			// Sends the request to the server
			xmlhttp.send();
		}
	}

	function refreshPage() {
		window.location.reload();
	}
	</script>
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
<script>
	// //post id to load_products.php and retrieve Service_Type from db
	// $(document).ready(function() {
	// 	$("#category").change(function() {

	// 		var cid = $(this).val();
	// 		$.ajax({
	// 			url: 'load_products.php',
	// 			type: 'post',
	// 			data: {
	// 				id: cid
	// 			},
	// 			success: function(res) {
	// 				$("#service_type_1").html(res);
	// 			}
	// 		});
	// 	});
	// });
</script>

</html>