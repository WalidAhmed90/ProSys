<?php 
$title = "ProSys";
$subtitle = "Create Project";
include('db/db_connect.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: login.php");
  }
//Getting Values from SESSION
$batchId = $_SESSION['batchId'];
$studentId = $_SESSION['usrId'];


    $check = true;
    /* Check if:
     * - User already initiated a group
     * - User is already in a group
     * - User sent request to group
     */

    //Check for request sent already
    $sql = "SELECT * FROM student_group_request WHERE studentId = '$studentId' LIMIT 1";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        //User sent request to group already
        $check = false;
    } else {
        //Check if group leader or in a group
        $sql = "SELECT * FROM student WHERE studentId = '$studentId' LIMIT 1";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $isLeader = $row['isLeader'];
                $groupId = $row['groupId'];
            }
        }
        if ($isLeader == 1 OR !is_null($groupId)){
            $check = false;
        }
        else{
            //$check = true;
        }

    }






//    $sql = "SELECT * FROM student WHERE batchId = '$batchId' AND studentId = '$studentId' LIMIT 1";
//    $result = $link->query($sql);
//
//    if ($result->num_rows > 0) {
//        while($row = $result->fetch_assoc()) {
//            if ($row['isLeader'] == 1){
//
//                //User is already initiated a group
//                $check = false;
//            }
//            else if (!is_null($row['groupId'])){
//                //User is already in a group
//                $check = false;
//            }
//            else{
//                $check = true;
//
//                $sql = "SELECT studentId FROM student_group_request WHERE studentId = '$studentId' LIMIT 1";
//                $result = $link->query($sql);
//
//                if ($result->num_rows > 0) {
//                    //User already sent request to group
//                    $check = false;
//                }else{
//                    $check = true;
//                }
//            }
//        }
//    }



/*echo "<script>alert('$ProjectName, $categories,$description,$other_txt')</script>"; */
    if (isset($_POST['createProjectbtn'])){
        
       if (($_POST['ProjectName']!="") && ($_POST['categories']!="") && ($_POST['description']!=""))
        {
           $projectName = $_POST['ProjectName'];
           $categories = $_POST['categories'];
           $description = $_POST['description'];
           $other_txt = $_POST['other_txt'];

             if ($categories == "Other") 
             {
                $sql = "INSERT INTO student_group (projectName,categories,description,batchId, leaderId)
                VALUES ('$projectName','$other_txt','$description', '$batchId', '$studentId')";

                if ($link->query($sql) === TRUE) {

                //Get last insert_id = groupId
                $groupId = $link->insert_id;

                //Set groupId and isLeader in student table
                $sql = "UPDATE student SET groupId='$groupId' , isLeader = '1' WHERE studentId = '$studentId' ";

                if ($link->query($sql) === TRUE) {

                    // Commit transaction
                    mysqli_commit($link);

                    //Close linkection
                    $link->close();

                    //Redirect with success message
                    header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
                } else {
                    //Redirect with error message
                    header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
                }

            }

               
             }
             else
             {

              $sql = "INSERT INTO student_group (projectName,categories,description,batchId, leaderId)
                VALUES ('$projectName','$categories','$description', '$batchId', '$studentId')";

                if ($link->query($sql) === TRUE) {

                //Get last insert_id = groupId
                $groupId = $link->insert_id;

                //Set groupId and isLeader in student table
                $sql = "UPDATE student SET groupId='$groupId' , isLeader = '1' WHERE studentId = '$studentId' ";

                if ($link->query($sql) === TRUE) {

                    // Commit transaction
                    mysqli_commit($link);

                    //Close linkection
                    $link->close();

                    //Redirect with success message
                    header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
                } else {
                    //Redirect with error message
                    header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
                }

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
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <p>Changes saved successfully!</p>
                                <a href="./groupDetails.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Show Group Details</a>
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                            <?php
                        }
                        else if ($_GET['status'] == 'cp'){ ?>
                            <div style="text-align:center;" class="alert alert-success" role="alert">
                              <button type="button" class="close" data-dismiss="alert">x</button>
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <p>Project deleted successfully!</p>
                                <p>Create another one thank you.</p>
                                
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
                        else if ($_GET['status'] == 'req'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! Please fill all required fields
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

            <?php if(isset($check)){
                        if ($check == true){ ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Project</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form  id="initiateGroup" name="initiateGroup" method="post" data-toggle="validator">
                <div class="card-body">
                  <div class="form-group">
                    <label for="SetGroupName">Set Group Name</label>
                    <input type="text" name="ProjectName" class="form-control" id="setprojectname" placeholder="Enter Project Name" required>
                    <p class="text-muted">you can change project name later.</p>
                  </div>

                  <!-- Project categories -->
                     <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Please select from the following technology in which your project belongs.</label>
                  <select type="text" name="categories" class="form-control select2bs4" id="other" style="width: 100%;">
                    <option selected="selected">3D/4D Printing</option>
                    <option value="3D/4D Printing">3D/4D Printing</option>
                    <option value="Big Data">Big Data</option>
                    <option value="Artificial Intelligence">Artificial Intelligence</option>
                    <option value="Cloud">Cloud</option>
                    <option value="Robotics">Robotics</option>
                    <option value="The Internet Of Things">The Internet Of Things</option>
                    <option value="Augmented Reality/Virtual Reality">Augmented Reality/Virtual Reality</option>
                    <option value="Block Chain">Block Chain</option>
                    <option value="Neurotech">Neurotech</option>
                    <option value="Shared Economy">Shared Economy</option>
                    <option value="Wearables">Wearables</option>
                    <option value="Implantable">Implantable</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Other Option -->
            <div class="form-group" id="other_txt">
                        <label>Other Categories.</label>
                        <input name="other_txt" type="text" class="form-control" placeholder="Enter ...">
                      </div>


                <!-- .Project categories -->

                <!-- Project Description -->
                      <div class="form-group">
                        <label>Project Description.</label>
                        <textarea type="text" name="description" class="form-control" rows="6" placeholder="Enter Project description here..."></textarea>
                      </div>


                <!-- ./Project Description -->

                <!-- /.card-body -->
                      <div class="card-footer">
                        <button type="submit" form="initiateGroup" name="createProjectbtn" class="btn btn-primary float-right form-group">Create Project</button>
                      </div>
                      

                </div>
              </form>

            </div>
            <!-- /.card -->
            <?php
                        }
                        else if ($check == false){ ?>
          
          <!--/.col (left) -->
          <!-- general form elements -->
                            <div class="card no-border">
                                <div class="card-header with-border">
                                    <h3 class="card-title">Initiate Group</h3>
                                </div>
                                <!-- /.card-header -->

                                    <div class="card-body">
                                        <h3>You can not initiate a group</h3>
                                        <ul>
                                            <li>You are either part of a Project group</li>
                                            <li>You have sent request to a group</li>
                                            <li>You initiated a group already</li>
                                        </ul>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">

                                    </div>

                            </div>
                            <!-- /.card -->
                        <?php
                        }
                    }?>
                    </div>

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

    })
</script>
<script>
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue == "Other"){
                $("#other_txt").show();
            } else{
                $("#other_txt").hide();
            }
        });
    }).change();
});
</script>
</body>
</html>