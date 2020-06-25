<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

   
    $id  = $_POST["cid"];
    $sem = $_POST["sem"];

    $query  = "SELECT subject_name FROM subjects WHERE cid=".$id. " and semester='".$sem."'";
    $result = $mysqli->query($query);

    while ($row = $result->fetch_row())
    {
        $name = str_replace(' ', '_', $row[0]);

        echo "<option VALUE=". $name.">".$row[0]."</option>";
    }

    echo '</select>';

    $result->close();
     
?>