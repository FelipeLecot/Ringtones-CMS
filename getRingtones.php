<?php
    header('Access-Control-Allow-Origin: *');
	include 'Login.php';

    $id = $_GET['id'];
    $orderBy = $_GET['order'];
    $cat = $_GET['cat'];
    $last = $_GET['latest'];
    $search = $_GET['search'];

    function orderBy($orderBy) {
        if ($orderBy == 'l') {
            return 'ORDER BY likes DESC ';
        }
        else if ($orderBy == 'r') {
            return 'ORDER BY id DESC ';
        }
        else {
            return 'ORDER BY downloads DESC ';
        }
    }

    function getCategory($filter) {
        $returnString = "AND ringtoneData ";

        if ($filter == 'al') {
            $returnString .= "RLIKE 'alarm' ";
        }
        else if ($filter == 'lg') {
            $returnString .= "RLIKE 'long' ";
        }
        else if ($filter == 'st') {
            $returnString .= "RLIKE 'short' ";
        }
        else if ($filter == 'nt') {
            $returnString .= "RLIKE 'notification|sound' ";
        }
        else if ($filter == 'rg') {
            $returnString .= "RLIKE 'ringtones|call' ";
        }
        else if ($filter == 'ef') {
            $returnString .= "RLIKE 'effects|sounds' ";
        }
        else if ($filter == '8b') {
            $returnString .= "RLIKE '8-bits|8bits|bits|retro' ";
        }
        else if ($filter == 'cy') {
            $returnString .= "RLIKE 'creepy|horror' ";
        }
        else if ($filter == 'sg') {
            $returnString .= "RLIKE 'song|music' ";
        }
        else if ($filter == 'kp') {
            $returnString .= "RLIKE 'k-pop|pop|korea' ";
        }
        else if ($filter == 'rk') {
            $returnString .= "RLIKE 'rock|metal' ";
        }
        else if ($filter == 'el') {
            $returnString .= "RLIKE 'electronic' ";
        }
        else if ($filter == 'tr') {
            $returnString .= "RLIKE 'trap' ";
        }
        else if ($filter == 'cl') {
            $returnString .= "RLIKE 'classic' ";
        }
        else {
            $returnString = "";
        }
        
        return $returnString;
    }

    function getSearchParams($search) {
        if ($search != null) {
            return "AND ringtoneData RLIKE '$search' ";
        }
    }

    $connect = mysqli_connect($host, $db_username, $db_password, $db_name);

    if ($id != '' && $id != null) {
        $query = "SELECT id, likes, ringtoneData, downloads FROM ringtones WHERE id = $id";
    }
    else {
        $query = "SELECT id, likes, ringtoneData, downloads FROM ringtones WHERE id > $last " . getCategory($cat) . getSearchParams($search) . orderBy($orderBy) . "LIMIT 10";
    }
    
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