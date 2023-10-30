<section class="content">
  <div class="full-width padding">
    <div class="box box-default color-palette-box">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> Tambah <?php echo ucwords($page) ?></h3>
      </div>
      <form class="form-horizontal" id="form" method="POST" action="" enctype="multipart/form-data">
        <div class="box-body">
          <?php if (!empty($this->session->flashdata('message_error'))) { ?>
            <div class="alert alert-danger">
              <?php
              print_r($this->session->flashdata('message_error'));
              ?>
            </div>
          <?php } ?>
          <?php echo validation_errors() ?>

          <?php
          if ($is_can_create) {
          ?>
            <div id="handsonLelang"></div>
          <?php
          }
          ?>
        </div>
      </form>
      <?php
      if ($is_can_create) {
      ?>
        <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <button type="button" class="btn btn-info hidden" id="btn-generate">Simpan</button>
            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</section>


<input type="hidden" id="kategori" value='<?php echo json_encode(array_values($kategori)) ?>' disabled>
<input type="hidden" id="vendor" value='<?php echo json_encode(array_values($vendor)) ?>' disabled>
<input type="hidden" id="proyek" value='<?php echo json_encode(array_values($proyek)) ?>' disabled>
<input type="hidden" id="location" value='<?php echo json_encode(array_values($location)) ?>' disabled>
<input type="hidden" id="uoms" value='<?php echo json_encode(array_values($uoms)) ?>' disabled>


<script data-main="<?php echo base_url() ?>assets/js/main/main-test_data_lelang" src="<?php echo base_url() ?>assets/js/require.js"></script>