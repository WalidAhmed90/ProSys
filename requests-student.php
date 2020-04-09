<?php
include_once("db/db_connect.php");
include_once("include/functions.php");


if (isset($_SESSION["usrId"])) {
    $studentId = $_SESSION['usrId'];

    //Check if user is leader of a group
    $sql = "SELECT * FROM student WHERE studentId = '$studentId' LIMIT 1 ";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $isLeader = $row['isLeader'];
            $groupId = $row['groupId'];
        }

    }

    if ($isLeader == 1) {
        //Check if his group limit
        $sql = "SELECT * from student_group WHERE leaderId = '$studentId' LIMIT 1 ";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
             while($row = $result->fetch_assoc()) {
           $inGroup = $row['inGroup'];
            
            $groupLimit = $row['groupLimit'];
        }
            
        }
        if ($inGroup <= $groupLimit){
            //Check if he has group requests
            $sql = "SELECT * FROM student JOIN student_group ON student.studentId = student_group.leaderId JOIN student_group_request ON student_group_request.groupId = student_group.groupId WHERE leaderId = '$studentId' AND groupLimit > inGroup ";
            $result = $link->query($sql);
            if ($result->num_rows > 0) {
                $numOfRequests = $result->num_rows;
            }
        }




    }
}
//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['btnAcceptReq'])){
        //Getting data from POST and sanitizing
        $acceptId = filter_input(INPUT_POST,'requestId',FILTER_SANITIZE_NUMBER_INT);


        //Get group id
        $groupId = $link->query("SELECT groupId FROM student_group_request WHERE requestId = '$acceptId'  LIMIT 1 ")->fetch_object()->groupId;

        //Get student id of person who sent the request
        $studentId = $link->query("SELECT studentId FROM student_group_request WHERE requestId = '$acceptId'  LIMIT 1 ")->fetch_object()->studentId;

        // Set autocommit to off
        mysqli_autocommit($link, FALSE);

        $sql = "UPDATE student SET groupId = '$groupId' WHERE studentId = '$studentId' LIMIT 1";

        if ($link->query($sql) == TRUE) {

            //Increment group members
            $inc_group = $link ->query("UPDATE student_group SET inGroup = inGroup + 1 WHERE groupId = '$groupId'");


            if ($inc_group  ){
                //Delete from request
                $delete_row = $link->query("DELETE FROM student_group_request WHERE requestId=" . $acceptId);
                if ($delete_row){
                    // Commit transaction
                    mysqli_commit($link);
                    header('Location:' . $_SERVER['PHP_SELF']);die;
                }
                else{
                    header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');die;
                }
            }

        }



    }
    if (isset($_POST['btnDeleteReq'])){

        //Getting data from POST and sanitizing
        $deleteId = filter_input(INPUT_POST,'requestId',FILTER_SANITIZE_NUMBER_INT);

        //try deleting record using the record ID we received from POST
        $delete_row = $link->query("DELETE FROM student_group_request WHERE requestId=" . $deleteId);

        if (!$delete_row) {
            exit();
        }else{
            header('Location:' . $_SERVER['PHP_SELF']);die;
        }
    }

}

?>
<!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown" id="requests-student">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-user"></i>
          <span class="badge badge-danger navbar-badge"><?php  if (isset($numOfRequests)){echo $numOfRequests;}else{echo "";};  ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <?php
            if (isset($numOfRequests)){


                $sql = "SELECT * from student_group JOIN student_group_request ON student_group.groupId = student_group_request.groupId WHERE student_group_request.groupId = '$groupId' ";
                $result = $link->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $requestFrom = getStudentData($row['studentId']); ?>

        <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="dist/img/pics/pic1.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <form action="" method="post" data-toggle="validator">
                <input type="hidden" name="requestId" value="<?php echo $row['requestId']?>">
                        <div class="media-body">
                        <h3 class="dropdown-item-title">
                  <?php echo $requestFrom['name']; ?>
                </h3>
                <p class="text-sm"> <?php echo "(". $requestFrom['rid'].")"; ?></p>
                <p class="text-sm">has sent you a group request.</p>
                <div class="dropdown-divider"></div>
                <div id="requestActions" class="float-left">
                                <button id="btnAcceptReq" name="btnAcceptReq" class="accept_button btn btn-primary btn-xs">Accept</button>
                                <button id="btnDelReq" name="btnDeleteReq" class="del_button btn btn-danger btn-xs ">Delete</button>
                </div>
              </div>
               </form>
            </div>
            <!-- Message End -->
            </a>
          <div class="dropdown-divider"></div>
                       
                   <?php }
                }

            }else{


            ?>
            <div class="media">
              <div class="media-body">
                <br>
                <h3 class="dropdown-item-title text-center">
                 you have no Group request.
                  
                </h3>
                <br>
              </div>
            </div>
           
         <?php }?>
        

          </div>
      </li>






