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
    <form id="time_table" method="post" action="enter_data.php">
        <div id="wrapper">
            <?php include('../../common/side_menu.html') ?>
        </div>

        <div id="page-wrapper"  class="col-md-7">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header"> <?php echo strtoupper("welcome"." ". $_COOKIE['user']);?></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Time Table</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="col-lg-4">
                                            <label>Course<span style="font-size:11px;color:red">*</span></label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Semester<span style="font-size:11px;color:red">*</span></label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Slots<span style="font-size:11px;color:red">*</span></label>
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
                                                <select class="form-control" name="sems" id="sems" required>
                                                    <option value="">Select Course First</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <input required class="form-control col-md-1" type="number" id="slots" name="slots" placeholder="Enter slots (max 5) ">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-offset-10 col-lg-6"><br><br>
                                                <input type="submit" class="btn btn-primary" id="enter_time_table" name="submit" value="Enter">
                                            </div>
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
