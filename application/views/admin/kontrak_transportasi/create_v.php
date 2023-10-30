<section class="content">
    <div class="full-width padding">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Kategori Feedback</h3>
            </div>
            <form id="form" method="POST" action="" enctype="multipart/form-data">
                <div class="box-body">
                    <?php if (!empty($this->session->flashdata('message_error'))) { ?>
                        <div class="alert alert-danger">
                            <?php
                            print_r($this->session->flashdata('message_error'));
                            ?>
                        </div>
                    <?php } ?>
                    <?php echo validation_errors() ?>
                    <div class="form-group">
                        <label for="">No Kontrak</label>
                        <input type="text" name="no_contract" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3">Berkas Kontrak</label>
                        <input class="form-control" type="file" value="" id="file_contract" name="file_contract">
                    </div>
                    <div class="form-group">
                        <label for="">Vendor</label>
                        <select class="form-control" name="vendor_id" data-selectjs="true">
                            <option value="" disabled selected>Pilih Vendor</option>
                            <?php
                            echo result_to_options($vendor, '', 'vendor_id', 'vendor_name');
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Kontrak</label>
                        <div class="" data-datepicker="true">
                            <input class="form-control" type="text" id="tgl_kontrak" name="tgl_kontrak" autocomplete="off" value="">
                        </div>
                    </div>
                    <!--<div class="form-group">
              <label for="">Berat Minimum (Ton)</label>
              <input class="form-control" type="text" id="weight_minimum" name="weight_minimum" onkeyup="App.format(this)" value="" >
          </div>
          <div class="form-group">
              <label for="">Data Traller</label>
              <select class="form-control" name="data_trailer[]" id="data_traller" multiple="true">

              </select>
              <input type="text" name="data_trailer" id="data_traller" value="" class="form-control"> 
          </div>-->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="">Start Date</label>
                            <div class="" data-datepicker="true">
                                <input class="form-control" type="text" id="start_date" name="start_date" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">End Date</label>
                            <div class="" data-datepicker="true">
                                <input class="form-control" type="text" id="end_date" name="end_date" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                <button type="submit" class="btn btn-primary" id="save-btn">Simpan</button>
                                <a href="<?php echo base_url(); ?><?= $cont ?>" class="btn btn-primary btn-danger">Batal</a>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
</section>

<script data-main="<?php echo base_url() ?>assets/js/main/main-<?= $cont ?>" src="<?php echo base_url() ?>assets/js/require.js"></script>