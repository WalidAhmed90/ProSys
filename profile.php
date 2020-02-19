<?php 
$title = "ProSys";
$subtitle = "Profile";
include('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

if (isset($_POST['save'])){
  if ($_SESSION['type']=="Student") {
    if(($_POST['Email']!="") && ($_POST['Cell']!="") && ($_POST['Gender']!=""))
        {
          $email = $_POST['Email'];
          $cell = $_POST['Cell'];
          $gender = $_POST['Gender'];
          $studentId = $_SESSION["usrId"];

          $sql = "UPDATE student SET studentEmail='$email',studentPhoneNo='$cell',studentGender='$gender' WHERE studentId ='$studentId' ";
          if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
        }

        }
      }
      else
      {
        if(($_POST['Email']!="") && ($_POST['Cell']!=""))
        {
          $email = $_POST['Email'];
          $cell = $_POST['Cell'];
          $facultyId = $_SESSION["usrId"];

          $sql = "UPDATE faculty SET facultyEmail='$email',facultyPhoneNo='$cell' WHERE facultyId='$facultyId' ";
          if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
        }

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



          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="dist/img/pics/pic1.jpg" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center text-wrap text-dark text-bold"><?php
                    echo $_SESSION["usrnm"];
          ?></h3>

                <p class="text-muted text-center"><?php
                    echo $_SESSION["user_id"]; ?></br> <?php
                    if($_SESSION['type'] == "Student"){
            echo "Student";
          }else{
                    echo $_SESSION["designation"];
                  }
          ?></p>

              <form method="post" action="" data-toggle="validator">
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item form-group">
                    <input type="text" name="Email" id="Email" class="form-control text-center" placeholder="<?php echo  $_SESSION["usremail"]; ?>" disabled="disabled" required>
                  </li>
                  <li class="list-group-item form-group">
                    <input type="text" name="Cell" id="Cell" class="form-control text-center" placeholder="<?php echo  $_SESSION["usrcell"]; ?>" disabled="disabled" required>
                  </li>
                  <?php if( $_SESSION['type'] == "Student"){ ?>
                  <li class="list-group-item form-group">
                    <input type="text" name="Gender" id="Gender" class="form-control text-center" placeholder="<?php echo $_SESSION["usrgender"] ?>" disabled="disabled" required>
                  </li>
                  <?php } 
                  else{?>
                    <input type="hidden" id="Gender" class="form-control text-center" disabled="disabled">
                    <?php }?>
                </ul>
                  <?php 
                   ?>
                  <button type="button" onclick="enable()" id="EnableDisableBtn" class="btn btn-primary btn-block">Edit Profile</button>
                  <button type="submit" name="save" onclick="disable()" id="save" class="btn btn-primary btn-block form-group" disabled="disabled" >Save</button>

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
                    <input type="password" class="form-control" id="Oldpassword" placeholder="Enter Current Password">
                  </div>
                  <div class="form-group">
                    <label for="Newpassword"> New Password</label>
                    <input type="password" class="form-control" id="Newpassword" placeholder=" Enter New Password">
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
                        <input type="file" class="custom-file-input" id="profileImage">
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
document.getElementById("save").disabled = false;
document.getElementById("EnableDisableBtn").disabled = true;
}
function disable() {
document.getElementById("Email").disabled = true;
document.getElementById("Cell").disabled = true;
document.getElementById("Gender").disabled = true;
document.getElementById("save").disabled = true;
document.getElementById("EnableDisableBtn").disabled = false;
}
</script>

  </body>
</html>