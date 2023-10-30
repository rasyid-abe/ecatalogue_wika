<section class="content-header">
 <h1>
   <?php echo ucwords($page)?>
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active"><?php echo ucwords($page)?></li>
 </ol>
</section>

<section class="content">
<?php if($is_can_search){?>
 <div class="box box-bottom">
   <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i> Export <?php echo ucwords($page)?></h3>
   <a href="<?= base_url()?>forecast" class="btn btn-sm btn-warning pull-right"><i class='fa fa-arrow-left'></i> Kembali</a>
   <div class="full-width datatableButton text-right">

   </div>
   </div>
   <form id="form" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="">Kategori</label>
            <select class="form-control" id="category_id" name="category_id" data-selectjs="true">
             <option value="" disabled selected>Pilih Kategori</option>
             <?php
              foreach ($category as $key => $value) { ?>
                  <option value="<?php echo $value->id?>"><?php echo $value->name?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <?php
                $array_bulan[1] = "Januari";
                $array_bulan[2] = "Februari";
                $array_bulan[3] = "Maret";
                $array_bulan[4] = "April";
                $array_bulan[5] = "Mei";
                $array_bulan[6] = "Juni";
                $array_bulan[7] = "Juli";
                $array_bulan[8] = "Agustus";
                $array_bulan[9] = "September";
                $array_bulan[10] = "Oktober";
                $array_bulan[11] = "November";
                $array_bulan[12] = "Desember";
            ?>
            <label for="">Bulan</label>
            <select class="form-control" id="month_forecast" name="month_forecast" data-selectjs="true">
             <option value="" disabled selected>Pilih Bulan</option>
             <?php
              foreach ($array_bulan as $key => $value) {
                    $select ="";
                    if($key == $month_now){
                        $select ="selected";
                    }
                ?>
                  <option value="<?php echo $key?>" <?php echo $select?>><?php echo $value?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="">Tahun</label>
            <select class="form-control" id="year_forecast" name="year_forecast" data-selectjs="true">
             <option value="" disabled selected>Pilih Tahun</option>
             <?php
              foreach ($year as $key => $value) {
                    $select ="";
                    if($value == $year_now){
                        $select ="selected";
                    }
                ?>
                  <option value="<?php echo $value?>" <?php echo $select?>><?php echo $value?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="">Periode (Jumlah Bulan)</label>
            <input type="text" class="form-control number" name="periode" id="periode" min="1" value="1">
            <!-- <select class="form-control" id="periode" name="periode" data-selectjs="true">
             <option value="" disabled selected>Pilih Periode</option>
                <option value="2">2 Bulan</option>
                <option value="3">3 Bulan</option>
                <option value="6">6 Bulan</option>
            </select> -->
          </div>
          <div class="form-group input-all" style="display:none">
              <div class="checkbox">
                  <label>
                      <input type="checkbox" name="is_input_all" id="is_input_all" value="1" checked> Input All
                  </label>
              </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="form-group col-md-6 harga">
                    <label for="">Harga Bawah</label>
                    <input type="text" class="form-control" name="price" id="price" onkeyup="App.format(this)">
                </div>
                <div class="form-group col-md-6 hargaupper">
                    <label for="">Harga Atas</label>
                    <input type="text" class="form-control" name="price_upper" id="price_upper" onkeyup="App.format(this)">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
          <button type="submit" class="btn btn-success">Simpan Data</button>
        </div>
      </div>
    </div>
  </form>
    <div id="hot" style="width: 100%;" class="hidden">
 </div>

<?php } ?>

</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-forecast" src="<?php echo base_url()?>assets/js/require.js"></script>
