<?php 
$title = "ProSys";
$subtitle = "Meeting Requests";
include('db/db_connect.php');
session_start();

//check if supervisor Requestged in
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
                            } else  if ($_GET['status'] == 'f'){ ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Error! Something Went Wrong
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else if ($_GET['status'] == 's'){ ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Error!
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else if ($_GET['status'] == 'e'){ ?>
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
                                <h3 class="card-title">Requests</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table class="table table-head-fixed text-nowrap table-striped">
                                    <tr>
                                        <th>Meeting Title</th>
                                        <th>Meeting Time <i class="fa fa-clock" aria-hidden="true"></i></th>
                                        <th>Comments <i class="fa fa-comment" aria-hidden="true"></i></th>
                                        <th style="width: 40px">Status </th>
                                    </tr>
                                    <?php
                                    $sql = "SELECT * FROM meeting_Requests WHERE group_id ='$groupId' ";
                                    $result = $link->query($sql);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['meeting_title']; ?></td>
                                                <td><?php echo $row['meeting_dtm']; ?></td>
                                                <td><?php echo $row['comments']; ?></span></td>
                                                <th><?php
                                                $status =$row['meeting_status'];
                                                if ($status == 'Pending'){ ?>
                                                    <span class="badge bg-warning"><?php echo $status?></span>
                                                    <?php
                                                } else if ($status == 'Done'){ ?>
                                                    <span class="badge bg-success"><?php echo $status?></span>
                                                    <?php
                                                } else if ($status == 'Cancelled'){ ?>
                                                    <span class="badge bg-danger"><?php echo $status?></span>
                                                    <?php
                                                } else if ($status == 'Postponed'){ ?>
                                                    <span class="badge bg-primary"><?php echo $status?></span>
                                                    <?php
                                                } else{ ?>
                                                    <span class="badge bg-default"><?php echo $status?></span>
                                                    <?php
                                                }
                                                ?></th>
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
            $('#meetingRequests').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false
            });
        });
    </script>
</body>