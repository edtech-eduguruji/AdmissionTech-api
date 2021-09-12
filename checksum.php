<?php
require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');


$db = parse_ini_file(dirname(__DIR__) . "/api/DbProperties.ini");

$userId = $_POST['userId'];
$responseUrl = ['responseUrl'];
$account = $_POST=['account'];
$amount = $_POST=['amount'];

$txnId = uniqid();
$str = $db['MERCHANTID'].'|'.$txnId.'|${na}|'.$amount.'|${na}|${na}|${na}|INR|NA|R|'.$db['SECURITYID'].'|${na}|${na}|F|'.$account.'|'.$userId.'|${na}|${na}|${na}|${na}|${na}|'.$responseUrl;
$checkSumVal = createCheckSum($str);

//Time entry
date_default_timezone_set('Asia/Kolkata');
$creationTime = getCurrentTime();


$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

//insert into db to log all payment entry
$sql = "INSERT INTO payment (registrationNo, paymentId, creationTime) VALUES ('$userId', '$txnId', '$creationTime')";
$con->query($sql);

echo $str.'|'.$checkSumVal;