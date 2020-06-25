
<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }


    if (isset($_POST['submit']))
    {      
        include('../../../config/DbQueries.php');
        $obj   = new DbQueries();
        
        $obj->update_lect_pass($_POST['new_pass'],$_POST['confirm_new_pass']);
    }
    include('../../common/header.html');

?>


<body>
    <form method="post" >
        <div id="wrapper">
            <?php include('../../common/side_lect_menu.html') ?>
            <div id="page-wrapper" class="col-md-7">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="page-header"> <?php echo strtoupper("welcome"." ".htmlentities($_COOKIE['user']));?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Profile</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <div class="col-lg-5 col-xs-5">
                                                    <label>New Password :</label>
                                                </div>
                                                <div class="col-lg-5 col-xs-5">
                                                    <input type="password" name="new_pass" id="new_pass" class="form-control" required>   
                                                </div>
                                            </div>

                                            <br><br>
                                            <div class="form-group">
                                                <div class="col-lg-5 col-xs-5">
                                                    <label>Confirm New Password :</label>
                                                </div>
                                                <div class="col-lg-5 col-xs-5">
                                                    <input type="password" name="confirm_new_pass" id="confirm_new_pass" class="form-control" required>
                                                </div>
                                            </div>

                                            <br><br>
                                            <div class="form-group">
                                                <div class="col-md-offset-10 col-md-4 col-xs-offset-5">
                                                    <input type="submit" class="btn btn-success" name="submit" value="Update">
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
    </form>
</body>

<?php
    include('../../common/footer.html');
?>