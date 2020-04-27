<?php
$title = "ProSys";
$subtitle = "Group Settings";
session_start();
include 'db/db_connect.php';
if(!isset($_SESSION['user_id'])){
    header("location: login.php");
}
//Getting Values from SESSION
$batchId = $_SESSION['batchId'];
$studentId = $_SESSION['usrId'];
/* Check if:
 * - User is a groupLeader
 * - User is already in a group
 */
$sql = "SELECT * FROM student WHERE studentId = '$studentId'  LIMIT 1";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $groupId =$row['groupId'];
        if ($row['isLeader'] == null){
            header('Location:' . 'CreateProject.php?status=cp');
        }
        else{
            //Get group name
            $sql = "SELECT projectName FROM student_group WHERE leaderId = '$studentId' AND groupId='$groupId' LIMIT 1";
            $result = $link->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $projectName =$row['projectName'];
                }
            } else{
                $projectName ='--';
            }
        }
    }
}

//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnDeleteMyGroup'])){
        //Check if group has no members
        $sql = "SELECT * FROM student_group WHERE leaderId='$studentId' LIMIT 1";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $inGroup = $row['inGroup'];
                $fypPart = $row['fypPart'];
                $groupId = $row['groupId'];
            } 
            if ($inGroup == 1 AND $fypPart ==1){
                $sql = "SELECT requestId FROM faculty_student_request WHERE groupId ='$groupId' LIMIT 1";
                    $result = $link->query($sql);
                    if ($result->num_rows > 0) {
                     echo "<script>alert('true')</script>";
                    $sql = "DELETE from faculty_student_request WHERE groupId = '$groupId' ";
                    if ($link->query($sql) === TRUE) {
                        //Delete group
                        // sql to delete a record
                        $sql = "DELETE from student_group WHERE leaderId = '$studentId' ";
                        if ($link->query($sql) === TRUE) {
                            //Update student record
                            $sql = "UPDATE student SET groupId=null ,isLeader = null WHERE studentId=' $studentId' ";
                            if ($link->query($sql) === TRUE) {
                                // Commit transaction
                                mysqli_commit($link);
                                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
                            } else{
                                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
                            }
                        }
                    }
                } else
                {
                    //Delete group
                    // sql to delete a record
                    $sql = "DELETE from student_group WHERE leaderId = '$studentId' ";
                    if ($link->query($sql) === TRUE) {
                            //Update student record
                            $sql = "UPDATE student SET groupId=null ,isLeader = null WHERE studentId=' $studentId' ";
                            if ($link->query($sql) === TRUE) {
                                // Commit transaction
                                mysqli_commit($link);
                                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
                            } else {
                                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
                            }
                        }
                    }
                } else if ($inGroup > 1 AND $fypPart ==1){
                    $sql = "SELECT studentId FROM student WHERE groupId = '$groupId'";
                    $result = $link->query($sql);
                    echo "<script>alert('$count')</script>";
                }
            }
        }
    }
    ?>
<head>
  <?php include('include/head.php'); ?>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include('include/navbar.php'); ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include ('include/sidebar.php'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php include ('include/contentheader.php'); ?>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <?php
                            if (isset($_GET['status'])){
                                if ($_GET['status'] == 't'){
                                    ?>
                                    <div style="text-align:center;" class="alert alert-success" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        Changes saved successfully!
                                        <button type="button" class="close" data-dismiss="alert">x</button>
                                    </div>
                                    <?php
                                } else  if ($_GET['status'] == 'f'){ 
                                    ?>
                                    <div style="text-align:center;" class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        Error! Something Went Wrong
                                        <button type="button" class="close" data-dismiss="alert">x</button>
                                    </div>
                                    <?php
                                } else if ($_GET['status'] == 'req'){
                                    ?>
                                    <div style="text-align:center;" class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        Error! Please fill all required fields
                                        <button type="button" class="close" data-dismiss="alert">x</button>
                                    </div>
                                    <?php
                                } else if ($_GET['status'] == 'e'){
                                    ?>
                                    <div style="text-align:center;" class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                        Error!
                                        <button type="button" class="close" data-dismiss="alert">x</button>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                    Group Settings</h3>
                                </div>
                                <!-- form start -->
                                <div class="card-body">
                                    <form action="" method="post" onsubmit="return confirm('Are you sure you want delete your own group?');" data-toggle="validator">
                                        <ul class="todo-list ui-sortable">
                                            <li class="">
                                                <!-- drag handle -->
                                                <span class="handle ui-sortable-handle">
                                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                                </span>
                                                <span class="text">Delete my group</span>
                                                <small class="badge bg-success"><?php echo $projectName;?></small>
                                                <?php
                                                $sql = "SELECT facultyStudentId FROM faculty_student_group WHERE groupId ='$groupId' LIMIT 1";
                                                $result = $link->query($sql);
                                                if ($result->num_rows > 0) {
                                                    ?>
                                                    <label class="float-right">you can not delete this group because you have a supervisor.
                                                    </label>
                                                    <?php
                                                } else{
                                                    ?>
                                                    <button type="submit" name="btnDeleteMyGroup" class="btn btn-danger  btn-xs float-right">Submit</button>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a href="<?php echo siteroot ;?>" class="btn btn-default">Back</a>
                                </div>
                            </div>
                            <!-- /.card -->
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include('include/footer.php'); ?>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <?php include ('include/jsFile.php'); ?>
</body>