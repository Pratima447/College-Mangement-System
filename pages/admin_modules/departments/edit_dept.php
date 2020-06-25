<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }


    include('../../../config/DbQueries.php');
    $obj = new DbQueries();

    $id = $_GET['did'];
   
    $all_data = $obj->getDept($id);
    $details  = $all_data->fetch_object();

    if(isset($_POST['submit']))
    {
       $obj->edit_dept($_POST['dept-short'],$_POST['dept-full'],$_POST['udate'],$id);   
    }
   
    include('../../common/header.html');

?>

<body>
    <form method="post" >
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
                            <div class="panel-heading">Edit Department</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Department Short Name<span id="" style="font-size:11px;color:red">*</span></label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" name="dept-short" id="dshort" value="<?php echo $details->dshort;?>" required="required" onblur="deptAvailability()">       
                                                <span id="course-availability-status" style="font-size:12px;"></span>
                                            </div>
                                        </div>	
                                        
                                        <br><br>
                            
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Department Full Name<span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" name="dept-full" id="dfull" value="<?php echo $details->dfull;?>"  required="required" onblur="deptfullAvail()">         
                                                <span id="course-status" style="font-size:12px;"></span>
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
                                        <input type="submit" class="btn btn-primary" name="submit" value="Update Department">
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