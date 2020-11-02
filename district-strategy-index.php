<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ดัชนีฯ ตามแผนยุทธศาสตร์ (S) ราย ฟข.</title>

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
            <h1 class="m-0 text-dark">ดัชนีฯ ตามแผนยุทธศาสตร์ (S) ราย ฟข.</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">ยุทธศาสตร์ (S) ราย ฟข.</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <hr class="mt-0">
        <!-- Select year and district -->
        <div class="row">
          <div class="col">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">กำหนดเงื่อนไข</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="input-group" style="width: 100%;">
                      <div class="input-group-prepend">
                        <span class="input-group-text">เลือกปี</span>
                      </div>
                      <select class="form-control select2">
                        <option selected>2563</option>
                        <option>2562</option>
                        <option>2561</option>
                        <option>2560</option>
                        <option>2559</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="input-group" style="width: 100%;">
                      <div class="input-group-prepend">
                        <span class="input-group-text">เลือกการไฟฟ้านครหลวงเขต</span>
                      </div>
                      <select class="form-control select2">
                        <option value="0" selected>ทุกการไฟฟ้าเขต</option>
                        <option value="1">บางกะปิ (ฟขก.)</option>
                        <option value="2">บางพลี (ฟขพ.)</option>
                        <option value="3">บางใหญ่ (ฟขญ.)</option>
                        <option value="4">คลองเตย (ฟขต.)</option>
                        <option value="5">มีนบุรี (ฟขม.)</option>
                        <option value="6">นนทบุรี (ฟขน.)</option>
                        <option value="7">ราษฎร์บูรณะ (ฟขร.)</option>
                        <option value="8">สามเสน (ฟขส.)</option>
                        <option value="9">สมุทรปราการ (ฟขป.)</option>
                        <option value="10">ธนบุรี (ฟขธ.)</option>
                        <option value="11">วัดเลียบ (ฟขล.)</option>
                        <option value="12">ยานนาวา (ฟขว.)</option>
                        <option value="13">บางขุนเทียน (ฟขท.)</option>
                        <option value="14">บางเขน (ฟขข.)</option>
                        <option value="15">บางบัวทอง (ฟขอ.)</option>
                        <option value="16">ลาดกระบัง (ฟขง.)</option>
                        <option value="17">นวลจันทร์ (ฟขจ.)</option>
                        <option value="18">บางนา (ฟขบ.)</option>
                      </select>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-secondary" name="show">คลิกเพื่อแสดง</button>
                        <button type="button" class="btn btn-secondary" data-card-widget="chartAll">
                          <i class="fas fa-chart-bar"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" data-card-widget="tableAll">
                          <i class="fas fa-table"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <hr class="mt-0">
        <!-- All District Charts -->
        <div class="row">
          <!-- SAIFI -->
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">SAIFI<small></small></h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">แผนภูมิ</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">ตาราง</a></li>
                  <!-- <button type="button" class="btn btn-tool d-none d-lg-inline">
                    <i class="fas fa-download"></i>
                  </button> -->
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </ul>
              </div>
              <!-- /.card-header -->
              <div class="card-body"> <!-- add class 'table-responsive p-0' for table showing -->
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <div class="chart">
                      <canvas id="chartCanvas1" height="180" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                    <table id="tableCanvas1" class="table table-sm table-striped table-hover text-nowrap">
                      <thead>
                        <tr>
                            <th>ฟข.</th>
                            <th>KPI</th>
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
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- ./card-body -->
              <!-- Loading (remove the following to stop the loading)-->
              <div class="overlay">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
              </div>
              <!-- end loading -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <!-- SAIDI -->
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">SAIDI<small></small></h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_3" data-toggle="tab">แผนภูมิ</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab">ตาราง</a></li>
                  <!-- <button type="button" class="btn btn-tool d-none d-lg-inline">
                    <i class="fas fa-download"></i>
                  </button> -->
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </ul>
              </div>
              <!-- /.card-header -->
              <div class="card-body"> <!-- add class 'table-responsive p-0' for table showing -->
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_3">
                    <div class="chart">
                      <canvas id="chartCanvas2" height="180" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_4">
                    <table id="tableCanvas2" class="table table-sm table-striped table-hover text-nowrap">
                      <thead>
                        <tr>
                            <th>ฟข.</th>
                            <th>KPI</th>
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
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- ./card-body -->
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

        <!-- District Charts -->
        <div class="row">
          <!-- Charts Header -->
          <div class="col-12 mb-1">
            <h4 class="m-0 text-dark">การไฟฟ้านครหลวงเขต </h4>
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
                    <i class="fas fa-times"></i></button>
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
        </div>
        <!-- /.District Charts -->
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
<script src="dist/js/district-strategy-index.js"></script>
</body>
</html>
