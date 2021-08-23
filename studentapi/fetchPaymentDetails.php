<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$registrationNo = $_GET['registrationNo'];

$sql_query = "SELECT payment.*, basic_details.submitted,basic_details.payment,users_info.user_id,users_info.user_name,
users_info.password,users_info.role,users_info.active FROM users_info 
INNER JOIN basic_details ON users_info.user_id = basic_details.registrationNo 
INNER JOIN payment ON payment.registrationNo = basic_details.registrationNo 
WHERE payment.registrationNo='$registrationNo' and AuthStatusCode='300' ";

$result = mysqli_query($con, $sql_query);

if (mysqli_num_rows($result) > 0) {
    $response = array(mysqli_fetch_assoc($result));
    echo createToken($response);
}
$dbConnection->closeConnection();
