<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$basic_details_id = uniqid();
$advanced_details_id = uniqid();
$academic_details_id = uniqid();
$documents_id = uniqid();
$merit_details_id = uniqid();
$registrationNo = uniqid();
$faculty = $_POST['faculty'];
$courseType = $_POST['courseType'];
$course = $_POST['course'];
$mediumOfInstitution = $_POST['mediumOfInstitution'];
$vaccinated = $_POST['vaccinated'];
$nameTitle = $_POST['nameTitle'];
$name = $_POST['name'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$caste = $_POST['caste'];
$religion = $_POST['religion'];
$personalMobile = $_POST['personalMobile'];
$parentMobile = $_POST['parentMobile'];
$fatherName = $_POST['fatherName'];
$motherName = $_POST['motherName'];
$parentsOccupation = $_POST['parentsOccupation'];
$wrn = $_POST['wrn'];
$form = $_POST['form'];
$photo = $_POST['photo'];
$houseNo = $_POST['houseNo'];
$street = $_POST['street'];
$pincode = $_POST['pincode'];
$postOffice = $_POST['postOffice'];
$state = $_POST['state'];
$city = $_POST['city'];
$cHouseNo = $_POST['cHouseNo'];
$cStreet = $_POST['cStreet'];
$cPincode = $_POST['cPincode'];
$cPostOffice = $_POST['cPostOffice'];
$cState = $_POST['cState'];
$cCity = $_POST['cCity'];
$aadharNo = $_POST['aadharNo'];
$email = $_POST['email'];
$category = $_POST['category'];
$subCategory = $_POST['subCategory'];
$categoryCertificate = $_POST['categoryCertificate'];
$subCategoryCertificate = $_POST['subCategoryCertificate'];
$academicDetails = $_POST['academicDetails'];
$documents = json_decode($_POST['documents'], true);
$guardianName = $_POST['guardianName'];
$relationOfApplicant = $_POST['relationOfApplicant'];
$nationalCompetition = $_POST['nationalCompetition'];
$nationalCertificate = $_POST['nationalCertificate'];
$otherCompetition = $_POST['otherCompetition'];
$otherCertificate = $_POST['otherCertificate'];
$ncc = $_POST['ncc'];
$nccCertificate = $_POST['nccCertificate'];
$freedomFighter = $_POST['freedomFighter'];
$nationalSevaScheme = $_POST['nationalSevaScheme'];
$nssDocument = $_POST['nssDocument'];
$roverRanger = $_POST['roverRanger'];
$otherRoverRanger = $_POST['otherRoverRanger'];
$rrDocument = $_POST['rrDocument'];
$bcom = $_POST['bcom'];
$other = $_POST['other'];
$totalMeritCount = $_POST['totalMeritCount'];
$signature = $_POST['signature'];

// Photo
if (isset($_FILES['photo'])) {
    $imgfile_name = $_FILES['photo']['name'];
    $imgfile_temp = $_FILES['photo']['tmp_name'];
    $imgfile_type = $_FILES['photo']['type'];
    $div = explode('.', $imgfile_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 2, 8) . '.' . $file_ext;
    $imguploaded_image = "uploads/" . $unique_image;
    $imgfile_type = $_FILES['photo']['type'];
    if ($imgfile_type == "image/png" || $imgfile_type == "image/jpeg" || $imgfile_type == "image/jpg") {
        if (move_uploaded_file($imgfile_temp, $imguploaded_image)) {
            $photo = ($imguploaded_image);
        }
    }
}

//Uploding documents from JSON
foreach ($documents as $value) {
    $document = $value['document'];
    if (isset($_FILES[$document])) {
        $file_name = $_FILES[$document]['name'];
        $file_temp = $_FILES[$document]['tmp_name'];
        $file_type = $_FILES[$document]['type'];
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_file = substr(md5(time()), 2, 8) . '.' . $file_ext;
        $uploaded_file = "uploads/" . $unique_file;
        $file_type = $_FILES[$document]['type'];
        if ($file_type == "image/png" || $file_type == "image/jpeg" || $file_type == "image/jpg" || $file_type == "application/pdf") {
            if (move_uploaded_file($file_temp, $uploaded_file)) {
                $value['document'] = $uploaded_file;
            }
        }
    }
}

$sql1 = "INSERT INTO basic_details (id,registrationNo) 
    VALUES ('$basic_details_id','$registrationNo')";
$con->query($sql1);
$sql2 = "INSERT INTO advanced_details (id,registrationNo) 
    VALUES ('$advanced_details_id','$registrationNo')";
$con->query($sql2);
$sql3 = "INSERT INTO academic_details (id,registrationNo,academicDetails) 
    VALUES ('$academic_details_id','$registrationNo','$academicDetails')";
$con->query($sql3);
$sql4 = "INSERT INTO documents (id,registrationNo,documents) 
    VALUES ('$documents_id','$registrationNo','$documents')";
$con->query($sql4);
$sql5 = "INSERT INTO merit_details (id,registrationNo,password,role) 
    VALUES ('$merit_details_id','$registrationNo')";
$con->query($sql5);
$data = array('response' => "yes");


$dbConnection->closeConnection();
echo json_encode($data);
