
<?php
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }
 

    include('../../../config/DbQueries.php');
    $obj         = new DbQueries();
    $stud_id    = $_COOKIE['stud_id'];

	$stud_data = $obj->getStudentData($stud_id);
    $details  = $stud_data->fetch_object();

    include('../../common/header.html');

?>

<body>
    <div id="wrapper">
    <?php include('../../common/side_stud_menu.html') ?>
        <div id="page-wrapper" class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                   <h4 class="page-header"> <?php echo strtoupper("welcome"." ".$_COOKIE['user']);?></h4>
                </div>
            </div>

            <div class="row profile">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Profile</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <div class="col-lg-3 col-xs-5">
                                                <label>Name :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <label><?php echo $details->mname ?></label>       
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-3 col-xs-5">
                                                <label>Email :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <label><?php  
                                                    if($details->email_id != '') {
                                                        echo $details->email_id;
                                                    } else {?>
                                                        Not Mentioned
                                                <?php } ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-3 col-xs-5">
                                                <label>Subjects :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <label><?php echo $details->subjects ?></label>       
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-3 col-xs-5">
                                                <label>Gender :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <label><?php echo $details->gender ?></label>       
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-3 col-xs-5">
                                                <label>Reg No :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <label>
                                                   <?php echo $details->reg_no ?>
                                                </label>       
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-3 col-xs-5">
                                                <label>Address :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <label><?php echo $details->perm_address ?></label>       
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-10 col-md-4 col-xs-offset-5">
                                                <a class="btn btn-info" href="../profile/update_pass.php">Update Password</a>
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
    </div>
</body>

<?php
    include('../../common/footer.html');
?>