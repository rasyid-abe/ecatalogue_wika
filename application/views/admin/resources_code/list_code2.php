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
<div class="modal fade" id="form_code1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 665px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="judulModalLabel">Form Input kode Sumber Daya</h4>
            </div>
            <form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url('resources_code2/create') ?>">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="code_log" id="code_log">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Level 1</label>
                        <select class="form-control form-sm" name="parent" id="parent">
                            <option value="">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="desc" id="desc" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="matgis" id="matgis" value=1>
                        <label class="form-check-label" for="matgis">
                            Matgis
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="matgis" id="nonmatgis" value=2>
                        <label class="form-check-label" for="nonMatgis">
                            Non Matgis
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-8">
                            <a href="<?php echo base_url('resources_treeview') ?>" class="btn btn-danger float-left">Note: Periksa Nomenklatur SDA sebelum meng-Input-kan SDA baru!</a>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-success">Simpan Data</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<section class="content">
    <div class="box box-default color-palette-box">
        <form class="" action="<?php echo base_url('resources_code2/status_ids') ?>" method="post">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
                <?php
                if ($is_can_create) {
                ?>
                    <button type="submit" name="ids" value="11" class="btn btn-xs btn-danger pull-right" id="btnHapus"><i class='fa fa-trash'></i> Hapus</button>
                    <span class="pull-right">&nbsp;</span>
                    <button type="submit" name="ids" value="22" class="btn btn-xs btn-warning pull-right" id="btnReject"><i class='fa fa-ban'></i> Reject</button>
                    <span class="pull-right">&nbsp;</span>
                    <button type="submit" name="ids" value="33" class="btn btn-xs btn-success pull-right" id="btnApprove"><i class='fa fa-check'></i> Approve</button>
                    <span class="pull-right">&nbsp;</span>
                    <button type="button" class="btn btn-xs btn-primary pull-right kategori_show show_modal" data-toggle="modal" data-target="#form_code1"><i class='fa fa-plus'></i> Tambah</button>
                <?php
                }
                ?>
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
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th width="1%"><input type="checkbox" id="checkAll"></th>
                            <th>Ubah</th>
                            <th>Kode</th>
                            <th>Parent</th>
                            <th>Nama</th>
                            <th>UNSPSC</th>
                            <th>Matgis</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $var) :
                            if ($var['status'] == 0) {
                                $status = 'Waiting';
                                $class = 'info';
                            } elseif ($var['status'] == 1) {
                                $status = 'Approved';
                                $class = 'success';
                            } else {
                                $class = 'warning';
                                $status = 'Rejected';
                            }

                            if ($var['sts_matgis'] == 1) {
                                $matgis = 'Matgis';
                            } elseif ($var['sts_matgis'] == 2) {
                                $matgis = 'Non Matgis';
                            }

                            if ($var['code'] != '') {
                                $code = $var['code'];
                                $text = 'green';
                            } else {
                                $inc = $this->Resources_code_model->increment($var['parent_code'], 2);
                                $code = substr($var['parent_code'], 0, 1) . $inc['data'] . '0000';
                                $text = 'yellow';
                            }
                        ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="idsData[]" class="check_delete" value="<?php echo $var['resources_code_id'] ?>" />
                                </td>
                                <td>
                                    <?php
                                    if ($is_can_edit) {
                                    ?>
                                        <a href="#" class="btn btn-xs btn-warning modalUbah" data-toggle="modal" data-target="#form_code1" data-id="<?php echo $var['resources_code_id'] ?>"><i class='fa fa-pencil'></i></a>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td class="text-<?= $text ?>"><?php echo $code ?></td>
                                <td><?php echo $var['parent_code'] ?></td>
                                <td><?php echo $var['name'] ?></td>
                                <td><?php echo $var['unspsc'] ?></td>
                                <td><?php echo $matgis ?></td>
                                <td><span class="label label-<?= $class ?>"><?= $status ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-resources_code2" src="<?php echo base_url() ?>assets/js/require.js"></script>
