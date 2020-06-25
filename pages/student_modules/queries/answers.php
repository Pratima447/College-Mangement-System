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
                        <div class="panel-heading">View My Queries</div>
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

                                        <div class="form-group">
                                            <div class="col-md-offset-10 col-lg-6"><br><br>
                                                <input type="button" class="btn btn-primary" id="check_query_status" name="submit" value="See">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row display_n" id="view_question">
                <div class="col-md-12 col-lg-12 col-sm-12"> 
                    <div class="panel panel-default">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th class="col-md-3">Question</th>
                                        <th class="col-md-3">Answer</th>
                                        <th class="col-md-3">Solved</th>
                                        <th class="col-md-3">Answered At</th>
                                        <th class="col-md-3">Answered By</th>

                                    </tr>
                                </thead>
                                <tbody id="my_questions" class="text_c">
                                    
                                </tbody>
                            </table>
                           
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