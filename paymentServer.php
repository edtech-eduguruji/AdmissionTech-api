<?php

require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');

error_log("----------------------------------------------------------------");
$data = $_POST['msg'];
error_log("PS: " . $data);

$myArray = explode('|', $data);
$countVal = count($myArray);

$billdesk_checksum = $myArray[$countVal-1];
$billdesk_checksum = trim($billdesk_checksum);
array_splice($myArray, $countVal-1, $countVal);
$str = implode('|', $myArray);

$gen_checksum = createCheckSum($str);
$gen_checksum = trim($gen_checksum);

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
    $TxnAmount = ltrim($myArray[4], "0");
    $BankID = $myArray[5];
    $BIN = $myArray[6];
    $TxnTypeCode = $myArray[7];
    $TxnDate = $myArray[13];
    $AuthStatusCode = $myArray[14];
    $PaymentFacultyId = $myArray[16];
    $registrationNo = $myArray[17];
    $courseFee = $myArray[18];
    $errorCode = $myArray[22];
    $errorDescription = $myArray[23];

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

//Time entry
date_default_timezone_set('Asia/Kolkata');
$creationTime = getCurrentTime();

if(strcmp($billdesk_checksum, $gen_checksum)==0) {
    
    $sql_query1 = "UPDATE payment set TxnReferenceNo='$TxnReferenceNo', BankReferenceNo='$BankReferenceNo', BankID='$BankID', 
    Bin='$BIN', TxnAmount='$TxnAmount', TxnCode='$TxnTypeCode', TxnType='$transTypeArray[$TxnTypeCode]', TxnDate='$TxnDate', 
    AuthStatusCode='$AuthStatusCode', AuthMsg='$authStatusArray[$AuthStatusCode]', creationTime='$creationTime', checksum='$data',  
    courseFee='$courseFee' where registrationNo='$registrationNo' and paymentId='$UniqueTxnID' ";

    mysqli_query($con, $sql_query1);
    
    if($AuthStatusCode == "0300") {
        $sql_query2 = "UPDATE basic_details SET payment='1', courseFee='$courseFee' WHERE registrationNo='$registrationNo'";
        mysqli_query($con, $sql_query2);
    }
} else {
    $sql_query1 = "INSERT INTO payment (registrationNo, paymentId, TxnReferenceNo, BankReferenceNo, BankID, Bin, TxnAmount, 
    TxnCode, TxnType, TxnDate, AuthStatusCode, AuthMsg, creationTime, checksum) 
    VALUES ('$registrationNo', '$UniqueTxnID', '$TxnReferenceNo', '$BankReferenceNo', '$BankID', '$BIN', '$TxnAmount', 
    '$TxnTypeCode', '$transTypeArray[$TxnTypeCode]', '$TxnDate', '$errorCode', '$errorDescription', '$creationTime', '$data' )";
    
    mysqli_query($con, $sql_query1);
}
error_log("----------------------------------------------------------------");

$dbConnection->closeConnection();