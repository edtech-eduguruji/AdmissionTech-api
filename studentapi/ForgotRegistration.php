<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$phone = $_GET['phone'];
$dob = $_GET['dob'];

$sql_query = "SELECT registrationNo from basic_details WHERE personalMobile = '$phone' AND dob = '$dob'";

$result = mysqli_query($con, $sql_query);

if (mysqli_num_rows($result) > 0) {
    echo json_encode(mysqli_fetch_assoc($result));
} else {
    header(' 500 Internal Server Error', true, 500);
}
$dbConnection->closeConnection();
