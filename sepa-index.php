<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ดัชนีความเชื่อถือได้ SEPA (E)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">ดัชนีความเชื่อถือได้ SEPA (E)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">SEPA (E)</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Selected Feature -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header p-2">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">เลือกปี</span>
                  </div>
                  <select class="form-control select2">
                    <option selected="selected">2563</option>
                    <option>2562</option>
                    <option>2561</option>
                    <option>2560</option>
                  </select>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <button type="button" class="btn btn-tool" data-card-widget="chartAll">
                        <i class="fas fa-chart-bar"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="tableAll">
                        <i class="fas fa-table"></i>
                      </button>
                    </span>
                  </div>
                </div>
              </div><!-- /.card-header -->
            </div>
          </div>
        </div>
        <!-- /.Selected Feature -->
        <!-- MEA Charts -->
        <section class="row">
          <!-- Charts Header -->
          <div class="col-12 mb-1">
            <h4 class="m-0 text-dark">กฟน.</h4>
          </div>
          <!-- BAR CHART S-saifi -->
          <div class="col-lg-6">
            <div class="card card-secondary">
              <div class="card-header">
                <h4 class="card-title">SAIFI<small></small></h4>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="chart">
                    <i class="fas fa-chart-bar"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="table">
                    <i class="fas fa-table"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body"> <!-- add class 'table-responsive p-0' for table showing -->
                <div class="chart">
                  <canvas id="chartCanvas1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.chart-responsive -->
                <table id="tableCanvas1" class="table table-striped text-nowrap d-none">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>ม.ค.</th>
                        <th>ก.พ.</th>
                        <th>มี.ค.</th>
                        <th>เม.ย.</th>
                        <th>พ.ค.</th>
                        <th>มิ.ย.</th>
                        <th>ก.ค.</th>
                        <th>ส.ค.</th>
                        <th>ก.ย.</th>
                        <th>ต.ค.</th>
                        <th>พ.ย.</th>
                        <th>ธ.ค.</th>
                    </tr>
                  </thead>
                  <tbody>
                      <!-- here is table data -->
                  </tbody>
                </table>
                <!-- /.table-responsive -->
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

          <!-- BAR CHART S-saidi -->
          <div class="col-lg-6">
            <div class="card card-secondary">
              <div class="card-header">
                <h4 class="card-title">SAIDI<small></small></h4>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="chart">
                    <i class="fas fa-chart-bar"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="table">
                    <i class="fas fa-table"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="chartCanvas2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.chart-responsive -->
                <table id="tableCanvas2" class="table table-striped text-nowrap d-none">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>ม.ค.</th>
                        <th>ก.พ.</th>
                        <th>มี.ค.</th>
                        <th>เม.ย.</th>
                        <th>พ.ค.</th>
                        <th>มิ.ย.</th>
                        <th>ก.ค.</th>
                        <th>ส.ค.</th>
                        <th>ก.ย.</th>
                        <th>ต.ค.</th>
                        <th>พ.ย.</th>
                        <th>ธ.ค.</th>
                    </tr>
                  </thead>
                  <tbody>
                      <!-- here is table data -->
                  </tbody>
                </table>
                <!-- /.table-responsive -->
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
        </section>
        <!-- /.MEA Charts -->

        <hr class="mt-0">
        
        <!-- T&S Charts -->
        <section class="row">
          <!-- Charts Header -->
          <div class="col-12 mb-1">
            <h4 class="m-0 text-dark">สายส่ง และสถานีฯ</h4>
          </div>
          <!-- BAR CHART S-saifi -->
          <div class="col-lg-6">
            <div class="card card-secondary">
              <div class="card-header">
                <h4 class="card-title">SAIFI<small></small></h4>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="chart">
                    <i class="fas fa-chart-bar"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="table">
                    <i class="fas fa-table"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="chartCanvas3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.chart-responsive -->
                <table id="tableCanvas3" class="table table-striped text-nowrap d-none">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>ม.ค.</th>
                        <th>ก.พ.</th>
                        <th>มี.ค.</th>
                        <th>เม.ย.</th>
                        <th>พ.ค.</th>
                        <th>มิ.ย.</th>
                        <th>ก.ค.</th>
                        <th>ส.ค.</th>
                        <th>ก.ย.</th>
                        <th>ต.ค.</th>
                        <th>พ.ย.</th>
                        <th>ธ.ค.</th>
                    </tr>
                  </thead>
                  <tbody>
                      <!-- here is table data -->
                  </tbody>
                </table>
                <!-- /.table-responsive -->
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

          <!-- BAR CHART S-saidi -->
          <div class="col-lg-6">
            <div class="card card-secondary">
              <div class="card-header">
                <h4 class="card-title">SAIDI<small></small></h4>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="chart">
                    <i class="fas fa-chart-bar"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="table">
                    <i class="fas fa-table"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="chartCanvas4" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.chart-responsive -->
                <table id="tableCanvas4" class="table table-striped text-nowrap d-none">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>ม.ค.</th>
                        <th>ก.พ.</th>
                        <th>มี.ค.</th>
                        <th>เม.ย.</th>
                        <th>พ.ค.</th>
                        <th>มิ.ย.</th>
                        <th>ก.ค.</th>
                        <th>ส.ค.</th>
                        <th>ก.ย.</th>
                        <th>ต.ค.</th>
                        <th>พ.ย.</th>
                        <th>ธ.ค.</th>
                    </tr>
                  </thead>
                  <tbody>
                      <!-- here is table data -->
                  </tbody>
                </table>
                <!-- /.table-responsive -->
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
        </section>
        <!-- /.T&S Charts -->

        <hr class="mt-0">

        <!-- Feeder Charts -->
        <section class="row">
          <!-- Charts Header -->
          <div class="col-12 mb-1">
            <h4 class="m-0 text-dark">สายป้อน</h4>
          </div>
          <!-- BAR CHART S-saifi -->
          <div class="col-lg-6">
            <div class="card card-secondary">
              <div class="card-header">
                <h4 class="card-title">SAIFI<small></small></h4>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="chart">
                    <i class="fas fa-chart-bar"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="table">
                    <i class="fas fa-table"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="chartCanvas5" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.chart-responsive -->
                <table id="tableCanvas5" class="table table-striped text-nowrap d-none">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>ม.ค.</th>
                        <th>ก.พ.</th>
                        <th>มี.ค.</th>
                        <th>เม.ย.</th>
                        <th>พ.ค.</th>
                        <th>มิ.ย.</th>
                        <th>ก.ค.</th>
                        <th>ส.ค.</th>
                        <th>ก.ย.</th>
                        <th>ต.ค.</th>
                        <th>พ.ย.</th>
                        <th>ธ.ค.</th>
                    </tr>
                  </thead>
                  <tbody>
                      <!-- here is table data -->
                  </tbody>
                </table>
                <!-- /.table-responsive -->
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

          <!-- BAR CHART S-saidi -->
          <div class="col-lg-6">
            <div class="card card-secondary">
              <div class="card-header">
                <h4 class="card-title">SAIDI<small></small></h4>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="chart">
                    <i class="fas fa-chart-bar"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="table">
                    <i class="fas fa-table"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="chartCanvas6" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.chart-responsive -->
                <table id="tableCanvas6" class="table table-striped text-nowrap d-none">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>ม.ค.</th>
                        <th>ก.พ.</th>
                        <th>มี.ค.</th>
                        <th>เม.ย.</th>
                        <th>พ.ค.</th>
                        <th>มิ.ย.</th>
                        <th>ก.ค.</th>
                        <th>ส.ค.</th>
                        <th>ก.ย.</th>
                        <th>ต.ค.</th>
                        <th>พ.ย.</th>
                        <th>ธ.ค.</th>
                    </tr>
                  </thead>
                  <tbody>
                      <!-- here is table data -->
                  </tbody>
                </table>
                <!-- /.table-responsive -->
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
        </section>
        <!-- /.Feeder Charts -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- footer -->
    <?php
        include "theme/footer.php"
    ?>
  <!-- /.footer -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
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
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/hilight_menu.js"></script>
<script src="dist/js/sepa-index.js"></script>
</body>
</html>
