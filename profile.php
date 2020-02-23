<?php 
$title = "ProSys";
$subtitle = "Profile";
include('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

//For Edit Profile
 if ($_SESSION['type']=="Student") {
   $sql = "SELECT * FROM student where studentRid = '".$_SESSION['user_id']."' ";
                                $result = mysqli_query($link,$sql);
                                $row = mysqli_fetch_array($result);
                                  if(mysqli_num_rows($result)>0){
                                       $_SESSION['type'] = "Student";
                                        $_SESSION["usrnm"]=$row["studentName"];
                                        $_SESSION["usrId"]=$row["studentId"];
                                        $_SESSION["usremail"]=$row["studentEmail"];
                                        $_SESSION["usrcell"]=$row["studentPhoneNo"];
                                        $_SESSION["usrgender"]=$row["studentGender"];
                                      }


  if (isset($_POST['btnSaveChanges'])){
 
    if(($_POST['email']!="") && ($_POST['cell']!="") && ($_POST['gender']!=""))
        {
          $email = $_POST['email'];
          $cell = $_POST['cell'];
          $gender = $_POST['gender'];
          $studentId = $_SESSION["usrId"];

          $sql = "UPDATE student SET studentEmail='".$email."',studentPhoneNo='".$cell."',studentGender='".$gender."' WHERE studentId ='".$_SESSION['user_id']."' ";
          if ($link->query($sql) === TRUE) {
             echo "<script>alert('Data has been updated')</script>";
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
        } else {
          echo "<script>alert('Error occur')</script>";
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
        }

        }
    }
  }
      else
      {
                                $sql = "SELECT * FROM faculty where facultyRid = '".$_SESSION['user_id']."' ";
                                $result = mysqli_query($link,$sql);
                                $row1 = mysqli_fetch_array($result);
                                  if(mysqli_num_rows($result)>0){
                                     $_SESSION['type'] = "Faculty";
                                     $_SESSION["usrnm"]=$row1["facultyName"];
                                      $_SESSION["usrId"]=$row1["facultyId"];
                                      $_SESSION["usremail"]=$row1["facultyEmail"];
                                     $_SESSION["usrcell"]=$row1["facultyPhoneNo"];
                                    $_SESSION["designation"]=$row1["designation"];
      }
    
       if (isset($_POST['btnSaveChanges1'])){

        if(($_POST['email']!="") && ($_POST['cell']!=""))
        {
          $email = $_POST['email'];
          $cell = $_POST['cell'];
          $facultyId = $_SESSION["usrId"];

          $sql = "UPDATE faculty SET facultyEmail='".$email."',facultyPhoneNo='".$cell."' WHERE facultyId='".$facultyId."' ";
          if ($link->query($sql) === TRUE) {
            echo "<script>alert('Data has been updated')</script>";
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
        } else {
          echo "<script>alert('Error occur')</script>";
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
        }

        }
      }
}

//For Change Password
if (isset($_POST['BtnChnagePassword'])) {
    if (($_POST['Oldpassword']!="") && ($_POST['Newpassword']!="")) {
      
      $Oldpassword = $_POST['Oldpassword'];
      $Newpassword = $_POST['Newpassword'];
      $user_id = $_SESSION['user_id'];

      $result = mysqli_query($link,"SELECT studentPassword FROM student WHERE studentRid='".$user_id."'");
      $row = mysqli_fetch_assoc($result);
      $oldpasswords = $row ['studentPassword'];

      $result1 = mysqli_query($link,"SELECT facultyPassword FROM faculty WHERE facultyRid='".$user_id."'");
      $row1 = mysqli_fetch_assoc($result1);
      $oldpasswordf = $row1 ['facultyPassword'];

//check passwords
if($Oldpassword==$oldpasswords)
{
$querychange = mysqli_query($link,"
UPDATE student SET studentPassword = '".$Newpassword."' WHERE studentRid='".$user_id."' ");

header('Location:' . 'login.php' . '?status=t');
session_destroy();
}
else
{
  echo "<script>alert('Error occur')</script>";
  header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');

}

if ($Oldpassword==$oldpasswordf) {
     $querychange = mysqli_query($link,"
UPDATE faculty SET facultyPassword = '".$Newpassword."' WHERE facultyRid='".$user_id."' ");

header('Location:' . 'login.php' . '?status=t');
session_destroy();

    
    }
    else
    {
      echo "<script>alert('Error occur')</script>";
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
                else if ($_GET['status'] == 'l'){ ?>
                    <div style="text-align:center;" class="alert alert-success" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                        Kindly login again thank you.
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
        <div class="row">

           



          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="dist/img/pics/pic1.jpg" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center text-wrap text-dark text-bold">

                  <?php
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
                
                    <h6 class="text-center"><span><i class="fa fa-envelope text-primary" aria-hidden="true"></i></span><a href="mailto:<?php echo  $_SESSION["usremail"]; ?>">  <?php echo  $_SESSION["usremail"]; ?></a></h6>
                    
                     <h6 class="text-center"><span><i class="fa fa-phone text-success" aria-hidden="true"></i></span>  <?php echo  $_SESSION["usrcell"]; ?></h6>
                   
                  <?php if( $_SESSION['type'] == "Student"){ ?>
                  
                     <h6 class="text-center"><span><i class="fa fa-user text-warning" aria-hidden="true"></i></span>  <?php echo $_SESSION["usrgender"]; ?></h6>
                    
                  <?php } 
                  else{
                    ?> 
                    <?php }?>
                    <br>

                  <button class="btn btn-info btn-block" data-toggle="modal" data-target="#modal-info" id="EnableDisableBtn">Edit Profile</button>
<?php if($_SESSION['type']=="Student") {?>
 <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
          <div class="modal-content bg-info">
            <div class="modal-header">
              <h4 class="modal-title">Edit Profile</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    <!-- form start -->
              <form role="form" method="post" action="" id="EditProfile" data-toggle="validator">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Email</label>
                 <input type="email" id="email" class="form-control" name="email" placeholder="<?php echo $_SESSION["usremail"];  ?>" required>
                </div>

                 <div class="form-group">
                  <label>Phone</label>
                 <input type="text" id="cell" class="form-control" name="cell" placeholder="<?php echo $_SESSION["usrcell"];  ?>" required>
                </div>

                 <div class="form-group">
                  <label>Gender</label>
                 <input type="text" id="gender" class="form-control" name="gender" placeholder="<?php echo $_SESSION["usrgender"] ;  ?>" required>
                </div>

              </div>
            </div>

             
            </div>
            <div class="modal-footer justify-content-between form-group">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
              <button type="submit" name="btnSaveChanges" class="btn btn-outline-light">Save changes</button>
            </div>

             </form>
            


          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
            <?php }else{ ?>

  <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
          <div class="modal-content bg-info">
            <div class="modal-header">
              <h4 class="modal-title">Edit Profile</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    <!-- form start -->
              <form role="form" method="post" action="" id="EditProfile" data-toggle="validator">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Email</label>
                 <input type="email" id="email" class="form-control" name="email" placeholder="<?php echo $_SESSION["usremail"];  ?>" required>
                </div>

                 <div class="form-group">
                  <label>Phone</label>
                 <input type="text" id="cell" class="form-control" name="cell" placeholder="<?php echo $_SESSION["usrcell"];  ?>" required>
                </div>

              </div>
            </div>

             
            </div>
            <div class="modal-footer justify-content-between form-group">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
              <button type="submit" name="btnSaveChanges1" class="btn btn-outline-light">Save changes</button>
            </div>

             </form>
            


          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    <?php }?>

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
              <form role="form" method="post" action="">
                <div class="card-body">
                  <div class="form-group">
                    <label for="Oldpassword">Current Password</label>
                    <input type="password" class="form-control" name="Oldpassword" id="Oldpassword" placeholder="Enter Current Password" required>
                  </div>
                  <div class="form-group">
                    <label for="Newpassword"> New Password</label>
                    <input type="password" class="form-control" id="Newpassword" name="Newpassword" placeholder=" Enter New Password" required>
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="BtnChnagePassword" class="btn btn-primary float-right">Submit</button>
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