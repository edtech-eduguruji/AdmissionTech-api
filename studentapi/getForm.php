<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();
$jwt = $dbConnection->getUserData("Authentication");

$response = null;

function filtersQuery($regNo, $fromDate, $toDate, $status, $faculty)
{
    $condition = "";
    $count = 0;
    if (!empty($regNo)) {
        $condition = "basic_details.registrationNo='$regNo'";
        $count++;
    }
    if (!empty($fromDate)) {
        if ($count > 0) {
            $condition = $condition . " AND ";
        }
        $condition = $condition . "basic_details.lastUpdated >= '$fromDate' ";
        $count++;
    }
    if (!empty($toDate)) {
        if ($count > 0) {
            $condition = $condition . " AND ";
        }
        $condition = $condition . "basic_details.lastUpdated <= '$toDate' ";
        $count++;
    }
    if (!empty($status)) {
        if ($count > 0) {
            $condition = $condition . " AND ";
        }
        if ($status == 'submittedForms') {
            $statusCondition = "payment='1' AND submitted='1'";
        } else {
            $statusCondition = "payment='1' AND submitted='0'";
        }
        $condition = $condition . $statusCondition;
        $count++;
    }
    if (!empty($faculty)) {
        if ($count > 0) {
            $condition = $condition . " AND ";
        }
        $condition = $condition . "faculty_course_details.faculty='$faculty'";
        $count++;
    }
    if ($count == 0) {
        return "payment = '1' AND submitted = '1'";
    } else {
        return $condition;
    }
}

if (isset($_GET['registrationNo'])) {
    $registrationNo = $_GET['registrationNo'];
    $WHERE = "WHERE basic_details.registrationNo='$registrationNo'";
    $response = null;
} else {
    $limit = $_GET['limit'];
    $offset = $_GET['offset'];
    $regNo = null;
    $fromDate = null;
    $toDate = null;
    $status = null;
    $faculty = null;
    if (isset($_GET['regNo'])) {
        $regNo = $_GET['regNo'];
    }
    if (isset($_GET['fromDate'])) {
        $fromDate = $_GET['fromDate'];
    }
    if (isset($_GET['toDate'])) {
        $toDate = $_GET['toDate'];
    }
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
    }
    if (isset($_GET['faculty'])) {
        $faculty = $_GET['faculty'];
    }
    $WHERE =  "WHERE " . filtersQuery($regNo, $fromDate, $toDate, $status, $faculty) . "ORDER BY basic_details.id DESC LIMIT $limit OFFSET $offset";
    $response = array();
}

$isTokenValid = verifyToken($jwt);

if ($isTokenValid) {
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
