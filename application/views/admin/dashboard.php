<section class="content-header">
  <h1>
    Dashboard
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>


<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-lg-3 col-xs-3">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h2><?= $po_matgis ?></h2>

          <p>PO Matgis</p>
        </div>
        <div class="icon">
          <i class="fa fa-shopping-bag"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-3">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h2><?= $total_produk ?></h2>

          <p>Material terdaftar</p>
        </div>
        <div class="icon">
          <i class="fa fa-cube"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-3">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h2><?= $total_user ?></h2>

          <p>Pengguna Yang Teregistrasi</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-3">
      <!-- small box -->
      <div class="small-box bg-blue">
        <div class="inner">
          <h2><?= $total_sda_app ?></h2>

          <p>Sumber Daya</p>
        </div>
        <div class="icon">
          <i class="ion ion-android-cloud-done"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <section class="col-lg-6 connectedSortable">
      <!-- Custom tabs (Charts with tabs)-->
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">

          <li class="pull-left header">Evaluasi dan monitoring
          </li>
          <div class="pull-right" style="width : 100px">
            <select class="form-control" name="" onchange="App.initWikaChart($(this).val())">
              <option value="" disabled>Pilih Tahun</option>
              <?php
              $tahun = date('Y');
              foreach (range($tahun - 2, $tahun + 1) as $v) {
                $sel = "";
                if ($tahun == $v) {
                  $sel = "selected";
                }
              ?>
                <option value="<?= $v ?>" <?= $sel ?>><?= $v ?></option>
              <?php
              }

              ?>
            </select>
          </div>
        </ul>
        <div class="tab-content no-padding">
          <!-- Morris chart - Sales -->
          <div id="wikachart" style="width: 100%; min-width: 400px; margin: 0 auto ;height : 500px"></div>
        </div>
      </div>
      <!-- /.nav-tabs-custom -->
      <!-- /.box -->
    </section>
    <section class="col-lg-6 connectedSortable">
      <!-- Custom tabs (Charts with tabs)-->
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">

          <li class="pull-left header">Evaluasi dan monitoring
          </li>
          <div class="pull-right" style="width : 100px">
            <select class="form-control" name="" onchange="App.initWikaChartSemen($(this).val())">
              <option value="" disabled>Pilih Tahun</option>
              <?php
              $tahun = date('Y');
              foreach (range($tahun - 2, $tahun + 1) as $v) {
                $sel = "";
                if ($tahun == $v) {
                  $sel = "selected";
                }
              ?>
                <option value="<?= $v ?>" <?= $sel ?>><?= $v ?></option>
              <?php
              }

              ?>
            </select>
          </div>
        </ul>
        <div class="tab-content no-padding">
          <!-- Morris chart - Sales -->
          <div id="wikachartSemen" style="width: 100%; min-width: 400px; margin: 0 auto ;height : 500px"></div>
        </div>
      </div>
      <!-- /.nav-tabs-custom -->
      <!-- /.box -->
    </section>
    <!-- <section class="col-lg-4 connectedSortable">
        <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
        <li class="pull-left header"></i>Monitoring Evaluasi </li>
    </ul>
    <div class="tab-content no-padding">
    <div id="monevchart" style="min-width: 310px; height: 300px; max-width: 100%; margin: 0 auto"></div>
</div>
</div>
</section> -->

    <!-- <section class="col-lg-4 connectedSortable">
<div class="nav-tabs-custom">
<ul class="nav nav-tabs pull-right">
<li class="pull-left header"></i>penyerapan material (Utilisasi pemakaian WIKA)</li>
</ul>
<div class="tab-content no-padding">
<div id="volumechart" style="min-width: 310px; height: 300px; max-width: 100%; margin: 0 auto"></div>
</div>
</div>
</section> -->
    <section class="col-lg-6 connectedSortable">
      <!-- Custom tabs (Charts with tabs)-->
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">

          <li class="pull-left header">Total Pembelian Ke Vendor
          </li>
          <div class="pull-right" style="width : 100px">
            <select class="form-control" name="" onchange="App.initVendorChart($(this).val())">
              <option value="" disabled>Pilih Tahun</option>
              <?php
              $tahun = date('Y');
              foreach (range($tahun - 2, $tahun + 1) as $v) {
                $sel = "";
                if ($tahun == $v) {
                  $sel = "selected";
                }
              ?>
                <option value="<?= $v ?>" <?= $sel ?>><?= $v ?></option>
              <?php
              }

              ?>
            </select>
          </div>
        </ul>
        <div class="tab-content no-padding">
          <!-- Morris chart - Sales -->
          <div id="vendorchart" style="width: 100%; min-widht: 400px; margin: 0 auto; height : 500px"></div>
        </div>
      </div>
      <!-- /.nav-tabs-custom -->
      <!-- /.box -->
    </section>
    <section class="col-lg-6 connectedSortable">
      <!-- Custom tabs (Charts with tabs)-->
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">

          <li class="pull-left header">Top 10 Product
          </li>
          <div class="pull-right" style="width : 100px">
            <select class="form-control" name="" onchange="App.initProductChart($(this).val())">
              <option value="" disabled>Pilih Tahun</option>
              <?php
              $tahun = date('Y');
              foreach (range($tahun - 2, $tahun + 1) as $v) {
                $sel = "";
                if ($tahun == $v) {
                  $sel = "selected";
                }
              ?>
                <option value="<?= $v ?>" <?= $sel ?>><?= $v ?></option>
              <?php
              }

              ?>
            </select>
          </div>
        </ul>
        <div class="tab-content no-padding">
          <!-- Morris chart - Sales -->
          <div id="productchart" style="width: 100%; min-widht: 400px; margin: 0 auto"></div>
        </div>
      </div>
      <!-- /.nav-tabs-custom -->
      <!-- /.box -->
    </section>
    <section class="col-lg-12 connectedSortable">
      <!-- Custom tabs (Charts with tabs)-->
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">

          <li class="pull-left header">Forecast
          </li>
          <div class="pull-right" style="width: 250px">
            <select class="form-control" id="option_chart_bulan" name="option_chart_bulan" data-selectjs="true">
              <option value="1" selected>Forecast 1 Bulan</option>
              <option value="2">Forecast 2 Bulan</option>
              <option value="3">Forecast 3 Bulan</option>
            </select>
          </div>
        </ul>
        <div class="tab-content no-padding">
          <div id="salesMonth" style="height:400px"></div>
        </div>
      </div>
      <!-- /.nav-tabs-custom -->
      <!-- /.box -->
    </section>
    <section class="col-lg-12 connectedSortable">
      <!-- Custom tabs (Charts with tabs)-->
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">

          <li class="pull-left header">Penyerapan Departemen
          </li>
          <div class="pull-right" style="width : 100px">
            <select class="form-control" name="" onchange="App.initDeptChart($(this).val())">
              <option value="" disabled>Pilih Tahun</option>
              <?php
              $tahun = date('Y');
              foreach (range($tahun - 2, $tahun + 1) as $v) {
                $sel = "";
                if ($tahun == $v) {
                  $sel = "selected";
                }
              ?>
                <option value="<?= $v ?>" <?= $sel ?>><?= $v ?></option>
              <?php
              }

              ?>
            </select>
          </div>
        </ul>
        <div class="tab-content no-padding">
          <!-- Morris chart - Sales -->
          <div id="dept-chart" style="width: 100%; min-width: 600px; height: 600px; margin: 0 auto"></div>
        </div>
      </div>
      <!-- /.nav-tabs-custom -->
      <!-- /.box -->
    </section>

  </div>
</section>
<?php $this->load->view('admin/dashboard/modal_po_vendor_v') ?>
<?php $this->load->view('admin/dashboard/modal_po_dept_v') ?>
<script data-main="<?php echo base_url() ?>assets/js/main/main-dashboard" src="<?php echo base_url() ?>assets/js/require.js"></script>
