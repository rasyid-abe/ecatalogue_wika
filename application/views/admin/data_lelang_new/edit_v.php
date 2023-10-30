<?php
//var_dump($user_pemantau_list);
?>
<section class="content">
  <div class="full-width padding">
    <div class="padding-top">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i>Edit <?php echo ucwords($page) ?></h3>
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
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group ">
                  <label for="" class="col-sm-3 control-label">level 1</label>
                  <div class="col-sm-9">
                    <select id="level1" name="level1" class="form-control" data-selectjs="true">
                      <option value="" disabled selected>Pilih </option>
                      <?php
                      echo array_to_options($sel_level1, $level1)
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Level 2</label>
                  <div class="col-sm-9">
                    <select id="level2" name="level2" class="form-control" data-selectjs="true">
                      <option value="" disabled selected>Pilih </option>
                      <?php
                      echo array_to_options($sel_level2, $level2)
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Level 3</label>
                  <div class="col-sm-9">
                    <select id="level3" name="level3" class="form-control" data-selectjs="true">
                      <option value="" disabled selected>Pilih </option>
                      <?php
                      echo array_to_options($sel_level3, $level3)
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">No Kontrak</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" id="no_kontrak" placeholder="No Kontrak" name="no_kontrak" value="<?= $no_kontrak ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">Nama</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" id="name" placeholder="Nama" name="name" value="<?= $name ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">Spesifikasi</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" id="spesifikasi" placeholder="Spesifikasi" name="spesifikasi" value="<?= $spesifikasi ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Vendor</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="vendor_id" name="vendor_id" data-selectjs="true">
                      <option value="">Pilih Vendor</option>
                      <?php
                      foreach ($vendor as $key => $value) {
                        $select = "";
                        if ($value->id == $vendor_id) {
                          $select = "selected";
                        }
                      ?>
                        <option value="<?php echo $value->id ?>" <?php echo $select ?>><?php echo $value->name ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Tanggal Kontrak</label>
                  <div class="col-sm-9">
                    <div class="" data-datepicker="true">
                      <input class="form-control" type="text" id="tgl_terkontrak" name="tgl_terkontrak" autocomplete="off" value="<?= $tgl_terkontrak ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Akhir Kontrak</label>
                  <div class="col-sm-9">
                    <div class="" data-datepicker="true">
                      <input class="form-control" type="text" id="tgl_akhir_kontrak" name="tgl_akhir_kontrak" autocomplete="off" value="<?= $tgl_akhir_kontrak ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Harga</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="text" id="harga" name="harga" autocomplete="off" onkeyup="App.format(this)" value="<?= rupiah($harga) ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Volume</label>
                  <div class="col-sm-9">
                    <input class="form-control number" type="text" id="volume" name="volume" autocomplete="off" value="<?= $volume ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Satuan</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="satuan" name="satuan" data-selectjs="true">
                      <option value="">Pilih Satuan</option>
                      <?php
                      foreach ($uom as $key => $value) {
                        $select = "";
                        if ($value->id == $satuan) {
                          $select = "selected";
                        }
                      ?>
                        <option value="<?php echo $value->id ?>" <?php echo $select ?>><?php echo $value->name ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Proyek</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="proyek_pengguna" name="proyek_pengguna" data-selectjs="true">
                      <option value="">Pilih Proyek</option>
                      <?php
                      foreach ($proyek as $key => $value) {
                        $select = "";
                        if ($value->id == $proyek_pengguna) {
                          $select = "selected";
                        }
                      ?>
                        <option value="<?php echo $value->id ?>" <?php echo $select ?>><?php echo $value->name ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">Keterangan</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" id="keterangan" name="keterangan"><?= $keterangan ?></textarea>
                  </div>
                </div>
                <div class="box-footer pad-15 full-width bg-softgrey border-top bot-rounded">
                  <button type="submit" class="btn btn-primary pull-right mleft-15" id="save-btn">Simpan</button>
                  <a href="<?php echo base_url(); ?><?= $cont ?>" class="btn btn-default pull-right">Batal</a>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script data-main="<?php echo base_url() ?>assets/js/main/main-data_lelang_new" src="<?php echo base_url() ?>assets/js/require.js"></script>