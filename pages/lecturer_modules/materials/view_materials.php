<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }


    include('../../../config/DbQueries.php');

    $obj     = new DbQueries();
    $all_courses = $obj->showCourses();

    if(isset($_POST['submit'])) 
    {
        $all_data = $obj->getCourse($_POST['course-short']);
        $details  = $all_data->fetch_object();

        $obj = new DbQueries();
        $obj->get_study_materials($details->cshort,$_POST['sems'],$_POST['subject']);
    }

    include('../../common/header.html');

?>

<body>
    <div id="wrapper">
        <?php include('../../common/side_lect_menu.html') ?>
        <div id="page-wrapper" class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header"> <?php echo strtoupper("welcome"." ". $_COOKIE['user']);?></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">View Study Materials</div>
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
                                                <select class="form-control" name="course-short" id="cshort"required onchange="showSem(this.value)">
                                                    <option VALUE="">SELECT</option>
                                                    <?php while($course=$all_courses->fetch_object()){?>							
                                                        <option VALUE="<?php echo htmlentities($course->cid);?>"><?php echo htmlentities($course->cshort)?>
                                                        </option>
                                                    <?php }?>   			
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="sems" id="sems" onfocus="showSubjects(this.value)" onchange="showSubjects(this.value)" required>
                                                    <option value="">Select Course First</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="subject" id="subject" required>
                                                    <option value="">Select Course and Sem First</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-10 col-lg-6"><br><br>
                                                <input type="submit" class="btn btn-primary" id="get_mat_file" name="submit" value="Request">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row display_n" id="view_files">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">View Study Materials</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12" id="mat_files">
                                    </div>
                                </div>
                            </div>
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