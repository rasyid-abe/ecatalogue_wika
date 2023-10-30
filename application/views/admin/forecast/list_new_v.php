<section class="content-header">
    <h1>
        <?php echo ucwords($page) ?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo ucwords($page) ?></li>
    </ol>
</section>

<!-- Modal Input-->
<div class="modal fade" id="forecastform" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="judulModalLabel">Form Input Harga Harian</h4>
            </div>
            <form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url('forecast_new/create') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="date" class="form-control" name="tglHarga" id="tglHarga" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Price Billet Tangsan</label>
                        <input type="text" class="form-control number" name="priceBilletTangshan" id="priceBilletTangshan">
                    </div>
                    <div class="form-group">
                        <label for="">Price Billet CIS</label>
                        <input type="text" class="form-control number" name="priceBilletCis" id="priceBilletCis">
                    </div>
                    <div class="form-group">
                        <label for="">Kurs Mid BI</label>
                        <input type="text" class="form-control number" name="kursBi" id="kursBi">
                    </div>
                    <div class="form-group">
                        <label for="">Harga Besi Tangshan (Rp)</label>
                        <input type="text" class="form-control number" name="hargaBesiTangshan" id="hargaBesiTangshan">
                    </div>
                    <div class="form-group">
                        <label for="">Harga Besi CIS (Rp)</label>
                        <input type="text" class="form-control number" name="hargaBesiCis" id="hargaBesiCis">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </form>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="forecastexcel" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Import Excel</h4>
            </div>
            <form id="formimp" method="post" enctype="multipart/form-data" action="<?php echo base_url('forecast_new/importExcel') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Format Excel</label><br>
                        <a href="<?php echo base_url('forecast_new/download_format') ?>" class="btn btn-sm btn-info">Download Format</a>
                    </div>
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
            <h3 class="box-title">Chart Forecast</h3>
            <div class="form-group pull-right">
                <select class="form-control form-sm" name="option_chart_hari" id="option_chart_hari">
                    <option value="">Pilih Hari</option>
                    <option value="30">30 Hari</option>
                    <option value="60">60 Hari</option>
                    <option value="90">90 Hari</option>
                </select>
            </div>
        </div>
        <div class="box-body with-border">
            <div class="row">
                <div class="col-sm-6">
                    <div id="container"></div>
                </div>
                <div class="col-sm-6">
                    <div id="container1"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">Chart Corelation</h3>
        </div>
        <div class="box-body with-border">
            <div class="row">
                <div class="col-sm-6">
                    <div id="tangshan"></div>
                </div>
                <div class="col-sm-6">
                    <div id="cis"></div>
                </div>
                <div class="col-sm-6">
                    <div id="kurs_tangshan"></div>
                </div>
                <div class="col-sm-6">
                    <div id="kurs_cis"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Forecast</h3>
        </div>
        <div class="box-body with-border">
            <div id="tabel_forecast"></div>
        </div>
    </div>
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Forecast Rata-rata</h3>
        </div>
        <div class="box-body with-border">
            <div id="tabel_rata_rata"></div>
        </div>
    </div>
    <div class="box box-default color-palette-box">
        <form class="" action="<?php echo base_url('forecast_new/delete') ?>" method="post">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Harga Besi</h3>
                <?php
                if ($is_can_create) {
                ?>
                    <button type="submit" class="btn btn-sm btn-danger pull-right" id="btnHapus"><i class='fa fa-trash'></i> Hapus</button>
                    <span class="pull-right">&nbsp;</span>
                    <button type="button" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#forecastexcel"><i class='fa fa-plus'></i> Import Excel</button>
                    <span class="pull-right">&nbsp;</span>
                    <button type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#forecastform"><i class='fa fa-plus'></i> Tambah Harga</button>
                <?php
                }
                ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <?php if (!empty($_GET['status'])) {
                                if ($_GET['status'] == 'true') { ?>
                                    <div class="alert alert-info">
                                        <?php echo $_GET['message'] ?>
                                    </div><?php
                                        } else { ?>
                                    <div class="alert alert-danger">
                                        <?php echo $_GET['message'] ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <?php if (!empty($this->session->flashdata('message'))) { ?>
                                <div class="alert alert-info">
                                    <?php
                                    print_r($this->session->flashdata('message'));
                                    ?>
                                </div>
                            <?php } ?>
                            <?php if (!empty($this->session->flashdata('message_error'))) { ?>
                                <div class="alert alert-info">
                                    <?php
                                    print_r($this->session->flashdata('message_error'));
                                    ?>
                                </div>
                            <?php } ?>
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th width="1%"><input type="checkbox" id="checkAll"></th>
                                        <th>Ubah</th>
                                        <th>Tanggal Forecast</th>
                                        <th>Price Billet Tangshan</th>
                                        <th>Price Billet CIS</th>
                                        <th>Kurs BI</th>
                                        <th>Harga Besi Tangshan (Rp)</th>
                                        <th>Harga Besi CIS (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($forecast_data_new as $key => $var) : ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="idsData[]" class="check_delete" value="<?php echo $var['forecast_id'] ?>" />
                                            </td>
                                            <td> <a href="#" class="btn btn-xs btn-warning modalUbah" data-toggle="modal" data-target="#forecastform" data-id="<?php echo $var['forecast_id'] ?>"><i class='fa fa-pencil'></i></a> </td>
                                            <td class="text-right"><?php echo $var['tgl_harga'] ?></td>
                                            <td class="text-right"><?php echo $var['price_billet_tangshan'] ?></td>
                                            <td class="text-right"><?php echo $var['price_billet_cis'] ?></td>
                                            <td class="text-right"><?php echo $var['kurs_bi'] ?></td>
                                            <td class="text-right"><?php echo $var['harga_besi_tangshan'] ?></td>
                                            <td class="text-right"><?php echo $var['harga_besi_cis'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-forecast_new" src="<?php echo base_url() ?>assets/js/require.js"></script>