<?php 
session_start();
$title = "ProSys";
$subtitle = "Dashboard";
include('db/db_connect.php');

if(!isset($_SESSION['user_id'])){
  header("location: login.php");
}


?>
<head>
  <?php include('include/head.php'); ?>
  <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
  
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

      <!-- Main content -->
      <section class="content">
        <!-- row -->
        <div class="row">
          <?php
          //Coordinator
          if ($_SESSION['type'] == "Faculty" && $_SESSION["isCord"] == 1){
            $num_of_batch = $link->query("SELECT batchId FROM batch WHERE isActive = 1 ")->num_rows;
            $num_of_students = $link->query("SELECT studentId FROM student ")->num_rows;
            $num_of_groups = $link->query("SELECT groupId FROM student_group JOIN batch ON student_group.batchId = batch.batchId WHERE batch.isActive = 1 ")->num_rows;
            $num_of_supervisor = $link->query("SELECT * FROM faculty JOIN work_load ON faculty.facultyId = work_load.facultyId WHERE totalLoad > 0")->num_rows;
            ?>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-purple">
                <div class="inner">
                  <h3><?php echo $num_of_batch;?></h3>

                  <p>Batch Active</p>
                </div>
                <div class="icon">
                  <i class="ion ion-university"></i>
                </div>
                <a href="./manageBatch.php" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $num_of_students;?></h3>

                  <p>Students Registered</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="./manageStudents.php" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $num_of_groups;?></h3>

                  <p>Groups Created</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ios-people"></i>
                </div>
                <a href="./manageGroups.php" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $num_of_supervisor;?></h3>

                  <p>Supervisors</p>
                </div>
                <div class="icon">
                  <i class="ion-ios-personadd"></i>
                </div>
                <a href="./manageFaculty.php" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <?php
          }
          ?>
          <div class="col-md-12">



            <?php
            if ($_SESSION['type'] == "Student"){
             include ('studentTimeline.php');
           }
           if ($_SESSION['type'] == "Faculty"){
            include ('facultyTimeline.php');
          }

          ?>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

  </div>
  <!-- .Content Wrapper. Contains page content -->

  
  <?php include('include/footer.php'); ?>
</div>

<!-- jQuery -->
<?php include('include/jsFile.php'); ?>
<!-- .jQuery -->


</body>
</html>