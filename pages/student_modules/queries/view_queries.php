<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $stud_id    = $_COOKIE['stud_id'];
    $sub_id     = $_POST['sub_id'];

    $query = 'SELECT question, answer, solved,solution_time,lect_name
                from queries
                where stud_id = '. $stud_id.' AND
                    sub_id = '.$sub_id;

    $result = $mysqli->query($query);

   
    $index = 1;

    while ($row = $result->fetch_row())
    {   
        $solved = $row[2] == 1 ? 'Solved' : 'Not Solved';
        echo '<tr>
                <td>'.$index.'</td>
                <td>'.$row[0].'</td>
                <td>'.$row[1].'</td>
                <td>'.$solved.'</td>
                <td>'.$row[3].'</td>
                <td>'.$row[4].'</td>

            </tr>';

            $index++;
    }

   
    $result->close();
     
?>