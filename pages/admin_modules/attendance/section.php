<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }


    include('../../../config/DbQueries.php');

    $obj     = new DbQueries();
    $all_courses = $obj->showCourses();

    include('../../common/header.html');

?>


<body>
    <div id="wrapper">
        <?php include('../../common/side_menu.html') ?>
    </div>
    <div id="page-wrapper" class="col-md-9">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header"> <?php echo strtoupper("welcome"." ". $_COOKIE['user']);?></h4>
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
                                    <div class="col-lg-4">
                                        <label>Course Short Name<span style="font-size:11px;color:red">*</span></label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Semester<span style="font-size:11px;color:red">*</span></label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Subjects<span style="font-size:11px;color:red">*</span></label>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <select class="form-control" name="course-short" id="cshort" required onchange="showSem(this.value)">
                                                <option VALUE="">SELECT</option>
                                                <?php while($course=$all_courses->fetch_object()){?>							
                                                    <option VALUE="<?php echo htmlentities($course->cid);?>"><?php echo htmlentities($course->cshort)?>
                                                    </option>
                                                <?php }?>   			
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <select class="form-control" name="sems" id="sems" onchange="showSubjects(this.value)" onfocus="showSubjects(this.value)" required>
                                                <option value="">Select Course First</option>
                                            </select>
                                        </div>
                                         <div class="col-lg-4">
                                            <select class="form-control" name="subject" id="subject"  required>
                                                <option value="">Select Course and Sem First</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-10 col-lg-6"><br><br>
                                            <input type="submit" class="btn btn-primary" id="get_att_report" name="submit" value="Get Report">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row display_n" id="view_attendance">
            <div class="col-md-12 col-lg-12 col-sm-12"> 
                <div class="panel panel-default">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover " id="table_here">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Semester</th>
                                    <th>Subject</th>
                                    <th>Student Name</th>
                                    <th>Session</th>
                                    <th>Present</th>

                                </tr>
                            </thead>
                            <tbody id="report" class="text_c">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
    include('../../common/footer.html');
?>