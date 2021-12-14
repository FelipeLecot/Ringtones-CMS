<?php
    header('Access-Control-Allow-Origin: *');
	include 'Login.php';

    $orderBy = $_GET['filter'];

    function orderBy($orderBy) {
        if ($orderBy == 'l') {
            return 'ORDER BY likes DESC';
        }
        else if ($orderBy == 'r') {
            return 'ORDER BY id DESC';
        }
        else {
            return 'ORDER BY downloads DESC';
        }
    }

    $connect = mysqli_connect($host, $db_username, $db_password, $db_name);

    $query = "SELECT id, likes, ringtoneData, downloads FROM ringtones " . orderBy($orderBy) . " LIMIT 10";

    $result = mysqli_query($connect,$query);

    $ringtoneList = Array();

    while ($rows = mysqli_fetch_array($result)) {
        $ringtoneData = json_decode($rows['ringtoneData'], true);
        $ringtoneData['data']['id'] = $rows['id'];
        $ringtoneData['data']['likes'] = $rows['likes'];
        $ringtoneData['data']['downloads'] = $rows['downloads'];
        
        $ringtoneList['list'][] = json_encode($ringtoneData['data'], true);
    }

    echo json_encode($ringtoneList, true);
?>