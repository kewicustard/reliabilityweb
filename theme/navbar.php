<!-- replace default font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,300;0,400;0,700;1,400&display=fallback">
<style>
  :root{
    --font-family-sans-serif:"Source Sans Pro","Sarabun",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
    --font-family-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
  }

  body {
    font-family: "Source Sans Pro","Sarabun",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
  }
</style>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">      
      <?php
        if (isset($_SESSION['user_login']) OR isset($_SESSION['admin_login'])) {
      ?>
          <!-- Profile User Menu-->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <img src="dist/img/user2-160x160.jpg" alt="User Image" class="img-circle elevation-2"
                  style="opacity: .8; float: left; width: 25px; height: 25px; margin-right: 10px; margin-top: -1px;">
                  <!-- add by me => style="float: left; width: 25px; height: 25px; margin-right: 10px; margin-top: -1px;" -->
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- Profile Image -->
              <div class="card card-primary card-outline" style="margin-bottom: 0rem"> <!-- add by me => style="margin-bottom: 0rem" -->
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img class="profile-user-img img-fluid img-circle"
                          src="dist/img/user4-128x128.jpg"
                          alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">Nina Mcintire</h3>

                    <p class="text-muted text-center">Software Engineer</p>

                    <ul class="list-group list-group-unbordered mb-3">
                      <li class="list-group-item">
                        <b>Followers</b> <a class="float-right">1,322</a>
                      </li>
                      <!-- <li class="list-group-item">
                        <b>Following</b> <a class="float-right">543</a>
                      </li>
                      <li class="list-group-item">
                        <b>Friends</b> <a class="float-right">13,287</a>
                      </li> -->
                    </ul>

                    <a href="logout.php" class="btn btn-primary btn-block"><b>ออกจากระบบ</b></a>
                  </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>        
          </li>
          <!-- Profile User Menu-->
      <?php
        } else {
      ?>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="login.php" class="nav-link">เข้าสู่ระบบ</a>
          </li>
      <?php
        }
      ?>
      
    </ul>
  </nav>