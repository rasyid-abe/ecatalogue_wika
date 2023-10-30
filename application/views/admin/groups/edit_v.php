<?php if(!empty($this->session->flashdata('message_error'))){?>
<div class="alert alert-danger">
<?php
   print_r($this->session->flashdata('message_error'));
?>
</div>
<?php }?>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Ubah <?= $page ?></h3>
    </div>
     <form id="form" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
        <div class="form-group">
          <label for="">Nama Departemen</label>
            <input class="form-control" id="name" name="name" value="<?php echo $name;?>" autocomplete="off" readonly>
          </div>
          <div class="form-group">
            <label for="">Nama General Manager</label>
              <input class="form-control" id="general_manager" name="general_manager" autocomplete="off" value="<?= $general_manager ?>" readonly>
          </div>
          <div class="form-group">
            <label for="">Kode Departemen</label>
              <input class="form-control" id="departemen_code2" name="departemen_code2" autocomplete="off" value="<?= $departemen_code2 ?>">
          </div>
          <div class="form-group">
              <label for="">TTD General Manager</label>
              <input type="file" class="form-control" id="ttd" name="ttd" accept="image/png">
          </div>
        </div>
      </div>
        </div>
         <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="<?php echo base_url();?>group" class="btn btn-primary btn-danger">Batal</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>


<script data-main="<?php echo base_url()?>assets/js/main/main-group" src="<?php echo base_url()?>assets/js/require.js"></script>
