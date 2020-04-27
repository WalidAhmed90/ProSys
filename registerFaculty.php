<?php 
$title = "ProSys";
$subtitle = "Register Faculty";
session_start();
include('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnRegisterFaculty'])){
        /* Validations
        * Required name, rid
        */
        if (($_POST['name']) !="" && ($_POST['rid']) !="" && ($_POST['designation']) !="" && ($_POST['quota']) !=""){
            //Getting values from POST and sanitizing it
            $rid = filter_input(INPUT_POST,'rid',FILTER_SANITIZE_SPECIAL_CHARS);
            $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_SPECIAL_CHARS);
            $design = filter_input(INPUT_POST,'designation',FILTER_SANITIZE_SPECIAL_CHARS);
            $quota = filter_input(INPUT_POST,'quota',FILTER_SANITIZE_NUMBER_INT);
            $password = "iuk123";
            $isActive = 1;
            $isCoordinator = 1;
            //Check if faculty already exists with rid
            $check = $link->query("SELECT facultyId FROM faculty WHERE facultyRid= '$rid' LIMIT 1");
            if ($check->num_rows > 0){
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=ar');die;
            } else{
                // Set autocommit to off
                mysqli_autocommit($link, FALSE);
                if ($design == "Coordinator") {
                    // prepare and bind
                    $stmt = $link->prepare("INSERT INTO faculty (facultyName, facultyRid, designation, facultyPassword,isActive,isCoordinator ) VALUES (?, ?, ?, ?, ?,?)");
                    $stmt->bind_param("ssssii", $name, $rid, $design,$password,$isActive,$isCoordinator);
                    // set parameters and execute
                    $stmt->execute();
                    $last_id = $stmt->insert_id;
                    $currentLoad = 0;
                    //Also add to work_load
                    $stmt = $link->prepare("INSERT INTO work_load (facultyId, totalLoad, currentLoad) VALUES (?, ?, ?)");
                    $stmt->bind_param("iii", $last_id, $quota, $currentLoad);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        // Commit transaction
                        mysqli_commit($link);
                        $stmt->close();
                        $link->close();
                        header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
                    }
                } else{
                    $isCoordinator = 0;
                    // prepare and bind
                    $stmt = $link->prepare("INSERT INTO faculty (facultyName, facultyRid, designation, facultyPassword,isActive,isCoordinator ) VALUES (?, ?, ?, ?, ?,?)");
                    $stmt->bind_param("ssssii", $name, $rid, $design,$password,$isActive,$isCoordinator);
                    // set parameters and execute
                    $stmt->execute();
                    $last_id = $stmt->insert_id;
                    $currentLoad = 0;
                    //Also add to work_load
                    $stmt = $link->prepare("INSERT INTO work_load (facultyId, totalLoad, currentLoad) VALUES (?, ?, ?)");
                    $stmt->bind_param("iii", $last_id, $quota, $currentLoad);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        // Commit transaction
                        mysqli_commit($link);
                        $stmt->close();
                        $link->close();
                        header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
                    }
                }
            }
        } else{
            //Failed validations
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=validation_err');die;
        }
    }
}
?>
<head>
    <?php include('include/head.php'); ?>
    <style type="text/css">
        .ui-dialog-titlebar-close {visibility: hidden; }
    </style>
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

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (isset($_GET['status'])){
                            if ($_GET['status'] == 't'){ ?>
                                <div style="text-align:center;" class="alert alert-success" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    <p>Faculty Registered successfully!</p>
                                    <a href="./manageFacultys.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Manage Facultys</a>
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
                            } else if ($_GET['status'] == 'ar'){ ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Error! This Faculty is already registered
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Register Faculty</h3>
                            </div>
                            <div class="row pt-3">
                                <div class="col-md-12">
                                    <form id="registerFaculty" name="registerFaculty" action="" method="post" data-toggle="validator">
                                        <div class="form-group col-md-3 float-left">
                                            <input type="text" name="rid" class="form-control" placeholder="Enter Registration ID" required/>
                                        </div>
                                        <div class="form-group col-md-3 float-left">
                                            <input type="text" name="name" pattern="[a-zA-Z][a-zA-Z ]{4,}"  class="form-control" placeholder="Enter Full name" required/>
                                        </div>
                                        <div class="form-group col-md-2 float-left">
                                            <input type="number" name="quota" min="1" max="5"  class="form-control" placeholder="Student Quota" required/>
                                        </div>
                                        <div class="form-group col-md-2 float-left">
                                            <select name="designation"  id="designation" class="form-control" required>
                                                <option selected="selected" value="Supervisor">Supervisor</option>
                                                <option value="Coordinator">Coordinator</option>
                                            </select>
                                        </div>
                                        <div class="form-group float-right col-md-2">
                                            <button type="submit" name="btnRegisterFaculty" class="btn btn-primary btn-sm btn-block">Register</button>
                                        </div>
                                    </form> 
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="registerFacultys" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Faculty No</th>
                                            <th>Faculty Name</th>
                                            <th>Faculty Registration ID</th>
                                            <th>Designation</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $counter = 0;
                                    $sql = "SELECT * from faculty";
                                    $result = $link->query($sql);
                                    while($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo ++$counter?></td>
                                            <td><?php echo $row['facultyName'];?></td>
                                            <td><?php echo $row['facultyRid'];?></td>
                                            <td><?php if ($row['designation']=="Coordinator"){?><i class="badge bg-warning">Coordinator</i><?php } else{ ?><i class="badge bg-Success">Supervisor</i><?php } ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- .Content Wrapper. Contains page content -->
        <?php include('include/footer.php'); ?>
    </div>
    <!-- jQuery -->
    <?php include('include/jsFile.php'); ?>
    <!-- .jQuery -->
    <script>
        $(document).ready(function() {
            $('#registerFacultys').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
</body>