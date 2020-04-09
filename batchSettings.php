<?php 
$title = "ProSys";
$subtitle = "Batch Settings";
session_start();
include('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

//Check if form is submitted by GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
}

//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    /**********************************
     * Add batch to Project Repository
     **********************************/
    
    if (isset($_POST['btnAddtoProjectRep'])){
        $batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);

        $sql = "SELECT id FROM project_repository WHERE batchId = '$batchId' LIMIT 1";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=ae');die;
        } else {
            $sql = "INSERT INTO project_repository (batchId)VALUES ('$batchId')";

            if ($link->query($sql) === TRUE) {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
            } else {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
            }
        }
    }


    if (isset($_POST['btnGradePt1'])){
        //echo "ALLOW GRADE PART 1";
    }

    if (isset($_POST['btnUpgradefyp'])){

        $batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);

        // Set autocommit to off
        // mysqli_autocommit($link, FALSE);

        $sql = "UPDATE batch SET fypPart = 2 WHERE batchId='$batchId' LIMIT 1";

        if ($link->query($sql) === TRUE) {
            $sql = "UPDATE student_group SET fypPart=2 WHERE batchId='$batchId'";

            $batchName = $link->query("SELECT batchName FROM batch WHERE batchId = '$batchId' LIMIT 1")->fetch_object()->batchName;

            $title = "Batch Upgraded";
            $details = $batchName ." has been upgraded to Project Defense";
            $type = "info";
            $fypPart = 2;

            //Add this info to timeline
            $sql = "INSERT INTO timeline_student (title, details, type, batchId, fypPart)VALUES ('$title', '$details', '$type', '$batchId', '$fypPart');";
            $sql .= "INSERT INTO timeline_faculty (title, details, type, batchId, fypPart)VALUES ('$title', '$details', '$type', '$batchId', '$fypPart');";
            if ($link->multi_query($sql) === TRUE) {
                // Commit transaction
                //mysqli_commit($link);
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t&settings='.$batchId);die;
            }
        }
    }

    
    /*****************************
     * fyp 1 Grading
     *****************************/
    if (isset($_POST['btnfyp1grading'])){
        $batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);
        $value = filter_input(INPUT_POST,'fyp1grading',FILTER_SANITIZE_NUMBER_INT);

        $sql = "UPDATE batch_settings SET fyp1_grading='$value' WHERE batchId='$batchId' ";

        if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t&settings='.$batchId);die;
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f&settings='.$batchId);die;
        }
    }

  
    /*****************************
     * fyp 2 Grading
     *****************************/
    if (isset($_POST['btnfyp2grading'])){
        $batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);
        $value = filter_input(INPUT_POST,'fyp2grading',FILTER_SANITIZE_NUMBER_INT);

        $sql = "UPDATE batch_settings SET fyp2_grading='$value' WHERE batchId='$batchId' ";

        if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t&settings='.$batchId);die;
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f&settings='.$batchId);die;
        }
    }

    /*****************************
     * Deactivate Batch
     *****************************/
    if (isset($_POST['btnDeactivate'])){
        $batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);
        // Set autocommit to off
        mysqli_autocommit($link, FALSE);
        $sql = "UPDATE batch SET isActive=0 WHERE batchId= '$batchId' ";

        if ($link->query($sql) === TRUE) {
            $sql = "UPDATE student SET isActive=0 WHERE batchId= '$batchId' ";

            if ($link->query($sql) === TRUE) {
                // Commit transaction
                mysqli_commit($link);
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t&settings='.$batchId);die;
            }else{
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f&settings='.$batchId);die;
            }
        }
    }

    /*****************************
     * Activate Batch
     *****************************/
    if (isset($_POST['btnActivate'])){
        $batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);
        // Set autocommit to off
        mysqli_autocommit($link, FALSE);
        $sql = "UPDATE batch SET isActive=1 WHERE batchId= '$batchId' ";

        if ($link->query($sql) === TRUE) {
            $sql = "UPDATE student SET isActive=1 WHERE batchId= '$batchId' ";

            if ($link->query($sql) === TRUE) {
                // Commit transaction
                mysqli_commit($link);
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t&settings='.$batchId);die;
            }else{
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f&settings='.$batchId);die;
            }
        }
    }
}
 ?>
<head>
  <?php include('include/head.php'); ?>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include('include/navbar.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include ('include/sidebar.php'); ?>
        <!-- /.Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <?php include ('include/contentheader.php'); ?>

            <!-- Main content -->
            <section class="content" style="min-height: 700px">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <?php
                        if (isset($_GET['status'])){
                            if ($_GET['status'] == 't'){ ?>
                                <div style="text-align:center;" class="alert alert-success" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign">
                                    </span>
                                    Changes saved successfully!
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else  if ($_GET['status'] == 'f'){ ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Error! Something Went Wrong
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else if ($_GET['status'] == 'ae'){ ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Error! This batch is already in Project Repository
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else if ($_GET['status'] == 'e'){ ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Error!
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            }
                        }


                        if (isset($_GET['settings']) && is_numeric($_GET['settings']) && strlen($_GET['settings']) > 0 ) {
                            $batchId = filter_input(INPUT_GET, 'settings', FILTER_SANITIZE_NUMBER_INT);

                            $sql = "SELECT * FROM batch WHERE batchId ='$batchId ' LIMIT 1";
                            $result = $link->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    $batchName = $row['batchName'];
                                    $startDate = $row['startingDate'];
                                    $isActive = $row['isActive'];
                                    $fypPart = $row['fypPart'];
                                }
                            }
                            ?>

                            <!-- general form elements -->
                            <div class="card card-primary card-outline">
                                <div class="card-header with-border">
                                    <h3 class="card-title">
                                        <i class="fa fa-cog" aria-hidden="true"></i> Setting : <?php echo $batchName; ?>
                                    </h3>
                                </div>
                                <!-- general form elements -->
                                <div class="card no-border">
                                    <div class="card-body table-responsive">
                                        <form action="" method="post" onsubmit="return confirm('Are you sure  ?');" data-toggle="validator">
                                            <input type="hidden" name="batchId" value="<?php echo $batchId;?>">
                                            <ul class="todo-list ui-sortable">
                                                <li class="">
                                                    <!-- drag handle -->
                                                    <span class="handle ui-sortable-handle">
                                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                                    </span>
                                                    <span class="text">Add this batch to Project Repository</span>
                                                    <small class="badge bg-primary"><?php echo $batchName;?></small>
                                                    <button type="submit" name="btnAddtoProjectRep" class="btn btn-info  btn-xs float-right">Submit</button>
                                                </li>
                                            </ul>
                                        </form>

                                        <?php if ($fypPart ==1){ ?>

                                            <form action="" method="post" onsubmit="return confirm('Are you sure  ?');" data-toggle="validator">
                                                <input type="hidden" name="batchId" value="<?php echo $batchId;?>">
                                                <ul class="todo-list ui-sortable">
                                                    <li class="">
                                                        <!-- drag handle -->
                                                        <span class="handle ui-sortable-handle">
                                                            <i class="fa fa-cog" aria-hidden="true"></i>
                                                        </span>
                                                        <span class="text">Upgrade Batch to Project Defense</span>
                                                        <small class="badge bg-primary"><?php echo $batchName;?></small>
                                                        <button type="submit" name="btnUpgradefyp" class="btn btn-info  btn-xs float-right">Submit</button>
                                                    </li>
                                                </ul>
                                            </form>
                                            
                                            <?php
                                        }

                                        if ($isActive == 1) {

                                        ?>

                                        <form action="" method="post" onsubmit="return confirm('This action will deactivate Batch and all the students in it.THIS ACTION IS IRREVERSIBLE. Are you sure you want to continue ?');" data-toggle="validator">
                                            <input type="hidden" name="batchId" value="<?php echo $batchId;?>">
                                            <ul class="todo-list ui-sortable">
                                                <li class="">
                                                    <!-- drag handle -->
                                                    <span class="handle ui-sortable-handle">
                                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                                    </span>
                                                    <span class="text">Deactivate this Batch</span>
                                                    <small class="badge bg-primary"><?php echo $batchName;?></small>
                                                    <button type="submit" name="btnDeactivate" class="btn btn-info  btn-xs float-right">Submit</button>
                                                </li>
                                            </ul>
                                        </form>

                                    <?php 
                                }
                                else
                                    { ?>

                                        <form action="" method="post" onsubmit="return confirm('This action will activate Batch and all the students in it. Are you sure you want to continue ?');" data-toggle="validator">
                                            <input type="hidden" name="batchId" value="<?php echo $batchId;?>">
                                            <ul class="todo-list ui-sortable">
                                                <li class="">
                                                    <!-- drag handle -->
                                                    <span class="handle ui-sortable-handle">
                                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                                    </span>
                                                    <span class="text">Activate this Batch</span>
                                                    <small class="badge bg-primary"><?php echo $batchName;?></small>
                                                    <button type="submit" name="btnActivate" class="btn btn-info  btn-xs float-right">Submit</button>
                                                </li>
                                            </ul>
                                        </form>

                                    <?php }
                                    if ($isActive == 1) {
                                        ?>

                                        <table class="table table-striped">
                                            <tr>
                                                <th>Configuration</th>
                                                <th>Value</th>
                                                <th>Action</th>
                                            </tr>

                                            <?php

                                            /***
                                            * Show batch settings
                                            ***/
                                            $sql = "SELECT * FROM batch_settings WHERE batchId = '$batchId' ";
                                            $result = $link->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while($row = $result->fetch_assoc()) {
                                                    ?>

                                                    <tr>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="batchId" value="<?php echo $batchId;?>">
                                                            <td>Project Proposal Grading</td>
                                                            <td>
                                                                <select name="fyp1grading" id="fyp1grading">
                                                                    <option value="0"  <?php if ($row['fyp1_grading'] == 0){echo "selected";}?>>Not Allowed</option>
                                                                    <option value="1"  <?php if ($row['fyp1_grading'] == 1){echo "selected";}?>>Allowed</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <button type="submit" class="btn btn-info btn-sm" name="btnfyp1grading">Submit</button></td>
                                                            </form>
                                                        </tr>
                                                        <tr>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="batchId" value="<?php echo $batchId;?>">
                                                                <td>Project Defense Grading</td>
                                                                <td>
                                                                    <select name="fyp2grading" id="fyp2grading">
                                                                        <option value="0"  <?php if ($row['fyp2_grading'] == 0){echo "selected";}?>>Not Allowed</option>
                                                                        <option value="1"  <?php if ($row['fyp2_grading'] == 1){echo "selected";}?>>Allowed
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <button type="submit" class="btn btn-info btn-sm" name="btnfyp2grading">Submit
                                                                    </button>
                                                                </td>
                                                            </form>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card-footer">
                                    <a href="<?php echo $_SERVER['PHP_SELF'] ;?>" class="btn btn-default">Back</a>
                                </div>
                            </div>
                            <!-- /.card -->

                            <?php
                        } else{
                            ?>

                            <!-- general form elements -->
                            <div class="card card-primary no-border">
                                <div class="card-header  with-border">
                                    <h3 class="card-title">List of Batch</h3>
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body table-responsive">
                                    <table id="batchSetting" class="table table-hover" >
                                        <tr>
                                            <th>Batch Name</th>
                                            <th>fyp Part</th>
                                            <th>Start Date</th>
                                            <th>Status</th>
                                            <th >Actions</th>
                                        </tr>
                                        <?php
                                        $sql = "SELECT * FROM batch";
                                        $result = $link->query($sql);

                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['batchName']; ?></td>
                                                    <td><?php echo $row['fypPart']; ?></td>
                                                    <td><?php echo $row['startingDate']; ?></td>
                                                    <td>
                                                        <?php if ($row['isActive'] == 1){
                                                            echo "<span class=\"badge bg-success\">Active</span>";
                                                        }else if ($row['isActive'] == 0){
                                                            echo "<span class=\"badge bg-danger\">Inactive</span>";
                                                        }  
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo $_SERVER['PHP_SELF'].'?settings='.$row['batchId']?>" class="btn btn-primary btn-sm" >
                                                            <i class="fa fa-cog" aria-hidden="true"></i> Settings
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } ?>
                                    </table>
                                </div>
                                <!-- /.card-body -->

                            </div>
                            <!-- /.card -->

                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php include('include/footer.php'); ?>
        <!-- Control Sidebar -->

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <?php include ('include/jsFile.php'); ?>
<script>
    $(document).ready(function() {
        $('#batchSetting').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
    });

    } );


</script>
</body>