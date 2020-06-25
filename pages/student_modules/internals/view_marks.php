<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }

    include('../../../config/DbQueries.php');

    $obj     = new DbQueries();

    $sid = $_COOKIE['stud_id'];

    $data       = $obj->getStudentData($sid);
    $stud_data  = $data->fetch_object(); 
    $sub_ids    = explode(",",$stud_data->sub_ids);
    $sub_names  = explode(",",$stud_data->subjects);

    include('../../common/header.html');

?>

<body>
    <form method="POST">
        <div id="wrapper">
            <?php include('../../common/side_stud_menu.html') ?>
        </div>
        <div id="page-wrapper" class="col-md-7">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header"> <?php echo strtoupper("welcome"." ". $_COOKIE['user']);?></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">View Internal Marks</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        
                                        <div class="row">
                                            <div>
                                                <div class="col-md-offset-1 col-lg-2" >
                                                    <label>Subjects<span style="font-size:11px;color:red">*</span></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <select class="form-control" name="subject" id="subject">
                                                        <option value="">Select Subject</option>
                                                        <?php
                                                            for($i = 0 ; $i < count($sub_names); $i++) { ?>
                                                                <option value="<?php echo htmlentities($sub_ids[$i]); ?>"><?php echo htmlentities($sub_names[$i]); ?></option>
                                                            <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="col-lg-2 col-md-offset-1">
                                                    <label>Session<span style="font-size:11px;color:red">*</span></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <select class="form-control" name="session" id="session"  required>
                                                        <option value="">Select Session</option>
                                                        <option value="1">1st</option>
                                                        <option value="2">2nd</option>
                                                        <option value="3">3rd</option>
                                                        <option value="0">Avg</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-10 col-lg-6"><br><br>
                                                <input type="button" class="btn btn-primary" id="stud_marks_list" name="submit" value="Get Report">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row display_n" id="view_internal_report">
                <div class="col-md-12 col-lg-12 col-sm-12"> 
                    <div class="panel panel-default">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th class="col-md-1">Reg No</th>
                                        <th class="col-md-1">Semester</th>
                                        <th class="col-md-3">Student Name</th>
                                        <th class="col-md-2">Subject Name</th>
                                        <th class="col-md-3">Session</th>
                                        <th>Marks</th>

                                    </tr>
                                </thead>
                                <tbody id="marks_data" class="text_c">
                                    
                                </tbody>
                            </table>
                           
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