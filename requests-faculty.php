<?php
include ("db/db_connect.php");
include("include/functions.php");

//Check if user is leader of a group
if (isset($_SESSION["usrId"])) {
    $supervisorId = $_SESSION['usrId'];
    //Check if Supervisor can accept request
    $sql = "SELECT * FROM faculty JOIN work_load ON faculty.facultyId = work_load.facultyId WHERE faculty.facultyId = '$supervisorId' LIMIT 1 ";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $totalLoad = $row['totalLoad'];
            $currentLoad = $row['currentLoad'];
            $facultyName = $row['facultyName'];
        }
    }
    if ($currentLoad < $totalLoad){
        //Check if he has student requests
        $sql = "SELECT * from faculty_student_request WHERE faculty_student_request.facultyId = '$supervisorId' ";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            $numOfRequests = $result->num_rows;
        }
    }
}

//Check if form is submitted by GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    //Function for delete Request
    if (isset($_GET["delete"]) and is_numeric($_GET["delete"]) ){
        $id = filter_input(INPUT_GET, 'delete');
        //Check if there is a request with this id
        $request = $link->query("SELECT requestId FROM faculty_student_request WHERE requestId = '$id' ")->fetch_object()->requestId; 
        if ($request){
            // sql to delete a record
            $sql = "DELETE FROM faculty_student_request WHERE requestId='$id' ";
            if ($link->query($sql) === TRUE) {
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
            }
        }
    }
    //Function for accept Request
    if (isset($_GET["accept"]) AND is_numeric($_GET["accept"]) AND strlen($_GET['accept']) > 0 ){
        $id = filter_input(INPUT_GET, 'accept');
        //Check if there is a request with this id
        $request = $link->query("SELECT requestId FROM faculty_student_request WHERE requestId = '$id' ")->fetch_object()->requestId; 
        if ($request){
            $groupId = $link->query("SELECT groupId FROM faculty_student_request WHERE requestId = '$id' ")->fetch_object()->groupId; ;
            $facultyId= $_SESSION['usrId'] ;
            // sql to accept a request
            $sql = "INSERT INTO faculty_student_group (groupId, facultyId)VALUES ('$groupId', '$facultyId')";
            if ($link->query($sql) === TRUE) {
                //If request accepted delete request from record
                $sql = "DELETE FROM faculty_student_request WHERE requestId='$id' ";
                if ($link->query($sql) === TRUE) {
                    //Record also deleted
                    //Increment value of currentload
                    $sql = "UPDATE work_load SET currentLoad = currentLoad +1 WHERE facultyId = '$facultyId'";
                    if ($link->query($sql) === TRUE) {
                        /****
                         * Add this to timeline
                         *  Faculty Name from facultyId (SESSION)
                         *  Group Name from groupId
                         *
                         */
                        //Add this info to the students and faculty timeline
                        //Get Batch id,projectName and SDP part from groupId
                        $sql = "SELECT * FROM student_group WHERE groupId = '$groupId' LIMIT 1";
                        $result = $link->query($sql);
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $batchId = $row['batchId'];
                                $projectName = $row['projectName'];
                                $fypPart = $row['fypPart'];
                            }
                        }
                        $title = 'Info';
                        $details = $facultyName." is now supervising group ".$projectName;
                        $sql = "INSERT INTO timeline_student (title, details, type, batchId, fypPart) VALUES ('$title', '$details', 'info', '$batchId', '$fypPart')";
                        if ($link->query($sql) === TRUE) {
                            $sql = "INSERT INTO timeline_faculty (title, details, type, batchId, fypPart) VALUES ('$title', '$details', 'info', '$batchId', '$fypPart')";
                            if ($link->query($sql) === TRUE) {
                                header('Location:' . $_SERVER['PHP_SELF'] );
                            }
                        }
                    }
                }
            }
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
            $supervisorId = $_SESSION['usrId'];
            $sql = "SELECT * from faculty_student_request JOIN student_group WHERE faculty_student_request.facultyId = '$supervisorId' AND student_group.groupId = faculty_student_request.groupId ";
            $result = $link->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $requestFrom = getStudentData($row['leaderId']); ?>
                    <!-- Message Start -->
                    <div class="media dropdown-item">
                        <img src="dist/img/pics/pic1.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title text-bold">
                                <?php echo $requestFrom['name']; ?>
                            </h3>
                            <p class="text-sm"> <?php echo $row['projectName']; ?></p>
                            <p class="text-sm">sent you request.</p>
                            <div class="dropdown-divider"></div>
                            <div id="requestActions" class="float-left">
                                <a href="<?php echo $_SERVER['PHP_SELF'] . '?accept=' . $row['requestId']; ?>"  class="btn btn-primary btn-xs">Accept</a>
                                <a href="<?php echo $_SERVER['PHP_SELF'] . '?delete=' . $row['requestId']; ?>"  class="btn btn-danger btn-xs">Delete</a>
                            </div>
                        </div>
                    </div>
                    <!-- Message End -->
                    <div class="dropdown-divider"></div>
                    <?php
                }
            }
        } else{
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
            <?php
        }
        ?>
    </div>
</li>