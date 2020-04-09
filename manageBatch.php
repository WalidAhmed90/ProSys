<?php
$title="ProSys";
$subtitle="Manage Batch";
include('include/head.php');
include('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header('location: login.php');
  }


?>
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

</head>

<body>
<div class="wrapper">

    <?php include('include/navbar.php'); ?>
    <?php include('include/sidebar.php'); ?>
    <div class="content-wrapper" >
        <?php include("include/contentheader.php"); ?>

        <section class="content">
            <div class="container-fluid">
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
                                Error!
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
                    <div class="card card-primary">
                        <div class="card-header with-border">
                            <h3 class="card-title">List of Batch</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive">
                            <table id="manageBatch" class="table  table-striped">
                                <tr>
                                    <th>Batch Name</th>
                                    <th>FYP Part</th>
                                    <th>Registered Students</th>
                                    <th>Start Date</th>
                                    <th>Status</th>
                                    <th >Actions</th>
                                </tr>
                                <?php
                                $sql = "SELECT * FROM batch";
                                $result = mysqli_query($link,$sql);

                                if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    while($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $row['batchName']; ?></td>
                                            <td><?php if($row['fypPart']== 1){
                                            	echo "Project Proposal";
                                            }else {
                                            	echo "Project Defence";
                                            } ?></td>
                                            <td><?php
                                                $batchId = $row['batchId'];
                                                $sql="SELECT studentRid FROM student WHERE batchId ='$batchId' ";
                                                $result1=mysqli_query($link,$sql);
                                                echo mysqli_num_rows($result1);  ?>
                                            </td>
                                            <td><?php echo $row['startingDate']; ?></td>
                                            <td><?php if ($row['isActive'] == 1){
                                                    echo "<span class=\"badge bg-success\">Active</span>";
                                                }else if ($row['isActive'] == 0){
                                                    echo "<span class=\"badge bg-danger\">Inactive</span>";
                                                }  ?>
                                            </td>
                                            <td>
                                              <a href="<?php echo "batchReport.php?id=".$row['batchId'] ;?>" class="btn btn-default btn-flat btn-sm" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Show Report</a>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                } ?>
                            </table>

                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->







                </div>

            </div>
            </div>
            <!-- container-fluid -->
        </section>
    </div>
    <?php
    include("include/footer.php");
    ?>
</div>

<?php
include("include/jsFile.php");
?>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
     $(document).ready(function() {
        $('#manageBatch').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
    });


    } );


</script>

</body>