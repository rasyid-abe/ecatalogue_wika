<section class="content">
  <div class="full-width padding">
    <div class="box box-default color-palette-box">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> Tambah <?php echo ucwords($page) ?></h3>
      </div>
      <form class="form-horizontal" id="form" method="POST" action="" enctype="multipart/form-data">
        <div class="box-body">
          <?php if (!empty($this->session->flashdata('message_error'))) { ?>
            <div class="alert alert-danger">
              <?php
              print_r($this->session->flashdata('message_error'));
              ?>
            </div>
          <?php } ?>
          <?php echo validation_errors() ?>
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 control-label">Nama </label>
            <div class="col-sm-9">
              <input type="name" class="form-control" id="name" placeholder="Nama" name="name">
            </div>
          </div>
          <!-- <div class="form-group row">
           <label for="inputEmail3" class="col-sm-3 control-label">No Surat</label>
           <div class="col-sm-9">
             <input type="name" class="form-control" id="no_surat" placeholder="No Surat" name="no_surat">
           </div>
         </div> -->
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 control-label">Tanggal</label>
            <div class="col-sm-9">
              <div class="" data-datepicker="true">
                <input class="form-control" type="text" value="" id="tgl" name="tgl" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 control-label">Deskripsi</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Departemen</label>
            <div class="col-sm-9">
              <select id="departemen" name="departemen[]" class="form-control" data-selectjs="true" multiple="multiple" required>
                <option value="" disabled>Pilih Departemen</option>
                <?php
                foreach ($groups as $group) { ?>
                  <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                <?php }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">List Pengguna</label>
            <div class="col-sm-9">
              <select class="form-control" id="users" name="users[]" data-selectjs="true" multiple="multiple">
                <option value="" disabled>Pilih User</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Vendor</label>
            <div class="col-sm-9">
              <select class="form-control" id="vendor_id" name="vendor_id" data-selectjs="true" onchange="App.onChangeVendor()">
                <option value="">Pilih Vendor</option>
                <?php
                if ($vendor) {

                  foreach ($vendor as $key => $value) {
                ?>
                    <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                <?php
                  }
                } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Level 1</label>
            <div class="col-sm-9">
              <select class="form-control form-sm" name="level1" id="level1" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($level1)
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Level 2</label>
            <div class="col-sm-9">
              <select class="form-control form-sm" name="level2" id="level2" data-selectjs="true" disabled onchange="App.onChangeVendor()">
                <option value="">Pilih</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Product</label>
            <div class="col-sm-9">
              <select class="form-control" id="product_id" name="product_id[]" data-selectjs="true" multiple="true">
                <option value="" disabled>Pilih Product</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Nomor Kontrak</label>
            <div class="col-sm-9">
              <input class="form-control" type="text" id="no_contract" name="no_contract" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Berkas Kontrak</label>
            <div class="col-sm-9">

              <input class="form-control" type="file" value="" id="file_contract" name="file_contract">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Awal Kontrak</label>
            <div class="col-sm-9">
              <div class="" data-datepicker="true">
                <input class="form-control" type="text" value="" id="start_contract" name="start_contract" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Akhir Kontrak</label>
            <div class="col-sm-9">
              <div class="" data-datepicker="true">
                <input class="form-control" type="text" value="" id="end_contract" name="end_contract" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Departemen Pemantau</label>
            <div class="col-sm-9">
              <select id="departemen_pemantau" name="departemen_pemantau" class="form-control" data-selectjs="true" required>
                <option value="" disabled selected>Pilih Departemen</option>
                <?php
                foreach ($groups as $group) { ?>
                  <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                <?php }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">User Pemantau</label>
            <div class="col-sm-9">
              <select class="form-control" id="user_pemantau" name="user_pemantau" data-selectjs="true">
                <option value="" disabled>Pilih User</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Volume (Kg)</label>
            <div class="col-sm-9">
              <input class="form-control" type="text" value="" id="volume" name="volume" autocomplete="off" onkeyup="App.format(this)">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Harga Kontrak (Rp)</label>
            <div class="col-sm-9">
              <input class="form-control" type="text" value="" id="harga" name="harga" autocomplete="off" onkeyup="App.format(this)">
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
</section>

<script data-main="<?php echo base_url() ?>assets/js/main/main-kontrak" src="<?php echo base_url() ?>assets/js/require.js"></script>