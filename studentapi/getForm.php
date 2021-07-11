<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$registrationNo = $_GET['registrationNo'];

$sql_query = "SELECT * from basic_details 
INNER JOIN advanced_details ON basic_details.registrationNo = advanced_details.registrationNo 
INNER JOIN academic_details ON basic_details.registrationNo = academic_details.registrationNo 
INNER JOIN documents ON basic_details.registrationNo = documents.registrationNo 
INNER JOIN merit_details ON basic_details.registrationNo = merit_details.registrationNo 
where basic_details.registrationNo='$registrationNo'";

// -- INNER JOIN payment ON basic_details.registrationNo = payment.registrationNo 

$result = mysqli_query($con, $sql_query);
$response = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $response = $row;
    }
}

$dbConnection->closeConnection();
echo json_encode($response);