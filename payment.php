<?php

require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');

error_log("----------------------------------------------------------------");
$data = $_POST['msg'];
error_log("PI: " . $data);

$myArray = explode('|', $data);
$countVal = count($myArray);

$billdesk_checksum = $myArray[$countVal-1];
$billdesk_checksum = trim($billdesk_checksum);
array_splice($myArray, $countVal-1, $countVal);
$str = implode('|', $myArray);
//echo $str;

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

//Time entry
date_default_timezone_set('Asia/Kolkata');
$creationTime = getCurrentTime();
$payment = '0';
$admissionYear = null;
$submitted = '0';

if($billdesk_checksum==$gen_checksum) {
    if($AuthStatusCode == "0300") {
        $payment = '1';

        $query = "SELECT basic_details.submitted, basic_details.payment, basic_details.courseFee, faculty_course_details.admissionYear 
        FROM basic_details 
        INNER JOIN faculty_course_details ON faculty_course_details.registrationNo = basic_details.registrationNo 
        WHERE basic_details.registrationNo = '$registrationNo' ";

        $result = $con->query($query);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $admissionYear = $row['admissionYear'];
                $submitted = $row['submitted'];
            }
        } else {
            header(' 500 Internal Server Error', true, 500);
        }
    }
}

$user = array(
    'UniqueTxnID' => $UniqueTxnID,
    'TxnReferenceNo' => $TxnReferenceNo,
    'BankReferenceNo' => $BankReferenceNo,
    'TxnAmount' => $TxnAmount,
    'BankID' => $BankID,
    'BIN' => $BIN,
    'TxnTypeCode' => $TxnTypeCode,
    'TxnDate' => $TxnDate,
    'AuthStatusCode' => $AuthStatusCode,
    'AuthMsg' => $authStatusArray[$AuthStatusCode],
    'PaymentFacultyId' => $PaymentFacultyId,
    'errorCode' => $errorCode,
    'errorDescription' => $errorDescription,

    'registrationNo' => $registrationNo,
    'payment' => $payment,
    'submitted' => $submitted,
    'role' => 'STUDENT',
    'active' => '1',
    'user_name' => $registrationNo,
    'user_id' => $registrationNo,

    'courseFee' => $courseFee,
    'admissionYear'=> $admissionYear
);

$jwt = createToken($user);
header("Location: https://admission.agracollegeagra.org.in/?token=$jwt#/paymentinfo");