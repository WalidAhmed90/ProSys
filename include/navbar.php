<nav class="main-header navbar navbar-expand navbar-white navbar-light">   

    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
        <?php

        //Student
        if($_SESSION['type'] == "Student" ){
            include('requests-student.php');
            include('dropdownStudentTasks.php');
        }
        //Supervisor
       if ($_SESSION['type'] == "Faculty" ){
            include('requests-faculty.php');
        }
         //Coordinator

        ?>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>

    </ul>
  </nav>