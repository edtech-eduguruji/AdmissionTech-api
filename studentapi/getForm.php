<?php
require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();
$jwt = $dbConnection->getUserData("Authentication");

$response = null;
$paymentColumns = "";
$paymentJoin = "";

if (isset($_GET['registrationNo'])) {
    $registrationNo = $_GET['registrationNo'];
    $WHERE = "WHERE basic_details.registrationNo='$registrationNo'";
    $response = null;
} else {
    if (isset($_GET['limit'])) {
        $limit = $_GET['limit'];
        $offset = $_GET['offset'];
        $pagination = "LIMIT $offset,$limit";
    } else {
        $pagination = "";
    }
    $courseType = null;
    $year = null;
    $category = null;
    $regNo = null;
    $fromDate = null;
    $toDate = null;
    $status = null;
    $faculty = null;
    $major1 = null;
    if (isset($_GET['courseType'])) {
        $courseType = $_GET['courseType'];
    }
    if (isset($_GET['admissionYear'])) {
        $year = $_GET['admissionYear'];
    }
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
    }
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
        if ($status ==  'submittedFormsWithCourseFee') {
            $paymentColumns = ",payment.AuthStatusCode, payment.paymentId, payment.TxnAmount";
            $paymentJoin = "INNER JOIN payment ON basic_details.registrationNo = payment.registrationNo ";
        }
    }
    if (isset($_GET['faculty'])) {
        $faculty = $_GET['faculty'];
    }
    if (isset($_GET['major1'])) {
        $major1 = $_GET['major1'];
    }
    $WHERE =  "WHERE " . filtersQuery($courseType, $year, $category, $regNo, $fromDate, $toDate, $status, $faculty, $major1) . " $pagination";
    $response = array();
}

$isTokenValid = verifyToken($jwt);
set_time_limit(500);

if ($isTokenValid) {
    $sql_query = "SELECT basic_details.registrationNo, basic_details.vaccinated, basic_details.nameTitle, 
    basic_details.name, basic_details.dob, basic_details.gender, basic_details.religion, basic_details.caste, 
    basic_details.category, basic_details.subCategory, basic_details.categoryCertificate, basic_details.subCategoryCertificate, 
    basic_details.personalMobile, basic_details.parentMobile, basic_details.aadharNo, basic_details.email, basic_details.mediumOfInstitution, 
    basic_details.photo, basic_details.wrn, basic_details.form, basic_details.signature, basic_details.submitted, basic_details.payment, 
    basic_details.courseFee, academic_details.registrationNo, academic_details.academicDetails, advanced_details.registrationNo, 
    advanced_details.fatherName, advanced_details.motherName, advanced_details.parentsOccupation, advanced_details.guardianName, 
    advanced_details.relationOfApplicant, advanced_details.houseNo, advanced_details.street, advanced_details.pincode, 
    advanced_details.postOffice, advanced_details.state, advanced_details.city, advanced_details.cHouseNo, 
    advanced_details.cStreet, advanced_details.cPincode, advanced_details.cPostOffice, advanced_details.cState, 
    advanced_details.cCity, documents.registrationNo, documents.documents, faculty_course_details.registrationNo, 
    faculty_course_details.faculty, faculty_course_details.courseType, faculty_course_details.admissionYear, 
    faculty_course_details.major1, faculty_course_details.major2, faculty_course_details.major3, faculty_course_details.major4, 
    faculty_course_details.vocationalSem1, faculty_course_details.vocationalSem2, faculty_course_details.coCurriculumSem1, 
    faculty_course_details.coCurriculumSem2, merit_details.id, merit_details.registrationNo, merit_details.nationalCompetition, 
    merit_details.nationalCertificate, merit_details.otherCompetition, merit_details.otherCertificate, merit_details.ncc, merit_details.nccCertificate, 
    merit_details.freedomFighter, merit_details.nationalSevaScheme, merit_details.nssDocument, merit_details.roverRanger, merit_details.otherRoverRanger, 
    merit_details.rrDocument, merit_details.bcom, merit_details.other, merit_details.uploadExtraMark, merit_details.totalMeritCount
    $paymentColumns
    FROM basic_details 
    INNER JOIN advanced_details ON basic_details.registrationNo = advanced_details.registrationNo 
    INNER JOIN academic_details ON basic_details.registrationNo = academic_details.registrationNo 
    INNER JOIN faculty_course_details ON basic_details.registrationNo = faculty_course_details.registrationNo
    INNER JOIN documents ON basic_details.registrationNo = documents.registrationNo 
    INNER JOIN merit_details ON basic_details.registrationNo = merit_details.registrationNo 
    $paymentJoin
    $WHERE";

    // error_log($sql_query);

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
