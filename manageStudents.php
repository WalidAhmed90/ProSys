<?php 
$title = "ProSys";
$subtitle = "Manage Students";
session_start();
include ("db/db_connect.php");
include("mysql_table.php");
include("include/functions.php");

if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

   //Edit Student
    if (isset($_POST['btnEditStudent'])){
        //Validations
        if (($_POST['name']) !="" && $_POST['rid'] !=""  && $_POST['email'] !=""  ){
            //Getting values from POST and sanitizing it
            $rid = filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
            $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
            $contact = filter_input(INPUT_POST,'contact',FILTER_SANITIZE_NUMBER_INT);
            $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
            $editId = filter_input(INPUT_POST,'editId',FILTER_SANITIZE_NUMBER_INT);
            $batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);
            $isActive = filter_input(INPUT_POST,'isActive',FILTER_SANITIZE_NUMBER_INT);

            // prepare and bind
            $stmt = $link->prepare("UPDATE  student  SET studentRid = ?, studentName = ?, studentEmail = ?, studentPhoneNo =?, studentPassword=?, isActive=? WHERE student.studentId = ?");
            $stmt->bind_param("sssssii", $rid, $name,$email, $contact, $password , $isActive , $editId);


            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $stmt->close();
                $link->close();
                header('Location:' . $_SERVER['PHP_SELF'] . '?batchId='.$batchId.'&status=t');die;
            }

        }
        else{
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=e');die;
        }
    }

    //Delete Student
    if (isset($_POST['btnDelete'])){

        //Check is student is in a group
        $deleteId = filter_input(INPUT_POST,'deleteId',FILTER_SANITIZE_NUMBER_INT);
        $batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);

        $sql = "SELECT groupId FROM student WHERE studentId ='$deleteId' LIMIT 1";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $groupId = $row['groupId'];
            }
            if (is_null($groupId)){
                //Delete
                // sql to delete a record
                $sql = "DELETE FROM student WHERE studentId='$deleteId'";

                if ($link->query($sql) === TRUE) {
                    header('Location:' . $_SERVER['PHP_SELF'] . '?batchId='.$batchId.'&status=t');die;
                } else {
                    header('Location:' . $_SERVER['PHP_SELF'] . '?batchId='.$batchId.'&status=f');die;
                }
            }else{
                header('Location:' . $_SERVER['PHP_SELF'] . '?batchId='.$batchId.'&status=n');die;
            }
        }
    }



 ?>
<head>
  <?php include('include/head.php'); ?>
</head>
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

       <section class="content">
            <div class="row">
                <div class="col-md-12">

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
                        else if ($_GET['status'] == 'n'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! This student is in a group.Can not delete this student
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                        else if ($_GET['status'] == 'e'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error!
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                    }

                    ?>


                    <?php if (isset($_GET['edit']) && is_numeric($_GET['edit']) && strlen($_GET['edit'])){
                        /*******
                         * Edit Student
                         */
                        $editId = filter_input(INPUT_GET,'edit',FILTER_SANITIZE_NUMBER_INT);

                        $sql = "SELECT * FROM student WHERE studentId = '$editId' LIMIT 1";
                        $result = mysqli_query($link,$sql);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
                                $rid = $row['studentRid'];
                                $name = $row['studentName'];
                                $email = $row['studentEmail'];
                                $contact = $row['studentPhoneNo'];
                                $gender = $row['studentGender'];
                                $password = $row['studentPassword'];
                                $isActive = $row['isActive'];
                                $batchId = $row['batchId'];
                                $isActive = $row['isActive'];
                            }
                        }
                        ?>
                        <!-- general form elements -->
                        <div class="card card-primary card-outline">
                            <div class="card-header with-border">
                                <h3 class="card-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit: <?php echo $name;?> </h3>
                            </div>
                            <!-- /.card-header -->

                            <form class="form-horizontal" name="editStudent" action=""  method="post" onsubmit="return confirm('Are you sure you want to submit these changes?');" data-toggle="validator">
                                <input type="hidden" name="editId" value="<?php echo $editId; ?>">
                                <input type="hidden" name="batchId" value="<?php echo $batchId; ?>">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">RID</label>

                                        <div class="col-sm-10">
                                            <input type="number" min="000001" max="99999" class="form-control" id="rid" name="rid" value="<?php echo $rid;?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>" required>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>

                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email;?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Contact</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact;?>" >
                                        </div>
                                    </div>

                                    <div class="form-group">


                                        <label class="col-sm-2 control-label">Password <i class="fa fa-eye text-primary" id="eye" aria-hidden="true"></i> </label>
                                        <div class="col-sm-10 " >

                                            <input type="password"  class="form-control" id="password" name="password" value="<?php echo $password ;?>"  required>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Status</label>

                                        <div class="col-sm-10">
                                            <select name="isActive" id="isActive" style="width:200px;" required>
                                                <option value="1" <?php if ($isActive==1){echo 'selected';}?>>Active</option>
                                                <option value="0" <?php if ($isActive==0){echo 'selected';}?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>





                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a href="<?php echo $_SERVER['PHP_SELF'].'?batchId='.$batchId; ?>" class="btn  btn-default btn-sm  "> Cancel</a>
                                    <button type="submit" name="btnEditStudent" class="btn btn-primary float-right">Submit</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>

                        </div>
                        <!-- /.card -->

                        <?php
                    }?>


                    <div class="card no-border ">
                        <div class="card-header">
                            <h3 class="card-title">List of students</h3>

                            <div class="card-tools">
                                <form name="selectBatch"  id="selectBatch" method="get"  data-toggle="validator">

                                    <div class="form-group input-group input-group-sm" style="width: 250px;">

                                        <select name="batchId"  id="batchId" class="form-control" required>
                                            <?php
                                            $sql = "SELECT * FROM batch WHERE  batch.isActive = 1";
                                            $result = mysqli_query($link,$sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) { ?>
                                                    <option value="<?php echo $row['batchId']; ?>" >
                                                        <?php echo $row['batchName'];?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>

                        <?php if (isset($_GET['batchId']) && is_numeric($_GET['batchId']) && strlen($_GET['batchId'])){
                            $batchId = filter_input(INPUT_GET,'batchId',FILTER_SANITIZE_NUMBER_INT);
                            ?>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive ">
                                <table id="manageStudents" class="table table-head-fixed text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>RID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Group Status</th>
                                        <th><i class="fa fa-clock-o" aria-hidden="true"></i> Created</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $sql = "SELECT * FROM student WHERE batchId = '$batchId'  ORDER BY student.createdDtm ASC "; //Chronological order
                                    $result = mysqli_query($link,$sql);
                                    while($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $row['studentRid'] ;?></td>
                                            <td><?php echo $row['studentName'];?></td>
                                            <td><?php echo $row['studentEmail'] ;?></td>
                                            <td><?php echo $row['studentGender'] ;?></td>
                                            <td>
                                                <?php if ($row['isLeader'] == 1 ){ ?>
                                                    <span class="badge bg-info">Group Leader</span>
                                                <?php } else if($row['groupId'] != null){ ?>
                                                    <span class="badge bg-primary">Group Formed</span>
                                                <?php }else if (is_null($row['groupId'])){ ?>
                                                    <span class="badge bg-warning">Not in Group</span>
                                                    <?php
                                                } ?>
                                            </td>
                                            <td><time class="timeago" datetime="<?php echo $row['createdDtm'];?>"></time>
                                            </td>
                                            <td>



                                                <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $row['studentId'].'&batchId='.$batchId; ?>"  class="btn  btn-default btn-block  btn-sm float-left"><i class="fas fa-edit" aria-hidden="true"></i> Edit</a>

                                                <form  action="" method="post" onsubmit="return confirm('Are you sure you want to delete this student?');" data-toggle="validator">
                                                    <input type="hidden" name="deleteId" value="<?php echo $row['studentId'];?>">
                                                    <input type="hidden" name="batchId" value="<?php echo $batchId; ?>">
                                                    <button type="submit" name="btnDelete" class="btn  btn-danger btn-block  btn-xs float-left"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                                </form>

                                                <a href="<?php echo "studentReport.php?id=".$row['studentId'] ;?>" class="btn btn-default btn-block btn-xs float-left" target="_blank"><i class="fas fa-external-link-alt"></i> View Report</a>


                                            </td>
                                        </tr>
                                    <?php }
                                    ?>
                                </table>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a href="registerStudent.php" class="btn btn-primary btn-sm float-right">Add New Student</a>
                                <a href="<?php echo siteroot; ?>" class="btn  btn-default btn-sm  "> Back</a>

                            </div>

                            <?php
                        }else{ ?>
                            <h4 class="text-muted">Select Batch from the list fist</h4>
                            <?php
                        } ?>

                    </div>
                    <!-- /.card -->




                </div>

            </div>
        </section>



    </div>
    <!-- .Content Wrapper. Contains page content -->

  
    <?php include('include/footer.php'); ?>
  </div>

  <!-- jQuery -->
  <?php include('include/jsFile.php'); ?>
  <!-- .jQuery -->
<script>
    $(document).ready(function() {
        $('#manageStudents').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
    });

        function show() {
            var p = document.getElementById('password');
            p.setAttribute('type', 'text');
        }

        function hide() {
            var p = document.getElementById('password');
            p.setAttribute('type', 'password');
        }

        var pwShown = 0;

        document.getElementById("eye").addEventListener("click", function () {
            if (pwShown == 0) {
                pwShown = 1;
                show();
            } else {
                pwShown = 0;
                hide();
            }
        }, false);
    } );


</script>
<script type="text/javascript">
   jQuery(document).ready(function() {
     $("time.timeago").timeago();
   });
</script>

 

  </body>
</html>