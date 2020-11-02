<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ค้นหาสถิติจาก กฟผ. และกฟภ. ไฟฟ้าดับ</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
            <h1 class="m-0 text-dark">ค้นหาสถิติจาก กฟผ. และกฟภ. ไฟฟ้าดับ</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">ค้นหาสถิติไฟฟ้าดับจาก กฟผ. และกฟภ.</li>
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

        <!-- Search Input -->
        <div class="row">
          <div class="col">
            <!-- nav-tabs-search-custom -->
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#utilities" data-toggle="tab">ค้นหารายองค์กร</a></li>
                  <li class="nav-item"><a class="nav-link" href="#cause" data-toggle="tab">ค้นหารายสาเหตุ</a></li>
                  <button type="button" class="btn btn-tool ml-auto" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="utilities">
                    <!-- Search with utilities -->
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">องค์กร</label>
                        <div class="col-sm-9">
                          <!-- radio -->
                          <div class="form-group">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="utilities" id="egatpea" value="0" checked>
                              <label class="form-check-label" for="egatpea">กฟผ. และ กฟภ.</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="utilities" id="egat" value="1">
                              <label class="form-check-label" for="egat">กฟผ. (EGAT)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="utilities" id="pea" value="2">
                              <label class="form-check-label" for="pea">กฟภ. (PEA)</label>
                            </div>
                          </div>                          
                        </div>
                      </div>
                    </form>
                    <!-- /.Search with utilities -->
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="cause">
                    <!-- Search with Cause -->
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">สาเหตุ</label>
                        <div class="col-sm-9">
                          <select class="form-control select2" name="selectedCauses[]" multiple="multiple" data-placeholder="เลือกอย่างน้อย 1 สาเหตุ" style="width: 100%;">
                            <!-- fetch cause from api -->
                          </select>
                        </div>
                      </div>
                    </form>
                    <!-- /.Search with Cause -->
                  </div>
                  <!-- /.tab-pane -->

                  <form class="form-horizontal">
                    <div class="form-group row">
                      <label for="inputName2" class="col-sm-3 col-form-label">รูปแบบไฟฟ้าดับ</label>
                      <div class="col-sm-9">
                        <!-- radio -->
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioIntType" id="intTypeAll" value="0" checked>
                            <label class="form-check-label" for="intTypeAll">ทุกรูปแบบ (ส่งผลให้มีสายป้อนไฟฟ้าดับนาน หรือไฟฟ้าดับชั่วครู่)</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioIntType" id="intTypeSustain" value="1">
                            <label class="form-check-label" for="intTypeSustain">ส่งผลให้มีสายป้อนไฟฟ้าดับนาน (> 1 นาที)</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="radioIntType" id="intTypeMomentary" value="2">
                            <label class="form-check-label" for="intTypeMomentary">ส่งผลให้มีสายป้อนไฟฟ้าดับชั่วครู่ (<= 1 นาที)</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputExperience" class="col-sm-3 col-form-label">ระบุช่วงวันที่ต้องการค้นหา</label>
                      <div class="col-sm-6">
                        <!-- Date -->
                        <div class="input-group mb-2">
                          <input type="text" class="form-control datetimepicker-input" id="datetimepickerFrom" data-toggle="datetimepicker" data-target="#datetimepickerFrom"/>
                          <div class="input-group-prepend">
                            <span class="input-group-text">To</span>
                          </div>
                          <input type="text" class="form-control datetimepicker-input" id="datetimepickerTo" data-toggle="datetimepicker" data-target="#datetimepickerTo"/>
                        </div>
                        <span>รูปแบบวันที่เป็น วัน เดือน ปี ค.ศ. เช่น 1 ม.ค. 2020</span>
                        <!-- /.form group -->
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-3 col-sm-9">
                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                      </div>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-9 h6"><strong>หมายเหตุ</strong> </div>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->

          </div>
        </div>
        <!-- /.Search Input -->

        <!-- Datatable -->
        <div class="row d-none">
          <div class="col">
            <div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
                <table id="outageTable" class="table table-bordered table-striped">
                  <caption class="h5 text-center" style="caption-side: top;"></caption>
                  <thead>
                    <tr>
                      <th>วันที่</th>
                      <th>องค์กร</th>
                      <th>เวลาเริ่มไฟดับ (from)</th>
                      <th>เวลาจ่ายไฟกลับ (to)</th>
                      <th>ระยะเวลา (นาที)</th>
                      <th>สาเหตุ</th>
                      <th>อุปกรณ์ที่เกี่ยวข้อง</th>
                      <th>รีเลย์ที่แสดง</th>
                      <th>รายละเอียดที่เกี่ยวข้อง</th>
                      <th>จำนวนสายป้อนที่ได้รับผลกระทบ</th>
                      <th>ระยะเวลาสายป้อนไฟฟ้าดับรวม</th> <!-- SUM(time_eq) -->
                    </tr>
                  </thead>
                </table>
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
        <!-- /.Datatable -->

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
<!-- <script src="plugins/jquery-ui/jquery-ui.min.js"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- <script>
  $.widget.bridge('uibutton', $.ui.button)
</script> -->
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- Button -->
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<!-- <script src="plugins/daterangepicker/daterangepicker.js"></script> -->
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/moment/moment-with-locales.min.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/hilight_menu.js"></script>
<script src="dist/js/search-egatpea-index.js"></script>
</body>
</html>
