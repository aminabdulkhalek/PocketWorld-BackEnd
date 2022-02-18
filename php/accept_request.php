<?php
session_start();

include("db_info.php");

$id1 = $_GET["id1"];
$id1 = base64_decode($id1);
$id2 = $_GET["id2"];
$is_pending = 0;

$query = $mysqli->prepare("UPDATE connections SET is_pending = ? WHERE (user1_id=? AND user2_id=?) OR (User1_id=? AND user2_id=?)"); 
$query->bind_param("sssss", $is_pending, $id1, $id2, $id2, $id1);
$query->execute();

$array_response = [];
$array_response["status"] = "Friend added!";

$json_response = json_encode($array_response);
echo $json_response;


?>