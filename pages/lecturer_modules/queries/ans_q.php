<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }

    include('../../../config/DbQueries.php');

    $obj     = new DbQueries();

    $qid     = $_GET['qid'];

    $q_data = $obj->get_question_details($qid);
    $data   = $q_data->fetch_object();

    if (isset($_POST['submit'])) 
    {
        $obj->post_answer($qid,$_POST['answer'],$_POST['update']);
    }
   
    include('../../common/header.html');

?>

<body>
    <form method="POST">
        <div id="wrapper">
            <?php include('../../common/side_lect_menu.html') ?>
        </div>
        <div id="page-wrapper" class="col-md-9">
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
                                                <label>Subject</label>
                                            </div>

                                            <div class="col-lg-4">
                                                <div><?php echo $data->subject_name; ?></div>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label for="">Question</label>
                                            </div>
                                            <textarea disabled class="" name="question" id="question" cols="60" rows="5"><?php echo $data->question; ?></textarea>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label for="">Answer</label>
                                            </div>
                                            <textarea required name="answer" id="answer" cols="60" rows="5" >
<?php if ($data->answer) { echo ltrim($data->answer," "); } ?>
                                            </textarea>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <div class="col-lg-3">
                                                <label>Answering On</label>
                                            </div>
                                            <div class="col-lg-4">
                                                <?php date_default_timezone_set('Asia/Kolkata'); ?>
                                                <input class="form-control" value="<?php echo date('d-m-Y h:i:s');?>" readonly="readonly" name="update">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-10 col-lg-6"><br><br>
                                                <input type="submit" class="btn btn-primary" id="submit_answer" name="submit" value="Submit">
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