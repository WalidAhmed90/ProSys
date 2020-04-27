<?php 
$title = "ProSys";
$subtitle = "Grading";
session_start();
include ('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
}
$facultyId = $_SESSION['usrId'];

/***************************************
 * Check if Coordinator allowed grading
 ***************************************/
$sql = "SELECT * FROM batch JOIN batch_settings ON batch_settings.batchId = batch.batchId WHERE isActive = 1 AND fypPart =1 LIMIT 1";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       
        $fyp1_grading = $row['fyp1_grading'];
        $fyp2_grading = $row['fyp2_grading'];
    }
}

//Check if form is submitted by GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET["group"]) and is_numeric($_GET["group"]) ){
        $groupId =  filter_input(INPUT_GET, "group",FILTER_SANITIZE_SPECIAL_CHARS);

        //Check if group is already graded
        $sql = "SELECT id FROM grades WHERE groupId='$groupId' AND fypPart=1 LIMIT 1 ";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            $grade_check = TRUE;
        }else{
            $grade_check = FALSE;
            $projName= $link->query("SELECT projectName FROM student_group WHERE student_group.groupId = '$groupId' ")->fetch_object()->projectName;
            //Supervisor Data
            $supervisorId = $link->query("SELECT facultyId FROM faculty_student_group WHERE faculty_student_group.groupId = '$groupId' ")->fetch_object()->facultyId;
            if($supervisorId){
                $supervisorName = $link->query("SELECT facultyName FROM faculty WHERE faculty.facultyId= '$supervisorId' ")->fetch_object()->facultyName;
            }
        }
    }
}

//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnGradeStudents'])){
        //VALIDATIONS
        if (isset($_POST['grade'])){
            //HIDDEN INPUTS
            $studentId = $_POST['studentId'];
            $count = $_POST['count'];
            $groupId = $_POST['groupId'];
            $fypPart = '1';
            //FROM FORM
            $grade = $_POST['grade'];
            $comments = $_POST['comments'];

            for ($x = 0; $x < $count; $x++) {
                $sql = "INSERT INTO grades (studentId, groupId, fypPart, comments, grade,gradedBy) VALUES ('$studentId[$x]', '$groupId', '$fypPart' , '$comments[$x]', '$grade[$x]','$facultyId')";

                if ($link->query($sql) === TRUE) {
                    header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
                } else {
                    //SQL ERROR
                    header('Location:' . $_SERVER['PHP_SELF'] . '?status=fs');
                }
            }
        }
        else if ($_POST['grade[]'] == "" ){
            //GRADE NOT SELECTED
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
        }
    }

    /**************
     * Edit Grade
     ************/
    if (isset($_POST['btnEditGrade'])){

        $gradeId = filter_input(INPUT_POST,'gradeId',FILTER_SANITIZE_NUMBER_INT);
        $groupId = filter_input(INPUT_POST,'groupId',FILTER_SANITIZE_NUMBER_INT);
        $grade = filter_input(INPUT_POST,'grade',FILTER_SANITIZE_NUMBER_INT);


        $sql = "UPDATE grades SET grade='$grade' WHERE id='$gradeId' ";

        if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?group='.$groupId.'&status=t');die;
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?group='.$groupId.'&status=f');die;
        }

    }
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

            <section class="content" style="min-height: 700px">
                <div class="row">
                    <div class="col-md-12">
                        <?php if (isset ($_GET['status'])){
                            if ($_GET['status'] == 't'){ ?>
                                <div style="text-align:center;" class="alert alert-success" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Changes saved successfully!
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else if ($_GET['status'] = 'f'){ ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Error! Something went wrong
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else{ ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Error! Something Went Wrong
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            }
                        }?>
                        <?php
                        if (isset($_GET['edit']) && is_numeric($_GET['edit']) && strlen($_GET['edit'])>0 ){
                            $gradeId = filter_input(INPUT_GET,'edit',FILTER_SANITIZE_NUMBER_INT);
                            $sql = "SELECT * FROM grades JOIN student ON student.studentId = grades.studentId WHERE grades.id = $gradeId LIMIT 1";
                            $result = $link->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    $name = $row['studentName'];
                                    $Rid = $row['studentRid'];
                                    $grade = $row['grade'];
                                    $groupId = $row['groupId'];
                                }
                            }?>
                            <div class="card card-primary card-outline no-border">
                                <div class="card-header with-border">
                                    <h3 class="card-title">Edit Grade: <?php echo $name;?> </h3>
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body">
                                    <form id="editgrade" name="editgrade" method="post" class="form-horizontal" data-toggle="validator">
                                        <div class="form-group">
                                            <input type="hidden" name="gradeId" value="<?php echo $gradeId;?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="groupId" value="<?php echo $groupId;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="grade">Select Grade</label>
                                            <select class="form-control" name="grade" style="width:200px;" required>
                                                <option value="">Select Grade</option>
                                                <?php
                                                for ($i=1 ;$i<=10; $i++){ ?>
                                                    <option value="<?php echo $i;?>" <?php if ($grade== $i ){echo 'selected';} ?> ><?php echo $i;?></option>
                                                    <?php
                                                }?>
                                            </select>
                                        </div>
                                        <br>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" form="editgrade" name="btnEditGrade" class="btn btn-primary btn-sm float-right" form="">Submit</button>
                                    <button onclick="goBack()" class="btn btn-default">Back</button>
                                </div>
                            </div>
                            <?php
                        }?>
                        <?php
                        /*****
                        * If coordinater allowed SPD-1 grading
                        */
                        if ($fyp1_grading == 1){ ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Grade Groups</h3><br>
                                    <p class="text-muted">Select a group and Grade Project Proposal</p>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body  ">
                                    <div class="form-group">
                                        <label for="chooseGroup" class="col-sm-2 control-label">Choose Group</label>
                                        <div class="col-sm-10">
                                            <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    Choose a Group
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu " aria-labelledby="dropdownMenu1">
                                                    <li><a href="<?php echo $_SERVER['PHP_SELF'];?>" class="dropdown-item">---</a></li>
                                                    <?php
                                                    $sql = "SELECT * FROM faculty_student_group JOIN student_group ON faculty_student_group.groupId = student_group.groupId WHERE NOT facultyId= '$facultyId'";
                                                    $result = $link->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        // output data of each row
                                                        while($row = $result->fetch_assoc()) { ?>
                                                            <div class="dropdown-divider"></div>
                                                            <li class="nav-item dropdown"><a href="<?php echo $_SERVER['PHP_SELF'].'?group='.$row['groupId'];?>" class="dropdown-item"><i class="fas fa-users mr-2"></i><?php
                                                            echo $row['projectName']; ?></a></li>
                                                            <?php
                                                        }
                                                    } else { ?>
                                                        <li><a href="<?php echo $_SERVER['PHP_SELF'];?>">No Groups Available</a></li>
                                                        <?php
                                                    }?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Show Group Members-->
                                    <?php
                                    if (isset($_GET['group']) AND is_numeric($_GET['group']) AND $grade_check == FALSE ){ ?>
                                        <br>
                                        <h2 class="page-header">
                                            <i class="fas fa-project-diagram"></i> <?php echo $projName;?>
                                            <small class="float-right">Supervisor: <?php if (isset($supervisorName)){echo $supervisorName;}?></small>
                                        </h2>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Rid</th>
                                                    <th>Name</th>
                                                    <th>Set Grade</th>
                                                    <th>Comments/Review</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <form role="form" action="" id="gradeStudents" name="gradeStudents" method="POST" data-toggle="validator">
                                                    <?php
                                                    $sql = "SELECT *  FROM student WHERE student.groupId ='$groupId' ";
                                                    $result = $link->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        // output data of each row
                                                        while($row = $result->fetch_assoc()) { ?>
                                                            <!--HIDDEN INPUTS-->
                                                            <input type="hidden" name="studentId[]" id="studentId[]" value="<?php echo $row['studentId'];?>">
                                                            <input type="hidden" name="count" id="count" value="<?php echo $result->num_rows; ?>">
                                                            <input type="hidden" name="groupId" id="groupId" value="<?php echo $groupId; ?>">
                                                            <tr>
                                                                <td><?php echo $row['studentRid'];?></td>
                                                                <td><?php echo $row['studentName'];?></td>
                                                                <td><select class="form-control" name="grade[]" required>
                                                                    <option value="">Select Grade</option>
                                                                    <?php
                                                                    for ($i=1 ;$i<=10; $i++){ ?>
                                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                        <?php
                                                                    }
                                                                    ?></select>
                                                                </td>
                                                                <td><input type="text" class="form-control" id="comments[]" name="comments[]" placeholder="Comments/Reviews if any"></td><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                </form>
                                            </tbody>
                                        </table>

                                        <div class="card-footer">
                                            <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default" >Cancel</a>
                                            <button type="submit" name="btnGradeStudents" form="gradeStudents" class="btn btn-primary float-right">Grade Students</button>
                                        </div>

                                        <?php
                                    } else if (isset($grade_check)) {
                                        if ($grade_check == TRUE){?>
                                            <br><br>
                                            
                                            <div class="callout callout-info">
                                                <h4>Already Graded!</h4>
                                                <p>This group has already been graded.You can edit Grades until coordinator locks them</p>
                                            </div>

                                            <table class="table table-condensed">
                                                <tr>
                                                    <th style="width: 20px;">Rid</th>
                                                    <th>Name</th>
                                                    <th sty="width: 10px;">Grade</th>
                                                    <th sty="width: 10px;">Actions</th>
                                                </tr>
                                                <?php
                                                $sql = "SELECT * FROM grades JOIN student ON student.studentId = grades.studentId WHERE grades.groupId = '$groupId' AND fypPart = 1";
                                                $result = $link->query($sql);

                                                if ($result->num_rows > 0) {
                                                    // output data of each row
                                                    while($row = $result->fetch_assoc()) {
                                                        $gradedBy = $row['gradedBy'];?>
                                                        <tr>
                                                            <td><?php echo $row['studentRid'];?></td>
                                                            <td><?php echo $row['studentName'];?></td>
                                                            <td><?php echo $row['grade'];?></td>
                                                            <td><a href="<?php echo $_SERVER['PHP_SELF']."?group=".$row['groupId']."&edit=".$row['id'];?>" class="btn btn-default btn-sm">Edit</a></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }?>
                                            </table>
                                            <?php
                                        }
                                    }?>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <?php
                        }?>
                    </div>
                </div>
            </section>
        </div>
        <!-- .Content Wrapper. Contains page content -->
        <?php include('include/footer.php'); ?>
    </div>

    <!-- jQuery -->
    <?php include('include/jsFile.php'); ?>
    <!-- .jQuery -->

    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
</body>