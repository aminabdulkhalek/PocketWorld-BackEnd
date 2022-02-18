<?php
session_start();

include("db_info.php");

$id1 = $_GET["id1"];
$id1 = base64_decode($id1);
$id2 = $_GET["id2"];

$query = $mysqli->prepare("DELETE FROM connections where (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?) "); 
$query->bind_param("iiii", $id1, $id2, $id2, $id1);
$query->execute();

$array_response = [];
$array_response["status"] = "Friend removed!";

$json_response = json_encode($array_response);
echo $json_response;


?>