<?php
    session_start ();

    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }

    if(isset($_POST['submit']) && isset($_POST['cid'])) 
    {

        $slots  = $_POST['slots'];
        $sem    = $_POST['sems'];

        include('../../../config/DbQueries.php');
        $obj = new DbQueries();
        $enter_result = $obj->enter_tt_course_sem($_POST['cid'],$_POST['course-short'],$_POST['sems'],$_POST['day'],$_POST['slots']);
        
        if ($enter_result == "1")
        {
            for ($i = 1; $i <= $slots; $i++)
            {
                $course_sem_day = $_POST['course-short'].'_'.$_POST['sems'].'_'.$_POST['day'];
                $start_time     = $_POST['start_time_'.$i];
                $end_time       = $_POST['end_time_'.$i];
                $sub_id         = $_POST['sub_'.$i];
                $lect_id        = $_POST['lect_'.$i];

                $subject_data = $obj->getSubject($sub_id);
                $details      = $subject_data->fetch_object();
                $sub_name = $details->subject_name;

                $lect_data = $obj->getLectureData($lect_id);
                $details   = $lect_data->fetch_object();
                $lect_name = $details->name;


                $tt_result = $obj->time_table_daily($course_sem_day,$_POST['day'],$start_time,$end_time, $sub_id, $sub_name, $lect_id,$lect_name);

                if ($tt_result != "1")
                {
                    echo "<script>alert('Error ocurred while inserting time table, please try again')</script>";
                } else {
                    echo "<script>alert('Inserted  time table data Successfully')</script>";
                }
                header('location:/pages/admin_modules/time_table/request_info.php');

            }

            
        }

    }
    else if(isset($_POST['submit']))
    {
        $cname  = $_GET['course'];
        $slots  = $_POST['slots'];
        $sem    = $_POST['sems'];
        $cid    = $_POST['course-short'];

    }
    include('../../common/header.html');

?>

<body>
    <div id="wrapper">
        <div class="col-md-12 navbar-brand navbar navbar-inverse navbar-static-top" style="margin-bottom: 0;">
            <img src="../../../public/uploads/logo.jpg" class="col-md-2" alt="STJIT logo" style="width: 8%;">
            <center>
                <p class="white_text header_title">Sri Taralabalu Jagadguru Institute of Technology</p>
                <p class="white_text">College Management System</p>
            </center>
        </div>
    </div>
    <form action="" method="POST">
        <input type="hidden" id="cid" name="cid" value="<?php echo $cid; ?>"/>
        <input type="hidden" id="sems" name="sems" value="<?php echo $sem; ?>"/>
        <input type="hidden" id="course-short" name="course-short" value="<?php echo $_GET['course'] ?>"/>
        <input type="hidden" id="slots" name="slots" value="<?php echo $slots; ?>"/>

        <div id="page-wrapper"  class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header p_15"> <?php echo strtoupper("welcome"." ". $_COOKIE['user']);?></h4>
                    <div class="col-md-5">
                            <a class="p_15" href="../time_table/request_info.php">Back</a>
                        </div>
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="font_w">Time Table Section</h4>
                        </div>
                    </div>
                    <center class="title_text">
                        <div class="">Course - <?php echo $_GET['course'] ?> </div>
                        <div class="">Sem - <?php echo $_POST['sems'] ?> </div>
                    </center>
                </div>
            </div>

            <br>
            <div class="row">
                <div>
                    <div class>
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover ">
                                <thead>
                                    <tr style="text_align:center">
                                        <th class="text_c">Day/Time</th>
                                        <?php
                                            for( $i = 1;$i <= $slots; $i++) 
                                            {?>
                                                <th>Slot <?php echo $i ?></th>

                                            <?php } ?>
                    
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="col-md-1"> 
                                            <select class="form-control" name="day" id="day"  required>
                                                <option value="">Select day</option>
                                                <option value="mon">Monday</option>
                                                <option value="tue">Tuesday</option>
                                                <option value="wed">Wednesday</option>
                                                <option value="thur">Thirsday</option>
                                                <option value="fri">Friday</option>
                                                <option value="sat">Saturday</option>
                                            </select>
                                        </td>
                                            
                                        <?php
                                            for( $i = 1;$i <= $slots; $i++) 
                                            {?>
                                            <td class="row col-md-2">  
                                                <div class="col-md-6">
                                                    <select name="start_time_<?php echo $i ?>" id="start_time_<?php echo $i ?>" class="form-control" style="padding: 0;" required>
                                                        <option value="">Start time</option>
                                                    <?php
                                                        for($hours = 0; $hours < 24; $hours++) 
                                                            for($mins = 0; $mins < 60; $mins+=30)
                                                            echo '<option value='.$hours.str_pad($mins,2,'0',STR_PAD_LEFT).'00>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';

                                                   ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="end_time_<?php echo $i ?>" id="end_time_<?php echo $i ?>" class="form-control" style="padding: 0;" required>
                                                    <option value="">End time</option>
                                                    <?php
                                                        for($hours = 0; $hours < 24; $hours++) 
                                                            for($mins = 0; $mins < 60; $mins+=30)
                                                            echo '<option value='.$hours.str_pad($mins,2,'0',STR_PAD_LEFT).'00>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
                                                    ?>
                                                    </select>
                                                </div>
                                                <br><br>
                                                <select name="sub_<?php echo $i ?>" id="sub_<?php echo $i ?>" class="form-control get_subjects" required>
                                                    <option value="">Select Subject</option>
                                                    
                                                </select>
                                                <select name="lect_<?php echo $i ?>" id="lect_<?php echo $i ?>" class="form-control get_lect" required>
                                                    <option value="">Select lecturer</option>
                                                    
                                                </select>
                                            </td>

                                            <?php } ?>
                                                    

                                
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-offset-10 col-md-3">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>


<?php
    include('../../common/footer.html');
?>