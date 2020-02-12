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

    $login_query_std = "select * from student where studentRid = '".$login_id."' AND studentPassword = '".$login_password."' ";
    $login_query_fac = "select * from faculty where facultyRid = '".$login_id."' AND facultyPassword = '".$login_password."' ";

    $run_std = mysqli_query($link,$login_query_std);
    $run_fac = mysqli_query($link,$login_query_fac);

    $row  = mysqli_fetch_array($run_std);
    $row1  = mysqli_fetch_array($run_fac);
    if(mysqli_num_rows($run_std)>0){
        $_SESSION['user_id'] = $login_id;
        $_SESSION['type'] = "Student";
        $_SESSION["usrnm"]=$row["studentName"];
        echo "<script>window.open('index.php','_self')</script>";
    }
    elseif(mysqli_num_rows($run_fac)>0){
        $_SESSION['user_id'] = $login_id;
        $_SESSION['type'] = "Faculty";
        $_SESSION["usrnm"]=$row1["facultyName"];
        echo "<script>window.open('index.php','_self')</script>";
    }
  else{
     echo "<script>alert('ID or Password is invalid!')</script>";  
      }
}

?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include('include/head.php'); ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Login</b>Page</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="login.php" method="post">
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
        <a href="forgot-password.html">I forgot my password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<?php include('include/jsFile.php'); ?>
</body>
</html>