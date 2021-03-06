<?php
    session_start ();

    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }
    include('../../../config/DbQueries.php');
    
    $obj = new DbQueries();
    
    // get all courses
    $all_courses = $obj->showCourses();

    // get student data
    $sid        = $_GET['id'];
    $data       = $obj->getStudentData($sid);
    $stud_data  = $data->fetch_object(); 

    // get course name
    $cid     = $stud_data->cid;

    $details     = $obj->getCourse($cid);
    $course_data = $details->fetch_object();

    if(isset($_POST['submit']))
    { 
        $obj->edit_student($_POST['course-short'],$_POST['subjects'],$_POST['fname'],$_POST['mname'],$_POST['lname'],
                        $_POST['guard_name'],$_POST['occupation'],$_POST['gender'],$_POST['income'],$_POST['category'],$_POST['phy_challenged'],
                        $_POST['nationality'],
                        $_POST['mobile'],$_POST['email_id'],$_POST['perm_address'],
                        $_POST['board_1'],$_POST['roll_no_1'],$_POST['percent_1'],$_POST['pass_year_1'],
                        $_POST['board_2'],$_POST['roll_no_2'],$_POST['percent_2'],$_POST['pass_year_2'],$_POST['dob_stud'],$sid

        );
       
   }

    include('../../common/header.html');

?>

<body>
    <form method="post" >
        <div id="wrapper">
            <?php include('../../common/side_menu.html') ?>
            <div id="page-wrapper" class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="page-header"> <?php echo strtoupper("welcome"." ".htmlentities($_SESSION['login']));?></h4>
                    </div>

                    <!-- Course info -->
                    <div class="row col-md-12">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Register Student</div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <!-- Show courses -->
                                                <div class="form-group">
                                                    <div class="col-lg-4">
                                                        <label>Select Course<span id="" style="font-size:11px;color:red">*</span></label>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" name="course-short" id="cshort"  onchange="showSub(this.value)" required="required" >
                                                            <option VALUE="<?php echo $course_data->cid?>"><?php echo $course_data->cshort?></option>
                                                            <?php while($course=$all_courses->fetch_object()){?>							
                                                                <option VALUE="<?php echo htmlentities($course->cid);?>"><?php echo htmlentities($course->cshort)?></option>
                                                            <?php }?>   			
                                                        </select>
                                                    </div>
                                                </div>

                                                <br><br>
                                                    
                                                <!-- Show subject -->
                                                <div class="form-group">
                                                    <div class="col-lg-4">
                                                        <label>Subjects<span id="" style="font-size:11px;color:red">*</span></label>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" name="subjects" id="subjects" readonly  value="<?php echo $stud_data->subjects;?>">
                                                    </div>
                                                </div>	
                                                        
                                                <br><br>									
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Course info ends-->


                    <!-- Personal info -->
                    <div class="row col-md-12">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Personal Informations</div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <label>First Name<span id="" style="font-size:11px;color:red">*</span>	</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control" name="fname" required="required" pattern="[A-Za-z]+$"  value="<?php echo htmlentities($stud_data->fname);?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Middle Name</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control" name="mname" value="<?php echo htmlentities($stud_data->mname);?>">
                                                    </div>
                                                </div>	
                                                
                                                <br><br>
                                        
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <label>Last Name</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control" name="lname" pattern="[A-Za-z]+$" value="<?php echo htmlentities($stud_data->lname);?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Gender</label>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <?php 
                                                        if (strcasecmp($stud_data->gender,"Male")==0)
                                                        {?>
                                                            <input type="radio" name="gender" id="male" value="Male" required="required" checked> &nbsp; Male &nbsp;
                                                            <?php }else{ ?>
                                                            <input type="radio" name="gender" id="male" value="Male" required="required"> &nbsp; Male &nbsp;
                                                        <?php }?>
                                                        <?php 
                                                        if (strcasecmp($stud_data->gender,"female")==0)
                                                        {?>
                                                            <input type="radio" name="gender" id="female" value="female" checked> &nbsp; Female &nbsp;
                                                            <?php } else{?>
                                                            <input type="radio" name="gender" id="female" value="female"> &nbsp; Female &nbsp;
                                                        <?php }?>
                                                        <?php 
                                                        if (strcasecmp($stud_data->gender,"other")==0)
                                                        {?>
                                                            <input type="radio" name="gender" id="other" value="other" checked> &nbsp; Other &nbsp;
                                                            <?php } else{?>
                                                            <input type="radio" name="gender" id="other" value="other"> &nbsp; Other &nbsp;
                                                        <?php }?>
                                                    </div>	
                                                </div>

                                                <br><br>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-lg-2">
                                                            <label for="datepicker">Date of Birth</label>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input class="form-control" type="text" id="datepicker" name="dob_stud" value="<?php echo $stud_data->dob?>">
                                                        </div>
                                                    </div>
                                                <br><br>		
                                            
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <label>Guardian Name<span id="" style="font-size:11px;color:red">*</span></label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control" name="guard_name" required="required" pattern="[A-Za-z]+$" value="<?php echo htmlentities($stud_data->guard_name);?>">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Occupation</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control" name="occupation" id="occupation" value="<?php echo htmlentities($stud_data->occupation);?>">
                                                    </div>
                                                </div>	

                                                <br><br>
                                
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <label>Family Income<span id="" style="font-size:11px;color:red">*</span></label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="income"  id="income"required="required" >
                                                            <option value="<?php echo htmlentities($stud_data->income);?>"><?php echo htmlentities($stud_data->income);?></option>
                                                            <option value="200000">200000</option>
                                                            <option value="500000">500000</option>
                                                            <option value="700000">700000</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Category<span id="" style="font-size:11px;color:red">*</span></label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="category"  id="category" required="required" >
                                                            <option VALUE="<?php echo htmlentities($stud_data->category);?>"><?php echo htmlentities($stud_data->category);?></option>
                                                            <option VALUE="general">General</option>
                                                            <option value="obc">OBC</option>
                                                            <option value="sc">SC</option>
                                                            <option value="st">ST</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>	
                        
                                                <br><br>
                        
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <label>Physically Challenged<span id="" style="font-size:11px;color:red">*</span></label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="phy_challenged"  id="phy_challenged"required="required" >
                                                            <option VALUE="<?php echo htmlentities($stud_data->phy_challenged);?>"><?php echo htmlentities($stud_data->phy_challenged);?></option>
                                                            <option VALUE="yes">Yes</option>
                                                            <option value="no">No</option>
                                                                
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Nationality<span id="" style="font-size:11px;color:red">*</span></label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control" name="nationality" id="nationality" value="<?php echo htmlentities($stud_data->nationality);?>">
                                                    </div>
                                                </div>	
                        
                                                <br><br>
                                        </div>	
                                    
                                    <br><br>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <!-- Personal info ends-->

                    <!-- Contact info -->
                    <div class="row col-md-12">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Contact Informations</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="col-lg-2">
                                                    <label>Mobile Number<span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control" type="number" name="mobile" id="mobile" required="required" maxlength="10" onkeyup="checkMobValidation(); return false;" value="<?php echo htmlentities($stud_data->mobile);?>">
                                                    <span id="invalid_mob_msg" class="font_12 font_w_600 display_n p_l" style="font-size:11px;color:red">Invalid mobile number</span>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Email Id</label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control" type="email" name="email_id" id="email" onkeyup="checkEmailValidation(); return false;" value="<?php echo htmlentities($stud_data->email_id);?>">
                                                    <span id="invalid_email_msg" class="font_12 font_w_600 display_n p_l" style="font-size:11px;color:red">Invalid mobile number</span>
                                                </div>
                                                <br>
                                            </div>

                                            <br><br>

                                            <div class="form-group">
                                                <div class="col-lg-2">
                                                    <label>Permanent Address<span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <textarea class="form-control" rows="3" name="perm_address" id="perm_address"><?php echo htmlentities($stud_data->perm_address);?></textarea>
                                                </div>
                                                <div class="col-lg-2">
                                                </div>
                                                <div class="col-lg-4">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact info ends-->

                    <!-- Academic info -->
                    <div class="row col-md-12">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Academic Informations</div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;Board<span id="" style="font-size:11px;color:red">*</span></th>
                
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;Roll No</th>
                                            
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;Year Of Passing<span id="" style="font-size:11px;color:red">*</span></th>
                                                                            
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;Percentage</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr> 
                                                <td>
                                                    <div class="col-lg-12">
                                                        <input required class="form-control" type="text" name="board_1" placeholder="Enter 10th Board name" value="<?php echo htmlentities($stud_data->board_1);?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-lg-6">
                                                        <input  class="form-control" type="text" name="roll_no_1" value="<?php echo htmlentities($stud_data->roll_no_1);?>">
                                                    </div>
                                                </td>
                        
                                                <td>
                                                    <div class="col-lg-6">
                                                        <input required class="form-control" type="text" name="pass_year_1" value="<?php echo htmlentities($stud_data->pass_year_1);?>">
                                                    </div>
                                                </td>
                                                                
                                                <td>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" name="percent_1" value="<?php echo htmlentities($stud_data->percent_1);?>">
                                                    </div>
                                                </td>
                                                </tr>

                                                <tr> 
                                                <td>
                                                    <div class="col-lg-12">
                                                        <input class="form-control" type="text" name="board_2" placeholder="Enter 12th Board name" value="<?php echo htmlentities($stud_data->board_2);?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" name="roll_no_2" value="<?php echo htmlentities($stud_data->roll_no_2);?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" name="pass_year_2" value="<?php echo htmlentities($stud_data->pass_year_2);?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" name="percent_2" value="<?php echo htmlentities($stud_data->percent_2);?>">
                                                    </div>
                                                </td>
                                            </tr>      
                                        </tbody>
                                    </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Academic info ends-->

                    <div class="form-group">
                        <div class="col-lg-6 col-md-offset-4"><br><br>
                            <input type="submit" class="btn btn-primary" name="submit" value="Update Student"></button>
                        </div>
                        <br><br>
                    </div>	
                </div>

            </div>
        </div>
        
    </form>
</body>


<?php
    include('../../common/footer.html');
?>