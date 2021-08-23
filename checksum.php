<?php
require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');
$db = parse_ini_file(dirname(__DIR__) . "/api/DbProperties.ini");

$requestMethod = $_SERVER['REQUEST_METHOD'];
switch ($requestMethod) {
    case "POST":
        $str = $_POST['str'];
        $checksum = hash_hmac('sha256',$str, $db['checksum'], false);
        $checksum = strtoupper($checksum);
        echo ($checksum);
        break;

    case "GET":
        break;

    case "DELETE":
        break;

    case "PATCH":
        $response = array();
        array_push($response, array('Result' => "Success"));
        echo json_encode($response);
        // $dbConnection->closeConnection();
        break;
}