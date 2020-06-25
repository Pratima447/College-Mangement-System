<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $lect_id    = $_COOKIE['id'];
    $start_time = $_POST['start_time'];
    $end_time   = $_POST['end_time'];
    $day        = $_POST['day'];
    $sub_id     = $_POST['sub_id'];

    $query = 'SELECT students.reg_no,time_table_daily.sub_id, students.sid, students.mname, concat(students.fname," ",students.mname," ",students.lname) as name,time_table_daily.start_time, time_table_daily.end_time, time_table_daily.lecturer, time_table_daily.lect_id, time_table_daily.day
    from time_table_daily,students
   
    where FIND_IN_SET (time_table_daily.sub_id, students.sub_ids)  AND
    lect_id = '. $lect_id.' AND
    start_time = "'.$start_time.'" AND 
    end_time = "'.$end_time.'" AND
    time_table_daily.sub_id = '.$sub_id.' AND
    time_table_daily.day ="'.$day.'"';

    $result = $mysqli->query($query);
    
    while ($row = $result->fetch_row())
    {
        $stud_name = "'".$row[3]."'";
        $call_func = "mark_me(".$row[2].")";

        echo '<tr>
                <td>'.$row[0].'</td>
                <td>'.$row[4].'</td>
                <td>
                    <button id="'.$row[2].'" class="text_c check_presence btn btn-info col-md-offset-4 col-md-4" onclick="'.$call_func.'">Mark</button>
                </td>
            </tr>';
    }

   
    $result->close();
     
?>