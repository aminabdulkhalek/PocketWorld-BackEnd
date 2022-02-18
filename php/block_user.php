<?php
session_start();

include("db_info.php");
// getting user1_id through get request
$id1 = $_GET["id1"];
$id1 = base64_decode($id1);
// getting user2_id through get request
$id2 = $_GET["id2"];

// getting is_blocked value 
$check_query = $mysqli->prepare("SELECT is_blocked FROM connections where (user1_id=? AND user2_id=?) or (user1_id=? AND user2_id=?) ");
$check_query->bind_param("iiii", $id1, $id2, $id2, $id1);
$check_query->execute();
//getting result from database as an object (will use that to fetch associations)
$check = $check_query->get_result(); 
// returns associative array with is_blocked as key and its value
$result = $check->fetch_assoc();

$array_response = [];
if ($result["is_blocked"] == 0){
    $is_blocked = 1;
    $array_response["status"] = "user blocked";
}else{
    $is_blocked = 0;
    $array_response["status"] = "user unblocked";
}


$query = $mysqli->prepare("UPDATE connections SET is_blocked= ? WHERE (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?)"); 

$query->bind_param("iiiii",$is_blocked, $id1, $id2, $id2, $id1);
$query->execute();



$json_response = json_encode($array_response);
echo $json_response;


?>