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

    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img src="<?php if (isset($_SESSION['image'])){
         echo 'public/profile_images/'.$_SESSION['image'];
       }else {echo 'public/profile_images/dummy.png';}?>" class="user-image img-circle elevation-2" alt="User Image">
       <span class="d-none d-md-inline"><?php echo $_SESSION["usrnm"]; ?></span>
     </a>
     <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <!-- User image -->
      <li class="user-header bg-primary">
        <img src="<?php if (isset($_SESSION['image'])){
         echo 'public/profile_images/'.$_SESSION['image'];
       }else {echo 'public/profile_images/dummy.png';}?>" class="img-circle elevation-2" alt="User Image">

       <p>
         <?php echo $_SESSION["usrnm"]; ?>
         <small>[
          <?php 
          if(isset ($_SESSION["user_id"]) ){
            echo $_SESSION["user_id"];
          }
          else if(isset ($_SESSION["designation"]) ){
            echo $_SESSION["designation"];
          }
          else{
            echo "";
          }
          
          ?>
        ]</small>
      </p>
    </li>
    <!-- Menu Footer-->
    <li class="user-footer">
      <div class="float-left">
        <?php
                //Check type of user

                //Student
        if($_SESSION['type'] == "Student") { ?>
          <a href="studentProfile.php" class="btn btn-default btn-flat">Profile</a>
          <?php
        }
                //Faculty
        else if($_SESSION['type'] == "Faculty"){ ?>
          <a href="facultyProfile.php" class="btn btn-default btn-flat">Profile</a>
          <?php
        }
                //Other users
        else { ?>
          <button class="btn btn-default btn-flat" disabled>Profile</button>
          <?php
        }


        ?>

      </div>
      <div class="float-right">
        <form id="signout" action="home.php" method="post">
          <a href="logout.php"  class="btn btn-default btn-flat">Sign out</a>
          <input type="hidden" name="signout" value="signout"/>
        </form>

      </div>
    </li>
  </ul>
</li>



</ul>
</nav>