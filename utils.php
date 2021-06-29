<?php

function getDBProperty()
{
    return parse_ini_file(dirname(__DIR__) . "/AdmissionTech-api/DbProperties.ini");
}

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
