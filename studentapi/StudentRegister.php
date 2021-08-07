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

$sql1 = "INSERT INTO users_info (user_id,user_name,password,role)  VALUES ('$registrationNo','$registrationNo','$dob','STUDENT')";

$sql2 = "INSERT INTO faculty_course_details (registrationNo, creationTime) VALUES ('$registrationNo', '$creationTime')";

$sql3 = "INSERT INTO advanced_details (registrationNo, creationTime) VALUES ('$registrationNo', '$creationTime')";

$sql4 = "INSERT INTO academic_details (registrationNo, creationTime) VALUES ('$registrationNo', '$creationTime')";

$sql5 = "INSERT INTO documents (registrationNo, creationTime) VALUES ('$registrationNo', '$creationTime')";

$sql6 = "INSERT INTO merit_details (registrationNo, creationTime) VALUES ('$registrationNo', '$creationTime')";


if($con->query($sql) && $con->query($sql1) && $con->query($sql2) && $con->query($sql3)
&& $con->query($sql4) && $con->query($sql5) && $con->query($sql6)) {
    $data = array('user_id' => $registrationNo, 'user_name' => $name, 
    'password' => $dob, 'fullname' => $name, 'submitted' => "0", 'payment' => "0", 'role' => "STUDENT");    
    $dbConnection->closeConnection();
    echo json_encode($data);
}
