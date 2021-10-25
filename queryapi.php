<?php

// $headers =  getallheaders();
// foreach($headers as $key=>$val){
//   echo $key . ': ' . $val . '<br>';
// }
// echo json_encode($_SERVER);
include_once('utils.php');
require('AppHeaders.php');
include_once('DBConnection.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();


$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case "GET":
        $registrationNo = $_GET['registrationNo'];
        $array = fetchPayment($registrationNo, '0', $con);

        date_default_timezone_set('Asia/Kolkata');
        $time = date('YmdHms', time());

        $response = array();
        foreach($array as $item) {
            $paymentId = $item['paymentId'];
            $str = getQueryApi('0122', $paymentId, $time);
            $response[$paymentId] = updatePayment($str, $item['registrationNo'], $item['paymentId'], $con);
        }
        echo json_encode($response);
        $dbConnection->closeConnection();
        break;

    case "POST":
        $requestType = $_POST['requestType'];
        $transactionId = $_POST['transactionId'];
        $time = $_POST['time'];
        $updateForm = $_POST['updateForm'];
        $registrationNo = $_POST['registrationNo'];
        $formSelectionGroup = $_POST['formSelectionGroup'];
        $PaymentTable = $_POST['PaymentTable'];

        if($updateForm == '1') {
            echo getQueryApi($requestType, $transactionId, $time);
        } else if($updateForm == '2'){

            // echo json_encode($_POST);
            if ($formSelectionGroup == 'Academic') {
                $academicDetails = json_decode($_POST['academicDetails'], true);
                $academicDetails = json_encode($academicDetails);

                $sql3 = "UPDATE academic_details SET academicDetails='$academicDetails' WHERE registrationNo='$registrationNo'";
                $con->query($sql3);
                $dbConnection->closeConnection();
            } else if ($formSelectionGroup == 'Major1') {
                $major1 = json_decode($_POST['major1'], true);
                $major1 = json_encode($major1);

                $sql3 = "UPDATE faculty_course_details SET major1='$major1' WHERE registrationNo='$registrationNo'";
                $con->query($sql3);
                $dbConnection->closeConnection();
            } else if ($formSelectionGroup == 'Major2') {
                $major2 = json_decode($_POST['major2'], true);
                $major2 = json_encode($major2);

                $sql3 = "UPDATE faculty_course_details SET major2='$major2' WHERE registrationNo='$registrationNo'";
                $con->query($sql3);
                $dbConnection->closeConnection();
            } else if ($formSelectionGroup == 'Signature') {
                $signature = ($_POST['signature']);

                $sql3 = "UPDATE basic_details SET signature='$signature' WHERE registrationNo='$registrationNo'";
                $con->query($sql3);
                $dbConnection->closeConnection();
            } else if ($formSelectionGroup == 'Category') {
                $category = ($_POST['category']);

                $sql3 = "UPDATE basic_details SET category='$category' WHERE registrationNo='$registrationNo'";
                $con->query($sql3);
                $dbConnection->closeConnection();
            } else if ($formSelectionGroup == 'PaymentTable') {
                
                $myArray = explode('|', $PaymentTable);
                $paymentId = $myArray[1];
                $str = getQueryApi('0122', $paymentId, $time);

                $myArray = explode('|', $str);
                $paymentId = $myArray[2];
                $registrationNo = $myArray[18];
                
                $creationTime = getCurrentTime();
                
                $sql3 = "INSERT into payment (paymentId, registrationNo, creationTime, checksum) value ('$paymentId', '$registrationNo', '$creationTime', '$PaymentTable')";
                $con->query($sql3);
                
                updatePayment($str, $registrationNo, $paymentId, $con);
                $dbConnection->closeConnection();

            } else if ($formSelectionGroup == 'Submitted') {
                $sql3 = "UPDATE basic_details SET submitted='1' WHERE registrationNo='$registrationNo'";
                $con->query($sql3);
                $dbConnection->closeConnection();
            }
        }

        break;
}