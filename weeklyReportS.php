<?php 
$title = "ProSys";
$subtitle = "Weekly Report";
include('db/db_connect.php');
session_start();

//check if supervisor logged in
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }
 $studentId = $_SESSION['usrId'];
//Getting groupId
$groupId = $link->query("SELECT groupId FROM student WHERE studentId = '$studentId' LIMIT 1" )->fetch_object()->groupId;



//Check if form is submitted by GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {


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

                    <div class="card card-primary">
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
                    </div>
                    <!-- /.card -->



                </div>

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

<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    function goBack() {
        window.history.back();
    }

    $(document).ready(function() {

        $('.textarea').wysihtml5();

        $('#meetingLogs').DataTable({
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