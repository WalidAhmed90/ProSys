<?php

//insert.php
$connect = mysqli_connect("localhost", "root", "", "fypms");


$query = "
INSERT INTO student (studentName, studentRid,studentPassword, batchId, isActive) VALUES (?, ?, ?, ?, ?)
";
$password="iuk123";
$isActive=1;

for($count = 0; $count<count($_POST['hidden_first_name']); $count++)
{	

	$data = array(
		$full_name=	$_POST['hidden_full_name'][$count],
		$reg_id=	$_POST['hidden_reg_id'][$count],
		$batchId=	$_POST['hidden_batch'][$count]
	);
	$stmt = mysqli_stmt_init($connect);
	mysqli_stmt_prepare($stmt,$query);
	mysqli_stmt_bind_param($stmt, "sssii", $full_name,$reg_id,$password,$batchId,$isActive);
	/* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $data);
}
/* close statement */
    mysqli_stmt_close($stmt);
    /* close connection */
mysqli_close($link);
?>