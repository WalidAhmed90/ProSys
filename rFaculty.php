<?php 
$title = "ProSys";
$subtitle = "Register Faculty";
session_start();
include('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }
$password="iuk123";
$isCoordinator=0;

$query = "
INSERT INTO faculty (facultyName,facultyRid,facultyPassword,isCoordinator) VALUES (?, ?, ?,?)
";
for($count = 0; $count<count($_POST['hidden_full_name']); $count++)
{ 

  $data = array(
    $full_name= $_POST['hidden_full_name'][$count],
    $reg_id=  $_POST['hidden_reg_id'][$count],
    $password,
    $isCoordinator
   

  );
  $stmt = mysqli_stmt_init($link);
  mysqli_stmt_prepare($stmt,$query);
  mysqli_stmt_bind_param($stmt, "sssi", $full_name,$reg_id,$password,$isCoordinator);
  /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $data);
}
/* close statement */
    mysqli_stmt_close($stmt);

 ?>