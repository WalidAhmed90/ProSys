<?php
include('db/db_connect.php');

if (isset($_SESSION["user_id"])) {
  $studentId = $_SESSION['usrId'];
  $batchId = $_SESSION['batchId'];
}
//Getting group id
$groupId = $link->query("SELECT groupId FROM student WHERE studentId = '$studentId' LIMIT 1" )->fetch_object()->groupId;

$sql = "SELECT * FROM batch_tasks WHERE batchId ='$batchId' ORDER BY createdDtm DESC";
$result = $link->query($sql);

if ($result->num_rows > 0) {
  $num_of_tasks = $result->num_rows;
}
?>
<li class="nav-item dropdown">
  <a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-bell"></i>
    <span class="badge badge-warning navbar-badge"><?php echo $num_of_tasks;?></span>
  </a>
  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <span class="dropdown-item dropdown-header">You have <?php echo $num_of_tasks;?> task(s)</span>
    <div class="dropdown-divider"></div>
    <?php
    $sql = "SELECT * FROM batch_tasks WHERE batchId ='$batchId' AND fypPart = 1  ORDER BY createdDtm DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
      $num_of_tasks = $result->num_rows;
      while ($row = $result->fetch_assoc()) { ?>
        <a href="<?php echo "studentTask.php?details=".$row['taskId'];?>" target="_blank" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i>
          <?php echo $row['taskName'];?>
          <?php if (check_group_uploads($groupId,$row['taskId'],$batchId)){ ?>
            <small class="badge bg-success float-right">DONE</small>
            <?php
          } else{ 
            ?>
            <small class="badge bg-warning float-right">Pending</small>
            <?php
          }?>
        </a>
        <div class="dropdown-divider"></div>
        <?php
      }
    } else{
      ?>
      <div class="media">
        <div class="media-body">
          <br>
          <h3 class="dropdown-item-title text-center">
            you have no task available.
          </h3>
          <br>
        </div>
      </div>
      <?php
    } 
    ?>
    <a href="studentTask.php" class="dropdown-item dropdown-footer">View all tasks</a>
  </div>
</li>
<!-- Tasks: style can be found in dropdown.less -->