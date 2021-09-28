<?php

use \Firebase\JWT\JWT;

require "vendor/Base64UrlEncoder.php";
require "vendor/autoload.php";

date_default_timezone_set('Asia/Kolkata');
function getCurrentTime()
{
    $currentTime = sprintf('%u', (microtime(true) * 1000));
    return $currentTime;
}
function getCurrentDay()
{
    $currentTime = date('Y-m-d', strtotime('0 days'));
    $currentDay = 1000 * strtotime($currentTime);
    return $currentDay;
}
function verifyUser($userId, $con)
{
    $query = "SELECT active FROM users_info WHERE user_id = '$userId' ";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['active'] == 0) {
                header('HTTP/1.0 401 Unauthorized');
            }
        }
    } else {
        header('HTTP/1.0 401 Unauthorized');
    }
}
function createCheckSum($str)
{
    $db = parse_ini_file(dirname(__DIR__) . "/api/DbProperties.ini");

    $checksum = hash_hmac('sha256', $str, $db['checksum'], false);
    $checksum = strtoupper($checksum);
    return $checksum;
}

function getQueryApi($requestType, $transactionId, $time)
{
    $db = parse_ini_file(dirname(__DIR__) . "/api/DbProperties.ini");

    $str = $requestType . '|' . $db['MERCHANTID'] . '|' . $transactionId . '|' . $time;
    $checkSumVal = createCheckSum($str);

    $msg = $str . '|' . $checkSumVal;

    $postfields = ["msg" => $msg];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.billdesk.com/pgidsk/PGIQueryController");

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));

    // Receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);
    curl_close($ch);

    return $server_output;
}

function createToken($userInfo)
{
    $secret_key = "Kushal-Maharaj-Ki-Jai";
    $issuer_claim = "AdmissionTech";
    $audience_claim = "Users";
    $issuedat_claim = time();
    $notbefore_claim = $issuedat_claim + 10;
    $token = array(
        "iss" => $issuer_claim,
        "aud" => $audience_claim,
        "iat" => $issuedat_claim,
        "nbf" => $notbefore_claim,
        'data' => $userInfo
    );
    $jwt = JWT::encode($token, $secret_key);
    return $jwt;
}

function verifyToken($jwt)
{
    // Spliting the token
    $tokenParts = explode('.', $jwt);
    $header = base64_decode($tokenParts[0]);
    $payload = base64_decode($tokenParts[1]);
    $signatureProvided = $tokenParts[2];

    // Building a signature based on the header and payload using the secret key
    $base64UrlHeader = base64UrlEncode($header);
    $base64UrlPayload = base64UrlEncode($payload);
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'Kushal-Maharaj-Ki-Jai', true);
    $base64UrlSignature = base64UrlEncode($signature);

    // verify it matches the signature provided in the token
    $signatureValid = ($base64UrlSignature === $signatureProvided);

    if (!$signatureValid) {
        return false;
    } else {
        return true;
    }
}

function filtersQuery($courseType, $year, $category, $regNo, $fromDate, $toDate, $status, $faculty, $major1)
{
    $condition = "";
    $count = 0;
    if (!empty($regNo)) {
        $condition = "basic_details.registrationNo='$regNo'";
        $count++;
    }
    if (!empty($courseType)) {
        if ($count > 0) {
            $condition = $condition . " AND ";
        }
        $condition = $condition . "faculty_course_details.courseType = '$courseType' ";
        $count++;
    }
    if (!empty($year)) {
        if ($count > 0) {
            $condition = $condition . " AND ";
        }
        $condition = $condition . "faculty_course_details.admissionYear = '$year' ";
        $count++;
    }
    if (!empty($category)) {
        if ($count > 0 && $category != 'all') {
            $condition = $condition . " AND ";
        }
        if ($category != 'all') {
            $condition = $condition . "basic_details.category = '$category' ";
        }
        $count++;
    }
    if (!empty($fromDate)) {
        if ($count > 0) {
            $condition = $condition . " AND ";
        }
        $condition = $condition . "basic_details.creationTime >= '$fromDate' ";
        $count++;
    }
    if (!empty($toDate)) {
        if ($count > 0) {
            $condition = $condition . " AND ";
        }
        $condition = $condition . "basic_details.creationTime <= '$toDate' ";
        $count++;
    }
    if (!empty($status)) {
        if ($count > 0) {
            $condition = $condition . " AND ";
        }
        if ($status == 'submittedForms') {
            $statusCondition = "basic_details.payment='1' AND basic_details.submitted='1'";
        } else if ($status == 'prospectusPayment') {
            $statusCondition = "basic_details.payment='1' AND basic_details.submitted='0'";
        } else if ($status == 'submittedFormsWithCourseFee') {
            $statusCondition = "basic_details.payment='1' AND basic_details.submitted='1' AND basic_details.courseFee='1'";
        } else if ($status == 'submittedFormsWithoutCourseFee') {
            $statusCondition = "basic_details.payment='1' AND basic_details.submitted='1' AND basic_details.courseFee='0'";
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
    if (!empty($major1)) {
        if ($count > 0) {
            $condition = $condition . " AND ";
        }
        $condition = $condition . "faculty_course_details.major1 LIKE '%$major1%'";
        $count++;
    }
    if ($count == 0) {
        return "basic_details.payment = '1' AND basic_details.submitted = '1'";
    } else {
        return $condition;
    }
}
