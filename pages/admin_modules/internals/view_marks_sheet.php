<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $cname    = $_POST['cname'];
    $sem_name = $_POST['sem_name'];
    $cid      = $_POST['cid'];
    $sems     = $_POST['sem'];
    $sub_id   = $_POST['sub_id'];
    $session  = $_POST['session'];

    if ($session != 0) {
        $query = 'SELECT reg_no, semester,student_name,subject_name, internal_marks.session,internal_marks.marks
                    from internal_marks
                    where c_id='.$cid.' and semester="'.$sems.'" and sub_id='. $sub_id.' and session='.$session;

        $result = $mysqli->query($query);
        $index = 1;

        while ($row = $result->fetch_row())
        {
            echo '<tr>
                    <td>'.$index.'</td>
                    <td>'. $cname.'</td>
                    <td>'. $sem_name.'</td>
                    <td>'.$row[0].'</td>
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
                    where c_id='.$cid.' and semester="'.$sems.'" and sub_id='. $sub_id.' group by stud_id';

        $result = $mysqli->query($query);
        $index = 1;

        while ($row = $result->fetch_row())
        {
            echo '<tr>
                    <td>'.$index.'</td>
                    <td>'. $cname.'</td>
                    <td>'. $sem_name.'</td>
                    <td>'.$row[0].'</td>
                    <td>'.$row[2].'</td>
                    <td>'.$row[3].'</td>
                    <td>'.$row[4].'</td>
                </tr>';
            
            $index++;
        }

    }
    
  
   
    $result->close();
     
?>