<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$data = array();
$registrationNo = uniqid();
$name = $_POST['name'];
$mobile = $_POST['mobile'];
$dob = $_POST['dob'];

//Time entry
date_default_timezone_set('Asia/Kolkata');
$creationTime = getCurrentTime();

$sql = "INSERT INTO basic_details (registrationNo,name,personalMobile,dob,submitted,payment,lastUpdated,creationTime) 
    VALUES ('$registrationNo','$name','$mobile','$dob','0','0','$creationTime','$creationTime')";
$con->query($sql);
$sql2 = "INSERT INTO users_info (user_id,user_name,password,role) 
    VALUES ('$registrationNo','$registrationNo','$dob','STUDENT')";
$con->query($sql2);

if($con->query($sql) && $con->query($sql2)) {
    $data = array('user_id' => $registrationNo, 'user_name' => $mobile, 
    'password' => $dob, 'fullname' => $name, 'submitted' => "0", 'payment' => "0", 'role' => "STUDENT");    
    $dbConnection->closeConnection();
    echo json_encode($data);
}
