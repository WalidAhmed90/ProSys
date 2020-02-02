<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">ProSys</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['user_id']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
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
          if ($_SESSION["type"] == "Student") {
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
              <li class="nav-item">
                <a href="initiateGroup.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Initiate Group</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="joinGroup.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Join Group</p>
                </a>
              </li>
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
            </ul>
          </li>
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
                  <a href="meetingLogs.php" class="nav-link">
                    <i class="far fa fa-list-ul nav-icon"></i>
                    <p>Meeting Logs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.html" class="nav-link">
                    <i class="far fa fa-upload nav-icon"></i>
                    <p>Deliverables</p>
                  </a>
                </li>
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
                <a href="pages/layout/top-nav.html" class="nav-link">
                  <i class="far fa fa-plus nav-icon"></i>
                  <p>Create Batch</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                  <i class="far fa-file nav-icon"></i>
                  <p>Batch</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                  <i class="far fa fa-tasks nav-icon"></i>
                  <p>Batch Task</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
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
                <a href="pages/charts/chartjs.html" class="nav-link">
                  <i class="far fa fa-plus nav-icon"></i>
                  <p>Student</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa fa-plus nav-icon"></i>
                  <p>Faculty</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/chartjs.html" class="nav-link">
                  <i class="far fa fa-plus nav-icon"></i>
                  <p>Coordinator</p>
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
                <a href="pages/charts/chartjs.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Batch</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Students</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/chartjs.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student Group</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Faculty</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Timeline</p>
                </a>
              </li>
            </ul>
          </li>
                <li class="nav-item">
                  <a href="./index.html" class="nav-link">
                    <i class="far fa fa-envelope nav-icon"></i>
                    <p>Send E-mail</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.html" class="nav-link">
                    <i class="far fa fa-file-pdf nav-icon"></i>
                    <p>Generate Report</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.html" class="nav-link">
                    <i class="far fa fa-database nav-icon"></i>
                    <p>Project Repository</p>
                  </a>
                </li>
              <?php } else{ ?>
                <!-- Supervisor -->
                <li class="nav-item">
                  <a href="./index.html" class="nav-link">
                    <i class="far fa fa-user-plus nav-icon"></i>
                    <p>Supervise Groups</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.html" class="nav-link">
                    <i class="far fa fa-list-ul nav-icon"></i>
                    <p>Meeting Logs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.html" class="nav-link">
                    <i class="far fa fa-check-circle nav-icon"></i>
                    <p>Grading</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.html" class="nav-link">
                    <i class="far fa fa-envelope nav-icon"></i>
                    <p>Send E-mail</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.html" class="nav-link">
                    <i class="far fa fa-lightbulb nav-icon"></i>
                    <p>Share Ideas</p>
                  </a>
                </li>
                <?php } }
            } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>