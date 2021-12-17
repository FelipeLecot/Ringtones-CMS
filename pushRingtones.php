<?php
    header('Access-Control-Allow-Origin: *');
	include 'Login.php';

    $file = $_POST['file'];
    $rawDataJSON = $_POST['data'];

    if (isset($_FILES['file'])) {
        $file_extension = end(explode(".", $_FILES["file"]["name"]));

        $connect = mysqli_connect($host, $db_username, $db_password, $db_name);

        $query = "INSERT INTO ringtones (ringtoneData) VALUES ('$rawDataJSON')";

        $result = mysqli_query($connect,$query);

        mysqli_close($connect);

        if ($_FILES["file"]["size"] < 5000000 && $file_extension == "mp3") {
            $sourcePath = $_FILES['file']['tmp_name'];
            $targetPath = "media/" . mysqli_insert_id($connect); . ".mp3";
            move_uploaded_file($sourcePath, $targetPath);
        }
    }
?>