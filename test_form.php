<?php 
$title = "ProSys";
$subtitle = "Register Student";
session_start();
include('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }
  $password="iuk123";
  $isActive=1;
  $full_name= $_POST['full_name'];
  $reg_id=  $_POST['reg_id'];
  $batchId= $_POST['batch'];
  $query = "
  INSERT INTO student (studentName,studentRid,studentPassword, batchId, isActive) VALUES ('".$full_name."', '".$reg_id."', '".$password."', '".$batchId."', '".$isActive."')";
  if(mysqli_query($link, $query))
  {
    echo json_encode(array("statusCode"=>200));
  }
?>