<?php

// $headers =  getallheaders();
// foreach($headers as $key=>$val){
//   echo $key . ': ' . $val . '<br>';
// }
// echo json_encode($_SERVER);
include_once('utils.php');
require('AppHeaders.php');
include_once('DBConnection.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();


$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case "GET":
        $registrationNo = $_GET['registrationNo'];
        $array = fetchPayment($registrationNo, '0', $con);

        date_default_timezone_set('Asia/Kolkata');
        $time = date('YmdHms', time());

        $response = array();
        foreach($array as $item) {
            $paymentId = $item['paymentId'];
            $str = getQueryApi('0122', $paymentId, $time);
            $response[$paymentId] = updatePayment($str, $item['registrationNo'], $item['paymentId'], $con);
        }
        echo json_encode($response);
        $dbConnection->closeConnection();
        break;

    case "POST":
        $requestType = $_POST['requestType'];
        $transactionId = $_POST['transactionId'];
        $time = $_POST['time'];
        $updateForm = $_POST['updateForm'];
        $registrationNo = $_POST['registrationNo'];

        if($updateForm == '0') {
            echo getQueryApi($requestType, $transactionId, $time);
        } else if($updateForm == '1'){
            echo json_encode($_POST);
            $academicDetails = json_decode($_POST['academicDetails'], true);
            $academicDetails = json_encode($academicDetails);

            $sql3 = "UPDATE academic_details SET academicDetails='$academicDetails' WHERE registrationNo='$registrationNo'";
            $con->query($sql3);
            $dbConnection->closeConnection();
        }

        break;
}