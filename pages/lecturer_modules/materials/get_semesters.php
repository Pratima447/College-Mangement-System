<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    if(!empty($_POST["cid"])) 
    {
        $id     = $_POST['cid'];
        $query  = "SELECT semester FROM subjects WHERE cid=".$id;
        $result = $mysqli->query($query);
        $sem_data = [];
        $index = 0;

        while ($row = $result->fetch_row())
        {
            echo "<option VALUE=". $row[0].">".$row[0]."</option>";
        }

        echo '</select>';

        $result->close();
    }
     
?>