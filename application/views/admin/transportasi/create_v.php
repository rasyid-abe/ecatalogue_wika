<section class="content">
    <div class="full-width padding">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Transportasi</h3>
            </div>
            <form id="form" method="POST" action="" enctype="multipart/form-data" autocomplete="off">
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
                        <label for="">Vendor</label>
                        <select class="form-control" name="vendor_id" id="vendor_id" data-selectjs="true">
                            <option value="" disabled selected>Pilih Vendor</option>
                            <?php
                            echo array_to_options($vendor);
                             ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="">Origin</label>
                            <select class="form-control" name="origin_location_id" id="origin_location_id" data-selectjs="true">
                                <option value="" disabled selected>Pilih Origin</option>
                                <?php
                                echo array_to_options($location);
                                 ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Destinasi</label>
                            <select class="form-control" name="destination_location_id" id="destination_location_id" data-selectjs="true">
                                <option value="" disabled selected>Pilih Destinasi</option>
                                <?php
                                echo array_to_options($location_destination);
                                 ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="text" name="price" id="price" value="" onkeyup="App.format(this)" class="form-control">
                    </div>
                    <div class="box-footer pad-15 full-width bg-softgrey border-top bot-rounded">
                        <button type="submit" class="btn btn-primary pull-right mleft-15" id="save-btn">Simpan</button>
                        <a href="<?php echo base_url();?><?= $cont ?>" class="btn btn-default pull-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script data-main="<?php echo base_url()?>assets/js/main/main-transportasi" src="<?php echo base_url()?>assets/js/require.js"></script>
