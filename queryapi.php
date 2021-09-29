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

        echo getQueryApi($requestType, $transactionId, $time);
        break;
}