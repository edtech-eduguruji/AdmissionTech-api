<?php

// $headers =  getallheaders();
// foreach($headers as $key=>$val){
//   echo $key . ': ' . $val . '<br>';
// }
// echo json_encode($_SERVER);


include_once('utils.php');

$msg = $_POST['msg'];

date_default_timezone_set('Asia/Kolkata');
$date = date('YmdHms', time());

// $str = "0122|CNBAGRACOL|565884a-3-0062-b14f-38754747da4|".$date;
// $checksum = createCheckSum($str);
// $postfields = [
//     "msg"=> $str.'|'.$checksum
//     ];

$postfields = ["msg"=> $msg];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://uat.billdesk.com/pgidsk/PGIQueryController");
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