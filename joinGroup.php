<?php 
$title = "ProSys";
$subtitle = "Join Group";
include('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }


$check = true;

//Getting values from SESSION
$studentId = $_SESSION['usrId'];
$gender = $_SESSION["usrgender"];
$batchId = $_SESSION["batchId"];


/****
 * Check if user is group leader OR part of group
 * OR he already sent request to user
 */
$sql = "SELECT * FROM student WHERE studentId = '$studentId' LIMIT 1";
$result = $link->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $isLeader = $row['isLeader'];
        $groupId = $row['groupId'];
    }
    if ($isLeader == 1 OR !is_null($groupId)){
        header('Location:' . 'index.php?status=logged_out'); //TODO : 404 Redirect
        session_destroy();
        die;
    }
}
/****
 * Now check if he already sent a request
 */
    $sql = "SELECT * FROM student_group_request WHERE studentId = '$studentId' LIMIT 1";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {

        $check= false;
    }

if ($_SERVER['REQUEST_METHOD']== 'GET') {
      //Send Request
    if (isset($_GET["requestId"]) and is_numeric($_GET["requestId"]) ){

        $requestId = filter_input(INPUT_GET, 'requestId');

            $sql = "INSERT INTO student_group_request (studentId, groupId) VALUES ('$studentId', '$requestId')";

            if ($link->query($sql) === TRUE) {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
            } else {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
            }
      }
    
}



//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   //Delete Request
    if (isset($_POST['btnDeleteRequest'])){
        // sql to delete a record
        $sql = "DELETE FROM student_group_request WHERE studentId='$studentId' LIMIT 1";

        if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
        }
    }

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
                <?php
        if (isset($_GET['status'])){
            if ($_GET['status'] == 't'){ ?>
                <div style="text-align:center;" class="alert alert-success" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    Changes saved successfully!
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
            else if ($_GET['status'] == 'a'){ ?>
                <div style="text-align:center;" class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    Error!
                    <button type="button" class="close" data-dismiss="alert">x</button>
                </div>
                <?php
            }
            else if ($_GET['add'] == 'e'){ ?>
                <div style="text-align:center;" class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    Error!
                    <button type="button" class="close" data-dismiss="alert">x</button>
                </div>
                <?php
            }

        }
        ?>
        <?php if ($check == true){ ?>

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Join Group</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="quickForm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="SetGroupName">List of available groups
                       <p class="text-muted">Click on send request.</p>   
                    </label>
                    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

               
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table id="joinGroup" class="table table-head-fixed text-nowrap table-striped">
                  <thead>
                    <tr>
                      <th>Project Name</th>
                      <th>Created By</th>
                      <th><i class="fas fa-clock" aria-hidden="true"> Group Created</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                        $sql = " SELECT student.studentId,student_group.createdDtm,projectName,studentRid,studentName,student_group.groupId FROM student_group INNER JOIN student ON student.studentId = student_group.leaderId WHERE inGroup < groupLimit " ;

                        $result = $link->query($sql);
                        while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['projectName'] ;?></td>
                                <td><a target="_blank" href="<?php echo 'studentProfile.php?id='.$row['studentId'];?>" ><?php echo $row['studentName']." [".$row['studentRid']."]";?></a></td>
                                <td><time class="timeago" datetime="<?php echo $row['createdDtm'];?>"></time>
                                </td>
                                <td>
                                    <form  action="" method="get" onsubmit="return confirm('Are you sure you want to send request to this group?');" data-toggle="validator">
                                        <input type="hidden" name="requestId" value="<?php echo $row['groupId'];?>">
                                        <button type="submit" class="btn  btn-primary btn-block  btn-sm"><i class="fa fa-user-plus" aria-hidden="true"></i> Send Request</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                        ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
                  </div>
                  <div>
                  	
                  </div>
              </form>
            </div>
            <!-- /.card -->


      <?php
        }else if ($check == false){ ?>
            <!-- general form elements -->
            <div class="card no-border">
                <div class="card-header with-border">
                    <h3 class="card-title"><i class="fa fa-info" aria-hidden="true"></i> Can not send request to group</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <p>You have already sent request to a group</p>
                    <form  action="" method="post" onsubmit="return confirm('Are you sure you want to cancel your sent request?');" data-toggle="validator">
                        <button type="submit" name="btnDeleteRequest" class="btn  btn-default  "><i class="fa fa-times" aria-hidden="true"></i> Cancel Request</button>
                    </form>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                </div>

            </div>
            <!-- /.card -->
        <?php
        }?>
            </div>
          <!--/.col (left) -->
        
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
<script type="text/javascript">
   jQuery(document).ready(function() {
     $("time.timeago").timeago();
   });
</script>
</body>
</html>
