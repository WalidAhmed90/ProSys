<?php 
$title = "ProSys";
$subtitle = "Dashboard";
include ('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

  //Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (isset($_POST['addStudentTimeline'])){
        //Validations
        if ($_POST['batch'] != "" && $_POST['title'] != "" && $_POST['details'] != "" && $_POST['type'] != ""){

            //Getting values from POST
            $batchId = filter_input(INPUT_POST,'batch',FILTER_SANITIZE_NUMBER_INT);
            $title = $_POST['title'];
            $details = $_POST['details'];
            $type = $_POST['type'];

            // prepare and bind
            $stmt = $link->prepare("INSERT INTO timeline_student (title, details, type, batchId ) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $title, $details, $type, $batchId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $stmt->close();
                $link->close();
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
            }
            else{
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
            }

        }
        else{

            header('Location:' . $_SERVER['PHP_SELF'] . '?status=validation_err');die;
        }
    }

    if (isset($_POST['addFacultyTimeline'])){
        //Validations
        if ($_POST['batch'] != "" && $_POST['title'] != "" && $_POST['details'] != "" && $_POST['type'] != ""){

            //Getting values from POST
            $batchId = filter_input(INPUT_POST,'batch',FILTER_SANITIZE_NUMBER_INT);
            $title = $_POST['title'];
            $details = $_POST['details'];
            $type = $_POST['type'];

            // prepare and bind
            $stmt = $link->prepare("INSERT INTO timeline_faculty (title, details, type, batchId ) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $title, $details, $type, $batchId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $stmt->close();
                $link->close();
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
            }
            else{
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
            }

        }
        else{

            header('Location:' . $_SERVER['PHP_SELF'] . '?status=validation_err');die;
        }

    }


    if (isset($_POST['editStudentTimeline'])){

        //Validations
        if ($_POST['title'] != "" && $_POST['details'] != "" && $_POST['type'] != "" ){

            $id = filter_input(INPUT_POST,'editId',FILTER_SANITIZE_NUMBER_INT);

            //Getting values from POST
            $title = $_POST['title'];
            $details = $_POST['details'];
            $type = $_POST['type'];

            // prepare and bind
            $stmt = $link->prepare("UPDATE timeline_student SET title=?, details=?, type=? WHERE id=? ");
            $stmt->bind_param("sssi", $title, $details, $type, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $stmt->close();
                $link->close();
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
            }
            else{
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
            }

        }
        else{

            header('Location:' . $_SERVER['PHP_SELF'] . '?status=validation_err');die;
        }

    }


    if (isset($_POST['editFacultyTimeline'])){
        //Validations

        if ($_POST['title'] != "" && $_POST['details'] != "" && $_POST['type'] != "" ){

            $id = filter_input(INPUT_POST,'editId',FILTER_SANITIZE_NUMBER_INT);
            //echo $id;exit;

            //Getting values from POST
            $title = $_POST['title'];
            $details = $_POST['details'];
            $type = $_POST['type'];

            // prepare and bind
            $stmt = $link->prepare("UPDATE timeline_faculty SET title=?, details=?, type=? WHERE id=? ");
            $stmt->bind_param("sssi", $title, $details, $type, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $stmt->close();
                $link->close();
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
            }
            else{
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
            }

        }
        else{

            header('Location:' . $_SERVER['PHP_SELF'] . '?status=validation_err');die;
        }

    }

    if (isset($_POST['btnDeleteSt'])){
        $id = filter_input(INPUT_POST,'deleteId',FILTER_SANITIZE_NUMBER_INT);

        // sql to delete a record
        $sql = "DELETE FROM timeline_student WHERE id= '$id'";

        if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
        }

    }



    if (isset($_POST['btnDeleteFa'])){
        $id = filter_input(INPUT_POST,'deleteId',FILTER_SANITIZE_NUMBER_INT);

        // sql to delete a record
        $sql = "DELETE FROM timeline_faculty WHERE id= '$id' ";

        if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
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
         <section class="content" style="min-height: 700px">

            <div class="row">
                <div class="col-md-12">

                <div class="col-md-6 col-xs-6 float-left">
                  <!-- small box -->
                  <div class="small-box bg-purple">
                      

                        <form method="get">
                            <input type="hidden" name="student" value="student">
                            <button type="submit" class="btn bg-purple btn-block" value="student"> student</button>
                        </form>

                       
                      
                 
              </div>
             </div>

              <div class="col-md-6 col-xs-6 float-left">
                  <!-- small box -->
                  <div class="small-box bg-primary">
                     
                          <form method="get">
                            <input type="hidden" name="faculty" value="faculty">
                            <button type="submit" class="btn bg-primary btn-block" value="faculty"> faculty</button>
                        </form>
                       
                      
                 
              </div>
                    
                </div>
            </div>

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
                        else if ($_GET['status'] == 'validation_err'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! Please fill all the required fields correctly
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

                    <?php if (isset($_GET['stDetails']) && is_numeric($_GET['stDetails']) && strlen($_GET['stDetails'])>0){
                        $detailsId = filter_input(INPUT_GET,'stDetails',FILTER_SANITIZE_NUMBER_INT);
                        $sql = "SELECT * FROM timeline_student WHERE id='$detailsId' LIMIT 1 ";
                        $result = $link->query($sql);

                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $title = $row['title'];
                                $details = $row['details'];
                                $type = $row['type'];
                                $createdDtm = $row['createdDtm'];


                            }
                        } else {
                            $title = "--";
                            $details = "--";
                            $type = "--";
                            $createdDtm = "--";

                        }

                        ?>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><?php echo $title;?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo $type;?>
                                        <?php echo $details;?>
                                        <br/>

                                        <p >Created : <?php echo $createdDtm; ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } ?>

                    <?php if (isset($_GET['faDetails']) && is_numeric($_GET['faDetails']) && strlen($_GET['faDetails'])>0){
                        $detailsId = filter_input(INPUT_GET,'faDetails',FILTER_SANITIZE_NUMBER_INT);
                        $sql = "SELECT * FROM timeline_faculty WHERE id='$detailsId' LIMIT 1 ";
                        $result = $link->query($sql);

                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $title = $row['title'];
                                $details = $row['details'];
                                $type = $row['type'];
                                $createdDtm = $row['createdDtm'];


                            }
                        } else {
                            $title = "--";
                            $details = "--";
                            $type = "--";
                            $createdDtm = "--";

                        }

                        ?>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><?php echo $title;?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo $type;?>
                                        <?php echo $details;?>
                                        <br/>

                                        <p >Created : <?php echo $createdDtm; ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } ?>


                    <?php
                        if (isset($_GET['stEdit']) && is_numeric($_GET['stEdit']) && strlen($_GET['stEdit'])>0){
                            /************************
                             * EDIT timeline_student
                             ************************/

                            $id = filter_input(INPUT_GET,'stEdit',FILTER_SANITIZE_NUMBER_INT);

                            $sql = "SELECT * FROM timeline_student WHERE id = '$id' LIMIT 1";
                            $result = $link->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    $title = $row['title'];
                                    $details = $row['details'];
                                    $type = $row['type'];
                                    $batchId = $row['batchId'];
                                    $fypPart = $row['fypPart'];
                                }
                            }
                            ?>
                            <!-- general form elements -->
                            <div class="card card-primary card-outline no-border">
                                <div class="card-header with-border">
                                    <h3 class="card-title"><i class="fa fa-edit" aria-hidden="true"></i> Edit: <?php echo $title;?></h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form class="form-horizontal"  action=""  method="post" onsubmit="return confirm('Are you sure you want to submit these changes?');" data-toggle="validator" >
                                    <input type="hidden" name="editId" value="<?php echo $id;?>">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label">Title</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"  name="title" value="<?php echo $title;?>" required>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Details</label>

                                            <div class="col-sm-10">
                                                <textarea class="textarea" name="details"  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                                    <?php echo $details;?>
                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label">Type</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"  name="type" value="<?php echo $type;?>">
                                            </div>
                                        </div>



                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default">Cancel</a>
                                        <button type="submit" name="editStudentTimeline" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                    <!-- /.card-footer -->
                                </form>

                            </div>
                            <!-- /.card -->

                        <?php
                        }

                        else if (isset($_GET['faEdit']) && is_numeric($_GET['faEdit']) && strlen($_GET['faEdit'])>0){
                            /************************
                             * EDIT timeline_faculty
                             ************************/
                            $id = filter_input(INPUT_GET,'faEdit',FILTER_SANITIZE_NUMBER_INT);

                            $sql = "SELECT * FROM timeline_faculty WHERE id = '$id' LIMIT 1";
                            $result = $link->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    $title = $row['title'];
                                    $details = $row['details'];
                                    $type = $row['type'];
                                    $batchId = $row['batchId'];
                                    $fypPart = $row['fypPart'];
                                }
                            }
                            ?>
                            <!-- general form elements -->
                            <div class="card no-border">
                                <div class="card-header with-border">
                                    <h3 class="card-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit: <?php echo $title;?></h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form class="form-horizontal"  action=""  method="post" onsubmit="return confirm('Are you sure you want to submit these changes?');" data-toggle="validator" >
                                    <input type="hidden" name="editId" value="<?php echo $id;?>">
                                    <div class="card-body">


                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label">Title</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"  name="title" value="<?php echo $title;?>" required>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Details</label>

                                            <div class="col-sm-10">
                                                <textarea class="textarea" name="details"  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                                    <?php echo $details;?>
                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label">Type</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="type" value="<?php echo $type;?>">
                                            </div>
                                        </div>



                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default">Cancel</a>
                                        <button type="submit"  name="editFacultyTimeline" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                    <!-- /.card-footer -->
                                </form>

                            </div>
                            <!-- /.card -->
                        <?php
                        }

                        else if (isset($_GET['stAdd'])){
                            /************************
                             * ADD timeline_student
                             ************************/
                            ?>
                            <div class="card no-border card-primary card-outline">
                                <div class="card-header with-border">
                                    <h3 class="card-title"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Student Timeline</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form class="form-horizontal"  action=""  method="post" onsubmit="return confirm('Are you sure you want to submit these changes?');" data-toggle="validator" >
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label">Batch</label>

                                            <div class="col-sm-10">
                                                <select name="batch" id="batch" style="width: 400px;" required>
                                                    <?php
                                                    $sql = "SELECT * FROM batch";
                                                    $result = $link->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while($row = $result->fetch_assoc()) { ?>
                                                            <option value="<?php echo $row['batchId'];?>"><?php echo $row['batchName'];?></option>
                                                        <?php
                                                        }
                                                    }                                                    
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>


                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label">Title</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"  name="title" placeholder="Enter title" required>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Details</label>

                                            <div class="col-sm-10">
                                                <textarea class="textarea" name="details" placeholder="Enter details here"  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required>

                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label">Type</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="type" placeholder="Type of notification e.g info,task,other" required>
                                            </div>
                                        </div>



                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default">Cancel</a>
                                        <button type="submit" name="addStudentTimeline" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                    <!-- /.card-footer -->
                                </form>

                            </div>


                        <?php
                        }
                        else if (isset($_GET['faAdd'])){
                            /************************
                             * ADD timeline_faculty
                             ************************/
                            ?>
                            <div class="card no-border card-primary card-outline">
                                <div class="card-header with-border">
                                    <h3 class="card-title"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Faculty Timeline</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form class="form-horizontal" action=""  method="post" onsubmit="return confirm('Are you sure you want to submit these changes?');"  data-toggle="validator">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label">Batch</label>

                                            <div class="col-sm-10">
                                                <select name="batch" id="batch" style="width: 400px;" required>
                                                    <?php
                                                    $sql = "SELECT * FROM batch";
                                                    $result = $link->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while($row = $result->fetch_assoc()) { ?>
                                                            <option value="<?php echo $row['batchId'];?>"><?php echo $row['batchName'];?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label">Title</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"  name="title" placeholder="Enter title" required>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Details</label>

                                            <div class="col-sm-10">
                                                <textarea class="textarea" name="details" placeholder="Enter details here"  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required>

                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label">Type</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="type" placeholder="Type of notification e.g info,task,other" required>
                                            </div>
                                        </div>



                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default">Cancel</a>
                                        <button type="submit"  name="addFacultyTimeline" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                    <!-- /.card-footer -->
                                </form>

                            </div>
                        <?php
                        }
                        else{ ?>

                            <?php if (isset($_GET['student'])) {
                
                             ?>
                            <!-- Student Timeline -->
                            <div class="card  card-primary">
                                <div class="card-header with-border">
                                    <h3 class="card-title">Student Timeline</h3>
                                </div>
                                <!-- /.card-header -->
                            <div class="card-body table-responsive ">
                                <table id="studentTimeline" class="table   table-striped">
                                <thead>
                                    <tr>
                                            <th>Title</th>
                                            <th>Details</th>
                                            <th>Type</th>
                                            <th>Batch</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    
                                </thead>
                                        
                                        <?php
                                        $sql = "SELECT * FROM timeline_student ORDER BY createdDtm DESC";
                                        $result = $link->query($sql);

                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while($row = $result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td width="20%"><?php echo $row['title'];?></td>
                                                    <td width="40%">
                                                        <?php if (strlen($row['details']) > 150){
                                                            echo getExcerpt($row['details'],0,150); ?>
                                                            <a href="<?php echo "manageTimeline.php?stDetails=".$row["id"] ;?>">Show More</a>
                                                            <?php
                                                        }
                                                        else{
                                                            echo $row['details'];
                                                        }
                                                        ?>
                                                    </td>

                                                    <td width="10%"><?php echo $row['type'];?></td>
                                                    <td width="10%">
                                                        <?php
                                                        $batchId= $row['batchId'];
                                                        if (strlen($batchId)>0 && is_numeric($batchId) && $batchId != 0){
                                                            echo $link->query("SELECT batchName FROM batch WHERE batchId = '$batchId' LIMIT 1")->fetch_object()->batchName;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td width="20%"><?php echo time2str($row['createdDtm']);?></td>
                                                    <td><a href="<?php echo $_SERVER['PHP_SELF'] . '?stEdit=' . $row['id']; ?>"   class="btn  btn-default btn-flat  btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                                        <form  action="" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');" data-toggle="validator">
                                                            <input type="hidden" name="deleteId" value="<?php echo $row['id'];?> ">
                                                            <button type="submit" name="btnDeleteSt" class="btn  btn-danger btn-flat  btn-xs"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <?php
                                            }
                                        }
                                        ?>


                                    </table>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <a href="manageTimeline.php?stAdd" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New</a>
                                </div>

                            </div>
                            <!-- /.card -->
                                <?php  } ?>

                                <?php if (isset($_GET['faculty'])) {
                
                             ?>
                            <!-- Faculty Timeline -->
                            <div class="card  card-primary">
                                <div class="card-header with-border">
                                    <h3 class="card-title">Faculty Timeline</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive ">
                                <table id="facultyTimeline" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Details</th>
                                            <th>Type</th>
                                            <th>Batch</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                        
                                    </thead>
                                        
                                        <?php
                                        $sql = "SELECT * FROM timeline_faculty ORDER BY createdDtm DESC";
                                        $result = $link->query($sql);

                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while($row = $result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><?php echo $row['title'];?></td>
                                                    <td>
                                                        <?php if (strlen($row['details']) > 150){
                                                            echo getExcerpt($row['details'],0,150); ?>
                                                            <a href="<?php echo "manageTimeline.php?faDetails=".$row["id"] ;?>">Show More</a>
                                                            <?php
                                                        }
                                                        else{
                                                            echo $row['details'];
                                                        }
                                                        ?>
                                                    </td>

                                                    <td><?php echo $row['type'];?></td>
                                                    <td>
                                                        <?php
                                                        $batchId= $row['batchId'];
                                                        if (strlen($batchId)>0 && is_numeric($batchId) && $batchId != 0){
                                                            echo $link->query("SELECT batchName FROM batch WHERE batchId = '$batchId' LIMIT 1")->fetch_object()->batchName;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo$row['createdDtm'];?></td>
                                                    <td><a href="<?php echo $_SERVER['PHP_SELF'] . '?faEdit=' . $row['id']; ?>"   class="btn  btn-default btn-flat  btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                                        <form  action="" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');" data-toggle="validator">
                                                            <input type="hidden" name="deleteId" value="<?php echo $row['id'];?> ">
                                                            <button type="submit" name="btnDeleteFa" class="btn  btn-danger btn-flat  btn-xs"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <?php
                                            }
                                        }
                                        ?>


                                    </table>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <a href="manageTimeline.php?faAdd" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New</a>
                                </div>

                            </div>
                            <!-- /.card -->


                        <?php
                        }
                    }
                    ?>







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
        $('#studentTimeline').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
    });

     $('#facultyTimeline').DataTable({
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
</html>