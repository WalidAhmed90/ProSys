<?php
$title="ProSys";
$subtitle="Manage Student Groups";
include('include/head.php');
include('db/db_connect.php');
include("mysql_table.php");
session_start();
if(!isset($_SESSION['user_id']))
{
    header("location: login.php");
}
if ($_SERVER['REQUEST_METHOD']== 'GET') {
    //Send Request
    if (isset($_GET["groupId"]) and is_numeric($_GET["groupId"]) ){
        $groupId = filter_input(INPUT_GET, 'groupId');
        $sql = "UPDATE `faculty_student_group` SET `remove_group`= 1 WHERE `groupId` = '$groupId'";
        if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
        }
    }
}
if ($_SERVER['REQUEST_METHOD']== 'GET') {
    //Send Request
    if (isset($_GET["undoId"]) and is_numeric($_GET["undoId"]) ){
        $groupId = filter_input(INPUT_GET, 'undoId');
        $sql = "UPDATE `faculty_student_group` SET `remove_group`= 0 WHERE `groupId` = '$groupId'";
        if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
        }
    }
}
?>
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include('include/navbar.php'); ?>
        <!-- .Navbar -->
        <?php include('include/head.php'); ?>
        <?php include('include/sidebar.php'); ?>
        <div class="content-wrapper" >
            <?php include('include/contentheader.php'); ?>
            <section class="content" style="min-height: 700px">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (isset($_GET['status'])){
                            if ($_GET['status'] == 't'){ ?>
                                <div style="text-align:center;" class="alert alert-success" role="alert">
                                    <i class="fas fa-exclamation"></i>
                                    Changes saved successfully!
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else  if ($_GET['status'] == 'f'){
                                ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation"></i>
                                    Error! Something Went Wrong
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else if ($_GET['status'] == 'n'){
                                ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation"></i>
                                    Error! This faculty is supervising a group. Can not delete this
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else if ($_GET['status'] == 'e'){
                                ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation"></i>
                                    Error!
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <?php if (isset($_GET['details']) && is_numeric($_GET['details']) && strlen($_GET['details'])){
                            $groupId = filter_input(INPUT_GET, 'details');
                            $projectName = $link->query("SELECT projectName FROM student JOIN student_group ON student.groupId = student_group.groupId  WHERE student.groupId = '$groupId' LIMIT 1" )->fetch_object()->projectName;
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
                            ?>
                            <!-- Group Members details -->
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
                                        <?php if (isset($supervisorName) != "") {?>
                                            <h6 class="text-muted">For the permission to unsupervise the group please click on remove group button.</h6>
                                            <h6 class="text-muted">Or you have already clicked the button.</h6>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <!-- /.card-body -->
                                    <!--GROUP MEMBERS-->
                                    <div class="card-header ">
                                        <h3 class="card-title text-primary font-weight-bold">Group Members</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body  table-responsive">
                                        <table id="groupMembers" class="table table-striped">
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
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                        <a href="<?php echo $_SERVER['PHP_SELF'].'?' ; ?>" class="btn  btn-default btn-sm  "> Back</a>
                                        <?php $sql = "SELECT * FROM faculty_student_group WHERE faculty_student_group.groupId = '$groupId' LIMIT 1 ";
                                        $result = $link->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                $remove_group =  $row["remove_group"];
                                            }
                                            if ($remove_group == 1) { ?>
                                                <form  action="" method="get" onsubmit="return confirm('Are you sure you want to undo remove "<?php echo $row['studentName']; ?>"  from your group?');" data-toggle="validator">
                                                    <input type="hidden" name="undoId" value="<?php echo $groupId;?>">
                                                    <button type="submit" class="btn  btn-primary float-right "><i class="fas fa-user-slash"></i> Undo Remove Group</button>
                                                </form>
                                                <?php
                                            } else{
                                                ?>
                                                <form  action="" method="get" onsubmit="return confirm('Are you sure you want to remove "<?php echo $row['studentName']; ?>"  from your group?');" data-toggle="validator">
                                                    <input type="hidden" name="groupId" value="<?php echo $groupId;?>">
                                                    <button type="submit" class="btn  btn-primary float-right "><i class="fas fa-user-slash"></i> Remove Group</button>
                                                </form>
                                            <?php } }?>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.card -->
                                <?php
                            } else{
                                ?>
                                <!-- general form elements -->
                                <div class="card card-primary no-border">
                                    <div class="card-header with-border">
                                        <h3 class="card-title">List of Groups</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive ">
                                        <table id="manageGroups" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Batch</th>
                                                    <th>Project Name</th>
                                                    <th>Group Members</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $sql = "SELECT * FROM student JOIN student_group ON student.studentId = student_group.leaderId JOIN batch ON batch.batchId = student_group.batchId WHERE isLeader = 1 AND batch.isActive = 1";
                                            $result = mysqli_query($link,$sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                // output data of each row
                                                while($row = mysqli_fetch_assoc($result)) { ?>
                                                    <tr>
                                                        <td><?php echo $row['batchName'];?></td>
                                                        <td><?php echo $row['projectName'];?></td>
                                                        <td>
                                                            <?php
                                                            $groupId = $row['groupId'];
                                                            $groupMembers = mysqli_query($link,"SELECT * FROM student WHERE groupId = '$groupId' ");
                                                            if (mysqli_num_rows($groupMembers) > 0){
                                                                while($member = mysqli_fetch_assoc($groupMembers)){ ?>
                                                                    <?php  echo $member['studentName']. " (" .$row['studentRid']. " )"."<br/>"; ?>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo $_SERVER['PHP_SELF']."?details=".$row['groupId'];?>" class="btn btn-default btn-sm"><i class="fa fa-info-circle" aria-hidden="true"></i> Details</a>
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
            <?php
            include('include/footer.php');
            ?>
        </div>
        <?php
        include('include/jsFile.php');
        ?>
        <script>
            function goBack() {
                window.history.back();
            }

            $(document).ready(function() {
                $('#manageGroups').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                });
            } );
        </script>
</body>