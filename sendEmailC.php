<?php
$title = "ProSys";
$subtitle = "Send Email";
include("include/head.php");
include ('db/db_connect.php');
session_start();

$username = $_SESSION["usrnm"];
//
include("libraries/sendgrid-php/sendgrid-php.php");
$sendgrid = new SendGrid('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');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['btnSendMail'])) {
        $recipient = $_POST['recipient'];
        $subject = $_POST['subject'];
        $msgBody = $_POST['msgBody'];

        //Setting up SendGrid
        $email = new SendGrid\Email();

        $email->setFrom('walidkhan345@gmail.com');
        $email->setFromName($username);
        $email->setSubject($subject);
        foreach (explode(",", $recipient) as $address) {

        
        $email->addTo($address);
        $email->setHtml($msgBody);
    
        try {
            $res = $sendgrid->send($email);
            if ($res->getCode() == 200){
                //Email send successfully
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
            }
            else{
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
            }

        } catch (\SendGrid\Exception $e) {
            echo $e->getCode();
            foreach ($e->getErrors() as $er) {
                echo $er;
                exit;
            }
        }
}



    }
}
?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include('include/navbar.php'); ?>
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

                    <!--Show validation errors-->
                    <?php if (isset ($_GET['status'])){
                        if ($_GET['status'] == 't'){ ?>
                            <div style="text-align:center;" class="alert alert-success" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Email Sent successfully!
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                        <?php   }
                        else if ($_GET['status'] = 'f'){ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! Email was not sent
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                        <?php }

                        else{ ?>
                            <div style="text-align:center;" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                Error! Something Went Wrong
                                <button type="button" class="close" data-dismiss="alert">x</button>
                            </div>
                        <?php    }
                    }?>



                      <div class="card card-primary card-outline no-border ">
                        <div class="card-header">
                            <h3 class="card-title">Select Batch And FYP Part to send Email</h3>

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
                </div>
                    <!-- /.card -->
                        <?php if (isset($_GET['batchId']) && is_numeric($_GET['batchId']) && strlen($_GET['batchId'])){
                            $batchId = filter_input(INPUT_GET,'batchId',FILTER_SANITIZE_NUMBER_INT);
                            
                            
                            $sql = "SELECT DISTINCT(studentEmail) FROM student WHERE batchId = '$batchId' "; 
                                    $result = mysqli_query($link,$sql);
                                    $studentEmail = array();
                                    while($row = mysqli_fetch_assoc($result)) { 

                                        $studentEmail[] = $row['studentEmail'];
                                    }
                                        ?>
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title">Compose New Message</h3>
                        </div>
                        <!-- /.card-header -->
                        <form role="form" action="" id="sendEmail" name="sendEmail" method="POST" data-toggle="validator">
                        <div class="card-body">
                            <div class="form-group">
                                <textarea type="email" name="recipient" class="form-control" placeholder="To:" required><?php 
                                $removed = array_shift($studentEmail);
                                echo implode(",",$studentEmail);
                                 ?></textarea> 
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control" placeholder="Subject:" required>
                            </div>
                            <div class="form-group">
                    <textarea id="compose-textarea" name="msgBody" class="form-control" style="height: 300px" required>

                    </textarea>
                            </div>

                        </div>
                        </form>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="submit" name="btnSendMail" form="sendEmail" class="btn btn-primary" ><i class="fa fa-envelope-o"></i> Send
                                </button>
                            </div>
                            <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-default"><i class="fa fa-times"></i> Discard</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /. card -->

                          <?php }?>

                 

                </div >
                
            </div>
    </section>
</div>

 <?php include('include/footer.php'); ?>
  </div>

  <!-- jQuery -->
  <?php include('include/jsFile.php'); ?>
  <!-- .jQuery -->

<!-- Page Script -->
<script>
    $(function () {
        //Add text editor
        $("#compose-textarea").wysihtml5();
    });
     $(function () {
        //Add text editor
        $("#to-textarea").wysihtml5();
    });
</script>
<script type="text/javascript">


</script>
</body>