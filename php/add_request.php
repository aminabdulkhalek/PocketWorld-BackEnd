<?php
session_start();

include("db_info.php");

$id1 = $_GET["id1"];
$id1 = base64_decode($id1);
$id2 = $_GET["id2"];
$is_pending = 1;

$check_query = $mysqli->prepare("SELECT * FROM connections where (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?)");
$check_query->bind_param("ssss", $id1, $id2, $id2, $id1);
$check_query->execute();
$check_query->store_result();
$num_rows = $check_query->num_rows;
$check_query->fetch();

$array_response = [];

if ($num_rows == 0){
    $query = $mysqli->prepare("INSERT INTO connections (user1_id, user2_id, is_pending) VALUES (?,?,?)"); 
    $query->bind_param("ssi", $id1, $id2, $is_pending);
    $query->execute();
    $array_response["status"] = "request sent";
}else{
    $array_response["status"] = "connection already exists";
}

$json_response = json_encode($array_response);
echo $json_response;



?>