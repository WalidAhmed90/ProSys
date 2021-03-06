<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
    style="opacity: .8">
    <span class="brand-text font-weight-light">ProSys</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 mb-3 d-flex " >
      <div class="mb-2">
        <img src="<?php if (isset($_SESSION['image'])) {
          echo 'public/profile_images/' . $_SESSION['image'];
          } else {
            echo 'public/profile_images/dummy.png';
          } ?>" style="object-fit:cover; width:50px; height:50px;" class="img-circle elevation-2 "  alt="User Image">
        </div>
        <div class="info d-flex justify-content-center mt-1">
         <a href="#"><p class="text-wrap text-left text-light text-bold"><?php
         echo $_SESSION["usrnm"];
         ?></p></a>
       </div>
     </div>

     <!-- Sidebar Menu -->
     <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-item has-treeview menu-open">
            <a href="index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>
          <!--
            ******************Student******************
            *********************************************
          -->
          <?php
          if ($_SESSION["type"] === "Student") {
            $studId = $_SESSION["user_id"];
            $sql = "SELECT * FROM student WHERE studentRid= '$studId' LIMIT 1";
            $result = mysqli_query($link,$sql);
            if (mysqli_num_rows($result)>0) {
                    // output data of each row
              while($row = mysqli_fetch_array($result)) {
                $isLeader = $row['isLeader'];
                $groupId  = $row['groupId'];
              }
            }
            ?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Group
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php
                if ($isLeader != 1 &&  is_null($groupId)) {
                  ?>
                  <li class="nav-item">
                    <a href="CreateProject.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Create Project</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="joinGroup.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Join Group</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="viewIdea.php" class="nav-link">
                      <i class="far fa-lightbulb"></i>
                      <p>View Share Ideas</p>
                    </a>
                  </li>
                  <?php
                } ?>

                <?php
                if ($isLeader == 1) {
                  ?>          
                  <li class="nav-item">
                    <a href="ChooseSupervisor.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Choose Supervisor</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="groupSettings.php" class="nav-link">
                      <i class="fa ffa fa-cog nav-icon"></i>
                      <p>Settings</p>
                    </a>
                  </li>
                  <?php
                } ?>
              </ul>
            </li>
            <?php
            if ( !is_null($groupId)) {
             ?>
             <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa fa-list-alt"></i>
                <p>
                  Project
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="setProjectName.php" class="nav-link">
                    <i class="far fa-edit nav-icon"></i>
                    
                    <p>Set Project Name</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="projectTemplates.php" class="nav-link">
                    <i class="far fa-file nav-icon"></i>
                    <p>Project Templates</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="studentTask.php" class="nav-link">
                <i class="far fa fa-tasks nav-icon"></i>
                <p>Tasks</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="groupDetails.php" class="nav-link">
                <i class="far fa fa-users nav-icon"></i>
                <p>Group Details</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="studentMeetingRequest.php" class="nav-link">
               <i class="far fa-handshake"></i>
               <p>Meeting Request</p>
             </a>
           </li>
           <?php
           $sql = "SELECT * From batch WHERE fypPart = 2 LIMIT 1";
           $result = mysqli_query($link,$sql);
           if (mysqli_num_rows($result)>0) {
                    // output data of each row
            while($row = mysqli_fetch_array($result)) {
              $fypPart = $row['fypPart'];
            }
            
            ?>
            <li class="nav-item">
              <a href="weeklyReportS.php" class="nav-link">
                <i class="fas fa-calendar-week"></i>
                <p>View Weekly Report</p>
              </a>
            </li>
            <?php
          }
          ?>
          <li class="nav-item">
            <a href="viewIdea.php" class="nav-link">
              <i class="far fa-lightbulb"></i>
              <p>View Share Ideas</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="sendEmail.php" class="nav-link">
              <i class="fa fa-paper-plane nav-icon"></i>
              <p> Send Email</p>
            </a>
          </li>
          
          <?php
        } ?>
      <?php  } 

      elseif($_SESSION["type"] == "Faculty"){
        $userID = $_SESSION['user_id'];
        $sql = "SELECT * FROM faculty WHERE facultyRid = '".$userID."' ";
        $run = mysqli_query($link,$sql);
        if(mysqli_num_rows($run)>0){
          while($row = mysqli_fetch_array($run)){
            $is_coor = $row['isCoordinator'];
          }

          if($is_coor == 1){

           ?>

           <!-- Coordinator SideBar -->
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Batch
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="createBatch.php" class="nav-link">
                  <i class="far fa fa-plus nav-icon"></i>
                  <p>Create Batch</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="batchTemplates.php" class="nav-link">
                  <i class="far fa-file nav-icon"></i>
                  <p>Batch Template</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="batchTask.php" class="nav-link">
                  <i class="far fa fa-tasks nav-icon"></i>
                  <p>Batch Task</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="batchSettings.php" class="nav-link">
                  <i class="fa ffa fa-cog nav-icon"></i>
                  <p>Settings</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa fa-user-plus"></i>
              <p>
                Register Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="registerStudent.php" class="nav-link">
                  <i class="far fa fa-plus nav-icon"></i>
                  <p>Student</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="registerFaculty.php" class="nav-link">
                  <i class="far fa fa-plus nav-icon"></i>
                  <p>Faculty</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa fa-edit"></i>
              <p>
                Manage
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="manageBatch.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Batch</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manageStudents.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Students</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manageStudentGroups.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student Group</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manageFaculty.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Faculty</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manageTimeline.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Timeline</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="weeklyReportC.php" class="nav-link">
             <i class="far fa-handshake"></i>
             <p>Weekly Report</p>
           </a>
         </li>
         <li class="nav-item">
          <a href="shareIdea.php" class="nav-link">
            <i class="far fa fa-lightbulb nav-icon"></i>
            <p>Share Ideas</p>
          </a>
        </li>
        <?php 
        $sql = "SELECT * FROM batch JOIN batch_settings ON batch_settings.batchId = batch.batchId WHERE isActive = 1 AND fypPart =1 LIMIT 1";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
                       // output data of each row
         while($row = $result->fetch_assoc()) {
           
           $fyp1_grading = $row['fyp1_grading'];
           
         }
       }else{
         $fyp1_grading = 0;
       }
       ?>
       <?php 
       $sql = "SELECT * FROM batch JOIN batch_settings ON batch_settings.batchId = batch.batchId WHERE isActive = 1 AND fypPart =2 LIMIT 1";
       $result = $link->query($sql);

       if ($result->num_rows > 0) {
                       // output data of each row
         while($row = $result->fetch_assoc()) {

          $fyp2_grading = $row['fyp2_grading'];
        }
      }else{
       $fyp2_grading = 0;
     }
     ?>
     <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="far fa fa-check-circle nav-icon"></i>
        <p>
          Grading
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <?php  if ($fyp1_grading == 1){ ?>
          <li class="nav-item">
            <a href="grading1C.php" class="nav-link">
             <i class="fas fa-award nav-icon"></i>
             
             <p>Project Proposal</p>
           </a>
         </li>
       <?php  }else{} ?>
       <?php  if ($fyp2_grading == 1){ ?>
        <li class="nav-item">
          <a href="grading2C.php" class="nav-link">
            <i class="fas fa-award nav-icon"></i>
            <p>Project Defense</p>
          </a>
        </li>
      <?php  }else{} ?>
    </ul>
  </li>
  <li class="nav-item">
    <a href="projectRepository.php" class="nav-link">
      <i class="far fa fa-database nav-icon"></i>
      <p>Project Repository</p>
    </a>
  </li>


<li class="nav-item">
  <a href="sendEmailC.php" class="nav-link">
    <i class="fa fa-paper-plane nav-icon"></i>
    <p> Send Email</p>
  </a>
</li>
<?php } else{ ?>
  <!-- Supervisor -->
  <li class="nav-item">
    <a href="superviseGroup.php" class="nav-link">
      <i class="far fa fa-user-plus nav-icon"></i>
      <p>Supervise Groups</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="weeklyReportF.php" class="nav-link">
      <i class="far fa fa-calendar-week nav-icon"></i>
      <p>Weekly Report</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="meetingRequest.php" class="nav-link">
      <i class="far fa-handshake nav-icon"></i>
      <p>Meeting Request</p>
    </a>
  </li>
  <?php 
  $sql = "SELECT * FROM batch JOIN batch_settings ON batch_settings.batchId = batch.batchId WHERE isActive = 1  LIMIT 1";
  $result = $link->query($sql);

  if ($result->num_rows > 0) {
                       // output data of each row
   while($row = $result->fetch_assoc()) {
     
     $fyp1_grading = $row['fyp1_grading'];
     $fyp2_grading = $row['fyp2_grading'];
   }
 }
 ?>
 <li class="nav-item has-treeview">
  <a href="#" class="nav-link">
    <i class="far fa fa-check-circle nav-icon"></i>
    <p>
      Grading
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <?php  if ($fyp1_grading == 1){ ?>
      <li class="nav-item">
        <a href="grading1.php" class="nav-link">
         <i class="fas fa-award nav-icon"></i>
         
         <p>Project Proposal</p>
       </a>
     </li>
   <?php  }else{} ?>
   <?php  if ($fyp2_grading == 1){ ?>
    <li class="nav-item">
      <a href="grading2.php" class="nav-link">
        <i class="fas fa-award nav-icon"></i>
        <p>Project Defense</p>
      </a>
    </li>
  <?php  }else{} ?>
</ul>
</li>

<li class="nav-item">
  <a href="shareIdea.php" class="nav-link">
    <i class="far fa fa-lightbulb nav-icon"></i>
    <p>Share Ideas</p>
  </a>
</li>


<li class="nav-item">
  <a href="sendEmail.php" class="nav-link">
    <i class="fa fa-paper-plane nav-icon"></i>
    <p> Send Email</p>
  </a>
</li>
<?php } }
} ?>

<!--  Send Email -->



</ul>
</nav>

<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>