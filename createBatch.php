<?php 
$title = "ProSys";
$subtitle = "Create Batch";
include('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }

    if (isset($_POST['btnCreateBatch'])){
        
        if(($_POST['batch']!="") && ($_POST['year']!="") && ($_POST['startingDate']!=""))
        {

            
            $batch = $_POST['batch'];
            $batchYear = $_POST['year'];

            $batchName = $batch ." ". $batchYear;


            
            $startingDate = $_POST['startingDate'];
            $isActive = 1;
            $fypPart = 1;

            //Check if BATCH already exists
            $sql = "SELECT batchId FROM batch WHERE batchName ='$batchName' LIMIT 1";

            $result = mysqli_query($link,$sql);

            if (mysqli_num_rows($result) > 0) {

                //Batch Already Exist
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=a');
            }else{

              
                $stmt = mysqli_prepare($link,"INSERT INTO batch (batchName, startingDate, isActive, fypPart) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt,"ssii", $batchName, $startingDate, $isActive, $fypPart);
                mysqli_stmt_execute($stmt);

                if (mysqli_affected_rows($link) > 0) {

                    $last_id = mysqli_insert_id($link);
                    $sql = "INSERT INTO batch_settings (batchId) VALUES ('$last_id')";

                    if (mysqli_query($link,$sql) === TRUE) {

                       
                        if (!file_exists('uploads/'.$batchName)) {
                            mkdir('uploads/'.$batchName, 0777, true);

                           
                            mysqli_close($stmt);
                            mysqli_close($link);
                            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');die;
                        }
                    }


                }
                else{
                   
                    header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
                    printf("Error: %s.\n", mysqli_error($stmt));exit;
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include ('include/contentheader.php'); ?>
    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
      <div class="row">


       
          <!-- left column -->
          <div class="col-md-12">

                 <?php
        if (isset($_GET['status'])){
            if ($_GET['status'] == 't'){ ?>
                <div style="text-align:center;" class="alert alert-success" role="alert">
                    <p><i class="fas fa-exclamation"></i> Batch Created successfully!</p>
                    <a href="registerStudent.php"> <i class="fa fa-chevron-right" aria-hidden="true"></i> Register Students</a>
                    <br/>
                    <a href="#"><i class="fa fa-chevron-right" aria-hidden="true"></i> Add Batch Tasks</a>
                    <button type="button" class="close" data-dismiss="alert">x</button>
                </div>
                <?php
            }
            else  if ($_GET['status'] == 'f'){ ?>
                <div style="text-align:center;" class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation"></i>
                    Error! Something Went Wrong
                    <button type="button" class="close" data-dismiss="alert">x</button>
                </div>
                <?php
            }
            else if ($_GET['status'] == 'a'){ ?>
                <div style="text-align:center;" class="alert alert-danger" role="alert">
                  <i class="fas fa-exclamation"></i>
                    Error! Batch Already Exist
                    <button type="button" class="close" data-dismiss="alert">x</button>
                </div>
                <?php
            }
            else if ($_GET['add'] == 'e'){ ?>
                <div style="text-align:center;" class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation"></i>
                    Error!
                    <button type="button" class="close" data-dismiss="alert">x</button>
                </div>
                <?php
            }

        }
        ?>

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Batch</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="" id="CreateProject" data-toggle="validator">
                <div class="card-body">

                  <!-- Batch Selection -->
                     <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Batch</label>
                  <select class="form-control" style="width: 100%;" required name="batch" id="batch">
                    <option selected="selected" value="Spring">Spring</option>
                    <option value="Fall">Fall</option>
                  </select>
                </div>
              </div>
            </div>

              <div class="form-group">
                  <label>Year</label>
                  <select name="year" id="year" type="text" class="form-control" required>
                    <option selected value="<?php echo(date('Y')-1); ?>"><?php echo(date('Y')-1); ?></option>
                    <option selected value="<?php echo(date('Y')); ?>"><?php echo(date('Y')); ?></option>
                  </select>
                </div>

                <!-- starting date -->

                <div class="form-group">
                  <label>Starting date of semeter</label>
                  <input class="form-control" type="date" name="startingDate"  id="startingDate" required>
                </div>

                <!-- .starting date -->
           
                <!-- .Project categories -->

                

                <!-- /.card-body -->
                      <div class="card-footer form-group">
                        <button type="submit" name="btnCreateBatch" class="btn btn-primary float-right">Create Batch</button>
                      </div>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
        <div class="col-md-6">

        </div>
          <!--/.col (right) -->
      </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
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
   $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    });

</script>
</body>
</html>