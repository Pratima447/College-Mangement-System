
<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }

    include('../../../config/DbQueries.php');
    $obj         = new DbQueries();

    $sid = $_COOKIE['stud_id'];

    $data       = $obj->getStudentData($sid);
    $stud_data  = $data->fetch_object(); 
    $sub_ids    = explode(",",$stud_data->sub_ids);
    $sub_names  = explode(",",$stud_data->subjects);

    include('../../common/header.html');

?>

<body>
    <div id="wrapper">
        <?php include('../../common/side_stud_menu.html') ?>
        <div id="page-wrapper" class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                   <h4 class="page-header"> <?php echo strtoupper("welcome"." ".$_COOKIE['user']);?></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">View Attendance</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                       
                                        <div class="row">
                                            <div class="col-md-offset-1 col-lg-2">
                                                <input type="radio" id="subject_option" name="subject_option" value="1" onclick="show_sub_sec();">
                                                <label for="subject_option">Subject</label><br>
                                            </div>
                                            <div class="col-md-offset-4 col-lg-2">
                                                <input type="radio" id="day_option" name="day_option" value="2" onclick="show_day_sec();">
                                                <label for="day_option">Day</label><br>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <div id="subject_sec" class="display_n">
                                                <div class="col-md-offset-1 col-lg-2" >
                                                    <label>Subjects<span style="font-size:11px;color:red">*</span></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <select class="form-control" name="subs_ids" id="subs_ids">
                                                        <option value="">Select Subject</option>
                                                        <?php
                                                            for($i = 0 ; $i < count($sub_names); $i++) { ?>
                                                                <option value="<?php echo htmlentities($sub_ids[$i]); ?>"><?php echo htmlentities($sub_names[$i]); ?></option>
                                                            <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="day_sec" class="display_n">
                                                <div class="col-lg-2 col-md-offset-1">
                                                    <label>Day<span style="font-size:11px;color:red">*</span></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <select class="form-control" name="stud_day" id="stud_day">
                                                        <option value="">Select day</option>
                                                        <option value="mon">Monday</option>
                                                        <option value="tue">Tuesday</option>
                                                        <option value="wed">Wednesday</option>
                                                        <option value="thur">Thursday</option>
                                                        <option value="fri">Friday</option>
                                                        <option value="sat">Saturday</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-10 col-lg-6"><br><br>
                                                <input type="submit" class="btn btn-primary" id="view_att_report" name="submit" value="View">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row display_n" id="view_att_sheet">
                <div class="col-md-12 col-lg-12 col-sm-12"> 
                    <div class="panel panel-default">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover " id="table_here">
                                <thead>
                                    <tr>
                                        <th>Subject </th>
                                        <th>Lecturer</th>
                                        <th>Day</th>
                                        <th>Presence</th>

                                    </tr>
                                </thead>
                                <tbody id="att_data" class="text_c">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
    include('../../common/footer.html');
?>