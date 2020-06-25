<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }


    include('../../../config/DbQueries.php');
    $obj = new DbQueries();

    $id = $_GET['lid'];
   
    $all_data = $obj->getLectureData($id);
    $details  = $all_data->fetch_object();

    if(isset($_POST['submit']))
    {
        $obj->update_lecture($id,$_POST['lname'],$_POST['mobile'],$_POST['qual'],$_POST['gender'],$_POST['join_date'],$_POST['perm_address']);
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
                            <div class="panel-heading">Edit Lecture</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Name<span id="" style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" type="text" id="lname" name="lname" required value="<?php echo $details->name ?>"/>
                                            </div>
                                        </div>	
                                        
                                        <br><br>
                            
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Mobile<span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" type="number" id="mobile" name="mobile" required maxlength="10" onkeyup="checkMobValidation(); return false;" value="<?php echo $details->mobile ?>"/>
                                                <span id="invalid_mob_msg" class="font_12 font_w_600 display_n p_l" style="font-size:11px;color:red">Invalid mobile number</span>
                                            </div>
                                        </div>	
                                                                        
                                        <br><br>								
                                
                                        <div class="form-group"  >
                                            <div class="col-lg-4">
                                                <label>Qualification</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" type="text" name="qual" id="qual" value="<?php echo $details->qualification ?>"/>
                                            </div>
                                        </div>

                                        <br><br>								

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Gender</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <?php 
                                                    if (strcasecmp($details->gender,"Male")==0)
                                                    {?>
                                                        <input type="radio" name="gender" id="male" value="Male" required="required" checked> &nbsp; Male &nbsp;
                                                        <?php }else{ ?>
                                                        <input type="radio" name="gender" id="male" value="Male" required="required"> &nbsp; Male &nbsp;
                                                    <?php }?>
                                                    <?php 
                                                    if (strcasecmp($details->gender,"female")==0)
                                                    {?>
                                                        <input type="radio" name="gender" id="female" value="female" checked> &nbsp; Female &nbsp;
                                                        <?php } else{?>
                                                        <input type="radio" name="gender" id="female" value="female"> &nbsp; Female &nbsp;
                                                    <?php }?>
                                                    <?php 
                                                    if (strcasecmp($details->gender,"other")==0)
                                                    {?>
                                                        <input type="radio" name="gender" id="other" value="other" checked> &nbsp; Other &nbsp;
                                                        <?php } else{?>
                                                        <input type="radio" name="gender" id="other" value="other"> &nbsp; Other &nbsp;
                                                <?php }?>
                                            </div>
                                        </div>

                                        <br><br>								

                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Join Date</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input id="datepicker" class="form-control" value="<?php echo $details->join_date?>" name="join_date">
                                            </div>
                                        </div>

                                        <br><br>
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Permanent Address<span id="" style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <textarea required class="form-control" rows="3" name="perm_address" id="address"><?php echo htmlentities($details->perm_address);?></textarea>
                                            </div>
                                        </div>
                                    </div>	
                                                                        
                                    <br><br>		
    
                                <div class="form-group">
                                    <div class="col-lg-4">
                                            
                                    </div>
                                    <div class="col-lg-6"><br><br>
                                        <input type="submit" class="btn btn-primary" name="submit" value="Update Lecture">
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