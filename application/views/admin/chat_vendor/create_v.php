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
          <input type="hidden" name="type_feedback" value="<?= $type_feedback ?>">
          <div class="form-group">
              <label for="">Kategori Feedback</label>
              <select class="form-control" name="kategori_feedback_id" data-selectjs="true">
                  <option value="" disabled selected>Pilih Kategori Feedback</option>
                  <?= array_to_options($kategori_feedback) ?>
              </select>
          </div>
          <div class="form-group">
              <label for="">Feedback</label>
              <textarea name="isi_feedback" rows="8" cols="80" class="form-control"></textarea>
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
