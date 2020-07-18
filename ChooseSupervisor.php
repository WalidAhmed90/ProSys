  <?php 
  $title = "ProSys";
  $subtitle = "Choose Supervisor";
  session_start();
  include 'db/db_connect.php';
  if($_SESSION['type'] != 'Student'){
    header("location: login.php");
  }
  //Check if request is sent to a supervisor already
  $studentId = $_SESSION["usrId"];

  $sql = "SELECT * FROM student WHERE studentId = '$studentId' LIMIT 1 ";
  $result = $link->query($sql);
  if ($result->num_rows > 0) {
      // output data of each row
    while($row = $result->fetch_assoc()) {
      $batchId = $row['batchId'];
      $groupId = $row['groupId'];
      $isLeader = $row['isLeader'];
    }
  }
  //If leader
  if ($isLeader != 1 OR is_null($groupId)){
    header('Location: '.'index.php');
  }
  $sql_check = "SELECT requestId FROM faculty_student_request WHERE groupId = '$groupId ' LIMIT 1";
  $result = $link->query($sql_check);
  if ($result->num_rows > 0) {
    $request_sent = true; //User has already sent request to a supervisor
    while($row = $result->fetch_assoc()) {
      $requestId = $row['requestId'];
    }
  }
  else{
    //Check if group has a supervisor already
    $sql_check = "SELECT facultyStudentId FROM faculty_student_group WHERE groupId = '$groupId ' LIMIT 1 ";
    $result = $link->query($sql_check);
    if ($result->num_rows > 0) {
      $request_sent = true;
      //User has already a supervisor
    }else{
      $request_sent = false;
    }
  }
  //Function to send supervisor a request
  if (isset($_POST['btnChooseSupervisor'])){
          //Getting value from POST and sanitizing
    $facultyId = $_POST['facultyId'];
    echo "<script>alert('$facultyId')</script>";  

          //Check if request is already sent
    $check = $link->query("SELECT facultyId FROM faculty_student_request WHERE groupId = '$groupId' LIMIT 1 ");

    if ($check->num_rows == 0){

      $stmt = mysqli_prepare($link,"INSERT INTO faculty_student_request  (facultyId, groupId) VALUES (?, ?)");
      mysqli_stmt_bind_param($stmt,"ii", $facultyId, $groupId);
      mysqli_stmt_execute($stmt);
      if (mysqli_affected_rows($link) > 0) {
        header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
      } else {
        header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
      }
    }
  }

  //Function to delete Request
  if (isset($_POST['btnDeleteReq'])){
          //Getting values from POST and Sanitizing

    $requestId = filter_input(INPUT_POST,'deleteId',FILTER_SANITIZE_NUMBER_INT);
          // sql to delete a record
    $sql = "DELETE FROM faculty_student_request WHERE requestId= '$requestId' ";

    if ($link->query($sql) === TRUE) {
      header('Location:' . $_SERVER['PHP_SELF'] . '?status=req_del_t');die;
    } else {
      header('Location:' . $_SERVER['PHP_SELF'] . '?status=req_del_f');die;
    }
  }
  ?>
  <head>
    <?php include('include/head.php'); ?>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
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

                <?php
                if (isset($_GET['status'])){
                  if ($_GET['status'] == 't'){ ?>
                    <div style="text-align:center;" class="alert alert-success" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign"></span>
                      Request sent to supervisor successfully!
                      <button type="button" class="close" data-dismiss="alert">x</button>
                    </div>
                    <?php
                  }
                  else  if ($_GET['status'] == 'f'){ ?>
                    <div style="text-align:center;" class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign"></span>
                      Error! Something Went Wrong
                      <button type="button" class="close" data-dismiss="alert">x</button>
                    </div>
                    <?php
                  }
                  else if ($_GET['status'] == 'req_del_t'){ ?>
                    <div style="text-align:center;" class="alert alert-success" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign"></span>
                      Request Deleted Successfully!
                      <button type="button" class="close" data-dismiss="alert">x</button>
                    </div>
                    <?php
                  }
                  else if ($_GET['add'] == 'req_del_f'){ ?>
                    <div style="text-align:center;" class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign"></span>
                      Error! Something Went Wrong
                      <button type="button" class="close" data-dismiss="alert">x</button>
                    </div>
                    <?php
                  }

                }
                ?>

                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Info</h3>
                  </div>
                  <?php 
                //If request is sent to supervisor or group already has a supervisor
                  if ($request_sent == true){ ?>
                    <div class="card-body ">
                      <h4>You can not sent request to supervisor</h4>
                      <p>This may be due to reasons</p>
                      <ul>
                        <li>You already have a group supervisor</li>
                        <!--<li>You have sent request to a supervisor</li>-->
                        <form action="" name="cancelRequest" method="POST" data-toggle="validator">
                          <li >You have sent request to a supervisor already
                            <?php if (isset($requestId)){ ?>
                              <input type="hidden" name="deleteId" value="<?php echo $requestId;?>">
                              <button type="submit" name="btnDeleteReq" class="btn btn-default btn-flat btn-xs"><i class="fa fa-user-times" aria-hidden="true"></i> Cancel Request</button>
                              <?php
                            }?>
                          </li>
                        </form>
                      </ul>
                    </div>
                  <?php  }
                //If request is not sent
                  else{ ?>

                   <!-- /.card-header -->
                   <div class="card-body ">
                    <table id="chooseSupervisor" class="table table-head-fixed text-nowrap table-striped" >
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Designation</th>
                          <th>Supervising Quota</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <?php
                      $sql = "SELECT * FROM faculty JOIN work_load ON faculty.facultyId = work_load.facultyId WHERE currentLoad < totalLoad ";
                      $result = $link->query($sql);
                      if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                          ?>
                          <tr>
                            <td><?php echo $row["facultyName"]; ?></td>
                            <td><?php echo $row["facultyEmail"]; ?></td>
                            <td><?php echo $row["designation"]; ?></td>
                            <td><span class="badge bg-warning">
                              <?php
                              echo 'Current:'.$row['currentLoad'].' Total '.$row['totalLoad'];
                              ?>
                            </span>
                          </td>
                          <td>
                            <form name="chooseSupervisor" action="" method="post" data-toggle="validator">
                              <input type= "hidden" name="facultyId" value="<?php echo $row["facultyId"]; ?>"/>
                              <?php if ($row["designation"] == "Supervisor") {

                               ?>
                               <button type="submit" name="btnChooseSupervisor"  id="btnChooseSupervisor"   class="btn btn-primary btn-sm btn-flat form-group"><i class="fa fa-user-plus" aria-hidden="true"></i> Send Request</button>

                             <?php }else{}?>
                           </form>
                         </td>
                       </tr>
                     <?php }
                   }
                   ?>
                 </table>
                 <div class="card-footer">
                  <a href="<?php echo siteroot; ?>" class="btn btn-default btn-sm">Back</a>
                </div>
              </div>
              <!-- /.card-body -->

            <?php  } ?>


          </div>
          <!-- /.card -->



        </div>
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
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<?php include ('include/jsFile.php'); ?>
<!-- .jQuery -->
</body>
</html>