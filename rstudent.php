<?php 
$title = "ProSys";
$subtitle = "Register Student";
session_start();
include('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

$query = "
INSERT INTO student (studentName,studentRid,studentPassword, batchId, isActive) VALUES (?, ?, ?, ?, ?)
";
$password="iuk123";
$isActive=1;
for($count = 0; $count<count($_POST['hidden_full_name']); $count++)
{ 

  $data = array(
    $full_name= $_POST['hidden_full_name'][$count],
    $reg_id=  $_POST['hidden_reg_id'][$count],
    $password,
    $batchId= $_POST['hidden_batch'][$count],
    $isActive
  );
  $stmt = mysqli_stmt_init($link);
  mysqli_stmt_prepare($stmt,$query);
  mysqli_stmt_bind_param($stmt, "sssii", $full_name,$reg_id,$password,$batchId,$isActive);
  /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $data);
}
/* close statement */
    mysqli_stmt_close($stmt);

 ?>