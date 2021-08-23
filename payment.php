<?php

require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');
$db = parse_ini_file(dirname(__DIR__) . "/api/DbProperties.ini");

$data = $_POST['msg'];
$myArray = explode('|', $data);
$countVal = count($myArray);

$billdesk_checksum = $myArray[$countVal-1];

array_splice($myArray, $countVal-1, $countVal);
//

$str = implode('|', $myArray);
//echo $str;

$gen_checksum = hash_hmac('sha256',$str, $db['checksum'] , false);
$gen_checksum = strtoupper($gen_checksum);

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
    '0300'=>'Success Transaction',
    '0399'=>'Invalid Authentication at Bank Failure Transaction',
    'NA'=>'Invalid Input in the Request Message Failure Transaction',
    '0002'=>'BillDesk is waiting for Response from Bank Pending Transaction',
    '0001'=>'Error at BillDesk');

    $UniqueTxnID = $myArray[1];
    $TxnReferenceNo = $myArray[2];
    $BankReferenceNo = $myArray[3];
    $TxnAmount = $myArray[4];
    $BankID = $myArray[5];
    $BIN = $myArray[6];
    $TxnTypeCode = $myArray[7];
    $TxnDate = $myArray[13];
    $AuthStatusCode = $myArray[14];
    $PaymentFacultyId = $myArray[16];
    $registrationNo = $myArray[17];

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

//Time entry
date_default_timezone_set('Asia/Kolkata');
$creationTime = getCurrentTime();
$jwt = null;

if($billdesk_checksum==$gen_checksum) {
    $sql_query1 = "INSERT INTO payment (registrationNo, paymentId, TxnReferenceNo, BankReferenceNo, BankID, Bin, TxnAmount, 
    TxnCode, TxnType, TxnDate, AuthStatusCode, AuthMsg, creationTime) 
    VALUES ('$registrationNo', '$UniqueTxnID', '$TxnReferenceNo', '$BankReferenceNo', '$BankID', '$BIN', '$TxnAmount', 
    '$TxnTypeCode', '$transTypeArray[$TxnTypeCode]', '$TxnDate', '$AuthStatusCode', '$authStatusArray[$AuthStatusCode]', '$creationTime')";

    mysqli_query($con, $sql_query1);
    
    if($AuthStatusCode == "0300") {
        $sql_query2 = "UPDATE basic_details SET payment='1' WHERE registrationNo='$registrationNo'";
        mysqli_query($con, $sql_query2);

        $sql_query3 = "SELECT payment.*, basic_details.submitted,basic_details.payment,users_info.user_id,users_info.user_name,
        users_info.password,users_info.role,users_info.active FROM users_info 
        INNER JOIN basic_details ON users_info.user_id = basic_details.registrationNo 
        INNER JOIN payment ON payment.registrationNo = basic_details.registrationNo 
        WHERE payment.registrationNo='$registrationNo' and AuthStatusCode='300' ";

        $result = mysqli_query($con, $sql_query3);

        if (mysqli_num_rows($result) > 0) {
            $response = array(mysqli_fetch_assoc($result));
            $jwt = createToken($response);
        }
    }
} else {
    $sql_query1 = "INSERT INTO payment (registrationNo, paymentId, TxnReferenceNo, BankReferenceNo, BankID, Bin, TxnAmount, 
    TxnCode, TxnType, TxnDate, AuthStatusCode, AuthMsg, creationTime) 
    VALUES ('$registrationNo', '$UniqueTxnID', '$TxnReferenceNo', '$BankReferenceNo', '$BankID', '$BIN', '$TxnAmount', 
    '$TxnTypeCode', '1', '$TxnDate', '$AuthStatusCode', 'Error at BillDesk', '$creationTime')";
    
    mysqli_query($con, $sql_query1);
}

$dbConnection->closeConnection();
header("Location: https://eduguruji.com/admission/?token=$jwt#/paymentinfo");