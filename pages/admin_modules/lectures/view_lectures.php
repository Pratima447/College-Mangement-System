<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }


    include('../../../config/DbQueries.php');
    $obj         = new DbQueries();
	$all_lectures = $obj->showLectures();

	if(isset($_GET['del']))
    {
        $obj->del_lecture(intval($_GET['del']));       
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
                            View Lectures
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S No</th>
                                            <th>Name <i class="fa fa-sort" aria-hidden="true"></i></th>
                                            <th>Mobile <i class="fa fa-sort" aria-hidden="true"></i></th>
                                            <th>Qualification <i class="fa fa-sort" aria-hidden="true"></i></th>
                                            <th>Join Date <i class="fa fa-sort" aria-hidden="true"></i></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $index = 1;
                                        while($res = $all_lectures->fetch_object())
                                        {?>	
                                        <tr>
                                            <td><?php echo $index?></td>
                                            <td><?php echo htmlentities($res->name);?></td>
                                            <td><?php echo htmlentities($res->mobile);?></td>
                                            <td><?php echo htmlentities($res->qualification);?></td>
                                            <td><?php echo htmlentities($res->join_date);?></td>
                                            <td>&nbsp;&nbsp;<a href="edit_lecture.php?lid=<?php echo htmlentities($res->lid);?>"><p class="fa fa-edit"></p></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="view_lectures.php?del=<?php echo htmlentities($res->lid); ?>"> <p class="fa fa-times-circle"></p></td>
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