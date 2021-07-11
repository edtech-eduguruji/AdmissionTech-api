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
$count = 0;


if (!file_exists("uploads/" . $registrationNo)) {
    mkdir("uploads/" . $registrationNo, 0777, true);
}


foreach ($_FILES as $key => $obj) {
    $fname = $obj['name'];
    $temp = $obj['tmp_name'];
    $filetype = $obj['type'];
    $filediv = explode('.', $fname);
    $fileext = strtolower(end($filediv));
    $creationTime = getCurrentTime();
    $uniquename = $key . $creationTime . '.' . $fileext;
    $uploaded = "uploads/" . $registrationNo . "/" . $uniquename;
    if ($filetype == "image/png" || $filetype == "image/jpeg" || $filetype == "image/jpg" || $file_type == "application/pdf") {
        if (move_uploaded_file($temp, $uploaded)) {
            if ($key == 'form') {
                $form = $uploaded;
            } else if ($key == 'photo') {
                $photo = $uploaded;
            } else if ($key == 'categoryCertificate') {
                $categoryCertificate = $uploaded;
            } else if ($key == 'subCategoryCertificate') {
                $subCategoryCertificate = $uploaded;
            } else if ($key == 'nationalCertificate') {
                $nationalCertificate = $uploaded;
            } else if ($key == 'nccCertificate') {
                $nccCertificate = $uploaded;
            } else if ($key == 'nssDocument') {
                $nssDocument = $uploaded;
            } else {
                $documents[$count]['document'] = $uploaded;
                $count = $count + 1;
            }
        }
    }
}
$documents = json_encode($documents);

$sql1 = "INSERT INTO basic_details (registrationNo, 
faculty,
  courseType,
  course,
  vaccinated,
  nameTitle,
  name,
  dob,
  gender,
  religion,
  caste,
  category,
  subCategory,
  categoryCertificate,
  subCategoryCertificate,
  personalMobile,
  parentMobile,
  aadharNo,
  email,
  mediumOfInstitution,
  photo,
  wrn,
  form,
  signature,
  submitted,
  payment) 
    VALUES ('$registrationNo',
    '$faculty',
  '$courseType',
  '$course',
  '$vaccinated',
  '$nameTitle',
  '$name',
  '$dob',
  '$gender',
  '$religion',
  '$caste',
  '$category',
  '$subCategory',
  '$categoryCertificate',
  '$subCategoryCertificate',
  '$personalMobile',
  '$parentMobile',
  '$aadharNo',
  '$email',
  '$mediumOfInstitution',
  '$photo',
  '$wrn',
  '$form',
  '$signature',
  '0',
  '0')";
//   echo $sql1;
mysqli_query($con, $sql1);


$sql2 = "INSERT INTO advanced_details (registrationNo,
  fatherName ,
  motherName ,
  parentsOccupation ,
  guardianName ,
  relationOfApplicant ,
  houseNo ,
  street ,
  pincode ,
  postOffice ,
  state ,
  city ,
  cHouseNo ,
  cStreet ,
  cPincode ,
  cPostOffice ,
  cState ,
  cCity ) 
    VALUES ('$registrationNo',
  '$fatherName' ,
  '$motherName' ,
  '$parentsOccupation' ,
  '$guardianName' ,
  '$relationOfApplicant' ,
  '$houseNo' ,
  '$street' ,
  '$pincode' ,
  '$postOffice' ,
  '$state' ,
  '$city' ,
  '$cHouseNo' ,
  '$cStreet' ,
  '$cPincode' ,
  '$cPostOffice' ,
  '$cState' ,
  '$cCity' )";
$con->query($sql2);

$sql3 = "INSERT INTO academic_details (registrationNo,academicDetails) 
    VALUES ('$registrationNo','$academicDetails')";
$con->query($sql3);

$sql4 = "INSERT INTO documents (registrationNo,documents) 
    VALUES ('$registrationNo','$documents')";
$con->query($sql4);


$sql5 = "INSERT INTO merit_details (registrationNo,
nationalCompetition ,
  nationalCertificate ,
  otherCompetition ,
  otherCertificate ,
  ncc ,
  nccCertificate ,
  freedomFighter ,
  nationalSevaScheme ,
  nssDocument ,
  roverRanger ,
  otherRoverRanger ,
  rrDocument ,
  bcom ,
  other ,
  totalMeritCount) 
    VALUES ('$registrationNo', 
  '$nationalCompetition' ,
  '$nationalCertificate' ,
  '$otherCompetition' ,
  '$otherCertificate' ,
  '$ncc' ,
  '$nccCertificate' ,
  '$freedomFighter' ,
  '$nationalSevaScheme' ,
  '$nssDocument' ,
  '$roverRanger' ,
  '$otherRoverRanger' ,
  '$rrDocument' ,
  '$bcom' ,
  '$other' ,
  '$totalMeritCount')";
$con->query($sql5);


$sql6 = "INSERT INTO users_info (user_id,user_name ,password ,role ,active) 
    VALUES ('$registrationNo','$name' ,'$dob' ,'STUDENT' ,'1')";
$con->query($sql6);


$data = array('response' => "yes");


$dbConnection->closeConnection();
echo json_encode($data);
