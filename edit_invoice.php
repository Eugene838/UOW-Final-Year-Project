<?php
include 'Navbar.php';
include 'Invoice.php';

$invoice = new Invoice();
if (!empty($_POST['customerName']) && $_POST['customerName'] && !empty($_POST['invoiceId']) && $_POST['invoiceId']) {
	$invoice->updateInvoice($_POST);
	if ($_POST) {
		$_SESSION['alert'] = '<div class="alert alert-success" role="alert-msg" id="alert">Invoice has been updated! <i class="bi bi-receipt"></i></div>';
		// echo '<meta http-equiv="refresh" content="1">';
		// echo "<span class='d-block p-2 bg-success text-white text-center'>Record successfully created!</span>";
		// return true;
	} else {
		$_SESSION['alert'] = '<div class="alert alert-danger" role="alert">Error! Unable to create invoice. <i class="bi bi-exclamation-circle"></i></div>';
	}
}
if (!empty($_GET['update_id']) && $_GET['update_id']) {
	$invoiceValues = $invoice->getInvoice($_GET['update_id']);
	$invoiceItems = $invoice->getInvoiceItems($_GET['update_id']);
}
?>
<style>
	body {
		background-image: url('img/AdminBackground.png');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-size: cover;
	}
</style>
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
</style>
<html>

<body>
	<title>Edit Invoice</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<div id="content-wrapper" class="content-wrapper">
		<?php
		if (isset($_SESSION['alert'])) {
			echo $_SESSION['alert'];
		}
		?>
		<div class="container content-invoice">
			<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
				<div class="container-fluid col-12 mt-4 mb-4 bg-light">
					<input id="currency" type="hidden" value="$">
					<div class="row">
						<div class="col-xs-12">
							<h3>Recipient</h3>
							<div class="form-group">
								<input value="<?php echo $invoiceValues['order_receiver_name']; ?>" type="text" class="form-control" readonly name="customerName" id="customerName" placeholder="Company Name" autocomplete="off">
							</div>
							<br>
							<div class="form-group">
								<input value="<?php echo $invoiceValues['Email']; ?>" type="text" class="form-control" name="Email" id="Email" placeholder="Email" autocomplete="off">
							</div>
							<br>
							<div class="form-group">
								<textarea class="form-control" rows="5" name="customerAddress" id="customerAddress" readonly placeholder="Your Address"><?php echo $invoiceValues['order_receiver_address']; ?></textarea>
							</div>
							<br>
						</div>
					</div>
					<br>
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
								<?php
								$count = 0;
								foreach ($invoiceItems as $invoiceItem) {
									$count++;
								?>
									<tr>
										<td><input class="itemRow" type="checkbox"></td>
										<td><input type="text" value="<?php echo $invoiceItem["item_code"]; ?>" name="productCode[]" id="productCode_<?php echo $count; ?>" readonly class="form-control" autocomplete="off"></td>
										<td><input type="text" value="<?php echo $invoiceItem["item_name"]; ?>" name="productName[]" id="productName_<?php echo $count; ?>" readonly class="form-control" autocomplete="off"></td>
										<td><input type="number" value="<?php echo $invoiceItem["order_item_quantity"]; ?>" name="quantity[]" id="quantity_<?php echo $count; ?>" readonly class="form-control quantity" autocomplete="off"></td>
										<td><input type="number" value="<?php echo $invoiceItem["order_item_price"]; ?>" name="price[]" id="price_<?php echo $count; ?>" readonly class="form-control price" autocomplete="off"></td>
										<td><input type="number" value="<?php echo $invoiceItem["order_item_final_amount"]; ?>" name="total[]" id="total_<?php echo $count; ?>" readonly class="form-control total" autocomplete="off"></td>
										<input type="hidden" value="<?php echo $invoiceItem['order_item_id']; ?>" class="form-control" name="itemId[]">
									</tr>
								<?php } ?>
							</table>
						</div>
					</div>
					<div class="row">
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<h3>Notes: </h3>
							<div class="form-group">
								<textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Your Notes"><?php echo $invoiceValues['note']; ?></textarea>
							</div>
							<br>
							<div class="form-group">
								<input type="hidden" value="<?php echo $invoiceValues['order_id']; ?>" class="form-control" name="invoiceId" id="invoiceId">

							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<span class="form-inline">
								<div class="form-group">
									<label>Subtotal: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">$</span>
										</div>
										<input value="<?php echo $invoiceValues['order_total_before_tax']; ?>" type="number" class="form-control" name="subTotal" id="subTotal" readonly placeholder="Subtotal">
									</div>
								</div>
								<div class="form-group">
									<label>Tax Rate: &nbsp;</label>
									<div class="input-group">
										<input value="<?php echo $invoiceValues['order_tax_per']; ?>" type="number" class="form-control" name="taxRate" id="taxRate" readonly placeholder="Tax Rate">
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
										<input value="<?php echo $invoiceValues['order_total_tax']; ?>" type="number" class="form-control" name="taxAmount" id="taxAmount" readonly placeholder="Tax Amount">
									</div>
								</div>
								<div class="form-group">
									<label>Total: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">$</span>
										</div>
										<input value="<?php echo $invoiceValues['order_total_after_tax']; ?>" type="number" class="form-control" name="totalAftertax" readonly id="totalAftertax" placeholder="Total">
									</div>
								</div>
								<div class="form-group">
									<label>Amount Paid: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">$</span>
										</div>
										<input value="<?php echo $invoiceValues['order_amount_paid']; ?>" type="number" class="form-control" name="amountPaid" id="amountPaid" readonly placeholder="Amount Paid">
									</div>
								</div>
								<div class="form-group">
									<label>Amount Due: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">$</span>
										</div>
										<input value="<?php echo $invoiceValues['order_total_amount_due']; ?>" type="number" class="form-control" name="amountDue" id="amountDue" readonly placeholder="Amount Due">
									</div>
								</div>

							</span>

						</div>
						<input data-loading-text="Updating Invoice..." type="submit" name="invoice_btn" value="Save Invoice" class="btn btn-success submit_btn invoice-save-btm">

					</div>

					<div class="clearfix"></div>

				</div>

			</form>
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