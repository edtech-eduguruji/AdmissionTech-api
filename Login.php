<?php
require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$username = $_GET['username'];
$password = $_GET['password'];

$sql = "SELECT * FROM users_info WHERE user_name='$username' AND password='$password' AND active = 1 ";
$result = $con->query($sql);
$count = mysqli_num_rows($result);
$response = array();

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['role'] == "Admin") {
            $row['fullname'] = "Admin";
        }
        array_push($response, $row);
    }
    echo json_encode($response);
} else {
    header(' 500 Internal Server Error', true, 500);
}
