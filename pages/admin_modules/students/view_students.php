<?php
    session_start ();
    if (! (isset ( $_COOKIE ['user'] ))) 
    {	
        header('location:../../../pages/gates/login.php');
    }

   include('../../../config/DbQueries.php');
   $obj          = new DbQueries();
   $all_students = $obj->showStudents();

   if(isset($_GET['del']))
   {
      $obj->del_student(intval($_GET['del']));       
   }

   include('../../common/header.html');

?>

<body>
   <div id="wrapper">
      <!-- Navigation -->
      <?php include('../../common/side_menu.html') ?>
      <nav>
      <div id="page-wrapper"  class="col-md-9">
         <div class="row">
            <div class="col-lg-12">
               <h4 class="page-header"> <?php echo strtoupper("welcome"." ".htmlentities($_SESSION['login']));?></h4>
            </div>
            <!-- /.col-lg-12 -->
         </div>
         <!-- /.row -->
         <div class="row">
            <div class="col-lg-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     View Students
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                     <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                           <thead>
                              <tr>
                                 <th>SNo</th>
                                 <th>RegNo <i class="fa fa-sort" aria-hidden="true"></i></th>
                                 <th>Name <i class="fa fa-sort" aria-hidden="true"></i></th>
                                 <th>Email <i class="fa fa-sort" aria-hidden="true"></i></th>
                                 <th>Mobile <i class="fa fa-sort" aria-hidden="true"></i></th>
                                 <th>Course <i class="fa fa-sort" aria-hidden="true"></i></th>
                                 <th>Subjects <i class="fa fa-sort" aria-hidden="true"></i></th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                            <?php 
                                $index = 1;
                                while($res = $all_students->fetch_object())
                                {
                                    $cid    = $res->cid;
                                    $c_data = $obj->getCourse($cid);
                                    $res1   = $c_data->fetch_object();
                                 
                            ?>	
                              <tr>
                                 <td><?php echo $index?></td>
                                 <td><?php echo htmlentities($res->reg_no);?></td>
                                 <td><?php echo htmlentities($res->fname." ".$res->mname." ".$res->lname);?></td>
                                 <td><?php echo htmlentities($res->email_id);?></td>
                                 <td><?php echo htmlentities($res->mobile);?></td>
                                 <td><?php echo htmlentities($res1->cshort);?></td>
                                 <td class="col-md-3"><?php echo htmlentities($res->subjects);?></td>
                                 <td>
                                    &nbsp;&nbsp;
                                    <a href="edit_student.php?id=<?php echo htmlentities($res->sid);?>">
                                       <p class="fa fa-edit"></p>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="view_students.php?del=<?php echo htmlentities($res->sid); ?>">
                                    <p class="fa fa-times-circle"></p>
                                 </td>
                              </tr>
                              <?php $index++;}?>   	           
                           </tbody>
                        </table>
                     </div>
                     <!-- /.table-responsive -->
                  </div>
                  <!-- /.panel-body -->
               </div>
               <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /#page-wrapper -->
   </div>
   <!-- /#wrapper -->
</body>


<?php
    include('../../common/footer.html');
?>