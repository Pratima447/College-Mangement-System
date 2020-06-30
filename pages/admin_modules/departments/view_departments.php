<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }


    include('../../../config/DbQueries.php');
    $obj         = new DbQueries();
	$all_courses = $obj->showDepartments();

	if(isset($_GET['del']))
    {
        $obj->del_department(intval($_GET['del']));       
    }

    include('../../common/header.html');

?>

<body>
    <div id="wrapper">
        <?php include('../../common/side_menu.html') ?>
        <div id="page-wrapper" class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                   <h4 class="page-header"> <?php echo strtoupper("welcome"." ".htmlentities($_SESSION['login']));?></h4>
                </div>
            </div>

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            View Departments
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S No</th>
                                            <th>Short Name <i class="fa fa-sort" aria-hidden="true"></i></th>
                                            <th>Full Name <i class="fa fa-sort" aria-hidden="true"></i></th>
                                            <th>Created Date <i class="fa fa-sort" aria-hidden="true"></i></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $index = 1;
                                        while($res = $all_courses->fetch_object())
                                        {?>	
                                        <tr>
                                            <td><?php echo $index?></td>
                                            <td><?php echo htmlentities($res->dshort);?></td>
                                            <td><?php echo htmlentities($res->dfull);?></td>
                                            <td><?php echo htmlentities($res->cdate);?></td>
                                            <td>&nbsp;&nbsp;<a href="edit_dept.php?did=<?php echo htmlentities($res->did);?>"><p class="fa fa-edit"></p></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="view_departments.php?del=<?php echo htmlentities($res->did); ?>"> <p class="fa fa-times-circle"></p></td>
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