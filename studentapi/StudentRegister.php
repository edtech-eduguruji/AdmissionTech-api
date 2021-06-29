<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$data = array();
$studentId = uniqid();
$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$password = $_POST['password'];

//Time entry
date_default_timezone_set('Asia/Kolkata');
$creationTime = getCurrentTime();

$check = "SELECT count(mobile) as counts FROM students WHERE mobile = '$mobile'";
$count = mysqli_query($con, $check);
$count = mysqli_fetch_assoc($count);
$count = $count['counts'];
if ($count == 0) {
    $sql = "INSERT INTO students (student_id,name,email,mobile,creationTime,createdBy) 
    VALUES ('$studentId','$name','$email','$mobile','$creationTime','$student')";
    $con->query($sql);
    $sql2 = "INSERT INTO users_info (user_id,user_name,password,role) 
    VALUES ('$studentId','$mobile','$password','STUDENT')";
    $con->query($sql2);
    $data = array('response' => "yes");
} else {
    $data = array('error' => true, 'message' => "Mobile number is already registered.");
}

$dbConnection->closeConnection();
echo json_encode($data);
