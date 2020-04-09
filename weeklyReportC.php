<?php 
$title = "ProSys";
$subtitle = "weekly Report";
session_start();
include ("db/db_connect.php");

if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

  
 ?>
<head>
  <?php include('include/head.php'); ?>
</head>
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
                        else if ($_GET['status'] == 'n'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! This student is in a group.Can not delete this student
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
                    <?php if (isset($_GET['report']) && is_numeric($_GET['report']) && strlen($_GET['report'])){
                            $groupId = filter_input(INPUT_GET,'report',FILTER_SANITIZE_NUMBER_INT);
                            ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Report Details</h3>
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
                                        <th>Attendance</th>
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
                                                <td><?php echo $row['attendance'] ;?></td>
                                            
                                        </tr>
                                    <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                        <!-- /.card-body -->

                            <div class="card-footer">
                                 <button onclick="goBack()" class="btn btn-default">Back</button>
                            </div>
                    </div>

                       <?php }elseif (isset($_GET['batchId']) && is_numeric($_GET['batchId']) && strlen($_GET['batchId'])){
                            $batchId = filter_input(INPUT_GET,'batchId',FILTER_SANITIZE_NUMBER_INT);
                            ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Group Details</h3>
                        </div>
                        <!-- /.card-header -->
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                            <table id="manageGroups" class="table table-head-fixed text-nowrap table-striped">
                                <thead>
                                <tr>
                                    <th>Batch</th>
                                    <th>Project Name</th>
                                    <th>Group Members</th>
                                    <th>Actions</th>

                                </tr>
                                </thead>
                                <?php
                                $sql = "SELECT * FROM student JOIN student_group ON student.studentId = student_group.leaderId JOIN batch ON batch.batchId = student_group.batchId WHERE isLeader = 1 AND batch.batchId = '$batchId'";
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

                                                ;?>
                                            </td>

                                            <td>
                                                <a href="<?php echo $_SERVER['PHP_SELF'] . '?report=' . $row['groupId']; ?>"  class="btn  btn-primary btn-xs" class="btn btn-default btn-flat btn-sm"><i class="fa fa-external-link" aria-hidden="true"></i> Show Report</a>
                                            </td>
                                        </tr>

                                    <?php
                                    }
                                }
                                ?>



                            </table>

                        </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                 <button onclick="goBack()" class="btn btn-default">Back</button>
                            </div>
                        </div>

                            <?php
                        }else{ ?>

                            <div class="card card-primary card-outline no-border ">
                        <div class="card-header">
                            <h3 class="card-title">List of students</h3>

                            <div class="card-tools">
                                <form name="selectBatch"  id="selectBatch" method="get"  data-toggle="validator">

                                    <div class="form-group input-group input-group-sm" style="width: 250px;">

                                        <select name="batchId"  id="batchId" class="form-control" required>
                                            <?php
                                            $sql = "SELECT * FROM batch WHERE  batch.isActive = 1";
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
                            <h5 class="text-muted">  Select Batch from the list fist</h5>
                            <?php
                        } ?>

                    </div>
                    <!-- /.card -->




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
    $(document).ready(function() {
        $('#manageStudents').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
    });

        function show() {
            var p = document.getElementById('password');
            p.setAttribute('type', 'text');
        }

        function hide() {
            var p = document.getElementById('password');
            p.setAttribute('type', 'password');
        }

        var pwShown = 0;

        document.getElementById("eye").addEventListener("click", function () {
            if (pwShown == 0) {
                pwShown = 1;
                show();
            } else {
                pwShown = 0;
                hide();
            }
        }, false);
    } );


</script>
<script type="text/javascript">
   jQuery(document).ready(function() {
     $("time.timeago").timeago();
   });
</script>
<script>
    function goBack() {
        window.history.back();
    }

    $(document).ready(function() {

        $('.textarea').wysihtml5();

        $('#manageGroups').DataTable({
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