<?php

// $upload = $_POST["img"];

// move uploaded imgs to a directory
$path = "http://localhost/pocketWorld-FrontEnd/assets/uploads/" . basename($_FILES["inpFile"]["name"]);


move_uploaded_file($_FILES["inpFile"]["tmp_name"], $path);






?>