<?php

include("db_info.php");

$id = $_GET["id"];
$id = base64_decode($id);
$is_blocked = 1;


$query = $mysqli->prepare("SELECT user1_id as blocked from connections WHERE NOT user1_id=? AND ((user2_id=?) AND is_blocked = ?) UNION SELECT user2_id from connections WHERE NOT user2_id=? AND ((user1_id=?) AND is_blocked = ?)");

$query->bind_param("iiiiii", $id, $id, $is_blocked,$id, $id, $is_blocked);
$query->execute();

$result = $query->get_result();
$blocked =[];

while($result_array = $result->fetch_assoc()){
    $blocked[] = $result_array;
}

$json = json_encode($blocked, JSON_PRETTY_PRINT);
echo($json);

?>