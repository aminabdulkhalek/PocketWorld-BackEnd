<?php

include("db_info.php");

if(isset($_POST["email"]) AND strlen($_POST["email"] > 0)){
    $email = $mysqli->real_escape_string($_POST["email"]); 
}else{
    die("Invalid email");
}

if(isset($_POST["password"]) AND strlen($_POST["password"] > 0)){
    $password = $mysqli->real_escape_string($_POST["password"]);
    $password = hash("sha256", $password);
}else{
    die("Invalid password");
}

if(isset($_POST["first_name"]) AND strlen($_POST["first_name"] > 0)){
    $first_name = $mysqli->real_escape_string($_POST["first_name"]);
}else{
    die("Invalid first name");
}

if(isset($_POST["last_name"]) AND strlen($_POST["last_name"] > 0)){
    $last_name = $mysqli->real_escape_string($_POST["last_name"]);
}else{
    die("Invalid last name");
}

// check if user exists in our database 
$check_query = $mysqli->prepare("SELECT * FROM users where email=?");
$check_query->bind_param("s", $email);
$check_query->execute();
$check_query->store_result();
$num_rows = $check_query->num_rows;
$check_query->fetch();

// if user doesnt exist insert sign up info into our table else return response user already exists 
if($num_rows == 0){
    $sign_up_query = $mysqli->prepare("INSERT INTO users (`first_name`, `last_name`, `email`, `password`) VALUES (?, ?, ?, ?)");
    $sign_up_query->bind_param("ssss", $first_name, $last_name, $email, $password);
    $sign_up_query->execute();
    $sign_up_query->store_result();
    $sign_up_query->fetch();
    $array_response = [];
    $array_response["status"] = "success";
    $array_response["first_name"] = $first_name;
    $array_response["last_name"] = $last_name;
    $array_response["email"] = $email;
    $array_response["password"] = $password;
    
    $json = json_encode($array_response);
    echo $json;
    $sign_up_query->close();
    $mysqli->close();
}else{
    $array_response["status"] = "user already exists";
    $json = json_encode($array_response);
    echo $json;
    $mysqli->close();
}

 


 
?>