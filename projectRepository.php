<?php 
$title = "ProSys";
$subtitle = "Project Repository";
include('db/db_connect.php');
session_start();
if($_SESSION['isCord'] != 1){
  header("location: login.php");
}

//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnDownload'])){
        $downloadID = filter_input(INPUT_POST,'downloadId',FILTER_SANITIZE_NUMBER_INT);
        //uploads/batch Name/group id/deliverable naem
        $sql = "SELECT * FROM group_uploads WHERE id = '$downloadID' LIMIT 1";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $deliverableName = $row['uploadFile'];
                $groupId = $row['groupId'];
            }
        }
        //Getting batchId,batch Name from groupId
        $batchId = $link->query("SELECT batchId FROM student_group WHERE groupId = '$groupId' ")->fetch_object()->batchId;
        $batchName = $link->query("SELECT batchName FROM batch WHERE batchId = '$batchId' ")->fetch_object()->batchName;
        $group = 'Group '.$groupId;
        $location = siteroot."uploads/".$batchName."/".$group."/".$deliverableName;
        //Download file
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false); // required for certain browsers
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'. basename($location) . '";');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($location));
        readfile($location);
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
                <?php if (isset($_GET['details']) && is_numeric($_GET['details']) && strlen($_GET['details'])>0){
                    $groupId = filter_input(INPUT_GET,'details',FILTER_SANITIZE_NUMBER_INT);
                    if (isset($groupId) && is_numeric($groupId) && strlen($groupId)>0){
                        $projectName = $link->query("SELECT projectName FROM student_group WHERE groupId = '$groupId' LIMIT 1")->fetch_object()->projectName;
                    }else{
                        $projectName="--";
                    }
                    ?>
                    <!--DETAILS-->
                    <div class="card card-primary card-outline no-border">
                        <div class="card-header">
                            <h3><?php echo $projectName;?></h3>
                            <h3 class="card-title">Members</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Rid</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $groupId = filter_input(INPUT_GET,'details',FILTER_SANITIZE_NUMBER_INT);
                                    $sql = "SELECT * FROM student WHERE groupId = '$groupId'";
                                    $result = $link->query($sql);
                                    if ($result->num_rows > 0) {
                                    // output data of each row
                                        while($row = $result->fetch_assoc()) { ?>
                                            <form name="detailForm" id="detailForm" method="post" data-toggle="validator">
                                                <input type="hidden" name="downloadId" value="<?php echo $row['id'];?>" >
                                                <tr>
                                                    <td><?php echo $row['studentRid']; ?></td>
                                                    <td><?php echo $row['studentName'];?></td>
                                                    <td><?php echo $row['studentEmail'];?></td>
                                                    <td><?php echo $row['studentPhoneNo'];?></td>
                                                </tr>
                                            </form>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card card-primary card-outline no-border">
                        <div class="card-header">
                            <h3 class="card-title">Group Uploads</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Deliverable</th>
                                        <th>Uploaded by</th>
                                        <th>Uploaded <i class="fa fa-clock-o"></i></th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $groupId = filter_input(INPUT_GET,'details',FILTER_SANITIZE_NUMBER_INT);
                                    $sql = "SELECT * FROM group_uploads  JOIN student ON student.studentId = group_uploads.uploadedBy WHERE group_uploads.groupId = '$groupId' LIMIT 1 ";
                                    $result = $link->query($sql);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) { ?>
                                            <form name="detailForm" id="detailForm" method="post">
                                                <input type="hidden" name="downloadId" value="<?php echo $row['id'];?>" >
                                                <tr>
                                                    <td><?php $taskId = $row['taskId'];
                                                    echo $link->query("SELECT taskName FROM batch_tasks WHERE taskId = '$taskId' ")->fetch_object()->taskName;?>
                                                </td>
                                                <td><a href="<?php echo "studentProfile.php?id=".$row['studentId']; ?>" target="_blank"><?php echo $row['studentName'];?></a></td>
                                                <td><?php echo $row['uploadedDtm'];?></td>
                                                <td>
                                                    <button type="submit" name="btnDownload"  class="btn btn-default btn-sm"><i class="fa fa-download"></i> Download</button>
                                                </td>
                                            </tr>
                                        </form>
                                        <?php
                                    }
                                }
                               ?>
                            </tbody>

                        </table>

                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">Project Proposal Grading.</h3><br>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-condensed">
                            <tr>
                                <th style="width: 20px;">Rid</th>
                                <th>Name</th>
                                <th>Contribution (40)</th>
                                <th>Answer to Question(20) </th>
                                <th>Completion(40)</th>
                                <th sty="width: 10px;">Overall Grade(100)</th>
                                <th >Grade</th>
                           </tr>
                            <?php
                            $sql="SELECT `contribution`, `anstoques`, `completion`, `grade`FROM `grades` WHERE grades.groupId = '$groupId' AND grades.iscord = 1 AND fypPart = 1 GROUP BY grades.studentId";
                            $contribution = array();
                            $completion = array();
                            $anstoques = array();
                            $grade = array();
                            $result = $link->query($sql);
                            if ($result->num_rows > 0) {
                             while($row = $result->fetch_assoc()) {
                                $contribution[] = $row['contribution'];
                                $completion[] = $row['completion'];
                                $anstoques[] = $row['anstoques'];
                                $grade[] = $row['grade'];
                            }
                        }
                        $sql = "SELECT `studentRid`, `studentName`, AVG(`contribution`) as contribution , AVG(`anstoques`) as AnswerToQuestion , AVG(`completion`) as Completion , AVG(`grade`) as grade  FROM grades JOIN student ON grades.studentId = student.studentId WHERE grades.groupId = '$groupId' AND grades.iscord = 0 AND fypPart = 1 GROUP BY grades.studentId";
                        $result = $link->query($sql);
                        if ($result->num_rows > 0) {
                                                // output data of each row
                            $count = 0;
                            while($row = $result->fetch_assoc()) {  ?>
                                <tr>
                                    <td><?php echo $row['studentRid'];?></td>
                                    <td><?php echo $row['studentName'];?></td>
                                    <td><?php echo $row['contribution']+ $contribution[$count];?></td>
                                    <td><?php echo $row['AnswerToQuestion'] + $anstoques[$count];?></td>
                                    <td><?php echo $row['Completion']+ $completion[$count];;?></td>
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
                <h3 class="card-title font-weight-bold">Project Defense Grading.</h3><br>
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
                    while($row = $result->fetch_assoc()) { ?>
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
 <div class="card card-primary card-outline no-border">
    <div class="card-header">
        <h3 class="card-title">Meeting Requests</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="" class="table table-striped">
            <thead>
                <tr>
                    <th>Meeting Title</th>
                    <th><i class="fa fa-clock-o"></i> Date Time</th>
                    <th>Comments</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $groupId = filter_input(INPUT_GET,'details',FILTER_SANITIZE_NUMBER_INT);
                $sql = "SELECT * FROM meeting_requests WHERE group_id = '$groupId' ";
                $result = $link->query($sql);
                if ($result->num_rows > 0) {
                                            // output data of each row
                    while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['meeting_title'];?></td>
                            <td><?php echo $row['meeting_dtm'];?></td>
                            <td><?php echo $row['comments'];?></td>
                            <td><?php echo $row['meeting_status'];?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
       </table>
   </div>
</div>
<!-- /.card -->

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Weekly Report</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
        <table class="table table-head-fixed text-nowrap table-striped">
            <tr>
               <th>Planned Work</th>
               <th>Proposed Work</th>
               <th>Achievements</th>
               <th>Week</th>
               <th>Comments</th>
               <th>Score</th>
           </tr>
           <?php
           $sql = "SELECT * FROM weekly_report WHERE group_Id ='$groupId' ";
           $result = $link->query($sql);
           if ($result->num_rows > 0) {
                                    // output data of each row
            while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['planned_work'];?></td>
                    <td><?php echo $row['proposed_work'] ;?></td>
                    <td><?php echo $row['achievements'] ;?></td>
                    <td><?php echo $row['week_No'];?></td>
                    <td><?php echo $row['comments'] ;?></td>
                    <td><?php if($row['score']== 1){echo "Very Poor";}
                    elseif($row['score']== 2){echo "Poor";}
                    elseif($row['score']== 3){echo "Average";}
                    elseif($row['score']== 4){echo "Good";}
                    elseif($row['score']== 5){echo "Very Good";}?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>
<!-- /.card-body -->
<div class="card-footer">
    <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default">Back</a>
</div>
<!-- /.card-footer -->
</div>
<!-- /.card -->
<?php
}else{ ?>
    <div class="card card-primary card-outline no-border ">
        <div class="card-header">
            <h3 class="card-title">List of Batch</h3>
            <div class="card-tools">
                <form name="selectBatch"  id="selectBatch" method="get"  data-toggle="validator">
                    <div class="form-group input-group input-group-sm" style="width: 250px;">
                        <select name="batchId"  id="batchId" class="form-control" required>
                            <?php
                            $sql = "SELECT * FROM batch JOIN project_repository ON batch.batchId = project_repository.batchId";
                            $result = mysqli_query($link,$sql);
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?php echo $row['batchId']; ?>" >
                                        <?php echo $row['batchName'];?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if (isset($_GET['batchId']) && is_numeric($_GET['batchId']) && strlen($_GET['batchId'])){
        $batchId = filter_input(INPUT_GET,'batchId',FILTER_SANITIZE_NUMBER_INT);
        ?>
        <div class="card card-primary  no-border">
            <div class="card-header">
                <h3 class="card-title">List of Projects</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="projectRepository" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Batch</th>
                            <th>Group</th>
                            <th>Project Name</th>
                            <th>Supervisor</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM project_repository JOIN batch ON batch.batchId = project_repository.batchId JOIN student_group ON student_group.batchId = project_repository.batchId JOIN faculty_student_group ON faculty_student_group.groupId = student_group.groupId JOIN faculty ON faculty.facultyId = faculty_student_group.facultyId WHERE batch.batchId = '$batchId'";
                        $result = $link->query($sql);
                        if ($result->num_rows > 0) {
                                    // output data of each row
                            while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['batchName'];?></td>
                                    <td><?php echo "Group # ".$row['groupId'];?></td>
                                    <td><?php echo $row['projectName'];?></td>
                                    <td><?php echo $row['facultyName'];?></td>
                                    <td>
                                        <a href="<?php echo $_SERVER['PHP_SELF'] . "?details=".$row['groupId']?>" class="btn btn-default btn-sm">Details</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
               </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <?php
    }
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
    $(function () {
        $('#projectRepository').DataTable({
            "columnDefs": [
            { "orderable": false, "targets": -1 }
            ],
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false

        });

        $('#projectDetials').DataTable({
            "columnDefs": [
            { "orderable": false, "targets": -1 }
            ],
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,            
            "autoWidth": false
        });
    });
</script>

</body>
</html>