<?php

require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');
include_once('checksum.php');

$data = $_POST['msg'];
$myArray = explode('|', $data);
$countVal = count($myArray);

$billdesk_checksum = $myArray[$countVal-1];
array_splice($myArray, $countVal-1, $countVal);
$str = implode('|', $myArray);
//echo $str;

$gen_checksum = createCheckSum($str);

// MerchantID|UniqueTxnID|TxnReferenceNo|BankReferenceNo|TxnAmount|BankID|BIN|TxnT
// ype|CurrencyName|ItemCode|SecurityType|SecurityID|SecurityPassword|TxnDate|AuthStat
// us|SettlementType|AdditionalInfo1|AdditionalInfo2|AdditionalInfo3|AdditionalInfo4|Addition
// alInfo5|AdditionalInfo6|AdditionalInfo7|ErrorStatus|ErrorDescription|CheckSum

$transTypeArray = array('01'=>'Netbanking',
    '02'=>'Credit Card',   
    '03'=>'Debit Card',
    '04'=>'Cash Card',
    '05'=>'Mobile Wallet',
    '06'=>'IMPS',
    '07'=>'Reward Points',
    '08'=>'Rupay',
    '09'=>'Others',
    '10'=>'UPI');    
    
    // Type Transaction
    
    $authStatusArray = array( 
        '0300'=>'Success',
        '0399'=>'Failure',
        'NA'=>'Failure',
        '0002'=>'Pending',
        '0001'=>'Failure');

    $UniqueTxnID = $myArray[1];
    $TxnReferenceNo = $myArray[2];
    $BankReferenceNo = $myArray[3];
    $TxnAmount = substr($myArray[4],5,strlen($myArray[4]));
    $BankID = $myArray[5];
    $BIN = $myArray[6];
    $TxnTypeCode = $myArray[7];
    $TxnDate = $myArray[13];
    $AuthStatusCode = $myArray[14];
    $PaymentFacultyId = $myArray[16];
    $registrationNo = $myArray[17];
    $errorCode = $myArray[22];
    $errorDescription = $myArray[23];

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

//Time entry
date_default_timezone_set('Asia/Kolkata');
$creationTime = getCurrentTime();

if($billdesk_checksum==$gen_checksum) {
    $sql_query1 = "INSERT INTO payment (registrationNo, paymentId, TxnReferenceNo, BankReferenceNo, BankID, Bin, TxnAmount, 
    TxnCode, TxnType, TxnDate, AuthStatusCode, AuthMsg, creationTime, checksum) 
    VALUES ('$registrationNo', '$UniqueTxnID', '$TxnReferenceNo', '$BankReferenceNo', '$BankID', '$BIN', '$TxnAmount', 
    '$TxnTypeCode', '$transTypeArray[$TxnTypeCode]', '$TxnDate', '$AuthStatusCode', '$authStatusArray[$AuthStatusCode]', 
    '$creationTime', '$data')";

    mysqli_query($con, $sql_query1);
    
    if($AuthStatusCode == "0300") {
        $sql_query2 = "UPDATE basic_details SET payment='1' WHERE registrationNo='$registrationNo'";
        mysqli_query($con, $sql_query2);
    }
} else {
    $sql_query1 = "INSERT INTO payment (registrationNo, paymentId, TxnReferenceNo, BankReferenceNo, BankID, Bin, TxnAmount, 
    TxnCode, TxnType, TxnDate, AuthStatusCode, AuthMsg, creationTime, checksum) 
    VALUES ('$registrationNo', '$UniqueTxnID', '$TxnReferenceNo', '$BankReferenceNo', '$BankID', '$BIN', '$TxnAmount', 
    '$TxnTypeCode', '$transTypeArray[$TxnTypeCode]', '$TxnDate', '$errorCode', '$errorDescription', '$creationTime', '$data' )";
    
    mysqli_query($con, $sql_query1);
}

$dbConnection->closeConnection();