<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$data = array();
$dob = $_POST['dob'];
$name = $_POST['name'];
$mobile = $_POST['mobile'];
$random = substr(str_shuffle(MD5(microtime())), 0, 6);
$registrationNo = 'AGA2021-'.$dob.'-'.$random;

//Time entry
date_default_timezone_set('Asia/Kolkata');
$creationTime = getCurrentTime();

$sql = "INSERT INTO basic_details (registrationNo,name,personalMobile,dob,submitted,payment,creationTime) 
    VALUES ('$registrationNo','$name','$mobile','$dob','0','0','$creationTime')";

$sql1 = "INSERT INTO users_info (user_id,user_name,password,role)  VALUES ('$registrationNo','$registrationNo','$dob','STUDENT')";

$sql2 = "INSERT INTO faculty_course_details (registrationNo, creationTime) VALUES ('$registrationNo', '$creationTime')";

$sql3 = "INSERT INTO advanced_details (registrationNo, creationTime) VALUES ('$registrationNo', '$creationTime')";

$sql4 = "INSERT INTO academic_details (registrationNo, creationTime) VALUES ('$registrationNo', '$creationTime')";

$sql5 = "INSERT INTO documents (registrationNo, creationTime) VALUES ('$registrationNo', '$creationTime')";

$sql6 = "INSERT INTO merit_details (registrationNo, creationTime) VALUES ('$registrationNo', '$creationTime')";


if (
    $con->query($sql) && $con->query($sql1) && $con->query($sql2) && $con->query($sql3)
    && $con->query($sql4) && $con->query($sql5) && $con->query($sql6)
) {
    $data = array(
        'user_id' => $registrationNo, 'user_name' => $name,
        'password' => $dob, 'fullname' => $name, 'submitted' => "0", 'payment' => "0", 'role' => "STUDENT"
    );
} else {
    header(' 500 Internal Server Error', true, 500);
}
echo json_encode($data);
$dbConnection->closeConnection();
