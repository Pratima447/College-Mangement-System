<?php

    session_start ();

    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }

    include('../../../config/DbQueries.php');
    $obj = new DbQueries();

    $all_courses  = $obj->showCourses();
    $all_courses1 = $obj->showCourses();

    if(isset($_POST['submit']))
    {
        $subject_name = [];

        for ($i = 1; $i <= $_POST['no_sub']; $i++)
        {
            $subject_name[$i] =  $_POST['S'. $i];
        }

        $obj = new DbQueries();

        $res = $obj->create_subject($_POST['course-short'],$_POST['sem'],$_POST['no_sub'],$subject_name);	        
    }
    include('../../common/header.html');

?>

<body>
    <form method="post">
        <div id="wrapper">
            <?php include('../../common/side_menu.html') ?>

            <div id="page-wrapper"  class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="page-header"> <?php echo strtoupper("welcome"." ".htmlentities($_SESSION['login']));?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add Subject</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Course Short Name<span id="" style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="course-short" id="cshort" required="required" >
                                                    <option VALUE="">SELECT</option>
                                                    <?php while($course=$all_courses->fetch_object()){?>							
                                                        <option VALUE="<?php echo htmlentities($course->cid);?>"><?php echo htmlentities($course->cshort)?></option>
                                                    <?php }?>   			
                                                </select>
                                            </div>
                                        </div>	
                                        
                                        <br><br>
                            
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Course Full Name<span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="course-full" id="cfull" required="required" >
                                                    <option VALUE="">SELECT</option>
                                                    <?php while($course=$all_courses1->fetch_object()){?>							
                                                        <option VALUE="<?php echo htmlentities($course->cid);?>"><?php echo htmlentities($course->cfull)?></option>
                                                    <?php }?>   			
                                                </select>
                                            </div>
                                        </div>	
                                                                        
                                        <br><br>								
                                    
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Semester</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" value="" type="number" name="sem" id="sem" placeholder="Enter integer value">
                                            </div>
                                        </div>

                                        <br><br>								

                                        <div class="form-group"  >
                                            <div class="col-lg-4">
                                                <label>No. of Subjects</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="no_sub" id="no_sub" required="required" onchange="populateSubjects()" >
                                                    <option VALUE="">SELECT</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div id="form_subjects">
                                            <!-- subjects here -->
                                        </div>
                                    </div>	
                                                                        
                                    <br><br>		
    
                                <div class="form-group">
                                    <div class="col-lg-4">
                                            
                                    </div>
                                    <div class="col-lg-6"><br><br>
                                        <input type="submit" class="btn btn-primary" name="submit" value="Add Subject">
                                    </div>
                                </div>		
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
