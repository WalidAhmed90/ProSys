<?php 
$title = "ProSys";
$subtitle = "Batch Task";
session_start();
include ('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

  if($_SERVER['REQUEST_METHOD']== 'GET')
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
                <h3 class="card-title">Batch Task</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form role="form" id="quickForm">
                <div class="card-body">
                  <div class="form-group">
                    <div class="row">              
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                <div class="card-tools">
                  <div class="input-group">
                    <form id="selectBatch" method="get" name="selectGroup" data-toggle = 'Validator'>
                      <div class="input-group input-group-sm" style="width: 250px">
                        <select name="batchId" id="batchId" class="form-control"
                        required="">
                          <option><?php echo 'options'; ?></option>
                        </select>
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Week</th>
                      <th>Task Name</th>
                      <th>Task Details</th>
                      <th>Deadline</th>
                      <th>Template</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><form name="deleteTask" method="post" action="null" onsubmit="return confirm('Are you sure you want to delete this task?');" data-toggle="Validator">
                        <input type="hidden" name="facultyId" value="">
                        <button type="submit" name="btnDeleteTask" class="btn btn-danger btn-block btn-sm" >
                          <i class="fa fa-trash" aria-hidden="true">
                        </i>
                          Delete
                        </button>
                      </form></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- /.card-body -->
                      <div class="card-footer">
                        <button type="submit" name="addNewTask" class="btn btn-primary float-right">
                          <i class="fa fa-plus"></i>
                        Add New Task</button>
                      </div>
            </div>
            <!-- /.card -->

            <!-- Add New Task -->
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Add New Task : Batch <?php echo "BatchID"; ?>
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
                      Select Week
                    </label>
                    <select class="form-control" id="week" name="week" required>
                      <option value="" >Select Week</option>
                      <?php 
                      for( $i=1 ; $i<=18 ; $i++){

                      ?>
                      <option value="<?php echo($i); ?>">Week<?php echo($i); ?></option>
                    <?php } ?>
                    </select>
                    </div>

                  <div class="form-group">
                    <label>
                      Select P1/P2
                    </label>
                    <select class="form-control" id="week" name="week" required>
                      <option value="" >Select P1/P2</option>
                      <option value="1">P1</option>
                      <option value="2">P2</option> 
                    </select>
                    </div>

                  <div class="form-group">
                    <label class="control-label">
                      Task Name
                    </label>
                    <div class="">
                      <input class="form-control" type="text" name="taskName" id="taskName" placeholder="Enter task name." required>
                    </div>
                    </div>

                    <div class="form-group">
                      <label>Task Details</label>
                      <div class="card-body">
                        <form data-toggle="Validator">
                          <textarea class="textarea" name="addComments" placeholder="AddComments...." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                          <div class="form-group">
                            <label class="control-label" >Set Deadline</label>
                            <div class="">
                              <input class="form-control" type="date"  id="deadlineDate" data-provide="datepicker">
                              <input class="form-control" type="time" name="deadlineTime" id="deadlineTime">
                            </div>
                          </div>

                      <div class="form-group">
                    <label>
                      Select Template
                    </label>
                    <select class="form-control" id="week" name="week" required>
                      <option value="" >Select Template</option>
                      <option value="1"><?php echo "templates"; ?></option>
                    </select>
                    </div>


                          
                        </form>

                        <div class="card-footer">
                          <a class="btn btn-default btn-sm" href="batchTask.php">Back</a>
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
          <!--.Add New Task -->

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



</body>
</html>