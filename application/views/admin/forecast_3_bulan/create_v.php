<section class="content-header">
 <h1>
   <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?>
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active"><?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></li>
 </ol>
</section>

<section class="content">
<?php if($is_can_search){?>
 <div class="box box-bottom">
   <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i> Export <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
   <a href="<?= base_url()?>forecast_3_bulan" class="btn btn-sm btn-warning pull-right"><i class='fa fa-arrow-left'></i> Kembali</a>
   <div class="full-width datatableButton text-right">

   </div>
   </div>
   <form id="form" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group col-12 row">
            <div class="col-sm-6">
              <label for="">Tanggal Awal</label>
              <div class="" data-datepicker="true">
                <input class="form-control" type="text" value="" id="start_date" name="start_date">
              </div>
            </div>
            <div class="col-sm-6">
              <label for="">Tanggal Akhir</label>
              <div class="" data-datepicker="true">
                <input class="form-control" type="text" value="" id="end_date" name="end_date">
              </div>
            </div>
          </div>
          <div class="form-group col-12 row">
            <div class="col-sm-6">
                <label for="">Data dari</label>
                <div class="radio">
                  <label>
                    <input type ="radio" name = "data_from" id = "data_from_1" value = "1">
                    Forecast
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type ="radio" name = "data_from" id = "data_from_0" value = "0" checked>
                    Riwayat Harga
                  </label>
                </div>
            </div>
            <div class="col-sm-6 hidden">
                <label for="">Separator CSV</label>
                <div class="radio">
                  <label>
                    <input type ="radio" name = "separator" id = "separator_1" value = "1" checked>
                    comma(,)
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type ="radio" name = "separator" id = "separator_0" value = "0">
                    semi-colon(;)
                  </label>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
          <button type="submit" class="btn btn-success hidden">Export to CSV</button>
          <button type="submit" class="btn btn-success" id="btngetdata">Ambil Data</button>
          <a href = "<?= base_url()?>forecast/import"><button type="button" class="btn btn-primary hidden">Import CSV</button></a>
          <button type="button" class="btn btn-info" id="btn-save" disabled>Simpan Data</button>
        </div>
      </div>
    </div>
  </form>
    <button type="button" id="btn-plus">Tambah Kolom</button>
    <button type="button" id="btn-min">Hapus Kolom</button>
    <div id="hot" style="width: 100%;" class="">
 </div>

<?php } ?>

</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-forecast_3_bulan" src="<?php echo base_url()?>assets/js/require.js"></script>
