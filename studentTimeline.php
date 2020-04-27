<?php if (isset($_GET['details']) && is_numeric($_GET['details']) && strlen($_GET['details'])>0){
  $detailsId = filter_input(INPUT_GET,'details',FILTER_SANITIZE_NUMBER_INT);
  $sql = "SELECT * FROM timeline_student WHERE id='$detailsId' LIMIT 1 ";
  $result = $link->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $title = $row['title'];
      $details = $row['details'];
      $type = $row['type'];
      $createdDtm = $row['createdDtm'];
    }
  }
  ?>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-info">
        <div class="modal-header">
          <h4 class="modal-title " id="myModalLabel"><?php echo $title;?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          </div>

          <div class="modal-body">
            <?php echo $details;?>
            <p class="text-light"><i class="fas fa-clock" aria-hidden="true"></i> <?php echo time2str($createdDtm);?></p>
            <br>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
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

    <?php
  }?>

  <div class="timeline">
    <?php
    include ('db/db_connect.php');
    //session_start();

    //If student is logged in
    if ($_SESSION['type'] == "Student"){
      $batchId = $_SESSION['batchId'];
    }

    //Get Values from Database
    $sql = "SELECT * FROM timeline_student WHERE batchId ='$batchId' ORDER BY createdDtm DESC  ";
    //Chronoligical Order
    $result = $link->query($sql);
    while ($row = $result->fetch_assoc()) { ?>

      <!-- timeline time label -->
      <div class="time-label">
        <span class="bg-red"> <?php echo date('F d, Y ',strtotime($row["createdDtm"])); ?></span>
      </div>
      <!-- /.timeline-label -->
      <!-- timeline item -->

      <div>
        <i class="far fa-bell bg-warning"></i>
        <div class="timeline-item">
          <span class="time text-light"><i class="fas fa-clock text-light"></i> 
            <?php echo time2str($row['createdDtm']);?>
          </span>
          <h3 class="timeline-header bg-info">
            <?php if ($row['type'] == 'task') {
              ?>
              <i class="fa fa-tasks" aria-hidden="true"></i> 
              <?php
            } else{ ?>
              <i class="fa fa-info-circle" aria-hidden="true"></i> 
              <?php
            }?>
            <?php echo $row["title"] ;?></h3>
            <div class="timeline-body">
              <?php
              if (strlen($row["details"] >= '500')){
                echo getExcerpt($row["details"],0,500)  ;
              } else{
                echo $row["details"] ;
              }?>
            </div>

            <div class="timeline-footer">
              <?php if (strlen($row["details"] >= '500')){ ?>
                <a href="<?php echo $_SERVER['PHP_SELF'].'?details='.$row['id'];?>"  class="btn btn-primary btn-sm">Show Details</a>
                <?php
              }?>
            </div>
          </div>
        </div>

        <!-- END timeline item -->
        <!-- timeline item -->
        <?php
      }?>

      <div>
        <i class="fas fa-clock bg-gray"></i>
      </div>
    </div>

    <script type="text/javascript">
      jQuery(document).ready(function() {
        $("time.timeago").timeago();
      });
    </script>