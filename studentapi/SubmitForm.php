<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$data = array();
$basic_details_id = uniqid();
$advanced_details_id = uniqid();
$academic_details_id = uniqid();
$documents_id = uniqid();
$merit_details_id = uniqid();
$registrationNo = $_POST['registrationNo'];
$submit = $_POST['submit'];
$count = 0;

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

if (!file_exists("../uploads/" . $registrationNo)) {
    mkdir("../uploads/" . $registrationNo, 0777, true);
}
foreach ($_FILES as $key => $obj) {
    $fname = $obj['name'];
    $temp = $obj['tmp_name'];
    $filetype = $obj['type'];
    $filediv = explode('.', $fname);
    $fileext = strtolower(end($filediv));
    $creationTime = getCurrentTime();
    $uniquename = $key . $creationTime . '.' . $fileext;
    $uploaded = "../uploads/" . $registrationNo . "/" . $uniquename;
    $dbPath = "uploads/" . $registrationNo . "/" . $uniquename;
    if ($filetype == "image/png" || $filetype == "image/jpeg" || $filetype == "image/jpg" || $file_type == "application/pdf") {
        if (move_uploaded_file($temp, $uploaded)) {
            if ($key == 'form') {
                $form = $dbPath;
            } else if ($key == 'photo') {
                $photo = $dbPath;
            } else if ($key == 'categoryCertificate') {
                $categoryCertificate = $dbPath;
            } else if ($key == 'subCategoryCertificate') {
                $subCategoryCertificate = $dbPath;
            } else if ($key == 'nationalCertificate') {
                $nationalCertificate = $dbPath;
            } else if ($key == 'nccCertificate') {
                $nccCertificate = $dbPath;
            } else if ($key == 'nssDocument') {
                $nssDocument = $dbPath;
            } else if($key=='signature'){
                $signature = $dbPath;
            } else {
                $documents[$count]['document'] = $dbPath;
                $count = $count + 1;
            }
        }
    }
}


if($registrationNo==NULL) {
    $registrationNo = uniqid();

    $documents = json_encode($documents);

    $sql1 = "INSERT INTO basic_details (registrationNo, 
    faculty, courseType, course, vaccinated, nameTitle, name, dob, gender, religion, 
    caste, category, subCategory, categoryCertificate, subCategoryCertificate, personalMobile, 
    parentMobile, aadharNo, email, mediumOfInstitution, photo, wrn, form, signature, submitted, payment) 
        VALUES ('$registrationNo',
        '$faculty',
    '$courseType', '$course', '$vaccinated', '$nameTitle', '$name', '$dob', '$gender', 
    '$religion', '$caste', '$category', '$subCategory', '$categoryCertificate', 
    '$subCategoryCertificate', '$personalMobile', '$parentMobile', '$aadharNo', '$email', 
    '$mediumOfInstitution', '$photo', '$wrn', '$form', '$signature', '$submit', '0')";
    //   echo $sql1;
    mysqli_query($con, $sql1);


    $sql2 = "INSERT INTO advanced_details (registrationNo,
    fatherName , motherName , parentsOccupation , guardianName , relationOfApplicant , 
    houseNo , street , pincode , postOffice , state , city , cHouseNo , cStreet , cPincode , cPostOffice , cState , cCity ) 
        VALUES ('$registrationNo',
    '$fatherName' , '$motherName' , '$parentsOccupation' , '$guardianName' , 
    '$relationOfApplicant' , '$houseNo' , '$street' , '$pincode' , '$postOffice' , 
    '$state' , '$city' , '$cHouseNo' , '$cStreet' , '$cPincode' , '$cPostOffice' , '$cState' , '$cCity' )";
    $con->query($sql2);

    $sql3 = "INSERT INTO academic_details (registrationNo,academicDetails) 
        VALUES ('$registrationNo','$academicDetails')";
    $con->query($sql3);

    $sql4 = "INSERT INTO documents (registrationNo,documents) 
        VALUES ('$registrationNo','$documents')";
    $con->query($sql4);

    $sql5 = "INSERT INTO merit_details (registrationNo,
    nationalCompetition , nationalCertificate , otherCompetition , otherCertificate , 
    ncc , nccCertificate , freedomFighter , nationalSevaScheme , nssDocument , roverRanger , 
    otherRoverRanger , rrDocument , bcom , other , totalMeritCount) 
        VALUES ('$registrationNo', 
    '$nationalCompetition' , '$nationalCertificate' , '$otherCompetition' , '$otherCertificate' , 
    '$ncc' , '$nccCertificate' , '$freedomFighter' , '$nationalSevaScheme' , '$nssDocument' , 
    '$roverRanger' , '$otherRoverRanger' , '$rrDocument' , '$bcom' , '$other' , '$totalMeritCount')";
    $con->query($sql5);

    $sql6 = "INSERT INTO users_info (user_id,user_name ,password ,role ,active) 
        VALUES ('$registrationNo','$registrationNo' ,'$dob' ,'STUDENT' ,'1')";
    $con->query($sql6);

} else {
    $documents = json_encode($documents);
    //update code
    $sql1 = "UPDATE basic_details SET 
    faculty='$faculty', courseType='$courseType', course='$course', vaccinated='$vaccinated', 
    nameTitle='$nameTitle', name='$name', dob='$dob', gender='$gender', religion='$religion', 
    caste='$caste', category='$category', subCategory='$subCategory', categoryCertificate='$categoryCertificate', 
    subCategoryCertificate='$subCategoryCertificate', personalMobile='$personalMobile', parentMobile='$parentMobile', 
    aadharNo='$aadharNo', email='$emai', mediumOfInstitution='$mediumOfInstitution', photo='$photo', wrn='$wrn', 
    form='$form', signature='$signature', submitted='$submit', payment='$payment' 
    WHERE registrationNo='$registrationNo'";
    $con->query($sql1);

    $sql2 = "UPDATE advanced_details SET 
    fatherName='$fatherName', motherName='$motherName', parentsOccupation='$parentsOccupation', 
    guardianName='$guardianName', relationOfApplicant='$relationOfApplicant', houseNo='$houseNo', street='$street', 
    pincode='$pincode', postOffice='$postOffice', state='$state', city='$city', cHouseNo='$cHouseNo', cStreet='$cStreet', 
    cPincode='$cPincode', cPostOffice='$cPostOffice', cState='$cState', cCity='$cCity'
    WHERE registrationNo='$registrationNo'";
    $con->query($sql2);

    $sql3 = "UPDATE academic_details SET academicDetails='$academicDetails' WHERE registrationNo='$registrationNo'";
    $con->query($sql3);

    $sql4 = "UPDATE documents SET documents='$documents' WHERE registrationNo='$registrationNo'";
    $con->query($sql4);

    $sql5 = "UPDATE merit_details SET
    nationalCompetition='$nationalCompetition', nationalCertificate='$nationalCertificate', 
    otherCompetition='$otherCompetition ', otherCertificate='$otherCertificate', ncc='$ncc', 
    nccCertificate='$nccCertificate', freedomFighter='$freedomFighter', nationalSevaSchemenationalSevaScheme', 
    nssDocument='$nssDocument', roverRanger='$roverRanger', otherRoverRanger='$otherRoverRanger', rrDocument='$rrDocument', 
    bcom='$bcom', other='$other', totalMeritCount='$totalMeritCount' WHERE registrationNo='$registrationNo'";
    $con->query($sql5);

    $sql6 = "UPDATE users_info SET password='$dob' WHERE registrationNo='$registrationNo'";
    $con->query($sql6);
}

$data = array('registrationNo' => $registrationNo, 'active' => "1", 
'role' =>"STUDENT", 'user_id' => $registrationNo, 'user_name' => $registrationNo);

$dbConnection->closeConnection();
echo json_encode($data);
