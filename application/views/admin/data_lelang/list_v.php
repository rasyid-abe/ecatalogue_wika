<section class="content-header">
  <h1>
    <?php echo ucwords($page) ?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?php echo ucwords($page) ?>
    </li>
  </ol>
</section>

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
              <label for="inputEmail3" class="col-sm-2 control-label">Departemen</label>
              <div class="col-sm-4">
                <select class="form-control" id="departemen" name="departemen" data-selectjs="true">
                  <option value="">Pilih Departemen</option>
                  <?php
                  foreach ($departemen as $key => $value) {
                  ?>
                    <option value="<?php echo $value->departemen ?>"><?php echo $value->departemen ?></option>
                  <?php } ?>
                </select>
              </div>
              <label for="inputPassword3" class="col-sm-2 control-label">Vendor</label>
              <div class="col-sm-4">
                <select class="form-control" id="vendor" name="vendor" data-selectjs="true">
                  <option value="">Pilih Vendor</option>
                  <?php
                  foreach ($vendor as $key => $value) {
                  ?>
                    <option value="<?php echo $value->vendor ?>"><?php echo $value->vendor ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-2 control-label">Metode Pembayaran</label>
              <div class="col-sm-4">
                <select class="form-control" id="keterangan" name="keterangan" data-selectjs="true">
                  <option value="">Pilih Metode Pembayaran</option>
                  <?php
                  foreach ($keterangan as $key => $value) {
                  ?>
                    <option value="<?php echo $value->keterangan ?>"><?php echo $value->keterangan ?></option>
                  <?php } ?>
                </select>
              </div>
              <label for="inputPassword3" class="col-sm-2 control-label">Lokasi</label>
              <div class="col-sm-4">
                <input type="name" class="form-control" id="lokasi" placeholder="Lokasi" name="lokasi">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-2 control-label">Awal Kontrak</label>
              <div class="col-sm-4">
                <div class="" data-datepicker="true">
                  <input class="form-control" type="text" value="" id="start_contract" name="start_contract" autocomplete="off">
                </div>
              </div>
              <label for="inputPassword3" class="col-sm-2 control-label">Akhir Kontrak</label>
              <div class="col-sm-4">
                <div class="" data-datepicker="true">
                  <input class="form-control" type="text" value="" id="end_contract" name="end_contract" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-2 control-label">Nama Barang</label>
              <div class="col-sm-4">
                <input type="name" class="form-control" id="nama" placeholder="Nama Barang" name="nama">
              </div>
              <label for="inputPassword3" class="col-sm-2 control-label">Spesifikasi</label>
              <div class="col-sm-4">
                <input type="name" class="form-control" id="spesifikasi" placeholder="Spesifikasi" name="spesifikasi">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-3">
                <button type="button" class="btn btn-success btn-sm" id="btn-download-excel">Download Excel</button>
              </div>
              <div class="col-sm-9 text-right">
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
      <h3 class="box-title"><i class="fa fa-tag"></i><?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?></h3>
      <?php if ($this->data['is_can_create']) { ?>
        <div class="full-width datatableButton text-right">
          <a href="<?php echo base_url() . $cont ?>/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> Upload <?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?></a>

        </div>
      <?php } ?>
      <br>
      <?php if ($this->data['is_can_delete']) { ?>
        <div class="full-width datatableButton text-right">
          <a href='#' id="btn-delete" class='btn btn-sm btn-danger delete'><i class='fa fa-trash'></i> Hapus</a>
        </div>
      <?php } ?>
    </div>
    <div class="alert alert-danger" style="display: none;" id="alert-hapus">
      Data Lelang Telah Terhapus!
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
            <form method="post" action="<?php echo base_url('data_lelang/destroy') ?>" id="form-delete">
              <table class="table table-striped display" id="table">
                <thead>
                  <th><?php if ($this->data['is_can_delete']) { ?><input type="checkbox" id="check-all"><?php } ?></th>
                  <th>No Urut</th>
                  <th>Departemen</th>
                  <th>Kategori</th>
                  <th>Nama</th>
                  <th>Spesifikasi</th>
                  <th>Mata Uang</th>
                  <th>Harga</th>
                  <th>Vendor</th>
                  <th>Tanggal Kontrak</th>
                  <th>Tanggal Akhir Kontrak</th>
                  <th>Volume</th>
                  <th>Satuan</th>
                  <th>Proyek Pengguna</th>
                  <th>Lokasi</th>
                  <th>Keterangan</th>
                  <th>Status</th>
                  <th>Action</th>
                </thead>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php $this->load->view('admin/data_lelang/modal_detail_data_lelang') ?>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-data_lelang" src="<?php echo base_url() ?>assets/js/require.js">
</script>