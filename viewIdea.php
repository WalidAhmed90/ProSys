<?php 
$title = "ProSys";
$subtitle = " View Share Idea";
session_start();
include('db/db_connect.php');

if(!isset($_SESSION['user_id'])){
  header("location: login.php");
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
                    <p class="text-light text-bold"><?php echo $details;?></p>
                    
                   
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
                  <div class="timeline-body">
                   <?php

                    if (strlen($row["details"] >= '500')){

                        echo getExcerpt($row["details"],0,500)  ;
                    }
                    else{

                        echo $row["details"] ;
                    }

                    ?>
                  </div>
                  <div class="timeline-footer">
                     <?php if (strlen($row["details"] >= '500')){ ?>
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