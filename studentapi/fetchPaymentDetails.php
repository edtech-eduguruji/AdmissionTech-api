<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();


$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case "GET":
        $registrationNo = $_GET['registrationNo'];
        $receipt = $_GET['receipt'];

        echo json_encode(fetchPayment($registrationNo, $receipt, $con));
        
        $dbConnection->closeConnection();
        break;

    case "POST":
        $registrationNo = $_GET['registrationNo'];
        break;
}