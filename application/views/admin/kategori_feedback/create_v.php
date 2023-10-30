<section class="content">
<div class="full-width padding">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Kategori Feedback</h3>
    </div>
      <form id="form" method="POST" action="" enctype="multipart/form-data">
        <div class="box-body">
          <?php if(!empty($this->session->flashdata('message_error'))){?>
          <div class="alert alert-danger">
          <?php
             print_r($this->session->flashdata('message_error'));
          ?>
          </div>
          <?php }?>
          <?php echo validation_errors() ?>
          <div class="form-group">
              <label for="">Kategori Feedback</label>
              <input type="text" name="name" value="" class="form-control">
          </div>
          <div class="box-footer">
              <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                      <button type="submit" class="btn btn-primary" id="save-btn">Simpan</button>
                      <a href="<?php echo base_url();?><?= $cont ?>" class="btn btn-primary btn-danger">Batal</a>
             </div>
              </div>
          </div>
      </form>
    </div>
</section>

<script data-main="<?php echo base_url()?>assets/js/main/main-<?= $cont ?>" src="<?php echo base_url()?>assets/js/require.js"></script>
