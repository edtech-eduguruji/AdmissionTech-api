<?php
require "vendor/autoload.php";
use \Firebase\JWT\JWT;

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
function createToken($userInfo) {
    $secret_key = "YOUR_SECRET_KEY";
    $issuer_claim = "THE_ISSUER"; // this can be the servername
    $audience_claim = "THE_AUDIENCE";
    $issuedat_claim = time(); // issued at
    $notbefore_claim = $issuedat_claim + 10; //not before in seconds
    //$expire_claim = $issuedat_claim + 60; // expire time in seconds
    $token = array(
        "iss" => $issuer_claim,
        "aud" => $audience_claim,
        "iat" => $issuedat_claim,
        "nbf" => $notbefore_claim,
        //"exp" => $expire_claim,
        'data' => $userInfo
    );
    $jwt = JWT::encode($token, $secret_key);
    return $jwt;
}