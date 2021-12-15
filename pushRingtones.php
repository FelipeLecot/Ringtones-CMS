<?php
    header('Access-Control-Allow-Origin: *');
	include 'Login.php';

    $file = $_POST['file'];
    $rawDataJSON = $_POST['data'];

    if (isset($_FILES['file'])) {
        $file_extension = end(explode(".", $_FILES["file"]["name"]));

        if ($_FILES["file"]["size"] < 5000000 && $file_extension == "mp3") {
            $sourcePath = $_FILES['file']['tmp_name'];
            $targetPath = "media/" .  . ".mp3";
            move_uploaded_file($sourcePath,$targetPath);
        }
    }
?>