
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
            <?php include('../../common/side_lect_menu.html') ?>

            <div id="page-wrapper"  class="col-md-8">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="page-header"> <?php echo strtoupper("welcome"." ". $_COOKIE['user']);?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Upload Material</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Course Short Name<span style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="course-short" id="cshort" required="required" onchange="showSem(this.value)">
                                                    <option VALUE="">SELECT</option>
                                                    <?php while($course=$all_courses->fetch_object()){?>							
                                                        <option VALUE="<?php echo htmlentities($course->cid);?>"><?php echo htmlentities($course->cshort)?>
                                                        </option>
                                                    <?php }?>   			
                                                </select>
                                            </div>
                                        </div>	
                                                                        
                                        <br><br>	

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Semester<span style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="sems" id="sems" onfocus="showSubjects(this.value)" onchange="showSubjects(this.value)">
                                                    <option value="">Select Course First</option>
                                                </select>
                                            </div>
                                        </div>

                                        <br><br>	

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>File<span style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="file" id="mat_file" name="mat_file" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                            </div>
                                        </div>

                                        <br><br>	

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Subject<span style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="subject" id="subject"  required="required">
                                                    <option value="">Select Course and Sem First</option>
                                                </select>
                                            </div>
                                        </div>

                                        <br><br>								
							
                                    </div>	
                                                                        
                                    <br><br>		
    
                                <div class="form-group">
                                    <div class="col-lg-4">
                                            
                                    </div>
                                    <div class="col-lg-6"><br><br>
                                        <input type="submit" class="btn btn-primary" id="upload_mat_file" name="submit" value="Upload">
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