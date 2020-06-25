
<?php
    session_start ();

    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }

    include('../../../config/DbQueries.php');
    $obj = new DbQueries();
    $id  = $_GET['sub_id'];
    
    $subject_data = $obj->getSubject($id);
    $details      = $subject_data->fetch_object();
    $all_courses  = $obj->showCourses();

    if(isset($_POST['submit']))
    {
        $id = $_GET['sub_id'];
        $obj->edit_subject($_POST['course-short'],$_POST['sem'],$_POST['subject_name'],$_POST['udate'],$id);
    }

    include('../../common/header.html');

?>

<body>
    <form method="post">
        <div id="wrapper">
            <?php include('../../common/side_menu.html') ?>

            <div id="page-wrapper"  class="col-md-8">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="page-header"> <?php echo strtoupper("welcome"." ".htmlentities($_SESSION['login']));?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit Subject</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Course Short Name<span id="" style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="course-short" id="cshort" required="required" >
                                                    <option VALUE=""><?php echo $details->cshort ?></option>
                                                    <?php while($course = $all_courses->fetch_object()){?>							
                                                        <option VALUE="<?php echo htmlentities($course->cid);?>"><?php echo htmlentities($course->cshort)?></option>
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
                                                <input class="form-control" value="<?php echo substr($details->semester,-1) ?>" type="number" name="sem" id="sem" placeholder="Enter integer value">
                                            </div>
                                        </div>

                                        <br><br>

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Subject</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" value="<?php echo $details->subject_name ?>" type="text" name="subject_name" id="<?php echo $_POST['sub_id'] ?>">
                                            </div>
                                        </div>

                                        <br><br>								

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Updation Date</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" value="<?php echo date('d-m-Y');?>" readonly="readonly" name="udate">
                                            </div>
                                        </div>
                                    </div>	
                                                                        
                                    <br><br>		
    
                                <div class="form-group">
                                    <div class="col-lg-4">
                                            
                                    </div>
                                    <div class="col-lg-6"><br><br>
                                        <input type="submit" class="btn btn-primary" name="submit" value="Update Subject">
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