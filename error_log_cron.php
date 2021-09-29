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
    
    $query = "$query WHERE basic_details.payment='1' and basic_details.courseFee='0' and (payment.courseFee='NA' or payment.courseFee='' or payment.courseFee='0') and 
(payment.AuthStatusCode = '0002' or payment.AuthStatusCode = '0399' or payment.AuthStatusCode ='' or payment.AuthStatusCode ='NA') limit $offset, $limit";

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
        
if ($count > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // echo "total trans found :". $count;
        if($check == 1) {
            // $check = 2;
            echo $row['registrationNo']."---";
            echo $row['paymentId']."---";
        
            $str = getQueryApi('0122', $row['paymentId'], $date);
            
            echo updatePayment($str, $row['registrationNo'], $row['paymentId'], $con);
        }
    }
    $dbConnection->closeConnection();
} else {
    header(' 500 Internal Server Error', true, 500);
}