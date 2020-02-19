<?php
$title="ProSys";
$subtitle="Manage Student Groups";
include('include/header.php');
include('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id']))
{
    header("location: login.php");
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
                        }
                        else  if ($_GET['status'] == 'f'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation"></i>
                                Error! Something Went Wrong
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                        else if ($_GET['status'] == 'n'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation"></i>
                                Error! This faculty is supervising a group. Can not delete this
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                        else if ($_GET['status'] == 'e'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation"></i>
                                Error!
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                    }

                    ?>


                    <!-- general form elements -->
                    <div class="card card-primary no-border">
                        <div class="card-header with-border">
                            <h3 class="card-title">List of Groups</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">
                            <table id="manageGroups" class="table table-head-fixed text-nowrap">
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
                                                        <a href="<?php echo siteroot."studentProfile.php?id=".$member['studentId'] ;?>" target="_blank"><?php  echo $member['studentName']. " [" .$row['studentRid']. " ]"."<br/>"; ?></a>
                                                    <?php
                                                    }
                                                }

                                                ;?>
                                            </td>

                                            <td>
                                                <a href="<?php echo siteroot."groupReport.php?id=".$row['groupId'] ;?>" class="btn btn-default btn-flat btn-sm" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Show Report</a>
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

                        </div>

                    </div>
                    <!-- /.card -->

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
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#manageGroups').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
    });



</script>
</body>