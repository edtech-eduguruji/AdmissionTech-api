<?php

// $headers =  getallheaders();
// foreach($headers as $key=>$val){
//   echo $key . ': ' . $val . '<br>';
// }
// echo json_encode($_SERVER);

include_once('utils.php');

// date_default_timezone_set('Asia/Kolkata');
// $date = date('YmdHms', time());

$requestType = $_POST['requestType'];
$transactionId = $_POST['transactionId'];
$time = $_POST['time'];

echo getQueryApi($requestType, $transactionId, $time);