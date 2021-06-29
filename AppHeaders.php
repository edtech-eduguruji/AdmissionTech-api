<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PATCH, OPTIONS');
header('Access-Control-Expose-Headers: ANDROIDVERSION, NPMVERSION');

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$db = parse_ini_file(dirname(__DIR__) . "/AdmissionTech-api/DbProperties.ini");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}
