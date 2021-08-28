<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();
$jwt = $dbConnection->getUserData("Authentication");

$response = null;

if (isset($_GET['registrationNo'])) {
    $registrationNo = $_GET['registrationNo'];
    $WHERE = "WHERE basic_details.registrationNo='$registrationNo'";
    $response = null;
} else {
    $limit = $_GET['limit'];
    $offset = $_GET['offset'];
    $WHERE = "WHERE payment = '1' AND submitted = '1' LIMIT $limit OFFSET $offset";
    $response = array();
}

$isTokenValid = verifyToken($jwt);

if ($isTokenValid) {
    $registrationNo = $_GET['registrationNo'];

    $sql_query = "SELECT * from basic_details 
    INNER JOIN advanced_details ON basic_details.registrationNo = advanced_details.registrationNo 
    INNER JOIN academic_details ON basic_details.registrationNo = academic_details.registrationNo 
    INNER JOIN faculty_course_details ON basic_details.registrationNo = faculty_course_details.registrationNo
    INNER JOIN documents ON basic_details.registrationNo = documents.registrationNo 
    INNER JOIN merit_details ON basic_details.registrationNo = merit_details.registrationNo 
    $WHERE";

    // -- INNER JOIN payment ON basic_details.registrationNo = payment.registrationNo 

    $result = mysqli_query($con, $sql_query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (isset($_GET['registrationNo'])) {
                $response = $row;
            } else {
                array_push($response, $row);
            }
        }
    } else {
        header(' 500 Internal Server Error', true, 500);
    }  
} else {
    header('HTTP/1.0 401 Unauthorized');
}
echo json_encode($response);
$dbConnection->closeConnection();
