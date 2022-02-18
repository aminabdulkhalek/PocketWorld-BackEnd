<?php
header("Access-Control-Allow-Origin: *");

include("db_info.php");

$id = $_POST["id"];
$id = base64_decode($id);
$pending = 1;
$blocked = 1;

$query = $mysqli->prepare("SELECT id, first_name, last_name FROM users where id <> ? and id NOT IN (SELECT user1_id as friend from connections WHERE NOT user1_id=? AND ((user2_id=?) AND is_blocked <> ? AND is_pending <> ?) UNION SELECT user2_id from connections WHERE NOT user2_id=? AND ((user1_id=?) AND is_blocked <> ? AND is_pending <> ?)) ORDER BY RAND () LIMIT 4");



$query->bind_param("sssssssss", $id, $id, $id, $blocked, $pending,$id, $id,$blocked, $pending);

$query->execute();

$result = $query->get_result();
$users =[];

while($result_array = $result->fetch_assoc()){
    $users[] = $result_array;
}


$json = json_encode($users, JSON_PRETTY_PRINT);
echo($json);


?>
