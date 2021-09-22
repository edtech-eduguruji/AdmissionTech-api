<?php

require('../AppHeaders.php');
include_once('../DBConnection.php');
include_once('../utils.php');

$dbConnection = new DBConnection($db);
$con = $dbConnection->getConnection();


$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case "GET":
        $registrationNo = $_GET['registrationNo'];

        $sql_query = "SELECT payment.*, basic_details.submitted,basic_details.payment,users_info.user_id,users_info.user_name,
        users_info.password,users_info.role,users_info.active FROM users_info 
        INNER JOIN basic_details ON users_info.user_id = basic_details.registrationNo 
        INNER JOIN payment ON payment.registrationNo = basic_details.registrationNo 
        WHERE payment.registrationNo='$registrationNo' and basic_details.payment='1' and
        (payment.courseFee='0' and AuthStatusCode='0300') or (basic_details.courseFee='1' and payment.courseFee='1' and AuthStatusCode='0300') ";

        $result = mysqli_query($con, $sql_query);

        if (mysqli_num_rows($result) > 0) {
            $json = array();
            while($row = mysqli_fetch_assoc($result)){
                $json[] = $row;
            }
            $response = array("payment"=>createToken($json[0]));
            if(count($json)>1) {
                $response['courseFee'] = createToken($json[1]);
            }
            
            echo json_encode($response);
        }
        $dbConnection->closeConnection();
        break;

    case "POST":
        $registrationNo = $_GET['registrationNo'];

        $sql_query = "SELECT payment.*, basic_details.submitted,basic_details.payment,users_info.user_id,users_info.user_name,
        users_info.password,users_info.role,users_info.active FROM users_info 
        INNER JOIN basic_details ON users_info.user_id = basic_details.registrationNo 
        INNER JOIN payment ON payment.registrationNo = basic_details.registrationNo 
        WHERE payment.registrationNo='$registrationNo' ";

        $result = mysqli_query($con, $sql_query);

        if (mysqli_num_rows($result) > 0) {
            $response = (mysqli_fetch_assoc($result));
            echo createToken($response);
        }
        $dbConnection->closeConnection();
        break;
}