<?php
    header('Access-Control-Allow-Origin: *');
	include 'Login.php';

    $rawDataJSON = strip_tags(trim($_POST['data']));

    if (isset($_FILES['file'])) {
        $file_extension = end(explode(".", $_FILES["file"]["name"]));

        $connect = mysqli_connect($host, $db_username, $db_password, $db_name);

        $query = "INSERT INTO ringtones (ringtoneData) VALUES ('$rawDataJSON')";

        $result = mysqli_query($connect,$query);

        if ($_FILES["file"]["size"] < 5000000 && $file_extension == "mp3") {
            $fileId = mysqli_insert_id($connect);
            $sourcePath = $_FILES['file']['tmp_name'];
            $targetPath = "media/" . $fileId . ".mp3";
            move_uploaded_file($sourcePath, $targetPath);
        }

        mysqli_close($connect);
    }
?>