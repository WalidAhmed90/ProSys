<?php
$title="ProSys";
$subtitle="Manage Faculty";
include('db/db_connect.php');
include("mysql_table.php");
include("include/functions.php");
session_start();
if(!isset($_SESSION['user_id']))
{
    header("location: login.php");
}


//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['btnDelete'])){

        //Getting value from POST and sanitizing
        $deleteId = filter_input(INPUT_POST,'deleteId',FILTER_SANITIZE_NUMBER_INT);


        //Check if faculty is supervising any group
        $sql = "SELECT facultyId FROM faculty_student_group WHERE facultyId= '".$deleteId."' LIMIT 1";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            //Faculty is supervising a group
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=n');die;
        } else {
            //Delete faculty
            // sql to delete a record
            $sql = "DELETE FROM faculty WHERE facultyId= '$deleteId' LIMIT 1";

            if ($link->query($sql) === TRUE) {
              //Also delete record from work_load
                $sql = "DELETE FROM work_load WHERE facultyId='$deleteId' ";

                if ($link->query($sql) === TRUE) {
                    header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
                }
            }
        }

    }

    if (isset($_POST['btnEditFaculty'])){
        //Validations
        if ($_POST['name']!="" && $_POST['designation']!="" && $_POST['email']!=""  && $_POST['quota'] !="" ){
            //Getting values from POST and sanitizing
            $editId = filter_input(INPUT_POST,'editId',FILTER_SANITIZE_NUMBER_INT);
            $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_SPECIAL_CHARS);
            $designation = filter_input(INPUT_POST,'designation',FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
            $contact = filter_input(INPUT_POST,'contact',FILTER_SANITIZE_NUMBER_INT);
            $quota = filter_input(INPUT_POST,'quota',FILTER_SANITIZE_NUMBER_INT);
            $designation = filter_input(INPUT_POST,'designation',FILTER_SANITIZE_NUMBER_INT);
            // prepare and bind
            $stmt = $link->prepare("UPDATE  faculty JOIN work_load ON faculty.facultyId= work_load.facultyId SET facultyName = ?, designation = ?,facultyEmail = ?, facultyPhoneNo = ?,  totalLoad =?, designation=? WHERE faculty.facultyId = ?");
            $stmt->bind_param("ssssiii", $name, $designation,$email,$contact, $quota,$designation,$editId);


            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $stmt->close();
                $link->close();
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
            }

        }
        else{
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=validation_err');die;
        }



    }


}



?>
<head>
  <?php include('include/head.php'); ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
 <!-- Navbar -->
    <?php include('include/navbar.php'); ?>
    <!-- .Navbar -->

    <!-- Main Sidebar Container -->
    <?php include('include/sidebar.php'); ?>
    <!-- .Main Sidebar Container -->
     <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
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
                                Error! This faculty is supervising a group. Can not delete this
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

                    <?php if (isset ($_GET['edit']) && is_numeric($_GET['edit']) && strlen($_GET['edit'])>0 )  {
                        $editId = filter_input(INPUT_GET,'edit',FILTER_SANITIZE_NUMBER_INT);
                        $facultyName = null;

                        $sql = "SELECT * FROM faculty JOIN work_load WHERE faculty.facultyId = work_load.facultyId AND faculty.facultyId = '$editId' LIMIT 1 ";
                        $result = $link->query($sql);

                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $facultyName = $row['facultyName'];
                                $designation = $row['designation'];
                                $email = $row['facultyEmail'];
                                $password = $row['facultyPassword'];
                                $contact = $row['facultyPhoneNo'];
                                $quota = $row['totalLoad'];
                                $designation = $row['designation'];
                            }
                        }
                        ?>
                        <!-- general form elements -->
                        <div class="card no-border">
                            <div class="card-header with-border">
                                <h3 class="card-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit: <?php echo $facultyName;?> </h3>
                            </div>

                            <form class="form-horizontal" name="editFaculty" action=""  method="post" onsubmit="return confirm('Are you sure you want to submit these changes?');" data-toggle="validator" >
                                <input type="hidden" name="editId" value="<?php echo $editId; ?>">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $facultyName;?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Designation</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="designation" name="designation" value="<?php echo $designation;?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>

                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email;?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">


                                        <label class="col-sm-2 control-label">Password <i class="fa fa-eye text-primary" id="eye" aria-hidden="true"></i> </label>
                                        <div class="col-sm-10 " >

                                            <input type="password"  class="form-control" id="password" name="password" value="<?php echo $password ;?>"  required>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Contact</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact;?>" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Supervising Quota</label>

                                        <div class="col-sm-10">
                                            <input type="number" min="0" max="5" class="form-control" id="quota" name="quota" value="<?php echo $quota ;?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Status</label>

                                        <div class="col-sm-10">
                                            <select name="designation" id="designation" style="width:200px;" required>
                                                <option value="1" <?php if ($designation==1){echo 'selected';}?>>Active</option>
                                                <option value="0" <?php if ($designation==0){echo 'selected';}?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>





                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn  btn-default btn-sm  "> Cancel</a>
                                    <button type="submit" name="btnEditFaculty" class="btn btn-primary float-right">Submit</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>

                        </div>
                        <!-- /.card -->
                    <?php
                    }else{
                        
                    }?>

                    <div class="card card-primary ">
                        <div class="card-header">
                            <h3 class="card-title">Faculty List</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive ">
                                <table id="manageFaculty" class="table table-head-fixed text-nowrap">
                                    <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <?php
                                $sql = "SELECT * from faculty WHERE designation != 1 "; //Exclude SuperAdmin from the list
                                $result = $link->query($sql);
                                while($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['facultyName'] ; if ($row["isCoordinator"] == 1){echo ' <span class="badge bg-primary">Coordinator</span>';}
                                        else
                                        {
                                            echo ' <span class="badge bg-success">Supervisor</span>';
                                        }
                                        ?></td>
                                        <td><?php echo $row['facultyEmail'] ;?></td>
                                        <td><?php
                                            if ($row['isActive'] == 1){ ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php
                                            }
                                            else if ($row['isActive'] == 0){ ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php
                                            }
                                            ;?></td>
                                        <td>
                                            <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $row['facultyId']; ?>"   class="btn  btn-default btn-block  btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                            <form  action="" method="post" onsubmit="return confirm('Are you sure you want to delete this faculty?');" data-toggle="validator">
                                                <input type="hidden" name="deleteId" value="<?php echo $row['facultyId'];?> ">
                                                <button type="submit" name="btnDelete" class="btn  btn-danger btn-block  btn-xs"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                            </form>

                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="./registerFaculty.php" class="btn btn-primary btn-sm float-right">Add New Faculty</a>
                            <a href="<?php echo siteroot; ?>" class="btn  btn-default btn-sm  "> Back</a>

                        </div>
                    </div>
                    <!-- /.card -->

                </div>

            </div>
        </section>
    </div><!-- ./content-wrapper -->
<!--</div>-->
<?php
include('include/footer.php');
?>
</div>
<!-- ./wrapper -->
<?php
include('include/jsFile.php');
?>
<script>
   $(document).ready(function() {
        $('#manageFaculty').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
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
</body>
</html>