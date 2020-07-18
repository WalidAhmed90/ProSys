<?php 
$title = "ProSys";
$subtitle = "Grading";
session_start();
include ('db/db_connect.php');
if($_SESSION['isCord'] != 1){
  header("location: login.php");
}
$facultyId = $_SESSION['usrId'];

/***************************************
 * Check if Coordinator allowed grading
 ***************************************/
$sql = "SELECT * FROM batch JOIN batch_settings ON batch_settings.batchId = batch.batchId WHERE isActive = 1 AND fypPart =2 LIMIT 1";
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
        $sql = "SELECT id FROM grades WHERE groupId='$groupId' AND fypPart=2 AND gradedBy = '$facultyId'  LIMIT 1 ";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            $grade_check = TRUE;

            $projName= $link->query("SELECT projectName FROM student_group WHERE student_group.groupId = '$groupId' ")->fetch_object()->projectName;

            //Supervisor Data
            $supervisorId = $link->query("SELECT facultyId FROM faculty_student_group WHERE faculty_student_group.groupId = '$groupId' ")->fetch_object()->facultyId;
            if($supervisorId){
                $supervisorName = $link->query("SELECT facultyName FROM faculty WHERE faculty.facultyId= '$supervisorId' ")->fetch_object()->facultyName;
            }

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
     if (isset($_POST['contribution']) && isset($_POST['presentation']) && isset($_POST['novelty'])){

            //HIDDEN INPUTS
        $studentId = $_POST['studentId'];
        $count = $_POST['count'];
        $groupId = $_POST['groupId'];
        $fypPart = '2';
        $iscord = '1';

            //FROM FORM
        $Contribution = $_POST['contribution'];
        $presentation = $_POST['presentation'];
        $novelty = $_POST['novelty'];
        $comments = $_POST['comments'];


        for ($x = 0; $x < $count; $x++) {

            $grade[$x] = $Contribution[$x] + $presentation[$x] + $novelty[$x];
            $sql = "INSERT INTO grades (studentId, groupId, fypPart, comments,contribution,presentation,novelty, grade,gradedBy,iscord) VALUES ('$studentId[$x]', '$groupId', '$fypPart' , '$comments[$x]','$Contribution[$x]','$presentation[$x]','$novelty[$x]', '$grade[$x]','$facultyId','$iscord')";

            if ($link->query($sql) === TRUE) {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
            } else {
                    //SQL ERROR
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=fs');
            }
        }

    }
    else if ($_POST['contribution[]'] == "" && $_POST['presentation[]'] == ""  && $_POST['novelty[]'] == "" ){
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
     $contribution = filter_input(INPUT_POST,'contribution',FILTER_SANITIZE_NUMBER_INT);
     $presentation = filter_input(INPUT_POST,'presentation',FILTER_SANITIZE_NUMBER_INT);
     $novelty = filter_input(INPUT_POST,'novelty',FILTER_SANITIZE_NUMBER_INT);
     $comments = filter_input(INPUT_POST,'comments',FILTER_SANITIZE_SPECIAL_CHARS);
     $grade = $contribution + $presentation + $novelty;


     $sql = "UPDATE grades SET contribution='$contribution', presentation='$presentation', novelty ='$novelty', comments ='$comments',grade='$grade' WHERE id='$gradeId' ";

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
                    <?php   }
                    else if ($_GET['status'] = 'f'){ ?>
                        <div style="text-align:center;" class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            Error! Something went wrong
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

                <?php
                if (isset($_GET['edit']) && is_numeric($_GET['edit']) && strlen($_GET['edit'])>0 ){
                    $gradeId = filter_input(INPUT_GET,'edit',FILTER_SANITIZE_NUMBER_INT);


                    $sql = "SELECT * FROM grades JOIN student ON student.studentId = grades.studentId WHERE grades.id = $gradeId AND fypPart = 2 LIMIT 1";
                    $result = $link->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $name = $row['studentName'];
                            $Rid = $row['studentRid'];
                            $Contribution = $row['contribution'];
                            $presentation = $row['presentation'];
                            $novelty = $row['novelty'];
                            $grade = $row['grade'];
                            $comments = $row['comments'];
                            $groupId = $row['groupId'];
                        }
                    }
                    ?>
                    <div class="card card-primary card-outline no-border">
                        <div class="card-header with-border">
                            <h3 class="card-title">Edit Grade: <?php echo $name;?> </h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <form id="editgrade" name="editgrade" method="post" class="form-horizontal" data-toggle="validator">
                                <div class="form-group">
                                    <input type="hidden" name="gradeId" value="<?php echo $gradeId;?>"></div>
                                    <div class="form-group">
                                        <input type="hidden" name="groupId" value="<?php echo $groupId;?>"></div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="contribution" class="mr-3">Contribution: </label>
                                                <input type="number" name="contribution"  min="0" max="20" required value="<?php echo $Contribution;?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="presentation" class="mr-3">Presentation: </label>
                                                <input type="number" name="presentation"  min="0" max="20" required value="<?php echo $presentation;?>" >
                                            </div>
                                            <div class="form-group">
                                                <label for="novelty" class="mr-3">novelty: </label>
                                                <input type="number" name="novelty"  min="0" max="10" required value="<?php echo $novelty;?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="comments" class="mr-3">Comment/Review: </label>
                                                <input type="text" name="comments" value="<?php echo $comments;?>" >
                                            </div>
                                            <div class="form-group">
                                                <label for="grade" class="mr-3">Grade : </label>
                                                <input type="text" name="grade" value="<?php echo $grade;?>" readonly>
                                            </div>
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
                        }
                        ?>

                        <?php
                    /*****
                     * If coordinater allowed SPD-1 grading
                     */
                    if ($fyp2_grading == 1){ ?>
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
                                                $sql = "SELECT * FROM faculty_student_group JOIN student_group ON faculty_student_group.groupId = student_group.groupId WHERE NOT facultyId= '$facultyId' AND fypPart = 2";
                                                $result = $link->query($sql);

                                                if ($result->num_rows > 0) {
                                                    // output data of each row
                                                    while($row = $result->fetch_assoc()) { ?>
                                                        <div class="dropdown-divider"></div>
                                                        <li class="nav-item dropdown"><a href="<?php echo $_SERVER['PHP_SELF'].'?group='.$row['groupId'];?>" class="dropdown-item"><i class="fas fa-users mr-2"></i><?php 
                                                        echo $row['projectName']; ?></a></li>
                                                    <?php    }
                                                } else { ?>
                                                    <li><a href="<?php echo $_SERVER['PHP_SELF'];?>">No Groups Available</a></li>
                                                <?php   }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Show Group Members-->
                        <?php
                        if (isset($_GET['group']) AND is_numeric($_GET['group']) AND $grade_check == FALSE ){ ?>

                            <br/>
                            
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                  <h2 class="page-header">
                                     <i class="fas fa-project-diagram ml-3"></i> <?php echo $projName;?>
                                     <small class="float-right mr-3">Supervisor: <?php if (isset($supervisorName)){echo $supervisorName;}?></small>
                                 </h2>
                                 <p>Mark sheet of the Group members.</p>

                             </div>
                             <div class="card-body table-responsive">
                                
                                <table class="table table-condensed">
                                    <tr>
                                        <th style="width: 20px;">Rid</th>
                                        <th>Name</th>
                                        <th>Graded by</th>
                                        <th>Contribution (20)</th>
                                        <th>Presentation(20) </th>
                                        <th>novelty(10)</th>
                                        <th>Comments</th>
                                        <th sty="width: 10px;">Grade</th>
                                        

                                    </tr>
                                    <?php 
                                    $sql = "SELECT facultyName, studentRid , studentName ,  `contribution`,`presentation`,`novelty`,`comments`,`grade`  FROM `faculty` JOIN grades ON faculty.facultyId = grades.gradedBy JOIN student ON grades.studentId = student.studentId WHERE grades.groupId = '$groupId' AND fypPart = 2 order by studentName";
                                    $result = $link->query($sql);

                                    if ($result->num_rows > 0) {
                                                // output data of each row
                                        while($row = $result->fetch_assoc()) {

                                            ?>
                                            <tr>
                                                <td><?php echo $row['studentRid'];?></td>
                                                <td><?php echo $row['studentName'];?></td>
                                                <td><?php echo $row['facultyName'];?></td>
                                                <td><?php echo $row['contribution'];?></td>
                                                <td><?php echo $row['presentation'];?></td>
                                                <td><?php echo $row['novelty'];?></td>
                                                <td><?php echo $row['comments'];?></td>
                                                <td><?php echo $row['grade'];?></td>
                                            </tr>

                                            <?php
                                        }
                                    }else{?>
                                     
                                        <td> -- </td>
                                        <td> -- </td>
                                        <td> -- </td>
                                        <td> -- </td>
                                        <td> -- </td>
                                        <td> -- </td>
                                        <td> -- </td>
                                        <td> -- </td>
                                        
                                        
                                        
                                        <br>
                                        <div class="callout callout-info">
                                            <h4>NOT GRADED YET.</h4>
                                        </div>
                                    <?php } ?>

                                </table>

                            </div>
                        </div>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                               <h3 class="card-title font-weight-bold">Overall performance by Group Members</h3><br>
                               
                           </div>
                           <div class="card-body table-responsive">
                            
                            <table class="table table-condensed">
                                <tr>
                                    <th style="width: 20px;">Rid</th>
                                    <th>Name</th>
                                    <th>Contribution (20)</th>
                                    <th>Presentation(20) </th>
                                    <th>novelty(10)</th>
                                    <th sty="width: 10px;">Overall Grade</th>
                                    

                                </tr>
                                <?php
                                $sql = "SELECT `studentRid`, `studentName`, AVG(`contribution`) as contribution , AVG(`presentation`) as presentation , AVG(`novelty`) as novelty , AVG(`grade`) as grade  FROM grades JOIN student ON grades.studentId = student.studentId WHERE grades.`groupId`= '$groupId' AND fypPart = 2 GROUP BY grades.`studentId`";
                                $result = $link->query($sql);

                                if ($result->num_rows > 0) {

                                                // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                     
                                        ?>
                                        <tr>
                                            <td><?php echo $row['studentRid'];?></td>
                                            <td><?php echo $row['studentName'];?></td>
                                            <td><?php echo number_format($row['contribution'],1);?></td>
                                            <td><?php echo number_format($row['presentation'],1); ?></td>
                                            <td><?php echo number_format($row['novelty'],1);?></td>
                                            <td><?php echo number_format($row['grade'],1);?></td>
                                        </tr>

                                        <?php
                                    }
                                }else{?>
                                    <td> -- </td>
                                    <td> -- </td>
                                    <td> -- </td>
                                    <td> -- </td>
                                    <td> -- </td>
                                    <td> -- </td>
                                    
                                <?php } ?>
                            </table>

                        </div>

                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Grade Group : <?php echo $projName;?></h3><br>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Rid</th>
                                        <th>Name</th>
                                        <th>Contribution (20)</th>
                                        <th>Presentation(20) </th>
                                        <th>novelty(10)</th>
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
                                                <td><input type="number" name="contribution[]" min="0" max="20" required></td>
                                                <td><input type="number" name="presentation[]" min="0" max="20" required></td>
                                                <td><input type="number" name="novelty[]" min="0" max="10" required>
                                                </td>
                                                <td><input type="text" class="form-control" id="comments[]" name="comments[]" placeholder="Comments/Reviews if any"></td>
                                                <!--                                        <td><button type="submit" name="btnGradeStudents" form="gradeStudents" class="btn btn-default btn-sm ">Grade Student</button></div></td>-->
                                            <?php } } ?>
                                        </tr>

                                    </form>
                                </tbody>
                            </table>

                            <div class="card-footer">
                                <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default" >Cancel</a>
                                <button type="submit" name="btnGradeStudents" form="gradeStudents" class="btn btn-primary float-right">Grade Students</button>
                            </div>
                        </div>
                    </div>
                    <?php
                }else if (isset($grade_check)) {
                    if ($grade_check == TRUE){
                       ?>
                       <br/>
                       
                       <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h2 class="page-header">
                             <i class="fas fa-project-diagram"></i> <?php echo $projName;?>
                             <small class="float-right">Supervisor: <?php if (isset($supervisorName)){echo $supervisorName;}?></small>
                         </h2>
                         <p>Mark sheet of the Group members.</p>
                         
                     </div>
                     <div class="card-body table-responsive">
                        
                        <table class="table table-condensed">
                            <tr>
                                <th style="width: 20px;">Rid</th>
                                <th>Name</th>
                                <th>Graded By</th>
                                <th>Contribution (20)</th>
                                <th>Presentation(20) </th>
                                <th>novelty(10)</th>
                                <th>Comments</th>
                                <th sty="width: 10px;">Grade</th>
                                

                            </tr>
                            <?php 


                            $sql = "SELECT facultyName, studentRid , studentName ,  `contribution`,`presentation`,`novelty`,`comments`,`grade`  FROM `faculty` JOIN grades ON faculty.facultyId = grades.gradedBy JOIN student ON grades.studentId = student.studentId WHERE grades.groupId = '$groupId' AND fypPart = 2 order by studentName";
                            $result = $link->query($sql);

                            if ($result->num_rows > 0) {
                                                // output data of each row
                                while($row = $result->fetch_assoc()) {

                                    ?>
                                    <tr>
                                        <td><?php echo $row['studentRid'];?></td>
                                        <td><?php echo $row['studentName'];?></td>
                                        <td><?php echo $row['facultyName'];?></td>
                                        <td><?php echo $row['contribution'];?></td>
                                        <td><?php echo $row['presentation'];?></td>
                                        <td><?php echo $row['novelty'];?></td>
                                        <td><?php echo $row['comments'];?></td>
                                        <td><?php echo $row['grade'];?></td>
                                    </tr>

                                    <?php
                                }
                            }?>
                            

                        </table>

                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">Overall Performace By the Group Members.</h3><br>
                    </div>
                    <div class="card-body table-responsive">
                        
                        <table class="table table-condensed">
                            <tr>
                                <th style="width: 20px;">Rid</th>
                                <th>Name</th>
                                <th>Contribution (40)</th>
                                <th>Presentation(40) </th>
                                <th>novelty(20)</th>
                                <th sty="width: 10px;">Overall Grade(100)</th>
                                <th >Grade</th>
                                

                            </tr>
                            <?php
                            $sql="SELECT `contribution`, `presentation`, `novelty`, `grade`FROM `grades` WHERE grades.groupId = '$groupId' AND grades.iscord = 1 AND fypPart = 2 GROUP BY grades.studentId";
                            $contribution = array();
                            $novelty = array();
                            $presentation = array();
                            $grade = array();
                            $result = $link->query($sql);
                            if ($result->num_rows > 0) {
                             while($row = $result->fetch_assoc()) {
                                $contribution[] = $row['contribution'];
                                $novelty[] = $row['novelty'];
                                $presentation[] = $row['presentation'];
                                $grade[] = $row['grade'];
                            }
                        }

                        $sql = "SELECT `studentRid`, `studentName`, AVG(`contribution`) as contribution , AVG(`presentation`) as presentation , AVG(`novelty`) as novelty , AVG(`grade`) as grade  FROM grades JOIN student ON grades.studentId = student.studentId WHERE grades.groupId = '$groupId' AND grades.iscord = 0 AND fypPart = 2 GROUP BY grades.studentId";
                        $result = $link->query($sql);
                        
                        if ($result->num_rows > 0) {
                                                // output data of each row
                            $count = 0;
                            while($row = $result->fetch_assoc()) {
                             
                                ?>
                                <tr>
                                    <td><?php echo $row['studentRid'];?></td>
                                    <td><?php echo $row['studentName'];?></td>
                                    <td><?php echo $row['contribution']+ $contribution[$count];?></td>
                                    <td><?php echo $row['presentation'] + $presentation[$count];?></td>
                                    <td><?php echo $row['novelty']+ $novelty[$count];;?></td>
                                    <td><?php echo round($row['grade'] + $grade[$count]);?></td>
                                    <td><?php 
                                    if (round($row['grade'] + $grade[$count]) >= 60 && round($row['grade'] + $grade[$count]) <= 64) {
                                     echo "C";
                                 }elseif (round($row['grade'] + $grade[$count]) >= 65 && round($row['grade'] + $grade[$count]) <= 73) {
                                     echo "C+";
                                 }elseif (round($row['grade'] + $grade[$count]) >= 74 && round($row['grade'] + $grade[$count]) <= 81) {
                                     echo "B";
                                 }elseif (round($row['grade'] + $grade[$count]) >= 82 && round($row['grade'] + $grade[$count]) <= 87 ) {
                                     echo "B+";
                                 }elseif (round($row['grade'] + $grade[$count]) >= 88) {
                                     echo "A";
                                 }else{
                                     echo "F";
                                 }
                                 ?></td>
                             </tr>
                             
                             <?php
                             $count++;
                         }
                     }
                     ?>
                 </table>

             </div>
         </div>
         
         <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Edit Group</h3><br>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-condensed">
                    <tr>
                        <th style="width: 20px;">Rid</th>
                        <th>Name</th>
                        <th>Contribution (20)</th>
                        <th>Presentation(10) </th>
                        <th>novelty(20)</th>
                        <th>Comments/Review</th>
                        <th sty="width: 10px;">Total Grade</th>
                        <th sty="width: 10px;">Actions</th>

                    </tr>
                    <?php
                    $sql = "SELECT * FROM grades JOIN student ON student.studentId = grades.studentId WHERE grades.groupId = '$groupId' AND fypPart = 2 AND gradedBy = '$facultyId' ";
                    $result = $link->query($sql);

                    if ($result->num_rows > 0) {
                                                // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $gradedBy = $row['gradedBy'];
                            ?>
                            <tr>
                                <td><?php echo $row['studentRid'];?></td>
                                <td><?php echo $row['studentName'];?></td>
                                <td><?php echo $row['contribution'];?></td>
                                <td><?php echo $row['presentation'];?></td>
                                <td><?php echo $row['novelty'];?></td>
                                <td><?php echo $row['comments'];?></td>
                                <td><?php echo $row['grade'];?></td>
                                <td><a href="<?php echo $_SERVER['PHP_SELF']."?group=".$row['groupId']."&edit=".$row['id'];?>" class="btn btn-default btn-sm">Edit</a></td>
                            </tr>

                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
            <?php
        }   } 

        ?>



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
</html>