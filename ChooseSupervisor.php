<?php 
$title = "ProSys";
$subtitle = "Choose Supervisor";
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
                <h3 class="card-title">Choose Supervisor</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="quickForm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="SetGroupName">List of supervisors
                       <p class="text-muted">Click on send request.</p>   
                    </label>
                    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Designation</th>
                      <th>Supervising Limit</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>
                        <span class="badge bg-success">
                          <?php echo 'current : 0'.' Total : 0'; ?>
                        </span>
                      </td>
                      <td><form name="chooseSupervisor" method="post" action="null" onsubmit="return confirm('Are you sure you want to send request to this supervisor?');" data-toggle="Validator">
                        <input type="hidden" name="facultyId" value="">
                        <button type="submit" name="btnChooseSupervisor" class="btn btn-primary btn-block btn-sm" >
                          <i class="fa fa-user-plus" aria-hidden="true">
                        </i>
                          Send Request
                        </button>
                      </form></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
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
      </div>
      <!-- /.container-fluid -->
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
<!-- .jQuery -->

</body>
</html>