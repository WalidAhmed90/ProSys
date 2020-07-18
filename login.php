<?php 
$title = "ProSys";
$subtitle = "Login";
session_start();
include('db/db_connect.php');

if(isset($_SESSION['user_id'])){
  header("location: index.php");
}

if(isset($_POST['submit'])){

  $login_id = $_POST['txt_id'];
  $login_password = $_POST['txt_pass'];
  
  $studentPassword = "select studentPassword from student where studentRid = '".$login_id."' ";
  $facultyPassword = "select facultyPassword from faculty where facultyRid = '".$login_id."' ";

  $pass_std = mysqli_query($link,$studentPassword);
  $pass_fac = mysqli_query($link,$facultyPassword);

  if (mysqli_num_rows($pass_std)>0) {
    $row  = mysqli_fetch_array($pass_std);
    $pass=$row["studentPassword"];
    $pass_check = password_verify($login_password, $pass);
    if ($pass_check) {
      $login_query_std = "select * from student where studentRid = '".$login_id."' AND isActive = 1 ";
      $run_std = mysqli_query($link,$login_query_std);
      if(mysqli_num_rows($run_std)>0){
        $row  = mysqli_fetch_array($run_std);
        $_SESSION['user_id'] = $login_id;
        $_SESSION['type'] = "Student";
        $_SESSION["usrnm"]=$row["studentName"];
        $_SESSION["usrId"]=$row["studentId"];
        $_SESSION["batchId"]=$row["batchId"];
        $_SESSION["usremail"]=$row["studentEmail"];
        $_SESSION["usrcell"]=$row["studentPhoneNo"];
        $_SESSION["usrgender"]=$row["studentGender"];
        $_SESSION["image"]=$row["studentImage"];
        $_SESSION["groupId"]=$row["groupId"];
        $_SESSION["isVerify"]=$row["isVerify"];
        echo "<script>window.open('index.php','_self')</script>";
      }
    }else
    {
      header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
    }

  }elseif (mysqli_num_rows($pass_fac)>0) {
    $row1  = mysqli_fetch_array($pass_fac);
    $passf=$row1["facultyPassword"];
    $pass_check1 = password_verify($login_password, $passf);
    if ($pass_check1) {
     $login_query_fac = "select * from faculty where facultyRid = '".$login_id."'";
     $run_fac = mysqli_query($link,$login_query_fac);
     if(mysqli_num_rows($run_fac)>0){
       $row1  = mysqli_fetch_array($run_fac);
       $_SESSION['user_id'] = $login_id;
       $_SESSION['type'] = "Faculty";
       $_SESSION["usrnm"]=$row1["facultyName"];
       $_SESSION["usrId"]=$row1["facultyId"];
       $_SESSION["usremail"]=$row1["facultyEmail"];
       $_SESSION["usrcell"]=$row1["facultyPhoneNo"];
       $_SESSION["designation"]=$row1["designation"];
       $_SESSION["image"]=$row1["facultyImage"];
       $_SESSION["isCord"]=$row1["isCoordinator"];
       echo "<script>window.open('index.php','_self')</script>";
       
     }

   }else
   {
    header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
  }
}else{
 header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die; 
}
}

?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include('include/head.php'); ?>
</head>
<body>

  <div class="row " style="background: #e9ecef; padding-top: 10px;">
    <div class="col-md-2"></div>
    <div class="col-md-8">
     <?php
     if (isset($_GET['status'])){
      if ($_GET['status'] == 't'){ ?>
        <div style="text-align:center;" class="alert alert-success" role="alert">
          <span class="glyphicon glyphicon-exclamation-sign"></span>
          Kindly login again thank you.
          <button type="button" class="close" data-dismiss="alert">x</button>
        </div>
        <?php
      }elseif ($_GET['status'] == 'f') { ?>
        <div style="text-align:center;" class="alert alert-danger" role="alert">
          <span class="glyphicon glyphicon-exclamation-sign"></span>
          ID or Password is invalid!.
          <button type="button" class="close" data-dismiss="alert">x</button>
        </div>
        <?php
      }elseif ($_GET['status'] == 've') { ?>
        <div style="text-align:center;" class="alert alert-danger" role="alert">
          <span class="glyphicon glyphicon-exclamation-sign"></span>
          please Verify your email by clicking the link that we have send on your gmail.
          <button type="button" class="close" data-dismiss="alert">x</button>
        </div>
        <?php
      }

    }
    ?>
  </div>
  <div class="col-md-2"></div>
</div>
<div class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Login</b>Page</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="input-group mb-3">
            <input type="text" name="txt_id" class="form-control" placeholder="ID" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="txt_pass" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" name="submit" class="btn btn-primary btn-block">Log In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-1">
          <a href="#">I forgot my password</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<?php include('include/jsFile.php'); ?>
</body>
</html>