<?php
session_start();

include("db_info.php");


$text = $_POST["text"];
$post_id = $_POST["post_id"];


$query = $mysqli->prepare("UPDATE posts SET Post_content=? WHERE ID=?");

$query->bind_param("ss", $text, $post_id);
$query->execute();

$array_response = [];
$array_response["status"] = "post updated";
$json_response = json_encode($array_response);
echo $json_response;

?>