<?php
require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$username = $con->real_escape_string($_GET['username']);
$password = $con->real_escape_string($_GET['password']);

if (isset($_GET['isAdmin'])) {
    $query = "SELECT * FROM users_info";
} else {
    $query = "SELECT basic_details.selection, basic_details.submitted,basic_details.payment,users_info.user_id,users_info.user_name,
    basic_details.courseFee, faculty_course_details.admissionYear, users_info.password,users_info.role,users_info.active FROM users_info 
    INNER JOIN basic_details ON users_info.user_id = basic_details.registrationNo 
    INNER JOIN faculty_course_details ON faculty_course_details.registrationNo = basic_details.registrationNo ";
}

$sql = "$query WHERE user_name = '$username' AND password = '$password' AND active = 1 ";

$result = $con->query($sql);
$count = mysqli_num_rows($result);
$response = null;

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['role'] == "ADMIN") {
            $row['fullname'] = "Admin";
        }
        $row['clg_id'] = $row['user_id'];
        $response = $row;
    }
    $jwt = createToken($response);
    echo $jwt;
} else {
    header(' 500 Internal Server Error', true, 500);
}
