<?php
include "db_connection.php";
// Get the user id
$product_id = $_REQUEST['product_id'];
$company = $_REQUEST['company'];
$db = new DB_Connect();
if ($product_id !== "") {
	
	// Get corresponding first name and
	// last name for that user id	
	$stmt = $db->connect()->prepare("SELECT product_name,product_price FROM product_table WHERE product_id=? AND Company=?");
	$stmt->execute([$product_id,$company]);
	if ($stmt->rowCount() > 0) {
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// Get the first name
	$first_name = $row[0]["product_name"];

	// Get the first name
	$last_name = $row[0]["product_price"];
}

// Store it in a array
$result = array("$first_name", "$last_name");

// Send in JSON encoded form
$myJSON = json_encode($result);
echo $myJSON;
?>