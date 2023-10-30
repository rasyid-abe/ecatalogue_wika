<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i><?php echo ucwords($page) ?></h3>
    </div>
     <form id="form" method="post">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <select id="enum_payment_method_id" name="enum_payment_method_id" class="form-control" required data-selectjs="true">
                  <option value="">Pilih Metode</option>
                  <?php
                  foreach ($enum_payment as $key => $value) {
                  $select = "";
                    if($value->id == $enum_payment_id){
                      $select="selected";
                    }
                    ?>
                    <option value="<?php echo $value->id;?>" <?php echo $select ?>><?php echo $value->name;?></option>
                  <?php }
                  ?>
                </select>
            </div>
            <div class="form-group">
              <label for="">Lama (hari)</label>
              <input class="form-control number" value="<?php echo $day;?>" type="text" id="day" name="day" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="">Deskripsi</label>
              <textarea class="form-control" id="description" name="description" autocomplete="off"><?php echo $description;?></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?php echo base_url();?>payment_method" class="btn btn-primary btn-danger">Batal</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>


<script data-main="<?php echo base_url()?>assets/js/main/main-payment_method" src="<?php echo base_url()?>assets/js/require.js"></script>


</section>
