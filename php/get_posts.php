<?php
include("db_info.php");

$id = $_POST["id"];
$id = base64_decode($id);

$query = $mysqli->prepare("SELECT * from posts WHERE User_ID =? 
or (
    User_ID IN (SELECT user1_id from connections WHERE (user2_id=? or user1_id=?) and is_blocked <> 1 and is_pending <> 1)
    )
or (
    User_ID IN (SELECT user2_id from connections WHERE (user2_id=? or user1_id=?) and is_blocked <> 1 and is_pending <> 1)
    ) ORDER BY post_time desc");

$query->bind_param("sssss", $id,$id,$id,$id,$id);
$query->execute();

$result = $query->get_result();

$connections = [];

while($connection1 = $result->fetch_assoc()){
    $connections[] = $connection1;
}


$json_response = json_encode($connections);
echo $json_response;

?>