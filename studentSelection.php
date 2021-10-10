<?php

require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();
$jwt = $dbConnection->getUserData("Authentication");


$isTokenValid = verifyToken($jwt);
if ($isTokenValid) {
    $data = array();
    $registrationNo = $_POST['registrationNo'];
    $value = $_POST['value'];

    $check = "SELECT registrationNo FROM basic_details 
    WHERE courseFee = '1' AND selection = '1' AND 
    registrationNo = '$registrationNo' ";

    $result = mysqli_query($con, $check);

    if (mysqli_num_rows($result) === 0) {
        $query = "UPDATE basic_details SET selection = '$value' WHERE registrationNo = '$registrationNo'";
        if (mysqli_query($con, $query)) {
            $data = ['isError' =>  false, 'Response' => "SUCCESS"];
        } else {
            $data = ['isError' => true, 'Response' => "ERROR"];
            header(' 500 Internal Server Error', true, 500);
        }
    } else {
        $data = ['isError' => true, 'Response' => "Student already paid the course fee. You cannot disable the selection."];
    }
} else {
    $data = ['isError' => true, "Response" => "Invalid Token"];
    header('HTTP/1.0 401 Unauthorized');
}
echo json_encode($data);
$dbConnection->closeConnection();
