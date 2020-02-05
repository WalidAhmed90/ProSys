<?php 
$title = "ProSys";
$subtitle = "Profile";
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
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
                  <img class="profile-user-img img-fluid img-circle"
                       src="dist/img/pics/pic1.jpg"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">Walid Ahmed</h3>

                <p class="text-muted text-center">12422</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item ">
                    <input type="text" id="Email" class="form-control text-center" placeholder="Walidkhan345@gmail.com" disabled="disabled">
                  </li>
                  <li class="list-group-item ">
                    <input type="text" id="Cell" class="form-control text-center" placeholder="03122990486" disabled="disabled">
                  </li>
                  <li class="list-group-item ">
                    <input type="text" id="Gender" class="form-control text-center" placeholder="Male" disabled="disabled">
                  </li>
                </ul>
                  <button type="button" onclick="enable()" name="EnableDisableBtn" class="btn btn-primary btn-flat" style="display: flex; justify-content: center; ">Edit Profile</button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <!-- left column -->
          <div class="col-md-9">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Profile</h3>
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
          <!--/.col (left) -->
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    </div>
    <!-- .Content Wrapper. Contains page content -->

    <footer class="main-footer">
    </footer>
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
}
</script>

  </body>
</html>