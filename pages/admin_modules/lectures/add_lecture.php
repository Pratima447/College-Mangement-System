<?php
    session_start ();

    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }


    if(isset($_POST['submit'])) 
    {
        include('../../../config/DbQueries.php');
        $obj = new DbQueries();

        $obj->add_lecture($_POST['lname'],$_POST['mobile'],$_POST['email'],$_POST['qual'],$_POST['gender'],$_POST['join_date'],$_POST['perm_address']);

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

                <div>
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add Lecture</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Name<span id="" style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" type="text" id="lname" name="lname" required/>
                                            </div>
                                        </div>	
                                        
                                        <br><br>
                            
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Mobile<span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" type="number" id="mobile" name="mobile" required maxlength="10" onkeyup="checkMobValidation(); return false;"/>
                                                <span id="invalid_mob_msg" class="font_12 font_w_600 display_n p_l" style="font-size:11px;color:red">Invalid mobile number</span>
                                            </div>
                                        </div>	

                                        <br><br>

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Email<span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" type="text" id="email" name="email" required onkeyup="checkEmailValidation(); return false;"/>
                                                <span id="invalid_email_msg" class="font_12 font_w_600 display_n p_l" style="font-size:11px;color:red">Invalid Email Id</span>
                                            </div>
                                        </div>	
                                                                        
                                        <br><br>								
                                
                                        <div class="form-group"  >
                                            <div class="col-lg-4">
                                                <label>Qualification</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" type="text" name="qual" id="qual">
                                            </div>
                                        </div>

                                        <br><br>								

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Gender</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="radio" name="gender" id="male" value="Male" required> &nbsp; Male &nbsp;
                                                <input type="radio" name="gender" id="female" value="female"> &nbsp; Female &nbsp;
                                                <input type="radio" name="gender" id="other" value="other"> &nbsp; Other &nbsp;
                                            </div>
                                        </div>

                                        <br><br>								

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Join Date</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input id="datepicker" class="form-control" value="<?php echo date('d-m-Y');?>" name="join_date">
                                            </div>
                                        </div>

                                        <br><br>
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Permanent Address<span id="" style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <textarea required class="form-control" rows="3" name="perm_address" id="address"></textarea>
                                            </div>
                                        </div>
                                    </div>	
                                                                        
                                    <br><br>		
    
                                <div class="form-group">
                                    <div class="col-lg-4">
                                            
                                    </div>
                                    <div class="col-lg-6"><br><br>
                                        <input type="submit" class="btn btn-primary" name="submit" value="Add Lecture">
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