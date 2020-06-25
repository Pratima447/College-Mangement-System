<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $stud_id    = $_POST['stud_id'];
    $sub_id     = $_POST['sub_id'];
    $sub_name   = $_POST['sub_name'];
    $day        = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time   = $_POST['end_time'];
    $lect_id    = $_COOKIE['id'];
    $lect_name  = $_COOKIE['user'];
    $present    = $_POST['presence'];

    $query = 'UPDATE attendance set presence='.$present.' WHERE stud_id='.$stud_id.' and sub_id='.$sub_id.' and lect_id='.$lect_id.' and day="'.$day.'" and start_time="'.$start_time.'" and end_time="'.$end_time.'"';
     
    $result = $mysqli->query($query);

    if($result) {
        echo 'done';
    } else {
        echo 'Eror';

    }
   
?>