<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">MEA Reliability</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">แผนกสถิติระบบไฟฟ้า</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- Dashboard - สรุปคะแนน -->
          <li class="nav-item" id="dashboard">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard - สรุปคะแนน
              </p>
            </a>
          </li>

          <li class="nav-header">ดัชนีความเชื่อถือได้ต่างๆ</li>
          <!-- ดัชนีความเชื่อถือได้ -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                ดัชนีความเชื่อถือได้
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" id="strategy-index">
                <a href="strategy-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ยุทธศาสตร์ (S)</p>
                </a>
              </li>
              <li class="nav-item" id="sepa-index">
                <a href="sepa-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SEPA (E)</p>
                </a>
              </li>
              <li class="nav-item" id="sepa-focus-group-index">
                <a href="sepa-focus-group-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SEPA Focus Group (E)</p>
                </a>
              </li>
              <li class="nav-item" id="industrial-index">
                <a href="industrial-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>นิคมอุตสาหกรรม</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- ดัชนีความเชื่อถือได้ ราย ฟข.-->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                ดัชนีฯ ราย ฟข.
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" id="district-strategy-index">
                <a href="district-strategy-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ยุทธศาสตร์ (S)</p>
                </a>
              </li>
              <li class="nav-item" id="district-sepa-index">
                <a href="district-sepa-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SEPA (E)</p>
                </a>
              </li>
              <li class="nav-item" id="district-sepa-focus-group-index">
                <a href="district-sepa-focus-group-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SEPA Focus Group (E)</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- ตรวจสอบดัชนีฯ -->
          <?php if (isset($_SESSION['user_login']) OR isset($_SESSION['admin_login'])) : ?>
            <li class="nav-header">ตรวจสอบดัชนีฯ ต่างๆ</li>
            <!-- ดัชนีความเชื่อถือได้ -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-bar"></i>
                <p>
                  ตรวจสอบดัชนีฯ
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" id="verify-strategy-index">
                  <a href="verify-strategy-index.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ยุทธศาสตร์ (S)</p>
                  </a>
                </li>
                <li class="nav-item" id="verify-sepa-index">
                  <a href="verify-sepa-index.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>SEPA (E)</p>
                  </a>
                </li>
                <li class="nav-item" id="verify-sepa-focus-group-index">
                  <a href="verify-sepa-focus-group-index.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>SEPA Focus Group (E)</p>
                  </a>
                </li>
              </ul>
            </li>
            <!-- ดัชนีความเชื่อถือได้ ราย ฟข.-->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-bar"></i>
                <p>
                  ตรวจสอบดัชนีฯ ราย ฟข.
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" id="verify-district-strategy-index">
                  <a href="strategy-index.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ยุทธศาสตร์ (S)</p>
                  </a>
                </li>
                <li class="nav-item" id="verify-district-sepa-index">
                  <a href="sepa-index.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>SEPA (E)</p>
                  </a>
                </li>
                <li class="nav-item" id="verify-district-sepa-focus-group-index">
                  <a href="sepa-focus-group-index.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>SEPA Focus Group (E)</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php endif; ?>

          <li class="nav-header">ค้นหาสถิติไฟฟ้าดับต่างๆ</li>
          <!-- ค้นหาสถิติไฟฟ้าดับ -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                ค้นหาสถิติไฟฟ้าดับ
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" id="search-feeder-index">
                <a href="search-feeder-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>สายป้อน</p>
                </a>
              </li>
              <li class="nav-item" id="search-line-index">
                <a href="search-line-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>สายส่ง</p>
                </a>
              </li>
              <li class="nav-item" id="search-station-index">
                <a href="search-station-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>สถานีฯ</p>
                </a>
              </li>
              <li class="nav-item" id="search-egatpea-index">
                <a href="search-egatpea-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>กฟผ. และกฟภ.</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- ตรวจสอบดัชนีฯ -->
          <?php if (isset($_SESSION['user_login']) OR isset($_SESSION['admin_login'])) : ?>
            <li class="nav-header">ตรวจสอบสถิติไฟฟ้าดับต่างๆ</li>
            <!-- ตรวจสอบเหตุการณ์ไฟฟ้าดับ -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-bar"></i>
                <p>
                  ตรวจสอบสถิติไฟฟ้าดับ
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" id="verify-stat-f">
                  <a href="verify-strategy-index.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>สายป้อน</p>
                  </a>
                </li>
                <li class="nav-item" id="verify-stat-ts">
                  <a href="verify-sepa-index.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>สายส่ง และสถานีฯ</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php endif; ?>

          <li class="nav-header">เอกสารที่เกี่ยวข้อง</li>
          <!-- เอกสารการคำนวณดัชนีฯ -->
          <li class="nav-item">
            <a href="documents/cal_indices.pdf" class="nav-link" target="_blank">
              <i class="nav-icon fas fa-file"></i>
              <p>การคำนวณดัชนีฯ</p>
            </a>
          </li>

          <!-- <li class="nav-header">สถิติและข้อมูลความเชื่อถือได้</li> -->
          <!-- สถิติและข้อมูลความเชื่อถือได้ -->
          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                สถิติและข้อมูลฯ
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" id="stat-mea-index">
                <a href="stat-mea-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>กฟน.</p>
                </a>
              </li>
              <li class="nav-item" id="search-stat-f">
                <a href="strategy-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>สายป้อน</p>
                </a>
              </li>
              <li class="nav-item" id="search-stat-ts">
                <a href="sepa-index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>สายส่ง และสถานีฯ</p>
                </a>
              </li>
            </ul>
          </li> -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>