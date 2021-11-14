<?php

require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$registrationNo = $_GET['registrationNo'];

$sql_query = "SELECT payment.*, basic_details.selection, basic_details.submitted,basic_details.payment,basic_details.name,
basic_details.aadharNo,basic_details.gender,advanced_details.fatherName,advanced_details.motherName,
basic_details.category,faculty_course_details.admissionYear,basic_details.dob,
users_info.user_id,users_info.user_name, users_info.password,users_info.role,users_info.active FROM users_info 
INNER JOIN basic_details ON users_info.user_id = basic_details.registrationNo 
INNER JOIN advanced_details ON users_info.user_id = advanced_details.registrationNo 
INNER JOIN faculty_course_details ON users_info.user_id = faculty_course_details.registrationNo 
INNER JOIN payment ON payment.registrationNo = basic_details.registrationNo ";

$sql_query = $sql_query . " WHERE (payment.registrationNo='$registrationNo' and basic_details.payment='1') and 
    ((payment.courseFee='0' and AuthStatusCode='0300') or (basic_details.courseFee='1' and payment.courseFee='1' and AuthStatusCode='0300')) ";

$result = mysqli_query($con, $sql_query);

if (mysqli_num_rows($result) > 0) {
    $json = array();
    while ($row = mysqli_fetch_assoc($result)) {
        if (count($json) <= 0) {
            $json[] = $row;
        } else if ($row['courseFee'] && $row['courseFee'] == '1') {
            $json[] = $row;
        }
    }
    $response = array("payment" => $json[0]);
    if (count($json) > 1) {
        $response['courseFee'] = $json[1];
    }

    echo json_encode($response);
}



$dbConnection->closeConnection();
