<?php
require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();

$jwt = $dbConnection->getUserData("Authentication");
$isTokenValid = verifyToken($jwt);
set_time_limit(500);

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case "POST":
        if ($isTokenValid) {
            $creationTime = getCurrentTime();
            $data = array();
            $registrationNo = $_POST['registrationNo'];

            if (!file_exists("../uploads/" . $registrationNo)) {
                mkdir("../uploads/" . $registrationNo, 0777, true);
            }

            $form = '';
            if (isset($_POST['form'])) {
                $form = $_POST['form'];
            }
            $photo = '';
            if (isset($_POST['photo'])) {
                $photo = $_POST['photo'];
            }
            $categoryCertificate = '';
            if (isset($_POST['categoryCertificate'])) {
                $categoryCertificate = $_POST['categoryCertificate'];
            }
            $subCategoryCertificate = '';
            if (isset($_POST['subCategoryCertificate'])) {
                $subCategoryCertificate = $_POST['subCategoryCertificate'];
            }
            $nationalCertificate = '';
            if (isset($_POST['nationalCertificate'])) {
                $nationalCertificate = $_POST['nationalCertificate'];
            }
            $otherCertificate = '';
            if (isset($_POST['otherCertificate'])) {
                $otherCertificate = $_POST['otherCertificate'];
            }
            $nccCertificate = '';
            if (isset($_POST['nccCertificate'])) {
                $nccCertificate = $_POST['nccCertificate'];
            }
            $nssDocument = '';
            if (isset($_POST['nssDocument'])) {
                $nssDocument = $_POST['nssDocument'];
            }
            $rrDocument = '';
            if (isset($_POST['rrDocument'])) {
                $rrDocument = $_POST['rrDocument'];
            }
            $uploadExtraMark = '';
            if (isset($_POST['uploadExtraMark'])) {
                $uploadExtraMark = $_POST['uploadExtraMark'];
            }
            $signature = '';
            if (isset($_POST['signature'])) {
                $signature = $_POST['signature'];
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
                if ($filetype == "image/png" || $filetype == "image/jpeg" || $filetype == "image/jpg" || $filetype == "application/pdf") {
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
                        } else if ($key == 'otherCertificate') {
                            $otherCertificate = $dbPath;
                        } else if ($key == 'rrDocument') {
                            $rrDocument = $dbPath;
                        } else if ($key == 'uploadExtraMark') {
                            $uploadExtraMark = $dbPath;
                        } else {
                            $documents[$count]['document'] = $dbPath;
                            $count++;
                        }
                    }
                }
            }

            $actionType = $_POST['formAction'];
            if ($actionType == '0') {  // Course Details
                $admissionYear = $_POST['admissionYear'];
                $courseType = $_POST['courseType'];
                $mediumOfInstitution = $_POST['mediumOfInstitution'];
                $sql = "UPDATE faculty_course_details SET courseType='$courseType', admissionYear='$admissionYear'
                WHERE registrationNo='$registrationNo'";
                $con->query($sql);
                $sql1 = "UPDATE basic_details SET mediumOfInstitution='$mediumOfInstitution'
                WHERE registrationNo='$registrationNo'";
                $con->query($sql1);
            } else if ($actionType == '1') {  // Basic Details
                $vaccinated = $_POST['vaccinated'];
                $nameTitle = $_POST['nameTitle'];
                $name = $con->real_escape_string($_POST['name']);
                $dob = $_POST['dob'];
                $gender = $_POST['gender'];
                $caste = $con->real_escape_string($_POST['caste']);
                $religion = $_POST['religion'];
                $personalMobile = $_POST['personalMobile'];
                $parentMobile = $_POST['parentMobile'];
                $wrn = $_POST['wrn'];
                $aadharNo = $_POST['aadharNo'];
                $email = $con->real_escape_string($_POST['email']);
                $category = $_POST['category'];
                $subCategory = $_POST['subCategory'];
                $sql1 = "UPDATE basic_details SET vaccinated='$vaccinated', 
                nameTitle='$nameTitle', name='$name', dob='$dob', gender='$gender', religion='$religion', 
                caste='$caste', category='$category', subCategory='$subCategory', categoryCertificate='$categoryCertificate', 
                subCategoryCertificate='$subCategoryCertificate', personalMobile='$personalMobile', parentMobile='$parentMobile', 
                aadharNo='$aadharNo', email='$email', photo='$photo', wrn='$wrn', form='$form', signature='$signature', lastUpdated='$creationTime'
                WHERE registrationNo='$registrationNo'";
                $con->query($sql1);
            } else if ($actionType == '2') { // Parent Details
                $fatherName = $_POST['fatherName'];
                $motherName = $_POST['motherName'];
                $parentsOccupation = $_POST['parentsOccupation'];
                $guardianName = $_POST['guardianName'];
                $relationOfApplicant = $_POST['relationOfApplicant'];
                $sql2 = "UPDATE advanced_details SET fatherName='$fatherName', motherName='$motherName', parentsOccupation='$parentsOccupation', 
                guardianName='$guardianName', relationOfApplicant='$relationOfApplicant' WHERE registrationNo='$registrationNo'";
                $con->query($sql2);
            } else if ($actionType == '3') { // Permanent Address
                $houseNo = $con->real_escape_string($_POST['houseNo']);
                $street = $con->real_escape_string($_POST['street']);
                $pincode = $_POST['pincode'];
                $postOffice = $con->real_escape_string($_POST['postOffice']);
                $state = $_POST['state'];
                $city = $_POST['city'];
                $sql2 = "UPDATE advanced_details SET houseNo='$houseNo', street='$street', pincode='$pincode', 
                postOffice='$postOffice', state='$state', city='$city' WHERE registrationNo='$registrationNo'";
                $con->query($sql2);
            } else if ($actionType == '4') { // Correspondence Address
                $cHouseNo = $con->real_escape_string($_POST['cHouseNo']);
                $cStreet = $con->real_escape_string($_POST['cStreet']);
                $cPincode = $_POST['cPincode'];
                $cPostOffice = $con->real_escape_string($_POST['cPostOffice']);
                $cState = $_POST['cState'];
                $cCity = $_POST['cCity'];
                $sql2 = "UPDATE advanced_details SET 
                cHouseNo='$cHouseNo', cStreet='$cStreet', cPincode='$cPincode', cPostOffice='$cPostOffice', cState='$cState', 
                cCity='$cCity', lastUpdated='$creationTime' WHERE registrationNo='$registrationNo'";
                $con->query($sql2);
            } else if ($actionType == '5') { // Academic Details
                $academicDetails = json_decode($_POST['academicDetails'], true);
                $academicDetails = json_encode($academicDetails);
                $sql = "UPDATE academic_details SET academicDetails='$academicDetails', lastUpdated='$creationTime' 
                WHERE registrationNo='$registrationNo'";
                $con->query($sql);
            } else if ($actionType == '6') { // Faculty Details
                $faculty = $_POST['faculty'];
                $major1 = json_decode($_POST['major1'], true);
                $major2 = json_decode($_POST['major2'], true);
                $major1 = json_encode($major1);
                $major2 = json_encode($major2);
                $major3 = $_POST['major3'];
                $major4 = $_POST['major4'];
                $vocationalSem1 = $_POST['vocationalSem1'];
                $vocationalSem2 = $_POST['vocationalSem2'];
                $coCurriculumSem1 = $_POST['coCurriculumSem1'];
                $coCurriculumSem2 = $_POST['coCurriculumSem2'];
                $sql = "UPDATE faculty_course_details SET 
                faculty='$faculty', courseType='$courseType', admissionYear='$admissionYear', major1='$major1', major2='$major2' ,
                major3='$major3',major4='$major4',vocationalSem1='$vocationalSem1',vocationalSem2='$vocationalSem2',
                coCurriculumSem1='$coCurriculumSem1',coCurriculumSem2='$coCurriculumSem2',lastUpdated='$creationTime'
                WHERE registrationNo='$registrationNo'";
                $con->query($sql);
            } else if ($actionType == '7') { // Upload Documents
                $documents = json_decode($_POST['documents'], true);
                $documents = json_encode($documents);
                $sql = "UPDATE documents SET documents='$documents',lastUpdated='$creationTime' 
                WHERE registrationNo='$registrationNo'";
                $con->query($sql);
            } else if ($actionType == '8') { // Merit Details
                $nationalCompetition = $_POST['nationalCompetition'];
                $otherCompetition = $_POST['otherCompetition'];
                $ncc = $_POST['ncc'];
                $freedomFighter = $_POST['freedomFighter'];
                $nationalSevaScheme = $_POST['nationalSevaScheme'];
                $roverRanger = $_POST['roverRanger'];
                $otherRoverRanger = $_POST['otherRoverRanger'];
                $bcom = $_POST['bcom'];
                $other = $_POST['other'];
                $totalMeritCount = $_POST['totalMeritCount'];
                $sql = "UPDATE merit_details SET
                nationalCompetition='$nationalCompetition', nationalCertificate='$nationalCertificate', 
                otherCompetition='$otherCompetition', otherCertificate='$otherCertificate', ncc='$ncc', 
                nccCertificate='$nccCertificate', freedomFighter='$freedomFighter', nationalSevaScheme='$nationalSevaScheme', 
                nssDocument='$nssDocument', roverRanger='$roverRanger', otherRoverRanger='$otherRoverRanger', rrDocument='$rrDocument', 
                bcom='$bcom', other='$other', uploadExtraMark='$uploadExtraMark', totalMeritCount='$totalMeritCount', lastUpdated='$creationTime' WHERE registrationNo='$registrationNo'";
                $con->query($sql);
            } else if ($actionType == '9') { // Declaration
                $sql = "UPDATE basic_details SET 
                signature='$signature', lastUpdated='$creationTime'
                WHERE registrationNo='$registrationNo'";
                $con->query($sql);
            }
            if (isset($_POST['submit'])) {
                if (!$form && !$photo && !$signature) {
                    header('HTTP/1.0 406 Unacceptable');
                } else {
                    // SUBMITTING FORM
                    $sql = "UPDATE basic_details SET submitted='1', lastUpdated='$creationTime'
                    WHERE registrationNo='$registrationNo'";
                    $con->query($sql);
                }
            }
            $dbConnection->closeConnection();
        } else {
            header('HTTP/1.0 401 Unauthorized');
        }
        break;

    case "GET":
        if ($isTokenValid) {
            $response = null;
            $registrationNo = $_GET['registrationNo'];
            $actionType = $_GET['formAction'];
            if ($actionType == '0') {  // Course Details
                $QUERY = "SELECT basic_details.mediumOfInstitution, faculty_course_details.courseType, faculty_course_details.admissionYear FROM basic_details
                INNER JOIN faculty_course_details ON basic_details.registrationNo = faculty_course_details.registrationNo ";
                $WHERE = "WHERE basic_details.registrationNo='$registrationNo'";
            } else if ($actionType == '1') {  // Basic Details
                $QUERY = "SELECT basic_details.vaccinated, basic_details.nameTitle, 
                basic_details.name, basic_details.dob, basic_details.gender, basic_details.religion, basic_details.caste, 
                basic_details.category, basic_details.subCategory, basic_details.categoryCertificate, basic_details.subCategoryCertificate, 
                basic_details.personalMobile, basic_details.parentMobile, basic_details.aadharNo, basic_details.email, 
                basic_details.photo, basic_details.wrn FROM basic_details ";
                $WHERE = "WHERE registrationNo='$registrationNo'";
            } else if ($actionType == '2') { // Parent Details
                $QUERY = "SELECT advanced_details.fatherName, advanced_details.motherName, advanced_details.parentsOccupation, advanced_details.guardianName, 
                advanced_details.relationOfApplicant FROM advanced_details ";
                $WHERE = "WHERE registrationNo='$registrationNo'";
            } else if ($actionType == '3') { // Permanent Address
                $QUERY = "SELECT advanced_details.houseNo, advanced_details.street, advanced_details.pincode, 
                advanced_details.postOffice, advanced_details.state, advanced_details.city FROM advanced_details ";
                $WHERE = "WHERE registrationNo='$registrationNo'";
            } else if ($actionType == '4') { // Correspondence Address
                $QUERY = "SELECT advanced_details.cHouseNo, advanced_details.cStreet, advanced_details.cPincode, 
                advanced_details.cPostOffice, advanced_details.cState, advanced_details.cCity FROM advanced_details ";
                $WHERE = "WHERE registrationNo='$registrationNo'";
            } else if ($actionType == '5') { // Academic Details
                $QUERY = "SELECT academic_details.academicDetails FROM academic_details ";
                $WHERE = "WHERE registrationNo='$registrationNo'";
            } else if ($actionType == '6') { // Faculty Details
                $QUERY = "SELECT faculty_course_details.faculty, faculty_course_details.courseType, faculty_course_details.admissionYear, 
                faculty_course_details.major1, faculty_course_details.major2, faculty_course_details.major3, faculty_course_details.major4, 
                faculty_course_details.vocationalSem1, faculty_course_details.vocationalSem2, faculty_course_details.coCurriculumSem1, 
                faculty_course_details.coCurriculumSem2 FROM faculty_course_details ";
                $WHERE = "WHERE registrationNo='$registrationNo'";
            } else if ($actionType == '7') { // Upload Documents
                $QUERY = "SELECT documents.documents FROM documents ";
                $WHERE = "WHERE registrationNo='$registrationNo'";
            } else if ($actionType == '8') { // Merit Details
                $QUERY = "SELECT merit_details.nationalCompetition, merit_details.nationalCertificate, merit_details.otherCompetition, merit_details.otherCertificate, merit_details.ncc, merit_details.nccCertificate, 
                merit_details.freedomFighter, merit_details.nationalSevaScheme, merit_details.nssDocument, merit_details.roverRanger, merit_details.otherRoverRanger, 
                merit_details.rrDocument, merit_details.bcom, merit_details.other, merit_details.uploadExtraMark, merit_details.totalMeritCount FROM merit_details ";
                $WHERE = "WHERE registrationNo='$registrationNo'";
            } else if ($actionType == '9') { // Declaration
                $QUERY = "SELECT basic_details.signature FROM basic_details ";
                $WHERE = "WHERE registrationNo='$registrationNo'";
            }
            $sql_query = "$QUERY $WHERE";
            $result = mysqli_query($con, $sql_query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $response = $row;
                }
            } else {
                header(' 500 Internal Server Error', true, 500);
            }
        } else {
            header('HTTP/1.0 401 Unauthorized');
        }
        echo json_encode($response);
        $dbConnection->closeConnection();
        break;
}
