<?php 
$title = "ProSys";
$subtitle = "Group Settings";
session_start();
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
                <h3 class="card-title">
                  <i class="fa fa-cogs" aria-hidden="true"></i>
                Group Settings</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="null" onsubmit="return confirm('Are you sure you want to delete your own group?');" data-toggle="Validator">
                <div class="card-body">
                  <ul class="todo-list ui-sortable">
                    <li>
                      <span class="handle ui-sortable-handle">
                        <i class="fa fa-cog" aria-hidden="true">
                        </i>
                      </span>
                      <span class="text">
                        Delete my group
                      </span>
                      <small class="badge badge-danger">
                        ProjectName
                      </small>
                      <button type="submit" name="btnDeleteMyGroup" class="btn btn-success btn-xs float-right" >
                        Submit
                      </button>
                    </li>
                  </ul>
                  <div>
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
</body>
</html>
