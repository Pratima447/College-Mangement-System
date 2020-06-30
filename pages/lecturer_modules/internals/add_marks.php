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
        $tot_students  = $_POST["tot_studs"];

        for ($i = 1; $i <= $tot_students; $i++)
        {
            $stud_id   = $_POST['stud_id_'.$i];
            $stud_name = $_POST['stud_name_'.$i];
            $reg_no    = $_POST['reg_no_'.$i];
            $sub_name  = $_POST['sub_name_'.$i];
            $marks     = $_POST['marks_id_'.$i];
            
            $exists = $obj->check_if_exists($_POST['course-short'],$_POST['sems'],$_POST['subject'],$stud_id,$_POST['session']);
            
            if (!$exists)
            {
                $entered = $obj->add_internal_marks($_POST['course-short'],$_POST['sems'],$_POST['subject'],$_POST['session'],$stud_id,$marks,$sub_name,$stud_name,$reg_no);

                if ($entered != 1) {
                    echo '<script>alert("Something went wrong , try Again!!")</script>';
                    break;
                } else {
                    echo '<script>alert("Entered Internal Marks successfully")</script>';
                }
            } else {
                echo '<script>alert("Student internal info exists already!!")</script>';
            }
        }

        

    }

    include('../../common/header.html');

?>

<body>
    <form method="POST">
        <div id="wrapper">
            <?php include('../../common/side_lect_menu.html') ?>
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
                        <div class="panel-heading">Add Internal Marks</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Course Short Name<span style="font-size:11px;color:red">*</span></label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Semester<span style="font-size:11px;color:red">*</span></label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Subjects<span style="font-size:11px;color:red">*</span></label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Internal Session<span style="font-size:11px;color:red">*</span></label>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <select class="form-control" name="course-short" id="cshort" required onchange="showSem(this.value)">
                                                    <option VALUE="">SELECT</option>
                                                    <?php while($course=$all_courses->fetch_object()){?>							
                                                        <option VALUE="<?php echo htmlentities($course->cid);?>"><?php echo htmlentities($course->cshort)?>
                                                        </option>
                                                    <?php }?>   			
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="sems" id="sems" onfocus="showSubjects(this.value)" onchange="showSubjects(this.value)"  required>
                                                    <option value="">Select Course First</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="subject" id="subject"  required>
                                                    <option value="">Select Course and Sem First</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="session" id="session"  required>
                                                    <option value="">Select Session</option>
                                                    <option value="1">1st</option>
                                                    <option value="2">2nd</option>
                                                    <option value="3">3rd</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-10 col-lg-6"><br><br>
                                                <input type="button" class="btn btn-primary" id="get_internal_list" name="submit" value="Get List">
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
                                        <th class="col-md-1">Course</th>
                                        <th class="col-md-1">Semester</th>
                                        <th class="col-md-1">Reg No</th>
                                        <th class="col-md-3">Student Name</th>
                                        <th class="col-md-2">Subject Name</th>
                                        <th>Session</th>
                                        <th>Marks</th>

                                    </tr>
                                </thead>
                                <tbody id="internal_data" class="text_c">
                                    
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-offset-10 col-md-3">
                                    <input type="submit" name="submit" value="Update" class="btn btn-success">
                                    <br><br>
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