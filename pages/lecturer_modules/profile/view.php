
<?php
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }
 

    include('../../../config/DbQueries.php');
    $obj         = new DbQueries();
    $lect_id    = $_COOKIE['id'];

	$lect_data = $obj->getLectureData($lect_id);
    $details  = $lect_data->fetch_object();

    include('../../common/header.html');

?>

<body>
    <div id="wrapper">
        <?php include('../../common/side_lect_menu.html') ?>
        <div id="page-wrapper" class="col-md-7">
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
                                                <label><?php echo $details->name ?></label>       
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-3 col-xs-5">
                                                <label>Email :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <label><?php echo $details->email ?></label>       
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-3 col-xs-5">
                                                <label>Qualification :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <label><?php echo $details->qualification ?></label>       
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
                                                <label>Join Date :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <label>
                                                    <?php  
                                                    if($details->join_date != '0000-00-00') {
                                                        echo $details->join_date;
                                                    } else {?>
                                                        Not Mentioned
                                                    <?php } ?>
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