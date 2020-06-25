<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $stud_id  = $_COOKIE['stud_id'];
    $sub_id   = $_POST['sub_id'];
    $session  = $_POST['session'];

    if ($session != 0) {
        $query = 'SELECT reg_no, semester,student_name,subject_name,session,marks
                    from internal_marks
                    where stud_id='.$stud_id.' and sub_id='. $sub_id.' and session='.$session;

        $result = $mysqli->query($query);
        $index = 1;

        while ($row = $result->fetch_row())
        {
            echo '<tr>
                    <td>'.$index.'</td>
                    <td>'.$row[0].'</td>
                    <td>'.$row[1].'</td>
                    <td>'.$row[2].'</td>
                    <td>'.$row[3].'</td>
                    <td>'.$row[4].'</td>
                    <td>'.$row[5].'</td>
                </tr>';
            
            $index++;
        }

    } 
    else 
    {
        $query = 'SELECT reg_no, semester,student_name,subject_name, avg(internal_marks.marks)
                    from internal_marks
                    where stud_id='.$stud_id.' and sub_id='. $sub_id;

        $result = $mysqli->query($query);
        $index = 1;

        while ($row = $result->fetch_row())
        {
            echo '<tr>
                    <td>'.$index.'</td>
                    <td>'.$row[0].'</td>
                    <td>'.$row[1].'</td>
                    <td>'.$row[2].'</td>
                    <td>'.$row[3].'</td>
                    <td>Avg</td>
                    <td>'.$row[4].'</td>
                </tr>';
            
            $index++;
        }

    }
    
  
   
    $result->close();
     
?>