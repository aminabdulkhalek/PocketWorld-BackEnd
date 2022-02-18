<?php

include("db_info.php");

$post_id = $_POST["post_id"];


$query = $mysqli->prepare("DELETE FROM posts WHERE ID=?");
$query->bind_param("s", $post_id);
$query->execute();

$array_response = [];
$array_response["status"] = "post deleted";
$json_response = json_encode($array_response);
echo $json_response;
?>