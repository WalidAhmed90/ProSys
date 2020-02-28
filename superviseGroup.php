<?php 
$title = "ProSys";
$subtitle = "Supervise Group";
session_start();
include ('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

  //Getting values from SESSION
$facultyId = $_SESSION["usrId"];

//Check if form is submitted by GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {


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
                    }

                    ?>

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header with-border">
                            <h3 class="card-title"> list of Groups</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive">
                            <table id="superviseGrouptable" class="table table-head-fixed text-nowrap">
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
                                                <a href="<?php echo $_SERVER['PHP_SELF']."?details=".$row['groupId'];?>" class="btn btn-default btn-sm">Details</a>
                                                <a href="<?php echo $_SERVER['PHP_SELF']."?uploads=".$row['groupId'];?>" class="btn btn-default btn-sm"> <i class="fa fa-upload"></i>Deliverables</a>
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
                                        <th style="width: 10px">CMS</th>
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
                        <div class="card no-border">
                            <div class="card-header with-border">
                                <h3 class="card-title">Group Deliverables</h3>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body ">
                                <table class="table table-responsive ">
                                    <tr>
                                        <th>Title</th>
                                        <th>Deliverable</th>
                                        <th>Uploaded <i class="fa fa-clock-o"></i></th>
                                        <th>Uploaded by</th>
                                    </tr>
                                    <?php
                                    $groupId = filter_input(INPUT_GET,'uploads',FILTER_SANITIZE_NUMBER_INT);

                                    $sql = "SELECT * FROM group_uploads WHERE groupId = '$groupId'";

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

                                                    $location = siteroot."uploads/".$batchName."/".$group."/".$deliverableName;
                                                    echo "<a href=\"$location\">$deliverableName</a>" ;

                                                    ?></td>
                                                    <td><?php echo $row['uploadedDtm'];?></td>
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