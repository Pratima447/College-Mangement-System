<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $stud_id = $_COOKIE['stud_id'];
    $day     = $_POST['day'];

    $query = 'SELECT subject_name, lect_name, day, presence
                from attendance
                where stud_id = '. $stud_id.' AND
                    day = "'.$day.'"';

    $result = $mysqli->query($query);
    
    while ($row = $result->fetch_row())
    {   
        $presence = $row[3] == 1 ? 'Present' : 'Absent';
        echo '<tr>
                <td>'.$row[0].'</td>
                <td>'.$row[1].'</td>
                <td>'.$row[2].'</td>
                <td>'.$presence.'</td>

            </tr>';
    }

   
    $result->close();
     
?>