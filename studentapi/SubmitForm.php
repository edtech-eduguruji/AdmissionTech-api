<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$creationTime = getCurrentTime();
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
$major1 = json_decode($_POST['major1'], true);
$major2 = json_decode($_POST['major2'], true);
$major3 = $_POST['major3'];
$major4 = $_POST['major4'];
$vocationalSem1 = $_POST['vocationalSem1'];
$vocationalSem2 = $_POST['vocationalSem2'];
$coCurriculumSem1 = $_POST['coCurriculumSem1'];
$coCurriculumSem2 = $_POST['coCurriculumSem2'];
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
$form = '';
if (isset($_POST['form'])) {
    $form = $_POST['form'];
}
$photo = '';
if (isset($_POST['photo'])) {
    $photo = $_POST['photo'];
}
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
$categoryCertificate = '';
if (isset($_POST['categoryCertificate'])) {
    $categoryCertificate = $_POST['categoryCertificate'];
}
$subCategoryCertificate = '';
if (isset($_POST['subCategoryCertificate'])) {
    $subCategoryCertificate = $_POST['subCategoryCertificate'];
}
$academicDetails = json_decode($_POST['academicDetails'], true);
$documents = json_decode($_POST['documents'], true);
$guardianName = $_POST['guardianName'];
$relationOfApplicant = $_POST['relationOfApplicant'];
$nationalCompetition = $_POST['nationalCompetition'];
$nationalCertificate = '';
if (isset($_POST['nationalCertificate'])) {
    $nationalCertificate = $_POST['nationalCertificate'];
}
$otherCompetition = $_POST['otherCompetition'];
$otherCertificate = '';
if (isset($_POST['otherCertificate'])) {
    $otherCertificate = $_POST['otherCertificate'];
}
$ncc = $_POST['ncc'];
$nccCertificate = '';
if (isset($_POST['nccCertificate'])) {
    $nccCertificate = $_POST['nccCertificate'];
}
$freedomFighter = $_POST['freedomFighter'];
$nationalSevaScheme = $_POST['nationalSevaScheme'];
$nssDocument = '';
if (isset($_POST['nssDocument'])) {
    $nssDocument = $_POST['nssDocument'];
}
$roverRanger = $_POST['roverRanger'];
$otherRoverRanger = $_POST['otherRoverRanger'];
$rrDocument = '';
if (isset($_POST['rrDocument'])) {
    $rrDocument = $_POST['rrDocument'];
}
$bcom = $_POST['bcom'];
$other = $_POST['other'];
$totalMeritCount = $_POST['totalMeritCount'];
$signature = '';
if (isset($_POST['signature'])) {
    $signature = $_POST['signature'];
}
$uploadExtraMark = $_POST['uploadExtraMark'];

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
            } else if ($key == 'signature') {
                $signature = $dbPath;
            }  else if ($key == 'otherCertificate') {
                $otherCertificate = $dbPath;
            }  else if ($key == 'rrDocument') {
                $rrDocument = $dbPath;
            }  else if ($key == 'uploadExtraMark') {
                $uploadExtraMark = $dbPath;
            } else {
                $documents[$count]['document'] = $dbPath;
                $count = $count + 1;
            }
        }
    }
}

$documents = json_encode($documents);
$academicDetails = json_encode($academicDetails);
$major1 = json_encode($major1);
$major2 = json_encode($major2);


if ($registrationNo == NULL || $registrationNo == '') {
    $registrationNo = uniqid();

    $sql = "INSERT INTO faculty_course_details (registrationNo,faculty,courseType,
    major1,major2, major3, major4, vocationalSem1, vocationalSem2, coCurriculumSem1, coCurriculumSem2,  lastUpdated, creationTime) 
        VALUES ('$registrationNo','$faculty','$courseType','$major1','$major2','$major3','$major4',
        '$vocationalSem1',$vocationalSem2,'$coCurriculumSem1','$coCurriculumSem2','$creationTime','$creationTime')";
    mysqli_query($con, $sql);

    $sql1 = "INSERT INTO basic_details (registrationNo, vaccinated, nameTitle, name, dob, gender, religion, 
    caste, category, subCategory, categoryCertificate, subCategoryCertificate, personalMobile, 
    parentMobile, aadharNo, email, mediumOfInstitution, photo, wrn, form, signature, submitted, lastUpdated, creationTime) 
        VALUES ('$registrationNo', '$vaccinated', '$nameTitle', '$name', '$dob', '$gender', 
    '$religion', '$caste', '$category', '$subCategory', '$categoryCertificate', 
    '$subCategoryCertificate', '$personalMobile', '$parentMobile', '$aadharNo', '$email', 
    '$mediumOfInstitution', '$photo', '$wrn', '$form', '$signature', '$submit', '$creationTime','$creationTime')";
    //   echo $sql1;
    mysqli_query($con, $sql1);


    $sql2 = "INSERT INTO advanced_details (registrationNo,
    fatherName , motherName , parentsOccupation , guardianName , relationOfApplicant , 
    houseNo , street , pincode , postOffice , state , city , cHouseNo , cStreet , cPincode , cPostOffice , cState , cCity, lastUpdated, creationTime ) 
        VALUES ('$registrationNo',
    '$fatherName' , '$motherName' , '$parentsOccupation' , '$guardianName' , 
    '$relationOfApplicant' , '$houseNo' , '$street' , '$pincode' , '$postOffice' , 
    '$state' , '$city' , '$cHouseNo' , '$cStreet' , '$cPincode' , '$cPostOffice' , '$cState' , '$cCity', '$creationTime', '$creationTime' )";
    $con->query($sql2);

    $sql3 = "INSERT INTO academic_details (registrationNo,academicDetails,lastUpdated,creationTime) 
        VALUES ('$registrationNo','$academicDetails')";
    $con->query($sql3);

    $sql4 = "INSERT INTO documents (registrationNo,documents,lastUpdated,creationTime) 
        VALUES ('$registrationNo','$documents','$creationTime','$creationTime')";
    $con->query($sql4);

    $sql5 = "INSERT INTO merit_details (registrationNo,
    nationalCompetition , nationalCertificate , otherCompetition , otherCertificate , 
    ncc , nccCertificate , freedomFighter , nationalSevaScheme , nssDocument , roverRanger , 
    otherRoverRanger , rrDocument , bcom , other , uploadExtraMark, totalMeritCount, lastUpdated, creationTIme) 
        VALUES ('$registrationNo', 
    '$nationalCompetition' , '$nationalCertificate' , '$otherCompetition' , '$otherCertificate' , 
    '$ncc' , '$nccCertificate' , '$freedomFighter' , '$nationalSevaScheme' , '$nssDocument' , 
    '$roverRanger' , '$otherRoverRanger' , '$rrDocument' , '$bcom' , '$other' , '$uploadExtraMark', 
    '$totalMeritCount', '$creationTime', '$creationTime')";
    $con->query($sql5);

    $sql6 = "INSERT INTO users_info (user_id,user_name ,password ,role ,active) 
        VALUES ('$registrationNo','$registrationNo' ,'$dob' ,'STUDENT' ,'1')";
    $con->query($sql6);
} else {

    //update code
    $sql = "UPDATE faculty_course_details SET 
    faculty='$faculty', courseType='$courseType', major1='$major1', major2='$major2' ,
    major3='$major3',major4='$major4',vocationalSem1='$vocationalSem1',vocationalSem2='$vocationalSem2',
    coCurriculumSem1='$coCurriculumSem1',coCurriculumSem2='$coCurriculumSem2',lastUpdated='$creationTime'
    WHERE registrationNo='$registrationNo'";
    $con->query($sql);

    $sql1 = "UPDATE basic_details SET vaccinated='$vaccinated', 
    nameTitle='$nameTitle', name='$name', dob='$dob', gender='$gender', religion='$religion', 
    caste='$caste', category='$category', subCategory='$subCategory', categoryCertificate='$categoryCertificate', 
    subCategoryCertificate='$subCategoryCertificate', personalMobile='$personalMobile', parentMobile='$parentMobile', 
    aadharNo='$aadharNo', email='$email', mediumOfInstitution='$mediumOfInstitution', photo='$photo', wrn='$wrn', 
    form='$form', signature='$signature', submitted='$submit', lastUpdated='$creationTime'
    WHERE registrationNo='$registrationNo'";
    $con->query($sql1);

    $sql2 = "UPDATE advanced_details SET 
    fatherName='$fatherName', motherName='$motherName', parentsOccupation='$parentsOccupation', 
    guardianName='$guardianName', relationOfApplicant='$relationOfApplicant', houseNo='$houseNo', street='$street', 
    pincode='$pincode', postOffice='$postOffice', state='$state', city='$city', cHouseNo='$cHouseNo', cStreet='$cStreet', 
    cPincode='$cPincode', cPostOffice='$cPostOffice', cState='$cState', cCity='$cCity', lastUpdated='$creationTime'
    WHERE registrationNo='$registrationNo'";
    $con->query($sql2);

    $sql3 = "UPDATE academic_details SET academicDetails='$academicDetails',lastUpdated='$creationTime' WHERE registrationNo='$registrationNo'";
    $con->query($sql3);

    $sql4 = "UPDATE documents SET documents='$documents',lastUpdated='$creationTime' WHERE registrationNo='$registrationNo'";
    $con->query($sql4);

    $sql5 = "UPDATE merit_details SET
    nationalCompetition='$nationalCompetition', nationalCertificate='$nationalCertificate', 
    otherCompetition='$otherCompetition', otherCertificate='$otherCertificate', ncc='$ncc', 
    nccCertificate='$nccCertificate', freedomFighter='$freedomFighter', nationalSevaScheme='$nationalSevaScheme', 
    nssDocument='$nssDocument', roverRanger='$roverRanger', otherRoverRanger='$otherRoverRanger', rrDocument='$rrDocument', 
    bcom='$bcom', other='$other', uploadExtraMark='$uploadExtraMark', totalMeritCount='$totalMeritCount', lastUpdated='$creationTime' WHERE registrationNo='$registrationNo'";
    $con->query($sql5);

    $sql6 = "UPDATE users_info SET password='$dob' WHERE user_id='$registrationNo'";
    $con->query($sql6);
}

$data = array(
    'registrationNo' => $registrationNo, 'active' => "1", 'submitted'=> $submit,
    'role' => "STUDENT", 'user_id' => $registrationNo, 'user_name' => $registrationNo
);

$dbConnection->closeConnection();
echo createToken($data);
