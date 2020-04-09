<?php 
$title = "ProSys";
$subtitle = "Register Student";
session_start();
include('db/db_connect.php');
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['btnRegisterStudent'])){
        /* Validations
        * Required name, rid
        */


        if (($_POST['name']) !="" && $_POST['rid'] !="" && $_POST['batchId'] !="" ){

            //Getting values from POST and sanitizing it
            $rid = filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
            $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_SPECIAL_CHARS);
            $batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);
            $password = "iuk123";


            //Check if student already exists with email & rid
            $sql = "SELECT * FROM student WHERE (studentRid = '$rid') AND isActive = 1 LIMIT 1";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                //Student Already Registered
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=ar');die;
            } else {
                //Student not registered already

                //other values
                $isActive = 1;

                // prepare and bind
                $stmt = $link->prepare("INSERT INTO student (studentName, studentRid,studentPassword, batchId, isActive) VALUES (?, ?,?, ?, ?)");
                $stmt->bind_param("sssii", $name, $rid,$password,$batchId, $isActive);

                $stmt->execute();
                  
                   $stmt->close();
                   $link->close();
                   header('Location:' . $_SERVER['PHP_SELF'] . '?batchId='.$batchId.'&status=t');die;
                 
 }



        }
        else{
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=e');die;
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
                                <p>Student Registered successfully!</p>
                                <a href="./manageStudents.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Manage Students</a>
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
                        else if ($_GET['status'] == 'ar'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! This student is already registered
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                
                    }

                ?>

             


                      <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h3 class="card-title">List of batches</h3>

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

                          
                          <div class="row pt-3">
                            <div class="col-md-12">
                            <?php if (isset($_GET['batchId']) && is_numeric($_GET['batchId']) && strlen($_GET['batchId'])){
                            $batchId = filter_input(INPUT_GET,'batchId',FILTER_SANITIZE_NUMBER_INT);
                            ?>

                          <form id="registerStudent" name="registerStudent" action="" method="post" data-toggle="validator">

                            <div class="form-group col-md-4 float-left">
                                <input type="text" name="rid" class="form-control" placeholder="Enter Registration ID" required/>
                                
                            </div>

                            <div class="form-group col-md-4 float-left">
                                <input type="text" name="name" pattern="[a-zA-Z][a-zA-Z ]{4,}"  class="form-control" placeholder="Enter Full name" required/>
                            </div>
                            <div class="form-group col-md-2 float-left">
                                <select name="batchId"  id="batchId" class="form-control" required>
                                                <?php
                                                $sql = "SELECT * FROM batch WHERE  batchId = '$batchId'";
                                                $result = $link->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) { ?>
                                                        <option value="<?php echo $row['batchId']; ?>" >
                                                            <?php echo $row['batchName'];?>
                                                        </option>
                                                        <?php
                                                    }
                                                  }
                                                
                                                ?>
                                            </select>
                            </div>

                           <div class="form-group float-right col-md-2">
                                <button type="submit" name="btnRegisterStudent" class="btn btn-primary btn-sm btn-block">Register</button>
                                </div>
                              <?php } ?>

                        </form> 
                                </div>
                            </div>


                                <div class="card-body table-responsive">
                                    <table id="registerStudents" class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>Student No</th>
                                            <th>Student Name</th>
                                            <th>Student Registration ID</th>
                                        </tr>
                                        </thead>

                                        <?php
                                        $counter = 0;
                                        if (isset($_GET['batchId']) && is_numeric($_GET['batchId']) && strlen($_GET['batchId'])){
                                        $batchId = filter_input(INPUT_GET,'batchId',FILTER_SANITIZE_NUMBER_INT);

                                        $sql = "SELECT * from student  WHERE student.batchId  = '$batchId'";
                                        $result = $link->query($sql);
                                        while($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo ++$counter?></td>
                                                <td><?php echo $row['studentName'];?></td>
                                                <td><?php echo $row['studentRid'];?></td>
                                            </tr>
                                             <?php
                            }
                            }?>
                                       
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
        $('#registerStudents').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false,
    });


    } );


</script>


  </body>
</html>
