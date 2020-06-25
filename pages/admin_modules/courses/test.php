<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }


    include('../../../config/DbQueries.php');
    $obj = new DbQueries();

    $id = $_GET['cid'];
   
    $all_data = $obj->getCourse($id);
    $details  = $all_data->fetch_object();

    if(isset($_POST['submit']))
    {
       $obj->edit_course($_POST['course-short'],$_POST['course-full'],$_POST['udate'],$id);   
    }
   
    include('../../common/header.html');

?>