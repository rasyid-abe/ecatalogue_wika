<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<section class="content-header">
  <h1>
    Dashboard Matgis
    <small style="margin-top: -15px;">
      <select class="form-control" id="filter_tahun" onchange="App.getDataDashboard()">
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
    </small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard Matgis</li>
  </ol>
</section>
 
<style>
  .mycard {
    width: 100%;
    background-color: white;
    padding: 5px;
    color: black;
    font-weight: bold;
    border-radius: 3px;
  }

  .mb-3 {
    margin-bottom: 20px;
  }

  .card-text {
    margin-bottom: -2px;
    font-size: 9pt;
  }

  #mapid {
    height: 400px;
  }
</style>

<section class="content">
  <div class="row text-center">
    <div class="col-lg-3 col-xs-3">
      <!-- small box -->
      <div class="small-box bg-lime">
        <div class="inner">
          <div id="po_matgis"></div>
          <p>PO Matgis</p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-3">
      <!-- small box -->
      <div class="small-box bg-orange">
        <div class="inner">
          <div id="kode_sda"></div>
          <p>Kode SDA</p>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow" id="nilai_tr">
        <div class="inner">
          <div id="nilai_transaksi"></div>
          <p>Nilai Transaksi</p>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-blue">
        <div class="inner">
          <div id="efisiensi_po"></div>
          <p>Cost Avoidence PO Matgis</p>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <div id="efisiensi_po_precent"></div>
          <p>Cost Avoidence</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-5">
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">

          <li class="pull-left header">Evaluasi dan monitoring</li>
        </ul>
        <div class="tab-content no-padding">
          <!-- Morris chart - Sales -->
          <div id="wikachart"></div>
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      <div class="mycard">
        <div class="card">
          <div id="mapid"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-5">
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">

          <li class="pull-left header">Top 10 Product
          </li>
        </ul>
        <div class="tab-content no-padding">
          <!-- Morris chart - Sales -->
          <div id="productchart" style="width: 100%; margin: 0 auto"></div>
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header">Total Pembelian Ke Vendor</li>
        </ul>
        <div class="tab-content no-padding">
          <!-- Morris chart - Sales -->
          <div id="vendorchart" style="width: 100%; margin: 0 auto;"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12">
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">

          <li class="pull-left header">Forecast
          </li>
          <div class="pull-right" style="width: 250px">
            <select class="form-control" id="option_chart_bulan" onchange="App.getDataDashboard()" data-selectjs="true">
              <option value="1" selected>Forecast 1 Bulan</option>
              <option value="2">Forecast 2 Bulan</option>
              <option value="3">Forecast 3 Bulan</option>
            </select>
          </div>
        </ul>
        <div class="tab-content no-padding">
          <div id="salesMonth"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12">
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">

          <li class="pull-left header">Penyerapan Departemen
          </li>
        </ul>
        <div class="tab-content no-padding">
          <!-- Morris chart - Sales -->
          <div id="dept-chart" style="width: 100%; margin: 0 auto"></div>
        </div>
      </div>
    </div>
  </div>

</section>

<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:900px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="modal_title">Modal title</h5>
        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="modal_body"></div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('admin/dashboard/modal_po_vendor_v') ?>
<?php $this->load->view('admin/dashboard/modal_po_dept_v') ?>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script data-main="<?php echo base_url() ?>assets/js/main/main-dashboard_matgis" src="<?php echo base_url() ?>assets/js/require.js"></script>
