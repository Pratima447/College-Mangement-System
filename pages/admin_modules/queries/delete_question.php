<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $qid = $_POST['qid'];

   
    $query = 'DELETE from queries where qid ='.$qid;

    $result = $mysqli->query($query);

    if ($result) {
        echo 1;
        return;
    } 
    return 0;

    $result->close();
     
    ?>