<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $sub_id     = $_POST['sub_id'];

    $query = 'SELECT question, answer, solved,solution_time,lect_name,qid, subject_name
                from queries
                where sub_id = '.$sub_id;

    $result = $mysqli->query($query);

   
    $index = 1;

    while ($row = $result->fetch_row())
    {   
        $solved = $row[2] == 1 ? 'Solved' : 'Not Solved';
        $page = '<p><a target="_blank" href="../queries/view_q.php?qid='.$row[5].'">View </a></p>';

        $date = '';
        if ($row[3] != null)
        {
            $date = new DateTime($row[3]); 
            $date = $date->format('M j Y g:i A');
        }
        echo '<tr>
                <td>'.$index.'</td>
                <td>'.$row[0].'</td>
                <td>'.$row[1].'</td>
                <td><span>'.$solved.'</span></td>
                <td>'.$date.'</td>
                <td>'.$row[4].'</td>
                <td>    
                    '.$page.'
                    <button id="del_query" onclick="del_query('.$row[5].')"> <p class="fa fa-times-circle"></p></button>
                    </td>

            </tr>';

            $index++;
    }

   
    $result->close();
     
?>