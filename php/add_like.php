<?php
session_start();

include("db_info.php");


$id = $_GET["id"];
$id = base64_decode($id);
$post_id = $_GET["post_id"];
$type = 1;

$check_query = $mysqli->prepare("SELECT * FROM likes where user1_id=? AND post_id=? AND type=?");

$check_query->bind_param("sss", $id, $post_id,$type);
$check_query->execute();
$check_query->store_result();
$num_rows = $check_query->num_rows;
$check_query->fetch();

$array_response = [];

if ($num_rows == 0){
    $query = $mysqli->prepare("INSERT INTO likes (user1_id, post_id, type) VALUES (?,?, ?)"); 
    $query->bind_param("sss", $id, $post_id, $type);
    $query->execute();
    $query2 = $mysqli->prepare("UPDATE posts SET nb_of_likes = nb_of_likes + 1 where ID=?");
    $query2->bind_param("s", $post_id);
    $query2->execute();
    $array_response["status"] = "post liked";
}else{
    $query3 = $mysqli->prepare("DELETE from likes where user1_id=? AND post_id=?"); 
    $query3->bind_param("ss", $id, $post_id);
    $query3->execute();
    $query4 = $mysqli->prepare("UPDATE posts SET nb_of_likes = nb_of_likes - 1 where ID=?");
    $query4->bind_param("s", $post_id);
    $query4->execute();
    $array_response["status"] = "like removed";
}

$query5 = $mysqli->prepare("SELECT nb_of_likes from posts where ID = ?");
$query5->bind_param("s", $post_id);
$query5->execute();
$result = $query5->get_result();
$likes_row = $result->fetch_assoc();
$array_response["nb_of_likes"] = $likes_row["nb_of_likes"];

$json_response = json_encode($array_response);
echo $json_response;



?>