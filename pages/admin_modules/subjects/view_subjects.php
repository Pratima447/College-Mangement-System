<?php
    session_start ();

    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }
   
    include('../../../config/DbQueries.php');
    $obj = new DbQueries();

	$all_subjects = $obj->showSubjects();

	if(isset($_GET['del']))
    {
        $obj->del_subject(intval($_GET['del']));
    }

    include('../../common/header.html');

?> 

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include('../../common/side_menu.html') ?>
        <nav>
            <div id="page-wrapper" class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                    <h4 class="page-header"> <?php echo strtoupper("welcome"." ".htmlentities($_SESSION['login']));?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                View Subjects
                            </div>
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>S No</th>
                                                <th>Course <i class="fa fa-sort" aria-hidden="true"></i></th>
                                                <th>Semester <i class="fa fa-sort" aria-hidden="true"></i></th>
                                                <th>Subjects <i class="fa fa-sort" aria-hidden="true"></i></th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php 
                                            $index = 1;

                                            while($subject = $all_subjects->fetch_object())
                                            {?>	
                                                <tr>
                                                    <td><?php echo $index?></td>
                                                    <td><?php echo htmlentities( $subject->cshort) ?></td>
                                                    <td><?php echo htmlentities( strtoupper($subject->semester));?></td>
                                                    <td><?php echo htmlentities(strtoupper($subject->subject_name));?></td>
                                                    <td>&nbsp;&nbsp;<a href="edit_subject.php?sub_id=<?php echo htmlentities($subject->sub_id);?>"><p class="fa fa-edit"></p></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a href="view_subjects.php?del=<?php echo htmlentities($subject->sub_id); ?>"> <p class="fa fa-times-circle"></p></td>
                                                    
                                                </tr>
                                            
                                            <?php $index++;}?>   	           
                                        </tbody>
                                    </table>
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
