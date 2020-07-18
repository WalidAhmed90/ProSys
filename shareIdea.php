<?php 
$title = "ProSys";
$subtitle = "Share Idea";
session_start();
include('db/db_connect.php');

if(!isset($_SESSION['isCord'])){
  header("location: login.php");
}
$facultyId = $_SESSION["usrId"];
//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    //Function to upload template goes here
  if (isset($_POST['btnSaveChanges'])){

    if ($_POST['title'] != "" && $_POST['details'] != "" ){

        //Getting data from POST
      $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_SPECIAL_CHARS);
      $details = $_POST['details'];
      $facultyId = filter_input(INPUT_POST,'facultyId',FILTER_SANITIZE_NUMBER_INT);

        //Getting facultyName from facultyId
      $facultyName = $link->query("SELECT facultyName FROM faculty WHERE facultyId = '$facultyId' ")->fetch_object()->facultyName;
      $fypPart=1;
      $sql = "INSERT INTO share_idea (title,details, facultyName,facultyId,fypPart) VALUES ('$title', '$details','$facultyName','$facultyId','$fypPart')";

      if ($link->query($sql) === TRUE) {
        header('Location:' . $_SERVER['PHP_SELF'] . '?add='.$facultyId.'&status=t');
      } else {
        header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
      }

    }else {
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
      <!-- Main content -->
      <section class="content">
        <!-- row -->
        <div class="row">
         <!-- col -->
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
            else if ($_GET['status'] == 'err_filesize'){ ?>
              <div style="text-align:center;" class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign"></span>
                Error! File size exceeded
                <button type="button" class="close" data-dismiss="alert">x</button>
              </div>
              <?php
            }
            else if ($_GET['status'] == 'err_filetype'){ ?>
              <div style="text-align:center;" class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign"></span>
                Error!
                <button type="button" class="close" data-dismiss="alert">x</button>
              </div>
              <?php
            }
          }
          ?>
          <button class="btn btn-Secondary btn-flat float-right" data-toggle="modal" data-target="#modal-info">Share New Idea</button>

        </div>
        <div class="col-md-12">

          <?php if (isset($_GET['details']) && is_numeric($_GET['details']) && strlen($_GET['details'])>0){
            $detailsId = filter_input(INPUT_GET,'details',FILTER_SANITIZE_NUMBER_INT);
            $sql = "SELECT * FROM share_idea WHERE shareId='$detailsId' LIMIT 1 ";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
        // output data of each row
              while($row = $result->fetch_assoc()) {
                $title = $row['title'];
                $details = $row['details'];
                $createdDtm = $row['createdDtm'];
                $facultyName = $row['facultyName'];

              }

            }
            ?>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content bg-info">
                  <div class="modal-header">
                   
                    <h4 class="modal-title" id="myModalLabel"><?php echo $title;?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                      <p class="text-light text-bold text-break"><?php echo $details;?></p>
                      
                      
                      <p class="text-light text-left"><i class="fa fa-lightbulb" aria-hidden="true"></i> idea share by <?php echo $facultyName;?>. 
                        <span class="text-light float-right"><i class="fa fa-clock" aria-hidden="true"></i> <?php echo time2str($createdDtm);?></span>
                      </p>
                      <br/>


                    </div>
                    <div class="modal-footer">
                      
                      <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

              <script>
        // A $( document ).ready() block.
        $( document ).ready(function() {
          $('#myModal').modal('show');
        });
      </script>

    <?php } ?>

    <div class="timeline">
      <?php
      include ('db/db_connect.php');
    //session_start();

    //Get Values from Database
    $sql = "SELECT * FROM share_idea  ORDER BY createdDtm DESC  ";//Chronoligical Order
    $result = $link->query($sql);
    while ($row = $result->fetch_assoc()) { ?>

      <!-- timeline time label -->
      <div class="time-label">
        <span class="bg-red"> <?php echo date('F d, Y ',strtotime($row["createdDtm"])); ?></span>
      </div>
      
      <!-- /.timeline-label -->
      <!-- timeline item -->
      <div>
        <i class="far fa-lightbulb bg-warning"></i>
        <div class="timeline-item">
          <span class="time text-light"><i class="fas fa-clock text-light"></i> 
            <?php echo time2str($row['createdDtm']);?>
          </span>
          <h3 class="timeline-header bg-info"><i class="far fa-comment"></i> <?php echo $row["facultyName"].' : ' ;?><span class="font-weight-bold"><?php echo $row["title"];?></span></h3>
          <div class="timeline-body text-break">
           <?php

           if (strlen($row["details"]) >= '500'){

            echo getExcerpt($row["details"],0,500)  ;
          }
          else{

            echo $row["details"] ;
          }

          ?>
        </div>
        <div class="timeline-footer">
         <?php if (strlen($row["details"]) >= '500'){ ?>
          <a href="<?php echo $_SERVER['PHP_SELF'].'?details='.$row['shareId'];?>"  class="btn btn-primary btn-sm">Show Details</a>
        <?php } ?>
      </div>
    </div>
  </div>
  
  <!-- END timeline item -->
  <!-- timeline item -->


  <?php
}
?>
<div>
  <i class="fas fa-clock bg-gray"></i>
</div>

</div>
<script type="text/javascript">
 jQuery(document).ready(function() {
   $("time.timeago").timeago();
 });
</script>

<div class="modal fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content bg-secondary">
      <div class="modal-header">
        <h4 class="modal-title">Share Idea</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <!-- form start -->
          <form role="form" method="post" action="" id="ShareIdea" data-toggle="validator">

            <div class="row">
              <div class="col-md-12">
               <input type="hidden" name="facultyId" value="<?php echo $facultyId;?>">
               <div class="form-group">
                <label>Title</label>
                <input type="text" id="title" class="form-control" name="title" value="" required>
              </div>

              <div class="form-group">
                <label>Details</label>
                <textarea class="form-control" name="details" placeholder="" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                required></textarea>
              </div>   
            </div>

            
          </div>
          <div class="modal-footer justify-content-between form-group">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
            <button type="submit" name="btnSaveChanges" class="btn btn-outline-light">Share Idea</button>
          </div>

        </form>
        


      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  

</div>
<!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->

</div>
<!-- .Content Wrapper. Contains page content -->

<?php include('include/footer.php'); ?>
</div>

<!-- jQuery -->
<?php include('include/jsFile.php'); ?>
<!-- .jQuery -->



</body>
</html>