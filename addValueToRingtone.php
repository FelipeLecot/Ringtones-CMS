<?php
    header('Access-Control-Allow-Origin: *');
	include 'Login.php';

    $type = $_POST['type'];
    $id = $_POST['id'];

    $connect = mysqli_connect($host, $db_username, $db_password, $db_name);

    $query = "UPDATE ringtones SET $type = $type + 1 WHERE id = '$id'";

    $result = mysqli_query($connect,$query);
?>