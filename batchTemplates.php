<?php
$title="ProSys";
$subtitle="Batch Templates";
include('db/db_connect.php');

session_start();

//Check if coordinator is logged in
if(!isset($_SESSION['user_id']))
{
    header("location: login.php");
}

$batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);

//Check if form is submitted by GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['delete'])){

        $deleteId = filter_input(INPUT_GET,'delete',FILTER_SANITIZE_NUMBER_INT);

        $sql = "SELECT * FROM batch_templates WHERE templateId= $deleteId LIMIT 1 ";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $template= $row['templateLocation'];
                $batchId = $row['batchId'];
            }

            //Get batch name from batchId
            $batchName = $link->query("SELECT batchName FROM batch WHERE batchId = '$batchId' ")->fetch_object()->batchName;





                // sql to delete a record
            $sql = "DELETE FROM batch_templates WHERE templateId='$deleteId'";

            if ($link->query($sql) === TRUE) {
                $file = './uploads/'.$batchName.'/templates/'.$template;
                if (file_exists($file)){
                    unlink($file);
                }
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
                die;
            } else {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
                die;
            }
        }


    }


}

//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    //Function to upload template goes here
    if (isset($_POST['btnUploadTemplate'])){

        //Getting data from POST
        $templateName = filter_input(INPUT_POST,'templateName',FILTER_SANITIZE_SPECIAL_CHARS);
        $batchId = filter_input(INPUT_POST,'batchId',FILTER_SANITIZE_NUMBER_INT);

        //Getting batchName from batchId
        $batchName = $link->query("SELECT batchName FROM batch WHERE batchId = '$batchId' ")->fetch_object()->batchName;



        if (isset($_FILES['templateFile'])){

            $file=$_FILES['templateFile'];

            //File properties
            $file_name  =   $file['name'];
            $file_tmp   =   $file['tmp_name'];
            $file_size  =   $file['size'];
            $file_error =   $file['error'];

            //Work out file extension
            $file_ext   =   explode('.',$file_name);
            $file_ext   = strtolower(end($file_ext));

            //$allowed    = array('doc','docx','pdf','jpg','jpeg','zip','rar','txt','pptx','ppt');
            $allowed    = array ('doc','docx','pdf','ppt','pptx','rar','zip','txt','jpg','jpeg');


            if(in_array($file_ext,$allowed)){



                if($file_error === 0){
                    if($file_size <= 10485760){ //10Mib


                        if (strlen($templateName) > 0){

                            $file_name_new  = $templateName.'.'.$file_ext;
                        }else if (strlen($templateName) <= 0){
                            $templateName  = $file_name;
                            $file_name_new  = $templateName;
                        }



                        //Make a folder with named templates in Batch folder
                        if (!file_exists('uploads/'.$batchName.'/templates/')) {
                            mkdir('uploads/'.$batchName.'/templates/', 0777, true);
                        }

                        $file_destination   ='uploads/'.$batchName.'/templates/'.$file_name_new;

                    }
                    else {
                        header('Location:' . $_SERVER['PHP_SELF'] . '?status=err_filesize');
                    }

                    if(move_uploaded_file($file_tmp, $file_destination)){
                        //echo $file_destination;

                        $sql = "INSERT INTO batch_templates (batchId, templateName, templateLocation) VALUES ('$batchId', '$templateName', '$file_name_new' )";

                        if ($link->query($sql) === TRUE) {
                            header('Location:' . $_SERVER['PHP_SELF'] . '?add='.$batchId.'&status=t');
                        } else {
                            header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
                        }

                    }
                    else
                    {
                        'Location:' . $_SERVER['PHP_SELF'] . '?status=f';exit;
                    }

                }else{
                    'Location:' . $_SERVER['PHP_SELF'] . '?status=f';exit;
                    //echo $file['size'];exit;
                    //print_r($file);exit;
                    //Unknown error

                }
            }
            else
            {
                'Location:' . $_SERVER['PHP_SELF'] . '?status=f';
            }

        }

    }



    if (isset($_POST['btnEdit'])){

    }

    if (isset($_POST['btnDelete'])){

    }
}
?>

<!--Date Picker-->
<link rel="stylesheet" href="plugins/datepicker/datepicker3.css"/>

<body class="hold-transition">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include('include/navbar.php'); ?>
        <!-- /.navbar -->
        <?php include('include/head.php'); ?>
        <?php include('include/sidebar.php'); ?>
        <div class="content-wrapper" >
            <?php include('include/contentheader.php'); ?>

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
                            } else  if ($_GET['status'] == 'f'){ ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Error! Something Went Wrong
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else if ($_GET['status'] == 'err_filesize'){ ?>
                                <div style="text-align:center;" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    Error! File size exceeded
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                </div>
                                <?php
                            } else if ($_GET['status'] == 'err_filetype'){ ?>
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
                        if (isset($_GET['edit']) && is_numeric($_GET['edit']) && strlen($_GET['edit'])> 0){ ?>
                            <!--Edit template-->
                            <div class="card card-primary card-outline no-border">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Edit Template -
                                        <?php
                                        $templateId = filter_input(INPUT_GET,'edit',FILTER_SANITIZE_NUMBER_INT);
                                        $sql = "SELECT templateName FROM batch_templates WHERE batch_templates.templateId = '$templateId' ";
                                        $result = $link->query($sql);
                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                $templateName = $row['templateName'];
                                            }
                                        } else {
                                            $templateName = "--";
                                        }
                                        echo $templateName;
                                        ?>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body no-padding">
                                    <form id="editTemplate" name="editTemplate" action="" method="post" enctype="multipart/form-data" data-toggle="validator">
                                        <input type="hidden" name="batchId" value="<?php echo $batchId;?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Template Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="templateName" id="templateName" value="<?php echo $templateName;?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <p class="text-muted">You can only edit template name,to upload new template kindly delete this template first</p>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="card-footer">
                                        <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default btn-sm float-left">Back
                                        </a>
                                        <button type="submit" name="btnUploadTemplate" id="btnUploadTemplate" form="uploadTemplates" class="btn btn-primary btn-sm float-right">
                                            <i class="fa fa-upload" ></i>
                                        Upload</button>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <?php
                        }
                        else if (isset($_GET['add']) && is_numeric($_GET['add']) && strlen($_GET['add'])> 0){ ?>
                            <!--Add new template-->
                            <div class="card card-primary no-border">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Add Template -
                                        <?php
                                        $batchId = filter_input(INPUT_GET,'add',FILTER_SANITIZE_NUMBER_INT);
                                        $sql = "SELECT batchName FROM batch WHERE batchId = '$batchId' ";
                                        $result = $link->query($sql);
                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                $batchName = $row['batchName'];
                                            }
                                        } else {
                                            $batchName = "--";
                                        }
                                        echo $batchName;
                                        ?>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body  no-padding">
                                    <form id="uploadTemplates" name="uploadTemplates" action="" method="post" enctype="multipart/form-data" data-toggle="validator">
                                        <input type="hidden" name="batchId" value="<?php echo $batchId;?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Template Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="templateName" id="templateName" placeholder="Enter Template name or leave empty to set filename as template name" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="file"  name="templateFile" accept=".doc ,.docx, .pdf, .rar, .zip, .jpg, .jpeg, .ppt, .pptx " required>
                                                <br>
                                                <p class="text-muted">File size limit :10 MiB</p>
                                                <span class="text-muted">Allowed File types : docx | pdf | zip | rar | jpeg | pptx   </span>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="card-footer">
                                        <button onclick="goBack()" class="btn btn-default">Back</button>
                                        <button type="submit" name="btnUploadTemplate" id="btnUploadTemplate" form="uploadTemplates" class="btn btn-primary  float-right"><i class="fa fa-upload" ></i>Upload</button>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <?php
                        } else{ 
                            ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <?php
                                        $batchId = filter_input(INPUT_GET,'batchId',FILTER_SANITIZE_NUMBER_INT);
                                        if ($batchId){
                                            //Get batch Name
                                            $batchName = $link->query("SELECT batchName FROM batch WHERE batchId = '$batchId' ")->fetch_object()->batchName;
                                            echo "Batch ".$batchName;
                                        } else{
                                            echo "<p >Select batch from the list</p>";
                                        }
                                        ?>
                                    </h3>
                                    <div class="card-tools">
                                        <form id="selectBatch"  id="selectBatch" method="get" name="selectGroup" data-toggle="validator">
                                            <div class="input-group input-group-sm" style="width: 250px;">
                                                <select name="batchId"  id="batchId" class="form-control" required>
                                                    <?php
                                                    $sql = "SELECT * FROM batch WHERE  batch.isActive = 1";
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
                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.card-header -->

                                <?php if (isset($_GET['batchId']) && is_numeric($_GET['batchId']) && strlen($_GET['batchId']) >0 ){ 
                                    ?>
                                    <div class="card-body  no-padding">
                                        <table id="meetingLogs" class="table table-head-fixed text-nowrap table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Template Name</th>
                                                    <th>Template</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            $batchId = filter_input(INPUT_GET,'batchId',FILTER_SANITIZE_NUMBER_INT);
                                            $sql = "SELECT * from batch_templates WHERE batchId = '$batchId' ORDER BY templateId ASC";
                                            $result = $link->query($sql);
                                            while($row = $result->fetch_assoc()) {
                                                ?>

                                                <tr>
                                                    <td><?php echo $row['templateName'];?></td>
                                                    <td><?php echo $row['templateLocation'];?></td>
                                                    <td>
                                                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $row['templateId']; ?>"  class="btn  btn-primary btn-xs">
                                                        Edit</a>
                                                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?delete=' . $row['templateId']; ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="btn  btn-danger btn-xs">
                                                        Delete</a>
                                                    </td>
                                                </tr>

                                                <?php
                                            }
                                            ?>

                                        </table>
                                        <div class="card-footer">
                                            <a href="<?php echo $_SERVER['PHP_SELF'] . '?add='.$batchId; ?>" class="btn  btn-primary btn-sm float-right ">
                                                <i class="fa fa-upload" ></i>
                                            Add New Template</a>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <?php
                                }
                                ?>
                            </div>
                            <!-- /.card -->
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
        <?php
        include('include/footer.php');
        ?>
    </div>
    <!-- ./wrapper -->
    <?php
    include('include/jsFile.php');
    ?>
    <!--Datepicker-->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script>

function goBack() {
        window.history.back();
    }


    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
    });


</script>
</body>
</html>