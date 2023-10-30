<section class="content">
    <div class="full-width padding">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Edit Kontrak Transportasi</h3>
            </div>
            <form id="form" method="POST" action="" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="id" value="<?php echo $id ?>">
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
                        <input type="text" name="no_contract" value="<?php echo $data->no_contract ?>" class="form-control">
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
                            echo result_to_options($vendor, $data->vendor_id, 'vendor_id', 'vendor_name');
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Kontrak</label>
                        <div class="" data-datepicker="true">
                            <input class="form-control" type="text" id="tgl_kontrak" name="tgl_kontrak" autocomplete="off" value="<?= $data->tgl_kontrak ?>">
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <label for="">Berat Minimum (Ton)</label>
                        <input class="form-control" type="text" id="weight_minimum" name="weight_minimum" onkeyup="App.format(this)" value="<?php echo rupiah($data->weight_minimum, 2) ?>" >
                    </div>
                    <div class="form-group">
                        <label for="">Data Trailer</label>
                        <select class="form-control" name="data_trailer[]" id="data_traller" multiple="true">
                            <?php
                            foreach (explode(',', $data->data_trailer) as $v) {
                            ?>
                                <option value="<?php echo $v ?>" selected><?php echo $v ?></option>
                                <?php
                            }
                                ?>
                        </select>
                         <input type="text" name="data_trailer" value="<?php echo $data->data_trailer ?>" class="form-control">
                </div> -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="">Start Date</label>
                            <div class="" data-datepicker="true">
                                <input class="form-control" type="text" id="start_date" name="start_date" autocomplete="off" value="<?= $data->start_date ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">End Date</label>
                            <div class="" data-datepicker="true">
                                <input class="form-control" type="text" id="end_date" name="end_date" autocomplete="off" value="<?= $data->end_date ?>">
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
    </div>
    </div>
</section>

<script data-main="<?php echo base_url() ?>assets/js/main/main-<?= $cont ?>" src="<?php echo base_url() ?>assets/js/require.js"></script>