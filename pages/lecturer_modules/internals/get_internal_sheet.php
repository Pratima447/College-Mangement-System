<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    $lect_id  = $_COOKIE['id'];
    $cname    = $_POST['cname'];
    $sem_name = $_POST['sem_name'];
    $cid      = $_POST['cid'];
    $sems     = $_POST['sem'];
    $sub_id   = $_POST['sub_id'];
    $session  = $_POST['session'];

    $query = 'SELECT courses.cshort, subjects.semester, students.reg_no, concat(students.fname," ",students.mname) as student_name, 
				subjects.subject_name,time_table_daily.sub_id,students.sid
				FROM courses 
				JOIN subjects on courses.cid = subjects.cid
				JOIN students on courses.cid = students.cid 
				JOIN time_table_daily on time_table_daily.sub_id = subjects.sub_id 
				WHERE
				FIND_IN_SET(time_table_daily.sub_id, students.sub_ids) AND
				lect_id ='.$lect_id.' and time_table_daily.sub_id='.$sub_id;

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
                <td>'.$session.'</td>
                <td>
                    <input type="number" id="marks_id_'.$index.'" name="marks_id_'.$index.'" class="form-control col-md-3"/>
					<input type="hidden" value="'.$row[6].'" name="stud_id_'.$index.'"/>
					<input type="hidden" value="'.$row[3].'" name="stud_name_'.$index.'"/>
                    <input type="hidden" value="'.$row[4].'" name="sub_name_'.$index.'"/>
                    <input type="hidden" value="'.$row[2].'" name="reg_no_'.$index.'"/>
                </td>

            </tr>';
        
        $index++;
    }

    $index = $index - 1;
    echo '<input type="hidden" name="tot_studs" id="tot_studs" value="'.$index.'" class="form-control col-md-3"/>';
   
    $result->close();
     
?>