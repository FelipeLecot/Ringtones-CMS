<?php
    header('Access-Control-Allow-Origin: *');
	include 'Login.php';

    $orderBy = $_GET['order'];
    $cat = $_GET['cat'];
    $last = $_GET['latest'];

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

    function getCategory($filter) {
        if ($filer == 'al') {
            return 'alarm';
        }
        else if ($filter == 'lg') {
            return 'long';
        }
        else if ($filter == 'st') {
            return 'short';
        }
        else if ($filter == 'al') {
            return 'alarm';
        }
        else if ($filter == 'nt') {
            return '(notification|sound)';
        }
        else if ($filter == 'rg') {
            return '(ringtones|call)';
        }
        else if ($filter == 'ef') {
            return '(effects|sounds)';
        }
        else if ($filter == '8b') {
            return '(8-bits|8bits|bits|retro)';
        }
        else if ($filter == 'cy') {
            return '(creepy|horror)';
        }
        else if ($filter == 'sg') {
            return '(song|music)';
        }
        else if ($filter == 'kp') {
            return '(k-pop|pop|korea)';
        }
        else if ($filter == 'rk') {
            return '(rock|metal)';
        }
        else if ($filter == 'el') {
            return 'electronic';
        }
        else if ($filter == 'tr') {
            return 'trap';
        }
        else if ($filter == 'cl') {
            return 'classic';
        }
        else {
            return '';
        }
    }

    $connect = mysqli_connect($host, $db_username, $db_password, $db_name);

    $query = "SELECT id, likes, ringtoneData, downloads FROM ringtones WHERE id > $last " . orderBy($orderBy) . "AND ringtoneData SIMILAR TO %" . getCategory($cat) . "% LIMIT 10";

    $result = mysqli_query($connect,$query);

    $ringtoneList = Array();

    while ($rows = mysqli_fetch_array($result)) {
        $ringtoneData = json_decode($rows['ringtoneData'], true);
        $ringtoneData['data']['id'] = $rows['id'];
        $ringtoneData['data']['likes'] = $rows['likes'];
        $ringtoneData['data']['downloads'] = $rows['downloads'];
        
        $ringtoneList['list'][] = json_encode($ringtoneData['data'], true);
    }

    mysqli_close($connect);

    echo json_encode($ringtoneList, true);
?>