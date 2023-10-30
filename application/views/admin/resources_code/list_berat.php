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

<!-- Modal Input-->
<div class="modal fade" id="form_berat" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 665px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="judulModalLabel">Form Tambah Berat</h4>
            </div>
            <form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url('resources_berat/store') ?>">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Kode</label>
                                <input type="text" class="form-control" name="code" id="code" maxlength="1">
                            </div>
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="">Berat 1</label>
                                <input type="number" step="0.001" class="form-control" name="berat1" id="berat1">
                            </div>
                            <div class="form-group">
                                <label for="">Berat 2</label>
                                <input type="number" step="0.001" class="form-control" name="berat2" id="berat2">
                            </div>
                            <div class="form-group">
                                <label for="">Berat 3</label>
                                <input type="number" step="0.001" class="form-control" name="berat3" id="berat3">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group satuan1">
                                <label for="">Satuan 1</label>
                                <select class="form-control form-sm" name="satuan1" id="satuan1">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                            <div class="form-group satuan2">
                                <label for="">Satuan 2</label>
                                <select class="form-control form-sm" name="satuan2" id="satuan2">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                            <div class="form-group satuan3">
                                <label for="">Satuan 3</label>
                                <select class="form-control form-sm" name="satuan3" id="satuan3">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
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
                <div class="col-sm-3">
                    <div class="form-group">
                        <select class="form-control form-sm" name="all_level1" id="all_level1">
                            <option value="">Pilih Level 1</option>
                            <?php foreach ($level1 as $var): ?>
                                <option value="<?php echo $var['code'] ?>"><?php echo $var['code'].' - '.$var['name'] ?></option>
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
            </div>
            <hr>
            <div id="tblFirst"></div>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-resources_berat" src="<?php echo base_url() ?>assets/js/require.js"></script>
<script type="text/javascript">
var myInput1 = document.querySelector('#berat1');
myInput1.addEventListener("keyup", function(){
    myInput1.value = myInput1.value.replace(/(\.\d{4})\d+/g, '$1');
});
var myInput2 = document.querySelector('#berat2');
myInput2.addEventListener("keyup", function(){
    myInput2.value = myInput2.value.replace(/(\.\d{4})\d+/g, '$1');
});
var myInput3 = document.querySelector('#berat3');
myInput3.addEventListener("keyup", function(){
    myInput3.value = myInput3.value.replace(/(\.\d{4})\d+/g, '$1');
});
</script>
