<?php 
$title = "ProSys";
$subtitle = "Grading";
session_start();
include ('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }
  $facultyId = $_SESSION['user_id'];

/***************************************
 * Check if Coordinator allowed grading
 ***************************************/
$sql = "SELECT * FROM batch JOIN batch_settings ON batch_settings.batchId = batch.batchId WHERE isActive = 1 AND fypPart =1 LIMIT 1";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $male_female_group = $row['male_female_group'];
        $sdp1_grading = $row['sdp1_grading'];
        $internal_evaluation = $row['internal_evaluation'];
        $sdp2_grading = $row['sdp2_grading'];
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
        $grade = filter_input(INPUT_POST,'grade',FILTER_SANITIZE_SPECIAL_CHARS);


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
</head>s
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
                        <?php   }
                        else if ($_GET['status'] = 'f'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! Please select grade
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                        <?php }

                        else{ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! Something Went Wrong
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                        <?php    }
                    }?>


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">List of students</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body  ">
                            <div class="form-group">
                                <label for="chooseGroup" class="col-sm-2 control-label">Choose Group</label>
                                <div class="col-sm-10">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Choose a Group
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <?php
                                            $sql = "SELECT *  FROM student_group WHERE fypPart=1"; //TODO SDP Part 2
                                            $result = $link->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while($row = $result->fetch_assoc()) { ?>
                                                    <li><a href="<?php echo $_SERVER['PHP_SELF'].'?group='.$row['groupId'];?>"><?php echo $row['projectName'];?></a></li>
                                            <?php    }
                                            } else { ?>
                                                <li><a href="<?php echo $_SERVER['PHP_SELF'];?>">No Groups Available</a></li>
                                         <?php   }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!--Show Group Members-->
                            <?php
                            if (isset($_GET['group']) AND is_numeric($_GET['group']) AND $grade_check == FALSE ){ ?>

                                <br/>
                                <h2 class="page-header">
                                    <i class="fa fa-list-alt"></i> <?php echo $projName;?>
                                    <small class="pull-right">Supervisor: <?php if (isset($supervisorName)){echo $supervisorName;}?></small>
                                </h2>

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Rid</th>
                                        <th>Name</th>
                                        <th>Set Grade</th>
                                        <th>Comments/Review</th>
<!--                                        <th>Action</th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <form role="form" action="" id="gradeStudents" name="gradeStudents" method="POST"  data-toggle="validator">
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
                                                <option value="A+">A+</option>
                                                <option value="A">A</option>
                                                <option value="B+">B+</option>
                                                <option value="B">B</option>
                                                <option value="C+">C+</option>
                                                <option value="C">C</option>
                                                <option value="D+">D+</option>
                                                <option value="D">D</option>
                                                <option value="F">F</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" id="comments[]" name="comments[]" placeholder="Comments/Reviews if any"></td>
<!--                                        <td><button type="submit" name="btnGradeStudents" form="gradeStudents" class="btn btn-default btn-sm ">Grade Student</button></div></td>-->
                                        <?php } } ?>
                                    </tr>

                                    </form>
                                    </tbody>
                                </table>

                                <div class="box-footer">
                                    <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default" >Cancel</a>
                                    <button type="submit" name="btnGradeStudents" form="gradeStudents" class="btn btn-primary pull-right">Grade Students</button>
                                </div>

                            <?php
                            }else if (isset($grade_check)) {
                                if ($grade_check == TRUE){


                                ?>
                                <br/><br/>

                                <div class="callout callout-info">
                                    <h4>Already Graded!</h4>

                                    <p>This group has already been graded.Select another group from the dropdown list</p>
                                </div>
                                    <table class="table table-condensed">
                                        <tr>
                                            <th style="width: 20px;">Rid</th>
                                            <th>Name</th>
                                            <th sty="width: 10px;">Grade</th>

                                        </tr>
                                        <?php
                                        $sql = "SELECT studentRid,studentName,grade,gradedBy FROM grades JOIN student ON student.studentId = grades.studentId WHERE grades.groupId = '$groupId' AND fypPart = 2";
                                        $result = $link->query($sql);

                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                $gradedBy = $row['gradedBy'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['studentRid'];?></td>
                                                    <td><?php echo $row['studentName'];?></td>
                                                    <td><?php echo $row['grade'];?></td>
                                                </tr>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </table>

                            <?php
                            }   }

                            ?>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>

            </div>
        </section>




    </div>
    <!-- .Content Wrapper. Contains page content -->

    <footer class="main-footer">
    </footer>
    <?php include('include/footer.php'); ?>
  </div>

  <!-- jQuery -->
  <?php include('include/jsFile.php'); ?>
  <!-- .jQuery -->

 

  </body>
</html>