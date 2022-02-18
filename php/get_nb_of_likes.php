<?php

include("db_info.php");

$post_id = $_GET["post_id"];

$query = $mysqli->prepare("SELECT nb_of_likes FROM posts where ID=?");
$query->bind_param("i", $post_id);
$query->execute();

$result = $query->get_result(); 
$result_array = $result->fetch_assoc();

$json = json_encode($result_array);
echo($json);

?>