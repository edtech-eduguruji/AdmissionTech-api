<?php
require('AppHeaders.php');
include_once('DBConnection.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$username = $_GET['username'];
$password = $_GET['password'];


$sql = "SELECT * FROM users_info WHERE user_name='$username' AND password='$password' AND active = 1 ";
$result = $con->query($sql);
$count = mysqli_num_rows($result);
$response = array();

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $fullname = "Admin";
        if ($row['role'] == "STUDENT") {
            $userId = $row['user_id'];
            $sql1 = "SELECT name FROM students WHERE student_id = '$userId' ";
            $result1 = $con->query($sql1);
            $count1 = mysqli_num_rows($result1);

            if ($count1 > 0) {
                $teacherSubject = array();
                while ($row_s = mysqli_fetch_assoc($result1)) {
                    $fullname = $row_s['name'];
                }
            }
        }
        $row['fullname'] = $fullname;
        array_push($response, $row);
    }
    echo json_encode($response);
} else {
    header(' 500 Internal Server Error', true, 500);
}
