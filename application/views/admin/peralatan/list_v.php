<input type="hidden" name="json_size" id="json_size" value='<?php echo $json_size ?>'>
<input type="hidden" id="arrLocationVendor" value='[]'>
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
<div class="modal fade" id="form_code1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 665px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="judulModalLabel">Form Input kode Sumber Daya</h4>
            </div>
            <form id="form_download" method="post" enctype="multipart/form-data" action="<?php echo base_url('peralatan/download') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Tender</label>
                        <input type="text" class="form-control" name="tender" id="tender">
                        <input type="hidden" class="form-control" name="ids" id="ids">
                    </div>
                    <div class="form-group">
                        <label for="">Owner</label>
                        <input type="text" class="form-control" name="owner" id="owner">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Tender</label>
                        <div class="" data-datepicker="true">
                          <input class="form-control" type="text" value="" id="tgl_tender" name="tgl_tender" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-success" >Simpan Data</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                    <!-- <h2 class="btn btn-danger" style="margin-top: 0px;"><span class="label label-danger"></span></h2> -->
                </div>
            </form>
        </div>
    </div>
</div>
<section class="content">
  <?php if ($is_can_search) { ?>
    <div class="box box-bottom">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> Pencarian <?php echo ucwords($page) ?></h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 control-label">Kategori</label>
              <div class="col-sm-4">
                <select class="form-control" id="vendor_id" data-selectjs="true">
                  <option value="">Pilih Kategori</option>
                  <?php
                  foreach ($jenis as $key => $value) {
                  ?>
                    <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                  <?php } ?>
                </select>
              </div>
              <label for="inputPassword3" class="col-sm-2 control-label">Proyek</label>
              <div class="col-sm-4">
                <select class="form-control" id="sda_code" data-selectjs="true">
                  <option value="">Pilih Proyek</option>
                  <?php
                  foreach ($kode_sda as $key => $value) { ?>
                    <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                  <?php }  ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-12 text-right">
                <a href="javascript:;" class="btn btn-sm btn-danger" id="reset">Hapus</a>
                <a href="javascript:;" class="btn btn-sm btn-primary" id="search">Cari</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php } ?>
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page) ?></h3>
      <?php if ($is_can_create) { ?>
        <div class="col-md-3 datatableButton pull-right">
          <div class="row">
            <a href="<?php echo base_url() ?>peralatan/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> <?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?></a>
            <span class="pull-right">&nbsp;</span>
            <button type="button" class="btn btn-sm btn-success pull-right show_modal" id="download_data" >Download</button>
            <span class="pull-right">&nbsp;</span>
            <a href="<?php echo base_url() ?>peralatan/history" class="btn btn-sm btn-warning pull-right"><i class='fa fa-book'></i> History</a>
                                                           
          </div>

        </div>
      <?php } ?>
    </div>
    <div class="box-body">
      <div class="box-header">
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <?php if (!empty($this->session->flashdata('message'))) { ?>
              <div class="alert alert-info">
                <?php
                print_r($this->session->flashdata('message'));
                ?>
              </div>
            <?php } ?>
            <?php if (!empty($this->session->flashdata('message_error'))) { ?>
              <div class="alert alert-danger">
                <?php
                print_r($this->session->flashdata('message_error'));
                ?>
              </div>
            <?php } ?>
            <table class="table table-striped" id="table">
              <thead>
                <tr>
                  <th width="1%"><input type="checkbox" id="checkAll"></th>
                  <th>No Urut</th>
                  <th>Kategori</th>
                  <th>Sub Kategori</th>
                  <th>Nama Alat</th>
                  <th>No Inventaris</th>
                  <th>Proyek</th>
                  <th>User PIC</th>
                  <th>Tanggal Update</th>
                  <th width="15%">Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-peralatan" src="<?php echo base_url() ?>assets/js/require.js"></script>