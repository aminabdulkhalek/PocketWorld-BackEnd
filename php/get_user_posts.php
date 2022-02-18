<?php

include("db_info.php");

$id = $_GET["id"];
$id = base64_decode($id);


$query = $mysqli->prepare("SELECT * from posts WHERE User_ID =?");

$query->bind_param("s", $id);
$query->execute();

$result = $query->get_result();

$connections = [];

while($connection1 = $result->fetch_assoc()){
    $connections[] = $connection1;
}


$json_response = json_encode($connections);
echo $json_response;

?>