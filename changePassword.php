<?php

require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();
$userId = $dbConnection->getUserData("Authorization");
$jwt = $dbConnection->getUserData("Authentication");

$isTokenValid = verifyToken($jwt);
if ($isTokenValid) {
    if (isset($_POST['oldPassword'])) {
        $oldPassword = $_POST['oldPassword'];
        $password = $_POST['password'];

        $sql_query = "SELECT * FROM users_info WHERE user_id = '$userId' AND password = '$oldPassword'";
        $result = mysqli_query($con, $sql_query);

        if (mysqli_num_rows($result) > 0) {
            $query = "UPDATE users_info SET password = '$password' WHERE user_id = '$userId'";
            if (mysqli_query($con, $query)) {
                $data = array('isError' => false, 'Message' =>  "Password Changed Successfully");
            } else {
                $data = array('isError' => true, 'Message' =>  "500 Internal Server Error");
            }
        } else {
            $data = array('isError' => true, 'Message' =>  "Old Password You Entered Is Incorrect");
        }
    } else {
        $data = array('isError' => true, 'Message' =>  "Please Enter Your Old Password");
    }
} else {
    header('HTTP/1.0 401 Unauthorized');
}
echo json_encode($data);
$dbConnection->closeConnection();
