<?php
include 'db_connection.php';

$famNRIC = $_GET['fNRIC'];
$famPhone = $_GET['fPhone'];

$db = new DB_Connect();
$stmt = $db->connect()->prepare("SELECT Family_ID from patient_profile WHERE NRIC_PNum = '$famNRIC' AND Phone_Num = '$famPhone'");
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $famID = $stmt->fetch()[0];
    echo $famID;
} else {
    echo "ERROR";
}

?>