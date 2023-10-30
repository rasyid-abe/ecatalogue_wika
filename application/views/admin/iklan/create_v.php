<section class="content">
    <div class="full-width padding">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Tambah <?= $page ?></h3>
            </div>
            <form class="" id="form" method="POST" action="" enctype="multipart/form-data">
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
                        <label for="">Role</label>
                        <select class="form-control" name="role_id" data-selectjs="true">
                            <option value="" disabled selected>Pilih Role</option>
                            <option value=0>Semua Role</option>
                            <?= array_to_options($roles, set_value('role_id')) ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <?= form_textarea([
                            'class' => 'form-control',
                            'name'   => 'description',
                            'rows' => 5,
                            'value' => set_value('description')
                        ])
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar </label><span class="images-info"> (Tipe Image, Maksimal 20MB)</span>
                        <input class="form-control product_images" type="file" value="" accept="image/*" id="image_iklan" name="image_iklan">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                <button type="submit" class="btn btn-primary" id="save-btn">Simpan</button>
                                <a href="<?php echo base_url() . $cont; ?>" class="btn btn-primary btn-danger">Batal</a>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
</section>

<script data-main="<?php echo base_url() ?>assets/js/main/main-<?= $cont ?>" src="<?php echo base_url() ?>assets/js/require.js"></script>