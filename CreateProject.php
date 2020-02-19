<?php 
$title = "ProSys";
$subtitle = "Create Project";
include('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
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
    <section class="content">
    <div class="container-fluid">
      <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Project</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="CreateProject">
                <div class="card-body">
                  <div class="form-group">
                    <label for="SetGroupName">Set Group Name</label>
                    <input type="text" name="SetProjectName" class="form-control" id="setprojectname" placeholder="Set Project Name" required>
                    <p class="text-muted">you can change project name later.</p>
                  </div>

                  <!-- Project categories -->
                     <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Please select from the following technology in which your project belongs.</label>
                  <select class="form-control select2bs4" style="width: 100%;">
                    <option selected="selected">3D/4D Printing</option>
                    <option>3D/4D Printing</option>
                    <option>Big Data</option>
                    <option>Artificial Intelligence</option>
                    <option>Cloud</option>
                    <option>Robotics</option>
                    <option>The Internet Of Things</option>
                    <option>Augmented Reality/Virtual Reality</option>
                    <option>Block Chain</option>
                    <option>Neurotech</option>
                    <option>Shared Economy</option>
                    <option>Wearables</option>
                    <option>Implantable</option>
                    <option>Other</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Other Option -->
            <div class="form-group">
                        <label>Other Categories.</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                      </div>


                <!-- .Project categories -->

                <!-- Project Description -->
                      <div class="form-group">
                        <label>Project Description.</label>
                        <textarea class="form-control" rows="6" placeholder="Enter Project description here..."></textarea>
                      </div>


                <!-- ./Project Description -->

                <!-- /.card-body -->
                      <div class="card-footer">
                        <button type="submit" name="initiateGroupbtn" class="btn btn-primary float-right">Create Project</button>
                      </div>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
        <div class="col-md-6">

        </div>
          <!--/.col (right) -->
      </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
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
<script>
   $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    })
</script>
</body>
</html>