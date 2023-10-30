<section class="content">
    <div class="full-width padding">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Tambah <?= $page ?></h3>
            </div>
            <form class="" id="form" method="POST" action="" enctype="multipart/form-data">
                <div class="box-body">
                    <?php if(!empty($this->session->flashdata('message_error'))){?>
                        <div class="alert alert-danger">
                            <?php
                            print_r($this->session->flashdata('message_error'));
                            ?>
                        </div>
                    <?php }?>
                    <?php if(!empty($this->session->flashdata('message_error1'))){?>
                        <div class="alert alert-danger">
                            <?php
                            print_r($this->session->flashdata('message_error1'));
                            ?>
                        </div>
                    <?php }?>
                    <?php echo validation_errors() ?>
                    <div class="form-group">
                        <label for="">Jenis Sync</label>
                        <select class="form-control" name="sync_code">
                            <option value="" disabled selected>Pilih Jenis Sync</option>
                            <?= array_to_options($sync_code) ?>
                        </select>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                <button type="submit" class="btn btn-primary" id="save-btn">Sync</button>
                                <a href="<?php echo base_url();?>sync" class="btn btn-primary btn-danger">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <script data-main="<?php echo base_url()?>assets/js/main/main-<?= $cont ?>" src="<?php echo base_url()?>assets/js/require.js"></script>
