<?php
$title = "ProSys";
$subtitle = "Group Details";
include('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: login.php");
}

$studentId = $_SESSION['usrId'];

//Getting group id
$sql = "SELECT * FROM student WHERE student.studentId = '$studentId' LIMIT 1";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $groupId = $row['groupId'];
        $isLeader = $row['isLeader'];
    }
} else{
    $groupId = $_SESSION["groupId"];
}

//Get Project name
if (!is_null($groupId)){

    //Getting group id and Project Name from DATABASE
    //If groupLeader
    $sql = "SELECT * FROM student_group WHERE student_group.leaderId = '$studentId' LIMIT 1";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $projectName = $row['projectName'];
        }
    }
    else{
        $projectName = $link->query("SELECT projectName FROM student JOIN student_group ON student.groupId = student_group.groupId  WHERE student.studentId = '$studentId' LIMIT 1" )->fetch_object()->projectName;
    }

}


//Getting supervisor id and name
$sql = "SELECT facultyId FROM faculty_student_group WHERE faculty_student_group.groupId = '$groupId' LIMIT 1 ";
$result = $link->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $supervisorId =  $row["facultyId"];
    }
    $sql_name = "SELECT facultyName FROM faculty WHERE faculty.facultyId = '$supervisorId' ";
    $result = $link->query($sql_name);
            if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            $supervisorName =  $row["facultyName"];
            }

        }
}

if ($_SERVER['REQUEST_METHOD']== 'GET') {
      //Send Request
    if (isset($_GET["requestId"]) and is_numeric($_GET["requestId"]) ){

        $requestId = filter_input(INPUT_GET, 'requestId');

            $sql = "UPDATE `student` SET `groupId`= null WHERE `studentRid` = '$requestId'";

            if ($link->query($sql) === TRUE) {

                $sql = "UPDATE `student_group` SET `inGroup`= inGroup -1 WHERE `leaderId` = '$studentId'";  
            if ($link->query($sql) === TRUE) {

                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
            } else {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
            }
        }
    }
}
//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
            <section class="content" style="min-height: 700px">
                <div class="row">
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
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <?php
                    if (!is_null($groupId) && !is_null($isLeader)) { ?>
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header with-border">
                                    <h3>Project Name:
                                        <span class="font-weight-bold text-info text-capitalize"><?php echo $projectName?></span>
                                    </h3>
                                    <!--Supervisor Name-->
                                    <h5>Supervisor:
                                        <span class="font-weight-bold text-info text-capitalize"><?php
                                        if (isset($supervisorName)){
                                            echo $supervisorName;
                                        } else{
                                            echo ' --- ';
                                        }
                                        ?></span>
                                    </h5>
                                </div>
                                <!-- /.card-body -->
                                <!--GROUP MEMBERS-->
                                <div class="card-header ">
                                    <h3 class="card-title text-primary font-weight-bold">Group Members</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body  table-responsive">
                                    <table id="groupMembers" class="table table-head-fixed text-nowrap table-striped">
                                        <thead>
                                            <tr>
                                                <th>Registration ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        //$groupID = $_SESSION['GroupID'];
                                        $sql = "SELECT * from student WHERE student.groupId = '$groupId' ";
                                        $result = $link->query($sql);
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['studentRid']; ?></td>
                                                <td><?php echo $row['studentName'];
                                                if ($row['isLeader'] == 1){
                                                    echo '  <span class="badge bg-primary">Leader</span>';
                                                }
                                                ?></td>
                                                <td><?php echo $row['studentEmail']; ?></td>
                                                <td><?php echo $row['studentPhoneNo']; ?></td>
                                                <td>
                                                    <?php  if ($row['isLeader'] != 1){ 
                                                        ?>
                                                        <form  action="" method="get" onsubmit="return confirm('Are you sure you want to remove "<?php echo $row['studentName']; ?>"  from your group?');" data-toggle="validator">
                                                            <input type="hidden" name="requestId" value="<?php echo $row['studentRid'];?>">
                                                            <button type="submit" class="btn  btn-primary btn-block  btn-sm"><i class="fas fa-user-slash"></i> Remove Member</button>
                                                        </form>
                                                    <?php } else{
                                                    } 
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    <?php 
                } else if (!is_null($groupId)) {
                    ?>
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header with-border">
                                <h3>Project Name:
                                    <span class="font-weight-bold text-info text-capitalize"><?php echo $projectName?></span>
                                </h3>
                                <!--Supervisor Name-->
                                <h5>Supervisor:
                                    <span class="font-weight-bold text-info text-capitalize">
                                        <?php
                                        if (isset($supervisorName)){
                                            echo $supervisorName;
                                        } else{
                                            echo ' --- ';
                                        }
                                        ?>
                                    </span>
                                </h5>
                            </div>
                            <!-- /.card-body -->
                            <!--GROUP MEMBERS-->
                            <div class="card-header ">
                                <h3 class="card-title text-primary font-weight-bold">Group Members</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body  table-responsive">
                                <table id="groupMembers" class="table table-head-fixed text-nowrap table-striped">
                                    <thead>
                                        <tr>
                                            <th>Registration ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    //$groupID = $_SESSION['GroupID'];
                                    $sql = "SELECT * from student WHERE student.groupId = '$groupId' ";
                                    $result = $link->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['studentRid']; ?></td>
                                            <td><?php echo $row['studentName'];
                                            if ($row['isLeader'] == 1){
                                                echo '  <span class="badge bg-primary">Leader</span>';
                                            }
                                            ?></td>
                                            <td><?php echo $row['studentEmail']; ?></td>
                                            <td><?php echo $row['studentPhoneNo']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <?php
                } else if (is_null($groupId)) {
                    ?>
                    <div class="col-md-12">
                        <div class="callout callout-info">
                            <h4>Can not show details</h4>
                            <p>You are not part of any group.Please form a group and try again</p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
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