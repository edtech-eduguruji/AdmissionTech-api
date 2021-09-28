<?php
require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$getTime = $_GET['getTime'];
$limit = $_GET['limit'];
$offset = $_GET['offset'];

$query = "SELECT basic_details.registrationNo,basic_details.payment, payment.paymentId FROM basic_details 
INNER JOIN payment ON payment.registrationNo = basic_details.registrationNo";

if($_GET['course']=='1') {
    echo "course payemnt---------";
    
    $query = "$query WHERE basic_details.payment='1' and basic_details.courseFee='0' and 
(payment.AuthStatusCode = '0002' or payment.AuthStatusCode = '0399' or payment.AuthStatusCode ='' or payment.AuthStatusCode ='NA')";

} else if($offset>=0 && $limit>=0) {
    
    $query = "SELECT registrationNo, paymentId from payment WHERE payment.AuthStatusCode!='0300' limit $offset, $limit ";

} else {
    $query = "$query WHERE basic_details.payment='0' and basic_details.courseFee='0' and (payment.courseFee='NA' or payment.courseFee='' or payment.courseFee='0') and 
(payment.AuthStatusCode = '0002' or payment.AuthStatusCode = '0399' or payment.AuthStatusCode ='' or payment.AuthStatusCode ='NA') ";
}


if($getTime) {
    $query = "$query and payment.creationTime >= $getTime ";
}

echo $query;

$result = $con->query($query);
$count = mysqli_num_rows($result);

date_default_timezone_set('Asia/Kolkata');
$date = date('YmdHms', time());

$check = 1;

// RequestType|MerchantID|UniqueTxnID|TxnReferenceNo|BankReferenceNo|TxnAmount|Ban
// kID|BankMerchantID|TxnType|CurrencyName|ItemCode|SecurityType|SecurityID|SecurityP
// assword|TxnDate|AuthStatus|SettlementType|AdditionalInfo1|AdditionalInfo2|AdditionalInf
// o3|AdditionalInfo4|AdditionalInfo5|AdditionalInfo6|AdditionalInfo7|ErrorStatus|ErrorDescrip
// tion|Filler1|RefundStatus|TotalRefundAmount|LastRefundDate|LastRefundRefNo|QueryStatu
// s|CheckSum

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


$authStatusArray = array( 
        '0300'=>'Success',
        '0399'=>'Failure',
        'NA'=>'Failure',
        '0002'=>'Pending',
        '0001'=>'Failure');
        
date_default_timezone_set('Asia/Kolkata');
$creationTime = getCurrentTime();
        
if ($count > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // echo "total trans found :". $count;
        
        if($check == 1) {
            // $check = 2;
            echo $row['registrationNo']."---";
            echo $row['paymentId']."---";
        
            $str = getQueryApi('0122', $row['paymentId'], $date);
            $val = explode('|', $str);
            
            $registrationNo = $row['registrationNo'];
            $UniqueTxnID = $row['paymentId'];
            $TxnReferenceNo = $val[3];
            $BankReferenceNo = $val[4];
            $TxnAmount = $val[5];
            $BankID = $val[6];
            $BankMerchantID = $val[7];
            $TxnTypeCode = $val[8];
            $TxnDate = $val[14];
            $AuthStatusCode = $val[15];
            $ErrorStatus = $val[24];
            $ErrorDescription = $val[25];
            $RefundStatus = $val[27];
            $TotalRefundAmount = $val[28];
            $LastRefundDate = $val[29];
            $LastRefundRefNo = $val[30];


            // $LastRefundRefNo = $val[17];
            // $LastRefundRefNo = $val[18];
            $courseFee = $val[19];
            
            echo json_encode($val).'     ';
            if(trim($courseFee)=='NA') {
                $courseFee = '0';
            }
            
            $sql_query1 = "UPDATE payment set TxnReferenceNo='$TxnReferenceNo', BankReferenceNo='$BankReferenceNo', BankID='$BankID', 
            TxnAmount='$TxnAmount', TxnCode='$TxnTypeCode', TxnType='$transTypeArray[$TxnTypeCode]', TxnDate='$TxnDate', 
            AuthStatusCode='$AuthStatusCode', AuthMsg='$authStatusArray[$AuthStatusCode]', updatedTime='$creationTime',
            RefundStatus='$RefundStatus', TotalRefundAmount='$TotalRefundAmount', LastRefundDate='$LastRefundDate', LastRefundRefNo='$LastRefundRefNo', 
            courseFee='$courseFee' where registrationNo='$registrationNo' and paymentId='$UniqueTxnID' ";
        
            mysqli_query($con, $sql_query1);
            
            if($AuthStatusCode=='0300' && $RefundStatus=='NA') {
                
                $sql_query2 = "UPDATE basic_details SET payment='1', courseFee='$courseFee' WHERE registrationNo='$registrationNo'";
                mysqli_query($con, $sql_query2);
                
                echo "status update to sucess for - ".$UniqueTxnID." and reg: ".$registrationNo;
                
            }
            
        }
    }
} else {
    header(' 500 Internal Server Error', true, 500);
}