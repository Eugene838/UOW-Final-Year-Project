<?php
// include 'db_connection.php';
class Invoice
{
	private $invoiceOrderTable = 'invoice_order';
	private $invoiceOrderItemTable = 'invoice_order_item';
	private $dbConnect = false;
	public function __construct()
	{
		if (!$this->dbConnect) {
			//Localhost database connection settings
			//$conn = new mysqli('127.0.0.1', 'root', "", "dentianDatabase");

			//Google database connection settings
			$conn = new mysqli('34.87.94.119', 'root', "r00tD3ntian@22", "dentianDatabase");
			
			if ($conn->connect_error) {
				die("Error failed to connect to MySQL: " . $conn->connect_error);
			} else {
				$this->dbConnect = $conn;
			}
		}
	}
	private function getData($sqlQuery)
	{
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			die('Error in query: ' . mysqli_error($sqlQuery));
		}
		$data = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}
	private function getNumRows($sqlQuery)
	{
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			die('Error in query: ' . mysqli_error($sqlQuery));
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}

	public function saveInvoice($POST, $company)
	{
		$sqlInsert = "
			INSERT INTO " . $this->invoiceOrderTable . "(order_receiver_name, appt_id, Email, order_receiver_address, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, order_total_amount_due, company ,note) 
			VALUES (\"" . $POST['customerName'] . "\",\"" . $POST['apptID'] . "\",\"" . $POST['customerEmail'] . "\", \"" . $POST['address'] . "\", '" . $POST['subTotal'] . "', '" . $POST['taxAmount'] . "', '" . $POST['taxRate'] . "', '" . $POST['totalAftertax'] . "', '" . $POST['amountPaid'] . "', '" . $POST['amountDue'] . "', \"" . $company . "\",'" . $POST['notes'] . "')";
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);

		for ($i = 0; $i < count($POST['service_code_']); $i++) { {
		$sqlInsertItem = "
			INSERT INTO " . $this->invoiceOrderItemTable . "(order_id, item_code, item_name, order_item_price, order_item_final_amount) 
			VALUES ('" . $lastInsertId . "', '" . $POST['service_code_'][$i] . "', '" . $POST['service_type_'][$i] . "' , '" . $POST['price1_'][$i] . "', '" . $POST['price1_'][$i] . "')";
		mysqli_query($this->dbConnect, $sqlInsertItem);
		}
	}
		for ($i = 0; $i < count($POST['productCode']); $i++) { {
				$sqlInsertItem1 = "
			INSERT INTO " . $this->invoiceOrderItemTable . "(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount) 
			VALUES ('" . $lastInsertId . "', '" . $POST['productCode'][$i] . "', '" . $POST['productName'][$i] . "', '" . $POST['quantity'][$i] . "', '" . $POST['price'][$i] . "', '" . $POST['total'][$i] . "')";
				mysqli_query($this->dbConnect, $sqlInsertItem1);
			}
		}
	}


	public function updateInvoice($POST)
	{
		if ($POST['invoiceId']) {
			$sqlInsert = "
				UPDATE " . $this->invoiceOrderTable . " 
				SET order_receiver_name = \"" . $POST['customerName'] . "\",Email=\"" . $POST['Email'] . "\", order_receiver_address= \"" . $POST['customerAddress'] . "\", order_total_before_tax = '" . $POST['subTotal'] . "', order_total_tax = '" . $POST['taxAmount'] . "', order_tax_per = '" . $POST['taxRate'] . "', order_total_after_tax = '" . $POST['totalAftertax'] . "', order_amount_paid = '" . $POST['amountPaid'] . "', order_total_amount_due = '" . $POST['amountDue'] . "', note = '" . $POST['notes'] . "' 
				WHERE order_id = '" . $POST['invoiceId'] . "'";
			mysqli_query($this->dbConnect, $sqlInsert);
		}
	}
	public function getInvoiceList($company)
	{
		$sqlQuery = "
			SELECT * FROM " . $this->invoiceOrderTable . "
			WHERE Company = \"" . $company . "\" ";
		// print_r($sqlQuery);
		return  $this->getData($sqlQuery);
	}
	public function getInvoice($invoiceId)
	{
		$sqlQuery = "
			SELECT * FROM " . $this->invoiceOrderTable . " 
			WHERE order_id = '$invoiceId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}
	public function getInvoiceItems($invoiceId)
	{
		$sqlQuery = "
			SELECT * FROM " . $this->invoiceOrderItemTable . " 
			WHERE order_id = '$invoiceId'";
		return  $this->getData($sqlQuery);
	}
	public function deleteInvoiceItems($invoiceId)
	{
		$sqlQuery = "
			DELETE FROM " . $this->invoiceOrderItemTable . " 
			WHERE order_id = '" . $invoiceId . "'";
		mysqli_query($this->dbConnect, $sqlQuery);
	}
	public function deleteInvoice($invoiceId)
	{
		$sqlQuery = "
			DELETE FROM " . $this->invoiceOrderTable . " 
			WHERE order_id = '" . $invoiceId . "'";
		mysqli_query($this->dbConnect, $sqlQuery);
		$this->deleteInvoiceItems($invoiceId);
		return 1;
	}
}
