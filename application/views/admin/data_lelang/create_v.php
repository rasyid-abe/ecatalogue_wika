<section class="content">
    <div class="full-width padding">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Upload Data Lelang</h3>
            </div>
            <form class="form-horizontal" id="form" method="POST" action="<?= base_url()?>data_lelang/import_csv" enctype="multipart/form-data">
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
                        <label for="inputPassword3" class="col-sm-3 control-label">Berkas Kontrak</label>
                        <div class="col-sm-9">

                            <input class="form-control" type="file" id="data_lelang" name="data_lelang">
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <button type="button" class="btn btn-success" onclick="window.open(App.baseUrl+'data_lelang/download_format/semicolon')">Download Format csv semicolon(;)</button>
                                <button type="button" class="btn btn-success" onclick="window.open(App.baseUrl+'data_lelang/download_format')">Download Format csv comma(,)</button>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                <button type="submit" class="btn btn-primary" id="save-btn">Simpan</button>
                                <a href="<?php echo base_url();?><?= $cont ?>" class="btn btn-primary btn-danger">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-upload"></i> History Upload Data Lelang</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered display" id="table-history">
                  <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th>User Upload</th>
                        <th>Jumlah Row</th>
                        <th>Tgl Upload</th>
                    </tr>
                  </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<script data-main="<?php echo base_url()?>assets/js/main/main-data_lelang" src="<?php echo base_url()?>assets/js/require.js"></script>
