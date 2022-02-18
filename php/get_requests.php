<?php

include("db_info.php");

$id = $_GET["id"];
$id = base64_decode($id);
$is_blocked = 0;
$is_pending = 1;

$query=$mysqli->prepare("SELECT user1_id as request from connections WHERE NOT user1_id=? AND (user2_id=? AND is_blocked = ? AND is_pending = ?)");



$query->bind_param("ssss", $id, $id, $is_blocked, $is_pending);
$query->execute();

$result = $query->get_result();
$friends =[];
while($result_array = $result->fetch_assoc()){
    $friends[] = $result_array;
}
  
$json = json_encode($friends, JSON_PRETTY_PRINT);
echo($json);

?>


