<?php 
session_start();
$title = "ProSys";
$subtitle = "Dashboard";
include('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }
  else{
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

    </div>
    <!-- .Content Wrapper. Contains page content -->

    <footer class="main-footer">
    </footer>
    <?php include('include/footer.php'); ?>
  </div>

  <!-- jQuery -->
  <?php include('include/jsFile.php'); ?>
  <!-- .jQuery -->

  </body>
</html>
<?php } ?>