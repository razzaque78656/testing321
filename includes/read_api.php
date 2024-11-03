<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin:*');

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
include "./config.php";


session_start();


if (isset($_COOKIE['LoggedIn']) ) {

    $cookies = $_COOKIE['LoggedIn'];
    $cookies = explode('.',$cookies);
    $cookies = end($cookies);
    $output = array('loggedIn' => 'true', 'status' => true,'user_id'=>$cookies);
    echo json_encode($output);
} else {
    $output = array('loggedIn' => 'false', 'status' => false);
    echo json_encode($output);
}
?>
