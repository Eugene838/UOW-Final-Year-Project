<?php
include "db_connection.php";
// Get the user id
$serviceName = $_REQUEST['serviceCode'];
$db = new DB_Connect();
if ($serviceName !== "") {

	// Get corresponding first name and
	// last name for that user id
	$stmt = $db->connect()->prepare("SELECT Service_Name, Price FROM dental_services WHERE Service_ID=?");
	$stmt->execute([$serviceName]);
	if ($stmt->rowCount() > 0) {
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


	$Price = $row[0]["Price"];

	
    $serviceName = $row[0]["Service_Name"];
}

// Store it in a array
$result = array("$Price", "$serviceName");

// Send in JSON encoded form
$myJSON = json_encode($result);
echo $myJSON;
?>