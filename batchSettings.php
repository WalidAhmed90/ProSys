<?php 
$title = "ProSys";
$subtitle = "Batch Settings";
session_start();
include('db/db_connect.php');
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
          <!-- Left Column -->
            <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header ">
                <h3 class="card-title">
                  <i class="fa fa-cog"></i>
                Setting : <?php echo "batch"; ?></h3>
                </div>
              <!-- /.card-header -->
              <!-- card-bode -->
              
                <div class="card-body">
                  <form action="" method="post" onsubmit="return confirm('Are you sure  ?');" data-toggle="validator">
                    <input type="hidden" name="batchId" value="">
                      <ul class="todo-list ui-sortable">
                          <li class="">
                          <span class="">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                          </span>
                          <span class="text">Add this batch to Project Repository</span>
                          <small class="label label-primary">
                          </small>
                            <button type="submit" name="btnAddtoProjectRep" class="btn btn-primary  btn-xs float-right">Submit</button>
                          </li>
                        </ul>
                  </form>
                  <form action="" method="post" onsubmit="return confirm('Are you sure  ?');" data-toggle="validator">
                    <input type="hidden" name="batchId" value="">
                    <ul class="todo-list ui-sortable">
                      <li class="">
                        <span class="">
                          <i class="fa fa-cog" aria-hidden="true"></i>
                        </span>
                        <span class="text">Upgrade Batch to SDP-2</span>
                        <small class="label label-primary"></small>
                        <button type="submit" name="" class="btn btn-primary  btn-xs float-right">Submit</button>
                      </li>
                    </ul>
                  </form>
                  <form action="" method="post" onsubmit="return confirm('This action will deactivate Batch and all the students in it.THIS ACTION IS IRREVERSIBLE. Are you sure you want to continue ?');" data-toggle="validator">
                    <input type="hidden" name="batchId" value="">
                    <ul class="todo-list ui-sortable">
                      <li class="">
                        <span class="">
                          <i class="fa fa-cog" aria-hidden="true"></i>
                        </span>
                        <span class="text">Deactivate this Batch</span>
                        <small class="label label-primary"></small>
                        <button type="submit" name="btnDeactivate" class="btn btn-primary  btn-xs float-right">Submit</button>
                      </li>
                    </ul>
                  </form>
                  <form action="" method="post" onsubmit="return confirm('Are you sure  ?');" data-toggle="validator">
                    <input type="hidden" name="batchId" value="">
                    <ul class="todo-list ui-sortable">
                      <li class="">
                        <span class="">
                          <i class="fa fa-cog" aria-hidden="true"></i>
                        </span>
                        <span class="text">Activate this batch</span>
                        <small class="label label-primary"></small>
                        <button type="submit" name="" class="btn btn-primary  btn-xs float-right">Submit</button>
                      </li>
                    </ul>
                  </form>

                <table class="table">
                    <tr>
                      <th>Configuration</th>
                      <th>Value</th>
                      <th>Action</th>
                    </tr>
                    <tr>
                      <form action="" method="post">
                        <input type="hidden" name="batchId" value="">
                        <td>FYP-1 Grading</td>
                        <td>
                          <select name="sdp1grading" id="sdp1grading">
                            <option value="0"  >Not Allowed</option>
                            <option value="1"  >Allowed</option>
                          </select>
                        </td>
                        <td>
                          <button type="submit" class="btn btn-default btn-sm" name="btnSdp1grading">Submit</button>
                        </td>
                        </form>
                      </tr>
                      <tr>
                        <form action="" method="post">
                          <input type="hidden" name="batchId" value="">
                          </input>
                          <td>FYP-2 Grading</td>
                          <td>
                            <select name="sdp2grading" id="sdp2grading">
                              <option value="0"  >Not Allowed
                              </option>
                              <option value="1"  >Allowed
                              </option>
                            </select>
                          </td>
                          <td>
                            <button type="submit" class="btn btn-default btn-sm" name="btnSdp2grading">Submit
                            </button>
                          </td>
                        </form>
                      </tr>
                </table>

            </div>
                 <!-- /.box-body -->
                 
                  <div class="card-footer">
                    <a href="" float-left class="btn btn-default">Back</a>
                  </div>
                

        </div>
                  <!-- /.box -->
      </div>
            <!-- /.box -->
    <!-- Left column -->

    <!-- general form elements -->
    <div class="col-md-12">
      <div class="card card-primary">
      <div class="card-header ">
          <h3 class="card-title">List of Batch</h3>
      </div>
      <!-- /.box-header -->

      <div class="card-body">
        <table class="table" >
          <tr>
            <th>Batch Name</th>
            <th>FYP Part</th>
            <th>Start Date</th>
            <th>Status</th>
            <th >Actions</th>
          </tr>
                                
        <tr>
              <td></td>
              <td></td>
              <td></td>
              <td><span class="label label-success">Active</span>
              <span class="label label-danger">Inactive</span>
              </td>
              <td>
                <a href="#" class="btn btn-primary btn-sm" ><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
              </td>
        </tr>

      </table>

      </div>
  <!-- /.box-body -->

      <div class="card-footer">
        
      </div>

    </div>
 <!-- /.box -->

  </div>
  <!-- close -->
          
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
