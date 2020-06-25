<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

   
    $id  = $_POST["cid"];
    $sem = $_POST["sem"];

    $query  = "SELECT * FROM subjects WHERE cid=".$id. " and semester='".$sem."'";
    $result = $mysqli->query($query);

    while ($row = $result->fetch_row())
    {
        echo "<option VALUE=". $row[0].">".$row[4]."</option>";
    }

    echo '</select>';

    $result->close();
     
?>