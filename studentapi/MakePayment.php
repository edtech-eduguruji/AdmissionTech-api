<?php

// require('../AppHeaders.php');
// include_once('../DBConnection.php');
// include_once('../utils.php');

// $dbConnection = new DBConnection($db);
// $con = $dbConnection->getConnection();

// $registrationNo = $_POST['registrationNo'];

// //Time entry
// date_default_timezone_set('Asia/Kolkata');
// $creationTime = getCurrentTime();

// $sql_query1 = "UPDATE payment SET status='1', payment_date='$creationTime',
// amount='252', mode='NET BANKING' WHERE registrationNo='$registrationNo'";

// $sql_query2 = "UPDATE basic_details SET payment='1' WHERE registrationNo='$registrationNo'";

// if (mysqli_query($con, $sql_query1) && mysqli_query($con, $sql_query2)) {
//     echo json_encode(["Response" => "Success"]);
// } else {
//     header(' 500 Internal Server Error', true, 500);
// }
// $dbConnection->closeConnection();
