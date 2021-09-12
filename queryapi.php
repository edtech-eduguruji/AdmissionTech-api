<?php

// $headers =  getallheaders();
// foreach($headers as $key=>$val){
//   echo $key . ': ' . $val . '<br>';
// }
// echo json_encode($_SERVER);

include_once('utils.php');
$db = parse_ini_file(dirname(__DIR__) . "/api/DbProperties.ini");

date_default_timezone_set('Asia/Kolkata');
$date = date('YmdHms', time());

$requestType = $_POST['requestType'];
$transactionId = $_POST['transactionId'];
$time = $_POST['time'];

$str = $requestType.'|'.$db['MERCHANTID'].'|'.$transactionId.'|'.$time;
$checkSumVal = createCheckSum($str);

$msg = $str.'|'.$checkSumVal;

$postfields = ["msg"=> $msg];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.billdesk.com/pgidsk/PGIQueryController");
// curl_setopt($ch, CURLOPT_URL,"https://eduguruji.com/admission/api/queryapi.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));

// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));

// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
curl_close ($ch);

echo $server_output;