<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $lect_id = $_COOKIE['id'];


    $query  = "SELECT sub_id, subject FROM time_table_daily where lect_id=".$lect_id;
    $result = $mysqli->query($query);

    while ($row = $result->fetch_row())
    {
        echo "<option VALUE=". $row[0].">".$row[1]."</option>";
    }

    echo '</select>';

    $result->close();
     
?>