
<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }

    include('../../../config/DbQueries.php');
    $obj         = new DbQueries();

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

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Mark Attendance</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="col-lg-4">
                                            <label>Time Slots<span style="font-size:11px;color:red">*</span></label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Day<span style="font-size:11px;color:red">*</span></label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Subjects<span style="font-size:11px;color:red">*</span></label>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                            <div class="col-md-6">
                                                    <select name="start_time" id="start_time" class="form-control" style="padding: 0;" required>
                                                        <option value="">Start time</option>
                                                    <?php
                                                        for($hours = 0; $hours < 24; $hours++) 
                                                            for($mins = 0; $mins < 60; $mins+=30)
                                                            echo '<option value='.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).':00>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';

                                                ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="end_time" id="end_time" class="form-control" style="padding: 0;" required>
                                                    <option value="">End time</option>
                                                    <?php
                                                        for($hours = 0; $hours < 24; $hours++) 
                                                            for($mins = 0; $mins < 60; $mins+=30)
                                                            echo '<option value='.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).':00>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
                                                            ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="day" id="day"  required>
                                                    <option value="">Select day</option>
                                                    <option value="mon">Monday</option>
                                                    <option value="tue">Tuesday</option>
                                                    <option value="wed">Wednesday</option>
                                                    <option value="thur">Thirsday</option>
                                                    <option value="fri">Friday</option>
                                                    <option value="sat">Saturday</option>
                                                </select>
                                            </div>
                                            <input type="hidden" id="presence" value="0">
                                            <div class="col-lg-4">
                                                <select class="form-control" name="subject" id="subject" required>
                                                    <option value="">Select Subject</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-10 col-lg-6"><br><br>
                                                <input type="submit" class="btn btn-primary" id="get_student_list" name="submit" value="Get Students">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row display_n" id="view_students">
                <div class="col-md-12 col-lg-12 col-sm-12"> 
                    <div class="panel panel-default">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover " id="table_here">
                                <thead>
                                    <tr>
                                        <th>Regno</th>
                                        <th>Name</th>
                                        <th>Mark</th>
                                    </tr>
                                </thead>
                                <tbody id="student_data" class="text_c">
                                    
                                </tbody>
                            </table>
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