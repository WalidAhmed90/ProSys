<?php 
$title = "ProSys";
$subtitle = "Profile";
include('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }
$studentId = $_SESSION['user_id'];

$sql = "SELECT * FROM student WHERE student.studentRid = '$studentId' LIMIT 1";
$result = mysqli_query($link,$sql);

if (mysqli_num_rows($result)>0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $studentEmail = $row['studentEmail'];
        $studentPhoneNo = $row['studentPhoneNo'];
        $studentGender = $row['studentGender'];

    }
  }

  /*update data on save button*/
/*
   if (isset($_POST['submit1'])){

      $studentEmail = $_POST['studentEmail'];
        $studentPhoneNo = $_POST['studentPhoneNo'];
        $studentGender = $_POST['studentGender'];

        $sql = "UPDATE student SET studentEmail='$studentEmail', studentPhoneNo='$studentPhoneNo', studentGender='studentGender' WHERE studentRid='$studentId' ";
        if (mysqli_query($link,$sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
        }
      }*/

//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit1']) AND $_POST['studentEmail'] != ""){
        
       $studentEmail = $_POST['studentEmail'];
        $studentPhoneNo = $_POST['studentPhoneNo'];
        $studentGender = $_POST['studentGender'];
        
        $sql = "UPDATE student SET studentEmail='$studentEmail', studentPhoneNo='$studentPhoneNo', studentGender='studentGender' WHERE studentRid='$studentId' ";

        if ($conn->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
        }

    }

} 
 ?>
<head>
  <?php include('include/head.php'); ?>
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" style="width: 200px; height: 200px;" 
                       src="dist/img/pics/pic1.jpg"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center text-wrap text-dark text-bold"><?php
                    echo $_SESSION["usrnm"];
          ?></h3>

                <p class="text-muted text-center"><?php
                    echo $_SESSION["user_id"];
          ?></p>
              <form method="post" >
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item form-group">
                    <input type="text" name="studentEmail" id="Email" class="form-control text-center" placeholder="<?php echo $studentEmail?>" disabled="disabled" required>
                  </li>
                  <li class="list-group-item form-group">
                    <input type="text" name="studentPhoneNo" id="Cell" class="form-control text-center" placeholder="<?php echo $studentPhoneNo?>" disabled="disabled" required>
                  </li>
                  <li class="list-group-item form-group">
                    <input type="text" name="studentGender" id="Gender" class="form-control text-center" placeholder="<?php echo $studentGender?>" disabled="disabled" required>
                  </li>
                </ul>
                  <button type="button" onclick="enable()" id="EnableDisableBtn" class="btn btn-primary btn-block form-group" >Edit Profile</button>
                  <button type="submit" onclick="disable()" name="submit1" id="EnableDisableBtn1" class="btn btn-primary btn-block form-group" disabled="disabled" >Save</button>
                  </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <!-- left column -->
          <div class="col-md-9">
            <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form">
                <div class="card-body">
                  <div class="form-group">
                    <label for="Oldpassword">Current Password</label>
                    <input type="password" class="form-control" id="Oldpassword" placeholder="Enter Current Password" required>
                  </div>
                  <div class="form-group">
                    <label for="Newpassword"> New Password</label>
                    <input type="password" class="form-control" id="Newpassword" placeholder=" Enter New Password" required>
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>

          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Change Profile Image</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form">
                <div class="card-body">
                  <div class="form-group">
                    <label for="profileImage">Change profile picture.</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="profileImage" required>
                        <label class="custom-file-label" for="profileImage">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          </div>
          <!--/.col (left) -->
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    </div>
    <!-- .Content Wrapper. Contains page content -->

  
    <?php include('include/footer.php'); ?>
  </div>

  <!-- jQuery -->
  <?php include('include/jsFile.php'); ?>
  <!-- .jQuery -->

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

  <script type="text/javascript">
   function enable() {
document.getElementById("Email").disabled = false;
document.getElementById("Cell").disabled = false;
document.getElementById("Gender").disabled = false;
document.getElementById("EnableDisableBtn1").disabled = false;
document.getElementById("EnableDisableBtn").disabled = true;
}
function disable() {
document.getElementById("Email").disabled = true;
document.getElementById("Cell").disabled = true;
document.getElementById("Gender").disabled = true;
document.getElementById("EnableDisableBtn1").disabled = true;
document.getElementById("EnableDisableBtn").disabled = false;
}
</script>

  </body>
</html>