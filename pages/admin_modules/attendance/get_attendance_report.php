<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $lect_id    = $_COOKIE['id'];
    $cid        = $_POST['cid'];
    $sem        = $_POST['sem'];
    $sub_id     = $_POST['sub_id'];

    $query = 'SELECT courses.cshort, subjects.semester, subjects.sub_id, attendance.subject_name,attendance.day,attendance.lect_name , attendance.student_name, attendance.presence,
                    attendance.start_time, attendance.end_time
                    from subjects
                    JOIN attendance on subjects.sub_id = attendance.sub_id
                    JOIN courses on subjects.cid = courses.cid
                    WHERE attendance.sub_id='.$sub_id.' AND
                    courses.cid = '.$cid.' AND
                    subjects.semester="'.$sem.'" group by attendance.stud_id';

    $result = $mysqli->query($query);
    
 
    while ($row = $result->fetch_row())
    {       
        $pressent = $row[7] == 1? 'Present' : 'Absent';
        echo '<tr>
                <td>'.$row[0].'</td>
                <td>'.$row[1].'</td>
                <td>'.$row[3].'</td>
                <td>'.$row[6].'</td>
                <td>'.$row[8].' - '. $row[9].'</td>
                <td>'.$pressent.'</td>
            </tr>';
    }

   
    $result->close();
     
?>