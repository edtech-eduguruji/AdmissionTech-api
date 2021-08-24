<?php
require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');

function createCheckSum($str) {
    $db = parse_ini_file(dirname(__DIR__) . "/api/DbProperties.ini");
    
    $checksum = hash_hmac('sha256',$str, $db['checksum'], false);
    $checksum = strtoupper($checksum);
    return $checksum;
}
echo createCheckSum($_POST['str']);