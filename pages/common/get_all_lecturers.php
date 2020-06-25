<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $query  = "SELECT * FROM lecturers";
    $result = $mysqli->query($query);

    echo "<option>Select lecturer</option>";

    while ($row = $result->fetch_row())
    {
        echo "<option VALUE=". $row[0].">".$row[1]."</option>";
    }

    echo '</select>';

    $result->close();
     
?>