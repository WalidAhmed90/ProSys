<?php 
$title = "ProSys";
$subtitle = "Weekly Report";
session_start();
include 'db/db_connect.php';
if($_SESSION['isCord'] == 1 OR $_SESSION['type'] == 'Student'){
  header("location: login.php");
}
$supervisorId = $_SESSION['usrId'];

//Check if supervisor has groups
$sql = "SELECT * FROM faculty_student_group WHERE facultyId = '$supervisorId' ";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    $groupCheck = true;
    $numOfGroups =$result->num_rows;

    while($row = $result->fetch_assoc()) {
        //echo $row['groupId'];echo '<br/>';
    }
}
else{
    //This faculty isnt supervising any group
    $groupCheck = false;
}



//Check if form is submitted by GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {


}

//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    /*
     * EDIT Weekly Report
     */

    if (isset($_POST['btnEditWeekly'])){
        //EDIT log
        $logId = filter_input(INPUT_POST,'editId',FILTER_SANITIZE_NUMBER_INT);
        $groupId = filter_input(INPUT_POST,'groupId',FILTER_SANITIZE_NUMBER_INT);
        //Validations
        if ($_POST['plannedWork'] != "" && $_POST['proposedWork'] != "" && $_POST['Achievements'] != ""){

            $groupId = filter_input(INPUT_POST,'groupId',FILTER_SANITIZE_NUMBER_INT);
            $plannedWork = $_POST['plannedWork'];
            $proposedWork = $_POST['proposedWork'];
            $Achievements = $_POST['Achievements'];
            $score = filter_input(INPUT_POST,'score',FILTER_SANITIZE_NUMBER_INT);
            $week = filter_input(INPUT_POST,'week',FILTER_SANITIZE_NUMBER_INT);
            $addComments = $_POST['addComments'];
            $Attendance = $_POST['Attendance'];
            $sql = "UPDATE weekly_report SET planned_work = '$plannedWork' , proposed_work='$proposedWork' , week_No = '$week' , achievements='$Achievements' ,score = '$score' , comments='$addComments' ,attendance='$Attendance' WHERE weekly_r_Id='$logId' ";

            if ($link->query($sql) === TRUE) {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t&id='.$groupId);
            } else {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f&id='.$groupId);
            }
        }
    }



    //ADD NEW LOG
    if (isset($_POST['addNewWeeklyBtn'])){
        //Validations
        if (isset($_POST['plannedWork']) && isset($_POST['proposedWork']) && isset($_POST['Achievements']) && isset($_POST['score']) && isset($_POST['week']) && isset($_POST['addComments']) && isset($_POST['groupId']) ){

            $plannedWork = $_POST['plannedWork'];
            $proposedWork = $_POST['proposedWork'];
            $Achievements = $_POST['Achievements'];
            $score = filter_input(INPUT_POST,'score',FILTER_SANITIZE_NUMBER_INT);
            $week = filter_input(INPUT_POST,'week',FILTER_SANITIZE_NUMBER_INT);
            $addComments = $_POST['addComments'];
            $Attendance = $_POST['Attendance'];

            $groupId = filter_input(INPUT_POST,'groupId',FILTER_SANITIZE_NUMBER_INT);

            $sql = "INSERT INTO weekly_report (supervisor_id, group_id, planned_work, proposed_work, week_No, achievements, score, comments , attendance)VALUES ('$supervisorId', '$groupId', ' $plannedWork ', '$proposedWork', '$week', ' $Achievements', '$score', '$addComments', '$Attendance')";

            if ($link->query($sql) === TRUE) {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t&id='.$groupId);
            } else {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f&id='.$groupId);
            }


        }

    }

    //DELETE Weekly Report
    if (isset($_POST['btnDelete'])){
        $groupId = filter_input(INPUT_POST,'groupId',FILTER_SANITIZE_NUMBER_INT);
        $logId = filter_input(INPUT_POST,'logId',FILTER_SANITIZE_NUMBER_INT);

        // sql to delete a record
        $sql = "DELETE FROM weekly_report WHERE weekly_r_Id = '$logId' LIMIT 1";

        if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t&id='.$groupId);
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f&id='.$groupId);
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
             
            </div>
        </div>

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
                    else if ($_GET['status'] == 's'){ ?>
                        <div style="text-align:center;" class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            Error!
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


                <?php if ($groupCheck == true){ ?>
                    <?php if (isset($_GET['add']) && is_numeric($_GET['add'])){
                    /*******************
                     * ADD Weekly ReportS
                     * ******************/
                    $groupId = filter_input(INPUT_GET,'add',FILTER_SANITIZE_NUMBER_INT);
                    

                    ?>
                    <div class="card no-border">
                        <div class="card-header">
                            <h3 class="card-title">Add New Weekly Report</h3>

                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="addNewWeekly" name="addNewWeekly" method="post" data-toggle="validator">
                            <div class="card-body">
                                <input type="hidden" name="groupId" value="<?php echo $groupId;?>">
                                <?php  $sql = "SELECT * FROM `weekly_report` WHERE `group_Id` = '$groupId' ORDER by `createdDtm` DESC LIMIT 1";
                                $result = $link->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $proposed_work = $row['proposed_work'];
                                    } ?>

                                    <div class="form-group">
                                        <label>Planned Work</label>
                                        <textarea class="form-control" name="plannedWork" placeholder="Enter Planned Work...." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required><?php echo $proposed_work; ?></textarea>
                                    </div>
                                <?php }else{ ?>
                                    <div class="form-group">
                                        <label>Planned Work</label>
                                        <textarea class="form-control" name="plannedWork" placeholder="Enter Planned Work...." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                                    </div>

                                <?php } ?>

                                <div class="form-group">
                                    <label>Proposed Work</label>
                                    <textarea class="form-control" name="proposedWork" placeholder="Enter Proposed Work...." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                    required></textarea>
                                </div>

                                

                                <div class="row">

                                    <div class="col-md-6">
                                        <label>
                                          Select Week
                                      </label>
                                      <select class="form-control" id="week" name="week" required>
                                          <option value="" >Select Week</option>
                                          <?php 
                                          for( $i=1 ; $i<=18 ; $i++){

                                              ?>
                                              <option value="<?php echo($i); ?>">Week <?php echo($i); ?></option>
                                          <?php } ?>
                                      </select>


                                  </div>


                                  <div class="col-md-6">
                                      <div class="form-group">
                                        <label>
                                          Select Remark
                                      </label>
                                      <select class="form-control" id="score" name="score" required>
                                          <option value="" >Select Remarks</option>
                                          <option value="1">Very Poor</option>
                                          <option value="2">Poor</option> 
                                          <option value="3">Average</option>
                                          <option value="4">Good</option> 
                                          <option value="5">Very Good</option>
                                          
                                      </select>
                                  </div>


                              </div>

                          </div>

                          <div class="form-group">
                            <label>Achievements</label>
                            <textarea class="form-control" name="Achievements" placeholder="Enter Achievements...." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                            required></textarea>
                            
                        </div>

                        <div class="form-group">
                            <label>Add Comments</label>
                            <textarea class="form-control" name="addComments"  placeholder="Add Comments..."  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                        <?php  $sql = "SELECT `studentName` from student WHERE student.groupId =  '$groupId' ";
                        $result = $link->query($sql);
                        if ($result->num_rows > 0) {
                           while($row = $result->fetch_array()) {
                               $studentName[] = $row['studentName'];
                           } }?>
                           <div class="form-group">
                            <label>Student Attendance</label>
                            <textarea class="form-control" name="Attendance"  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php foreach ($studentName as $key => $value) {
                               echo $value.", &#13;&#10;";
                           } ?></textarea>
                       </div>

                   </div>
                   <!-- /.card-body -->

                   <div class="card-footer">
                    <a href="<?php echo $_SERVER['PHP_SELF'].'?id='.$groupId ; ?>" class="btn  btn-default btn-sm  "> Back</a>
                    <button type="submit" name="addNewWeeklyBtn" class="btn btn-primary float-right" onclick="return confirm('Are you sure?')">Submit</button>
                </div>
            </form>

            <!-- /.card-body -->
        </div>
        <!-- /.card -->


        <?php
        
    }?>



    <?php if (isset($_GET['edit']) && is_numeric($_GET['edit']) && strlen($_GET['edit']) > 0 ){
                    /*******************
                     * EDIT Weekly ReportS
                     * ******************/

                    $id = filter_input(INPUT_GET,'edit',FILTER_SANITIZE_NUMBER_INT);

                    $sql = "SELECT * from weekly_report WHERE supervisor_id='$supervisorId' AND weekly_r_Id='$id' LIMIT 1";
                    $result = $link->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $planned_work = $row['planned_work'];
                            $proposed_work = $row['proposed_work'];
                            $week_No = $row['week_No'];
                            $achievements = $row['achievements'];
                            $score = $row['score'];
                            $comments = $row['comments'];
                            $attendance = $row['attendance'];
                            $groupId = $row['group_Id'];
                            

                        }
                        ?>
                        <div class="card no-border">
                            <div class="card-header">
                                <h3 class="card-title">Edit Weekly Report: Week <?php echo $week_No?></h3>
                            </div>

                            <div class="card-body">
                                <!-- form start -->
                                <form id="editWeekly" name="editWeekly" action="" method="post" data-toggle="validator">
                                    <input type="hidden" name="groupId" value="<?php echo $groupId;?>">
                                    <input type="hidden" name="editId" id="editId" value="<?php echo $id;?>">

                                    <div class="card-body">

                                     <div class="form-group">
                                        <label>Planned Work</label>
                                        <textarea class="form-control"  name="plannedWork" placeholder="Enter Planned Work...." 
                                        style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required><?php echo $planned_work; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Proposed Work</label>
                                        <textarea class="form-control" name="proposedWork" placeholder="Enter Proposed Work...."  
                                        style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                        required><?php echo $proposed_work; ?></textarea>
                                    </div>

                                    

                                    <div class="row">

                                        <div class="col-md-6">
                                            <label>
                                              Select Week
                                          </label>
                                          <select class="form-control" id="week" name="week" required>
                                              <option value="" >Select Week</option>
                                              <?php 
                                              for( $i=1 ; $i<=18 ; $i++){

                                                  ?>
                                                  <option value="<?php echo($i); ?>" <?php if($week_No== $i){echo "selected";}?> >Week <?php echo($i); ?></option>
                                              <?php } ?>
                                          </select>


                                      </div>


                                      <div class="col-md-6">
                                          <div class="form-group">
                                            <label>
                                              Select Remark
                                          </label>
                                          <select class="form-control" id="score" name="score" required>
                                              <option value="" <?php if($score==""){echo "selected";}?> >Select Remarks</option>
                                              <option value="1"  <?php if($score== 1){echo "selected";}?>>Very Poor</option>
                                              <option value="2" <?php if($score== 2){echo "selected";}?>>Poor</option> 
                                              <option value="3" <?php if($score== 3){echo "selected";}?>>Average</option>
                                              <option value="4" <?php if($score== 4){echo "selected";}?>>Good</option> 
                                              <option value="5" <?php if($score== 5){echo "selected";}?>>Very Good</option>
                                          </select>
                                      </div>


                                  </div>

                              </div>

                              <div class="form-group">
                                <label>Achievements</label>
                                <textarea class="form-control" name="Achievements" placeholder="Enter Achievements...." 
                                style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                required><?php echo $achievements; ?></textarea>
                                
                            </div>

                            <div class="form-group">
                                <label>Add Comments</label>
                                <textarea class="form-control" name="addComments"  placeholder="Add Comments..." 
                                style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $comments; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Student Attendance</label>
                                <textarea class="form-control" name="Attendance"  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $attendance; ?></textarea>
                            </div>

                        </div>
                        <!-- /.card-body -->

                    </form>
                    <div class="card-footer">
                        <button onclick="goBack()" class="btn btn-default">Back</button>
                        <!--                                    <a href="--><?php //echo $_SERVER['PHP_SELF'];?><!--" class="btn btn-default">Back</a>-->
                        <button type="submit" form="editWeekly" name="btnEditWeekly"  class="btn btn-primary float-right">Submit</button>
                    </div>

                </div>


            </div>



            <?php
        }


        ?>





        <?php
    }else{
                    /*******************
                     * SHOW Weekly ReportS
                     * ******************/
                    ?>
                    <div class="card no-border">
                        <div class="card-header">
                            <h3 class="card-title">Weekly Reports</h3>

                            <div class="card-tools">
                                <form id="selectGroup"  method="get" name="selectGroup" data-toggle="validator">
                                    <div class="input-group input-group-sm" style="width: 250px;">

                                        <select name="id" class="form-control" required>
                                            <?php
                                            $sql = "SELECT * FROM faculty_student_group JOIN student_group WHERE facultyId = '$supervisorId' AND student_group.groupId = faculty_student_group.groupId AND student_group.fypPart = 2";
                                            $result = $link->query($sql);
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) { ?>
                                                    <option value="<?php echo $row['groupId']; ?>"><?php if (isset($row['projectName'])){echo 'Group:'.$row['groupId']. '[ '.$row['projectName'].' ] ';}else{ echo '--';}?>
                                                </option>
                                                <?php
                                            }
                                        }else
                                        { ?>
                                            <option value="#">
                                                NO groups availables
                                            </option>

                                        <?php    }
                                        ?>
                                    </select>

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php
                    if (isset($_GET['id']) && is_numeric($_GET['id']) && strlen($_GET['id'])>0){ ?>
                        <!-- /.card-header -->
                        <div class="card-body  table-responsive no-padding">
                            <table id="weeklyReports" class="table table-head-fixed text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th>Group</th>
                                        <th>Planned Work</th>
                                        <th>Proposed Work</th>
                                        <th>Achievements</th>
                                        <th>Week</th>
                                        <th>Comments</th>
                                        <th>Score</th>
                                        <th>Attendance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <?php

                                $groupId = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
                                    //Check if this supervisor has this group
                                $sql = "SELECT weekly_r_Id from weekly_report WHERE supervisor_id='$supervisorId' AND group_id='$groupId' LIMIT 1";
                                $result = $link->query($sql);
                                if ($result->num_rows > 0) {
                                    $sql = "SELECT * from weekly_report WHERE supervisor_id = '$supervisorId' AND group_id = '$groupId' ORDER BY createdDtm DESC";
                                    $result = $link->query($sql);
                                    while($row = $result->fetch_assoc()) { ?>
                                        <tr>

                                         <td><?php echo $row['group_Id'] ;?></td>
                                         <td><?php echo $row['planned_work'];?></td>
                                         <td><?php echo $row['proposed_work'] ;?></td>
                                         <td><?php echo $row['achievements'] ;?></td>
                                         <td><?php echo $row['week_No'];?></td>
                                         <td><?php echo $row['comments'] ;?></td>
                                         <td><?php echo $row['score'];?></td>
                                         <td><?php echo $row['attendance'];?></td>
                                         
                                         <td>
                                            <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $row['weekly_r_Id']; ?>"   class="btn  btn-default btn-flat  btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                                            <form  action="" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');" data-toggle="validator">
                                                <input type="hidden" name="logId" value="<?php  echo $row['weekly_r_Id'];?>">
                                                <input type="hidden" name="groupId" value="<?php echo $row['group_id'];?>">
                                                <button type="submit" name="btnDelete" class="btn  btn-danger btn-flat  btn-xs"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                            <input type="hidden" name="logId" value="<?php echo $row['weekly_r_Id'];?>">
                                        </td>
                                    </tr>
                                <?php }
                            }

                            ?>
                        </table>
                        
                    </div>

                <?php }
                ?>
                <div class="card-footer ">
                    <a href="<?php echo $_SERVER['PHP_SELF'] . '?add='. $groupId; ?>" class="btn  btn-primary  float-right"><i class="fa fa-plus"></i> Weekly Report</a>
                </div>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <?php
        }?>

        <?php
    }else if ($_GET == false){ ?>
        <div class="card no-border">
            <div class="card-header">
                <h3 class="card-title">Add New Weekly Report</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <p>You are not supervising any group</p>
            </div>
            <!-- /.card-body -->
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <?php
    } ?>
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

<script>
    function goBack() {
        window.history.back();
    }

    $(document).ready(function() {

        $('.textarea').wysihtml5();

        $('#weeklyReports').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false
        });
    } );
</script>

</body>
</html>