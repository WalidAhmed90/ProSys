<?php 
$title="ProSys";
$subtitle="Profile";
include("db/db_connect.php");
session_start();

if(!isset($_SESSION["user_id"]))
{
    header('Location: '.'index.php');
}
//Getting values from DB
$designation = $_SESSION['designation'];
$name = $_SESSION['usrnm'];
$email = $_SESSION['usremail'];
$contact = $_SESSION['usrcell'];
$image = $_SESSION['image'];

//Code implementation for remove photo
if (isset($_POST['btnDelete'])){
    $sql_remove='UPDATE faculty SET facultyImage=? WHERE facultyId=?';
    $user_id=$_SESSION['facultyId'];
    $dummy_image=null;
    $stmt_remove = $link->prepare($sql_remove);
    if($stmt_remove === false) {
        trigger_error('Wrong SQL: ' . $sql_remove . ' Error: ' . $link->error, E_USER_ERROR);
    }
    $stmt_remove->bind_param('ss',$dummy_image,$user_id);
    $stmt_remove->execute();
    $stmt_remove->close();

    $file = "public/profile_images/".$_SESSION["image"];
    if (file_exists($file)){
        if ($file=="public/profile_images/dummy.png"){
            //Dont delete
        }else{
            if (unlink($file)){
                $_SESSION["image"]=null;
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');;
            }else{header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');};
        }
    }

}

//Code for Image upload
if (isset($_FILES['image'])){
    $file=$_FILES['image'];

    //File properties
    $file_name  =   $file['name'];
    $file_tmp   =   $file['tmp_name'];
    $file_size  =   $file['size'];
    $file_error =   $file['error'];

    //Work out file extension
    $file_ext   =   explode('.',$file_name);
    $file_ext   = strtolower(end($file_ext));

    $allowed    = array('jpg','jpeg');

    if(in_array($file_ext,$allowed)){
        if($file_error === 0){
            if($file_size <= 2097152){
                $file_name_new  = uniqid('',true).'.'.$file_ext;
                $file_destination   ='public/profile_images/'.$file_name_new;
            }else {$error_msg='The picture size is greater than 2MiB';}
            if(move_uploaded_file($file_tmp, $file_destination)){
                //echo $file_destination;

                $sql = "UPDATE faculty SET facultyImage =? WHERE facultyId=? ";
                $stmt = $link->prepare($sql);
                if($stmt === false) {
                    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $link->error, E_USER_ERROR);
                }
                $stmt->bind_param('ss',$file_name_new,$_SESSION["facultyId"]);
                $stmt->execute();
                //Delete old photo and set new photo
                $file = "public/profile_images/".$_SESSION["image"];
                if (file_exists($file)){
                    if ($file=="public/profile_images/dummy.png"){
                        //Dont delete
                    }else{
                        if (unlink($file)){
                        }else{};
                    }
                }
                $_SESSION["image"]=$file_name_new;


                $stmt->close();
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
            }else {header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');}
        }
    }else {header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');}
}


//Check if form is submitted by GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET["id"]) and is_numeric($_GET["id"]) ){
        $facultyId = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

        //Default Values
        $name = '--';
        $designation = '--';
        $email = '--';
        $contact = '--';
        $image = NULL;

        $sql = "SELECT * FROM faculty WHERE faculty.facultyId = '$facultyId' LIMIT 1";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $name = $row['facultyName'];
                $designation = $row['designation'];
                $email = $row['facultyEmail'];
                $image = $row['facultyImage'];
                $contact = $row['facultyPhoneNo'];

            }
        } else {


        }



    }
}


//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnEditProf']) AND $_POST['phoneNumber'] != "" AND $_POST['userEmail'] != ""){
        
        $facultyId = $_SESSION['facultyId'];
        $phoneNum = $_POST['phoneNumber'];
        $email = $_POST['userEmail'];
        
        $sql = "UPDATE faculty SET facultyPhoneNo= '$phoneNum', facultyEmail='$email'  WHERE facultyId = '$facultyId' ";

        if ($link->query($sql) === TRUE) {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
        } else {
            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
        }

    }

}

//For Change Password
if (isset($_POST['BtnChnagePassword'])) {
    if (($_POST['Oldpassword']!="") && ($_POST['Newpassword']!="")) {
      
      $Oldpassword = $_POST['Oldpassword'];
      $Newpassword = $_POST['Newpassword'];
      $secure_pass = password_hash($Newpassword, PASSWORD_BCRYPT);
      $user_id = $_SESSION['user_id'];

      $result = $link->query("SELECT facultyPassword FROM faculty WHERE facultyRid='$user_id'");
      $row = mysqli_fetch_assoc($result);
      $oldpasswords = $row ['facultyPassword'];

      $pass_check = password_verify($Oldpassword, $oldpasswords );
      
      if($pass_check)
      {
        $querychange = $link->query("
            UPDATE faculty SET facultyPassword = '$secure_pass' WHERE facultyRid='$user_id' ");

        header('Location:' . 'login.php' . '?status=t');
        session_destroy();
    }
    else
    {
      echo "<script>alert('Error occur')</script>";
      header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');

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
                    else if ($_GET['status'] == 'a'){ ?>
                        <div style="text-align:center;" class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            Error!
                            <button type="button" class="close" data-dismiss="alert">x</button>
                        </div>
                        <?php
                    }
                    

                }
                ?>



                <?php
                if (isset($_GET['id']) AND is_numeric($_GET['id']) ) { ?>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header with-border">
                                    <h3 class="card-title">Faculty Information</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->

                                <div class="card-body">

                                    <!-- Profile Image -->
                                    <div class="card-body card-profile">
                                        <img class="profile-user-img img-responsive img-rounded" src="<?php if (isset($image)){
                                            echo 'public/profile_images/'.$image;
                                        }else {echo 'public/profile_images/dummy.png';}?>" alt="User profile picture">
                                        <h3 class="profile-username text-center"><?php echo $name;?></h3>
                                    </div>
                                    <!-- /.card-body -->
                                    <!-- /.card -->
                                    <p class="text-muted text-center">Faculty</p>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Designation</b> <a class="float-right"><?php echo $designation;?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Email</b> <a class="float-right"><?php echo $email;?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Contact No.</b> <a class="float-right"><?php echo $contact;?></a>
                                        </li>
                                    </ul>

                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button class="btn btn-default btn-sm" onclick="goBack()">Back</button>
                                </div>

                            </div>  <!-- /.card -->
                        </div> <!-- end of col-md-6 !-->

                        <div class="col-md-2"></div>


                    </div>
                </div>

                <?php
            }else if(isset($_SESSION["user_id"])){ ?>
                <div class="row">
                   <div class="col-md-4 float-left">
                    <!-- Profile Image -->
                    <div class="card card-primary">
                        <div class="card-body card-profile">
                          <div class="text-center" >
                              <img class="profile-user-img img-fluid img-circle " style="object-fit:cover; width:150px; height:150px;"   src="<?php if (isset($_SESSION['image'])){
                                echo 'public/profile_images/'.$_SESSION['image'];
                            }else {echo 'public/profile_images/dummy.png';}?>" alt="Responsive image">
                        </div>
                        
                        <h3 class="profile-username text-center"><?php echo $name;?></h3>
                        <p class="text-muted text-center"><?php echo $designation;?></p>
                        <h6 class="text-center"><span><i class="fa fa-envelope text-primary" aria-hidden="true"></i></span><a href="mailto:<?php echo  $_SESSION["usremail"]; ?>">  <?php echo  $_SESSION["usremail"]; ?></a></h6>
                        
                        <h6 class="text-center"><span><i class="fa fa-phone text-success" aria-hidden="true"></i></span>  <?php echo  $_SESSION["usrcell"]; ?></h6>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <p class="text-aqua" style="text-align: center">Browse image and press upload</p>
                                <form action="" method="post" enctype="multipart/form-data" data-toggle="validator">
                                    <div class="form-group">
                                        <input type="file" name="image" class="btn btn-block btn-flat" accept=".jpg ,.jpeg, .png, .bmp, .svg" required>
                                        <input type="submit" value="Upload" class="btn btn-block bg-dark">
                                    </div>
                                </form>
                            </li>
                        </ul>
                        <form role="form" id="change_image" action="" method="post" data-toggle="validator">
                            <input type="submit" name="btnDelete" id="btnDelete" value="Remove Photo" class="btn bg-maroon btn-block" />
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-4 float-right">
                <div class="card card-primary card-outline">
                    <div class="card-header with-border">
                        <h3 class="card-title">Personal Information</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="" id="facultyProfile" name="facultyProfile" method="POST" data-toggle="validator">

                        <div class="card-body">
                            <div class="form-group has-feedback">
                                <input type="text" name="userRid" class="form-control " disabled="" placeholder="<?php echo $designation; ?>" />
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" name="userName" class="form-control " disabled="" placeholder="<?php echo $name; ?>" />
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="email" name="userEmail" class="form-control"  value="<?php echo $email?>" />
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" name="phoneNumber" class="form-control bfh-phone" value="<?php echo $contact?>" />
                                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                            </div>
                            
                        </div>

                    </form>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" name="btnEditProf" form="facultyProfile" class="btn btn-primary float-right">Submit</button>
                        
                    </div>

                </div>  <!-- /.card -->
            </div> <!-- end of col-md-6 !-->
            
            <div class="col-md-4">
                <!-- general form elements -->
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="Oldpassword">Current Password</label>
                        <input type="password" class="form-control" name="Oldpassword" id="Oldpassword" placeholder="Enter Current Password" required>
                    </div>
                    <div class="form-group">
                        <label for="Newpassword"> New Password</label>
                        <input type="password" class="form-control" id="Newpassword" name="Newpassword" placeholder=" Enter New Password" required>
                    </div>
                    
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="BtnChnagePassword" class="btn btn-primary float-right">Submit</button>
              </div>
          </form>
      </div>
      <!-- /.card -->

  </div>
  
</div>



<?php
}
?>


</div>        

</section>

</div>
<!-- .Content Wrapper. Contains page content -->

<footer class="main-footer">
</footer>
<?php include('include/footer.php'); ?>
</div>

<!-- jQuery -->
<?php include('include/jsFile.php'); ?>
<!-- .jQuery -->

<script>
    function goBack() {
        window.history.back();
    }

    $( "#btnDelete" ).click(function() {
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
      },
      function(){
          swal("Deleted!", "Your profile image has been deleted.", "success");
          change_image.submit();
      });
    });;



</script>

</body>
</html>