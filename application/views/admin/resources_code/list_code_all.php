<section class="content-header">
    <h1>
        <?php echo ucwords($page) ?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><?php echo ucwords('Kode Sumber Daya') ?></li>
        <li class="active"><?php echo ucwords($page) ?></li>
    </ol>
</section>

<div class="modal fade" id="forecastexcel" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Import Excell</h4>
            </div>
            <form id="formimp" method="post" enctype="multipart/form-data" action="<?php echo base_url('resources_all/importExcel') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Cari File</label>
                        <input type="file" class="form-control" name="ImportExcel" id="ImportExcel" accept=".xls,.xlsx" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>

    </div>
</div>

<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $title ?></h3>
        </div>
        <div class="box-body">

            <?php if (!empty($this->session->flashdata('message'))) { ?>
                <div class="alert alert-info">
                    <?php
                    print_r($this->session->flashdata('message'));
                    ?>
                </div>
            <?php } ?>
            <?php if (!empty($this->session->flashdata('message_error'))) { ?>
                <div class="alert alert-warning">
                    <?php
                    print_r($this->session->flashdata('message_error'));
                    ?>
                </div>
            <?php } ?>

            <div class="row">
                <form action="<?php echo base_url('resources_all/generate_pdf') ?>" method="post">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control form-sm" name="all_level1" id="all_level1">
                                <option value="">Pilih Level 1</option>
                                <?php foreach ($level1 as $var) : ?>
                                    <option value="<?php echo $var['code'] ?>"><?php echo $var['code'] . ' - ' . $var['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control form-sm" name="all_level2" id="all_level2" disabled>
                                <option value="">Pilih Level 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control form-sm" name="all_level3" id="all_level3" disabled>
                                <option value="">Pilih Level 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control form-sm" name="all_level4" id="all_level4" disabled>
                                <option value="">Pilih Level 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control form-sm" name="all_level5" id="all_level5" disabled>
                                <option value="">Pilih Level 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary"><i class='fa fa-download'></i> Download PDF</button>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-block btn-info pull-right" data-toggle="modal" data-target="#forecastexcel"><i class='fa fa-plus'></i> Import Excel</button>
                    </div>
                </form>
            </div>
            <hr>
            <div id="tblFirst"></div>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-resources_all" src="<?php echo base_url() ?>assets/js/require.js"></script>
