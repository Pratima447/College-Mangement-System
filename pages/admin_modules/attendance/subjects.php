<?php

    $dbuser = "root";
    $dbpass = "";
    $host   = "localhost";
    $dbname ="studentmanagement";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    if(!empty($_POST["cid"])) 
    {
        $id     = $_POST['cid'];
        $query  = "SELECT sub_id, subject_name FROM subjects WHERE cid=".$id;
        $result = $mysqli->query($query);

        $sub_name ='';
        $sub_id ='';

        while ($row = $result->fetch_row())
        {
            $sub_name = $sub_name. $row[1] . ",";
            $sub_id   = $sub_id . $row[0] . ",";
        }

        $sub_name = rtrim($sub_name, ",");
        $sub_id   = rtrim($sub_id, ",");

        $all_data = [
            'names' => $sub_name,
            'ids'   => $sub_id
        ];

        echo json_encode($all_data);
    

        $result->close();
    }
     
?>