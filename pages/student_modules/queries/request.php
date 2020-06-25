<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }

    include('../../../config/DbQueries.php');

    $obj     = new DbQueries();

    if (isset($_POST['submit'])) 
    {
        $obj->post_stud_query($_POST['subject'],$_POST['question']);

    }

    $sid = $_COOKIE['stud_id'];

    $data       = $obj->getStudentData($sid);
    $stud_data  = $data->fetch_object(); 
    $sub_ids    = explode(",",$stud_data->sub_ids);
    $sub_names  = explode(",",$stud_data->subjects);
   
    include('../../common/header.html');

?>

<body>
    <form method="POST">
        <div id="wrapper">
            <?php include('../../common/side_stud_menu.html') ?>
        </div>
        <div id="page-wrapper" class="col-md-7">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header"> <?php echo strtoupper("welcome"." ". $_COOKIE['user']);?></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">View Internal Marks</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        
                                        <div class="row">
                                            <div class="col-lg-3" >
                                                <label>Subjects<span style="font-size:11px;color:red">*</span></label>
                                            </div>

                                            <div class="col-lg-4">
                                                <select class="form-control" name="subject" id="subject">
                                                    <option value="">Select Subject</option>
                                                    <?php
                                                        for($i = 0 ; $i < count($sub_names); $i++) { ?>
                                                            <option value="<?php echo htmlentities($sub_ids[$i]); ?>"><?php echo htmlentities($sub_names[$i]); ?></option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label for="">Question</label>
                                            </div>
                                            <textarea class="" name="question" id="question" cols="60" rows="10"></textarea>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <div class="col-lg-3">
                                                <label>Requesting On</label>
                                            </div>
                                            <div class="col-lg-4">
                                                <?php date_default_timezone_set('Asia/Kolkata'); ?>
                                                <input class="form-control" value="<?php $date = new DateTime(); echo $date->format('M j Y g:i A');?>" readonly="readonly" name="cdate">
                                                <!-- <input class="form-control" value="<?php echo date('d-m-Y h:i:s');?>" readonly="readonly" name="cdate"> -->
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-10 col-lg-6"><br><br>
                                                <input type="submit" class="btn btn-primary" id="submit_question" name="submit" value="Submit">
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