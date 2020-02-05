<?php 
$title = "ProSys";
$subtitle = "Meeting Logs";
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }
  else{

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
                <h3 class="card-title">Meeting Logs</h3>
              </div>

              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="quickForm">
                <div class="card-body">
                  <div class="form-group">
                    <div class="row">
          <div class="col-12">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <h4>Group Members</h4>
                <div class="dropdown-divider"></div>
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Meeting Title</th>
                      <th>
                        <i class="fa fa-clock"></i>
                      Meeting Time</th>
                      <th>Comments</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>
                        <div class="card-body no-padding">
                          <div>
                            <a href="" class="btn btn-primary btn-block btn-sm">
                          <i class="fa fa-edit" aria-hidden="true"></i>
                          Edit
                        </a>
                          </div>
                        <div>
                          <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');" data-toggle="Validator">
                          <input type="hidden" name="groupId" value="<?php echo('groupId'); ?>">
                          <button class="btn btn-danger btn-block btn-sm float-left" type="submit" name="btnDelete">
                          <i class="fa fa-trash" aria-hidden="true"></i>
                          Delete
                        </button>
                        </form>
                        <input type="hidden" name="groupId" value="<?php echo('groupId'); ?>">
                        </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="meetingLogbtn" class="btn btn-primary float-right">Add New Log</button>
                </div>
              </form>
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

          <!-- Edit Meeting Logs -->
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Meeting Log : 
                  <?php echo "MeetingTitle"; ?>
                </h3>
              </div>

              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="editLogs" name="editLogs" action="" method="post" data-toggle="Validator">
                <input type="hidden" name="groupId" value="<?php echo('groupId') ?>">
                <input type="hidden" name="editId" value="<?php echo('editId') ?>" id="editId">
                <div class="card-body">
                  <div class="form-group">
                    <label>
                      Meeting Title
                    </label>
                    <input type="text" name="MeetingTitle" id="MeetingTitle" class="form-control" value="<?php echo('MeetingTitile') ?>">
                    </div>

                    <!-- DropDown -->
                    <div class="form-group">
                    <label>
                      Change Status
                    </label>
                    <select class="form-control" id="Status" name="status" required>
                      <option value="" >Select Status</option>
                      <option value="Pending">Pending</option>
                      <option value="Postpond">Postpond</option>
                      <option value="Done">Done</option>
                      <option value="Cancelled">Cancelled</option>
                    </select>
                    </div>
                    <!-- .DropDown -->

                    <div class="form-group">
                      <label>Add Comments</label>
                      <div class="card-body">
                        <form data-toggle="Validator">
                          <textarea class="textarea" name="addComments" placeholder="AddComments...." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                          
                        </form>

                        <div class="card-footer">
                            <button type="submit" name="meetingLogbtn" class="btn btn-primary float-right">Submit</button>
                          </div>


                      </div>
                    </div>
              </div>
              
                  </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.Edit Meeting Logs -->

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