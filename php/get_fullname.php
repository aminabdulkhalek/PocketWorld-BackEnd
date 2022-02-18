<?php
header("Access-Control-Allow-Origin: *");
include("db_info.php");

$id = $_POST["id"];

$query = $mysqli->prepare("SELECT first_name, last_name FROM users where ID =?");
$query->bind_param("s", $id);
$query->execute();

$result = $query->get_result();
$row = $result->fetch_assoc();

$array_response = [];
$array_response["first_name"] = $row["first_name"];
$array_response["last_name"] = $row["last_name"];


$json_response = json_encode($array_response);
echo $json_response;

$query->close();
$mysqli->close();

?>