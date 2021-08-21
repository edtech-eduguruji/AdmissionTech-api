<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$registrationNo = $_GET['registrationNo'];
$sql_query = "SELECT * from payment WHERE registrationNo='$registrationNo'";
$result = mysqli_query($con, $sql_query);

if (mysqli_num_rows($result) > 0) {
    $response = array(mysqli_fetch_assoc($result));
    echo json_encode($response);
}
$dbConnection->closeConnection();
