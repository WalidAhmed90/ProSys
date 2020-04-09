<?php 
$title = "ProSys";
$subtitle = "Project Templates";
include('db/db_connect.php');
include('include/functions.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

$groupId = $_SESSION['groupId'];
$batchId = $_SESSION["batchId"];
if ($batchId){
    $batchName = $link->query("SELECT batchName FROM batch WHERE batchId = '$batchId' ")->fetch_object()->batchName;
}
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
                <div class="col-sm-1"></div>
                <div class="col-md-10">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header with-border">
                            <h3 class="card-title">Batch - <?php echo $batchName;?></h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table class="table table-head-fixed text-nowrap table-striped">
                            <?php
                            $sql = "SELECT * FROM batch_templates WHERE batch_templates.batchId = '$batchId' ";
                            $result = $link->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row

                                while($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <h4>
                                            <i class="<?php get_icon($row['templateLocation'])?>" ></i>
                                            <a href="<?php echo 'uploads/'.$batchName.'/templates/'.$row['templateLocation'];?>">
                                                <?php echo $row['templateName'];?>
                                            </a>

                                        </h4>
                                    </tr>
                                <?php
                                }
                            } else { ?>
                                <h5>No templates available.</h5>
                            <?php
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
                <div class="col-sm-1"></div>
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
</body>
</html>
