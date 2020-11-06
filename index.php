<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - สรุปคะแนนตัวชี้วัด</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

  <!-- Navbar -->
    <?php
        include_once "theme/navbar.php"
    ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    <?php
        include_once "theme/main_sidebar.php"
    ?>
  <!-- /.Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0 text-dark">สรุปคะแนนดัชนีฯ ตามตัวชี้วัดต่างๆ</h1>
          </div><!-- /.col -->
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">สรุปคะแนน</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <!-- Container MEA Strategy -->
          <div class="col-lg-6" id="strategy-card">
            <div class="card card-outline card-secondary"> <!-- change "card-secondary" to others for changing card's color -->
              <div class="card-header">
                <h3 class="card-title">ดัชนีฯ ตามแผนยุทธศาสตร์</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- container small box -->
                <div class="row">
                  <!-- small box -->
                  <div class="col-6">
                    <div class="small-box mb-0 bg-light">
                      <div class="inner">
                        <h3>-.--</h3>

                        <p>คะแนน SAIFI</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-help-circled"></i>
                      </div>
                      <a href="strategy-index.php" class="small-box-footer">ดูข้อมูลดัชนีฯ <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- small box -->
                  <div class="col-6">
                    <div class="small-box mb-0 bg-light">
                      <div class="inner">
                        <h3>-.--</h3>

                        <p>คะแนน SAIDI</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-help-circled"></i>
                      </div>
                      <a href="strategy-index.php" class="small-box-footer">ดูข้อมูลดัชนีฯ <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <!-- Loading (remove the following to stop the loading)-->
              <div class="overlay">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
              </div>
              <!-- end loading -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <!-- Container SEPA -->
          <div class="col-lg-6" id="sepa-card">
            <div class="card card-outline card-secondary">
              <div class="card-header">
                <h3 class="card-title">ดัชนีฯ ตามตัวชี้วัด SEPA</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- container small box -->
                <div class="row">
                  <div class="col-6">
                    <!-- small box -->
                    <div class="small-box mb-0 bg-light">
                      <div class="inner">
                        <h3>-.--</h3>

                        <p>คะแนน SAIFI</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-help-circled"></i>
                      </div>
                      <a href="sepa-index.php" class="small-box-footer">ดูข้อมูลดัชนีฯ <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-6">
                    <!-- small box -->
                    <div class="small-box mb-0 bg-light">
                      <div class="inner">
                        <h3>-.--</h3>

                        <p>คะแนน SAIDI</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-help-circled"></i>
                      </div>
                      <a href="sepa-index.php" class="small-box-footer">ดูข้อมูลดัชนีฯ <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                </div>
              </div>
              <!-- /.card-body -->
              <!-- Loading (remove the following to stop the loading)-->
              <div class="overlay">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
              </div>
              <!-- end loading -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <!-- Container SEPA Focus Group -->
          <div class="col-lg-6" id="sepa-focus-group-card">
            <div class="card card-outline card-secondary">
              <div class="card-header">
                <h3 class="card-title">ดัชนีฯ ตามตัวชี้วัด SEPA Focus Group</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- container small box -->
                <div class="row">
                  <div class="col-6">
                    <!-- small box -->
                    <div class="small-box mb-0 bg-light">
                      <div class="inner">
                        <h3>-.--</h3>

                        <p>คะแนน SAIFI</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-help-circled"></i>
                      </div>
                      <a href="sepa-focus-group-index.php" class="small-box-footer">ดูข้อมูลดัชนีฯ <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-6">
                    <!-- small box -->
                    <div class="small-box mb-0 bg-light">
                      <div class="inner">
                        <h3>-.--</h3>

                        <p>คะแนน SAIDI</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-help-circled"></i>
                      </div>
                      <a href="sepa-focus-group-index.php" class="small-box-footer">ดูข้อมูลดัชนีฯ <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                </div>
              </div>
              <!-- /.card-body -->
              <!-- Loading (remove the following to stop the loading)-->
              <div class="overlay">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
              </div>
              <!-- end loading -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
 
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- footer -->
    <?php
        include_once "theme/footer.php"
    ?>
  <!-- /.footer -->

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/constant/constant.js"></script>
<script src="dist/js/hilight_menu.js"></script>
<script src="dist/js/index.js"></script>
<!-- add-scirpt -->
<?php 
  if (isset($_SESSION['user_login']) OR isset($_SESSION['admin_login'])) {
    include "theme/add-script.php";
  }
?>
<!-- /.add-script -->
</body>
</html>
