<?php 
$title = "ProSys";
$subtitle = "Supervise Group";
session_start();
include ('db/db_connect.php');
if($_SESSION['isCord'] == 1 OR $_SESSION['type'] == 'Student'){
  header("location: login.php");
  }
$facultyId = $_SESSION['usrId'];
$facultyName = $_SESSION["usrnm"];
  //Function for remove Request
    if (isset($_GET["remove"]) AND is_numeric($_GET["remove"]) ){

        $id = filter_input(INPUT_GET, 'remove');

            $sql = "SELECT * FROM group_uploads WHERE groupId = '$id' ";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
               header('Location:' .$_SERVER['PHP_SELF'] .'?status=val');
            }else{

           //If request accepted delete request from record
                 $sql = "DELETE FROM `meeting_requests` WHERE `group_id` ='$id' ";
                if ($link->query($sql) === TRUE) {
                    //Record also deleted
                      $sql = "DELETE FROM `weekly_report` WHERE `group_Id` ='$id' ";
                if ($link->query($sql) === TRUE) {

                     $sql = "DELETE FROM `faculty_student_group` WHERE `groupId` ='$id' ";
                if ($link->query($sql) === TRUE) {
                    //Record also deleted
                    //Increment value of currentload
                    $sql = "UPDATE work_load SET currentLoad = currentLoad -1 WHERE facultyId = '$facultyId'";
                    if ($link->query($sql) === TRUE) {

                        /****
                         * Add this to timeline
                         *  Zeeshan Sabir is now supervising group (FYP Management System)
                         *  Faculty Name from facultyId (SESSION)
                         *  Group Name from groupId
                         *
                         */
                        //Add this info to the students and faculty timeline




                        //Get Batch id,projectName and SDP part from groupId
                        $sql = "SELECT * FROM student_group WHERE groupId = '$id' LIMIT 1";
                        $result = $link->query($sql);

                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $batchId = $row['batchId'];
                                $projectName = $row['projectName'];
                                $fypPart = $row['fypPart'];
                            }
                        }

                        $title = 'Info';
                        $details = $facultyName." is not supervising group ".$projectName;

                        $sql = "INSERT INTO timeline_student (title, details, type, batchId, fypPart) VALUES ('$title', '$details', 'info', '$batchId', '$fypPart')";

                        if ($link->query($sql) === TRUE) {
                            $sql = "INSERT INTO timeline_faculty (title, details, type, batchId, fypPart) VALUES ('$title', '$details', 'info', '$batchId', '$fypPart')";

                            if ($link->query($sql) === TRUE) {
                               header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
                            }else
                            {
                                  header('Location:' . $_SERVER['PHP_SELF'] . '?status=e');die;
                            }


                        }
                    }

                    
                }else
                {
                    header('Location:' . $_SERVER['PHP_SELF'] . '?status=e');die;
                }

            } 
        }
    }
}
            
            
        
            
               




//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "FORM SUBMITTED POST";
    exit;

}


 ?>
<head>
  <?php include('include/head.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include('include/navbar.php'); ?>
    <!-- .Navbar -->

    <!-- Main Sidebar Container -->
    <?php include('include/sidebar.php'); ?>
    <!-- .Main Sidebar Container -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <?php include ('include/contentheader.php'); ?>
      <!-- .Content Header (Page header) -->

       <section class="content">
            <div class="row">

                <div class="col-md-12">

                    <?php
                    if (isset($_GET['status'])){
                        if ($_GET['status'] == 't'){ ?>
                            <div style="text-align:center;" class="alert alert-success" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Changes saved successfully!
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                        else  if ($_GET['status'] == 'f'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! Something Went Wrong
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                        else if ($_GET['status'] == 'req'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! Please fill all required fields
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                        else if ($_GET['status'] == 'e'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error!
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                        elseif ($_GET['status'] == 'val') { ?>
                            <div style="text-align: center; " class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Can not remove the group now because this group submitted the deliverable.
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                         <?php   
                        
                    }
                }

                    ?>

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header with-border">
                            <h3 class="card-title"> list of Groups</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive">
                            <table id="superviseGrouptable" class="table table-head-fixed text-nowrap table-striped">
                                <tr>
                                    <th>Group</th>
                                    <th>Project Name</th>
                                    <th>Batch</th>
                                    <th>Actions</th>
                                </tr>
                                <?php
                                $sql = "SELECT * FROM faculty_student_group JOIN student_group WHERE facultyId = '$facultyId' AND faculty_student_group.groupId = student_group.groupId";

                                $result = $link->query($sql);

                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['groupId'];?></td>
                                            <td><?php echo $row['projectName'];?></td>

                                            <td><?php $batchId= $row['batchId'];
                                                $batchName = $link->query("SELECT batchName FROM batch WHERE batchId = '$batchId' ")->fetch_object()->batchName;
                                                echo $batchName;
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo $_SERVER['PHP_SELF']."?details=".$row['groupId'];?>" class="btn-primary btn-block  btn-sm"><i class="fa fa-info-circle" aria-hidden="true"></i> Details</a>
                                                <?php if ($row['remove_group']==1) {
                                                    
                                                 ?>
                                                <a href="<?php echo $_SERVER['PHP_SELF']."?remove=".$row['groupId'];?>" class="btn-danger btn-block  btn-sm"><i class="fa fa-times" aria-hidden="true"></i> Remove</a>
                                            <?php }?>
                                                <a href="<?php echo $_SERVER['PHP_SELF']."?uploads=".$row['groupId'];?>" class="btn btn-block btn-default btn-sm"> <i class="fa fa-upload"></i>Deliverables</a>
                                            </td>

                                        </tr>

                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <?php if (isset($_GET['details']) && is_numeric($_GET['details']) && strlen($_GET['details'])){ ?>
                        <!-- Group Members details -->
                        <div class="card no-border">
                            <div class="card-header with-border">
                                <h3 class="card-title">Group Members Details</h3>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body ">
                                <table class="table table-condensed ">
                                    <tr>
                                        <th style="width: 10px">Rid</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                    </tr>
                                    <?php
                                    $groupId = filter_input(INPUT_GET,'details',FILTER_SANITIZE_NUMBER_INT);

                                    $sql = "SELECT * FROM student  WHERE groupId = '$groupId' ";

                                    $result = $link->query($sql);

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['studentRid'];?></td>
                                                <td><?php echo $row['studentName'];?></td>
                                                <td><?php echo $row['studentEmail'];?></td>
                                                <td><?php echo $row['studentPhoneNo'];?></td>
                                            </tr>

                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    <?php
                    }
                    else if (isset($_GET['uploads']) && is_numeric($_GET['uploads']) && strlen($_GET['uploads'])){ ?>
                        <!-- Group Uploads details -->
                        <div class="card no-border table-responsive">
                            <div class="card-header with-border">
                                <h3 class="card-title">Group Deliverables</h3>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body ">
                                <table class="table table-head-fixed text-nowrap table-striped">
                                    <tr>
                                        <th>Title</th>
                                        <th>Deliverable</th>
                                        <th>Deadline</th>
                                        <th>Uploaded <i class="fas fa-clock"></i></th>
                                        <th>Status</th>
                                        <th>Uploaded by</th>
                                    </tr>
                                    <?php
                                    $groupId = filter_input(INPUT_GET,'uploads',FILTER_SANITIZE_NUMBER_INT);

                                    $sql = "SELECT * FROM group_uploads join batch_tasks ON group_uploads.taskId = batch_tasks.taskId WHERE groupId  = '$groupId'";

                                    $result = $link->query($sql);

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php
                                                    $taskId = $row['taskId'];
                                                    $taskName = $link->query("SELECT taskName FROM batch_tasks WHERE taskId = '$taskId' LIMIT 1")->fetch_object()->taskName;
                                                    echo $taskName;

                                                    ?>
                                                </td>
                                                <td><?php
                                                    $deliverableName=$row['uploadFile'];
                                                    $groupId = $row['groupId'];

                                                    //Getting batchId,batch Name from groupId
                                                    $batchId = $link->query("SELECT batchId FROM student_group WHERE groupId = '$groupId' ")->fetch_object()->batchId;
                                                    $batchName = $link->query("SELECT batchName FROM batch WHERE batchId = '$batchId' ")->fetch_object()->batchName;

                                                    $group = 'Group '.$groupId;

                                                    $location = "uploads/".$batchName."/".$group."/".$deliverableName;
                                                    echo "<a href=\"$location\">$deliverableName</a>" ;

                                                    ?></td>
                                                    <td><?php echo $row['taskDeadline'];?></td>
                                                    <td><?php echo $row['uploadedDtm'];?></td>
                                                    <td class="badge bg-black text-center"><?php if ((strtotime($row['taskDeadline']) - strtotime($row['uploadedDtm'])) > 0) {
                                                        
                                                       echo "IN TIME";
                                                    }else{
                                        
                                                         echo " LATE ";
                                                    } ?></td>
                                                    <td><?php
                                                    $studentId =$row['uploadedBy'];
                                                    $studentName = $link->query("SELECT studentName FROM student WHERE studentId = '$studentId' LIMIT 1")->fetch_object()->studentName;
                                                    echo "<a href=\"studentProfile.php?id=$studentId\">$studentName</a>" ;
                                                    ?>
                                                </td>
                                            </tr>

                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    <?php
                    }
                    ?>






                </div>
            </div>
        </section>


    </div>
    <?php include('include/footer.php'); ?>
  </div>

  <!-- jQuery -->
  <?php include('include/jsFile.php'); ?>
  <!-- .jQuery -->
  <script type="text/javascript">
      $(document).ready(function(){
            $('superviseGrouptable').DataTable({
                "paging": true;
                "lengthChange": false;
                "searching": true;
                "ordering": false;
                "info": true;
                "autoWidth": false;
            });
      });

  </script>

 

  </body>
</html>