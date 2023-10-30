<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page) ?></h3>
    </div>
    <form id="form" method="post" enctype="multipart/form-data">
      <div class="box-body">
        <?php echo validation_errors() ?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">Kategori</label>
              <select class="form-control form-sm" name="kategori" id="kategori" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($kategori)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Sub Kategori</label>
              <select class="form-control form-sm" name="sub_kategori" id="sub_kategori" data-selectjs="true" disabled required>
                <option value="">Pilih</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Nama Alat</label>
              <input class="form-control" type="text" id="name" name="name" autocomplete="off" required placeholder="Nama Alat">
            </div>
            <div class="form-group">
              <label for="">Merek / Type</label>
              <input class="form-control" type="text" id="merek" name="merek" autocomplete="off" required placeholder="Merek / Type">
            </div>
            <div class="form-group">
              <label for="">No Inventaris</label>
              <input class="form-control" type="text" id="no_inventaris" name="no_inventaris" autocomplete="off" required placeholder="No Inventaris">
            </div>
            <div class="form-group">
              <label for="">Quantity</label>
              <input class="form-control" type="text" id="qty" name="qty" autocomplete="off" placeholder="Quantity">
            </div>
            <div class="form-group">
              <label for="">No Rangka</label>
              <input class="form-control" type="text" id="no_rangka" name="no_rangka" autocomplete="off" placeholder="No Rangka">
            </div>
            <div class="form-group">
              <label for="">No Mesin</label>
              <input class="form-control" type="text" id="no_mesin" name="no_mesin" autocomplete="off" placeholder="No Mesin">
            </div>
            <div class="form-group">
              <label for="">Posisi</label>
              <input class="form-control" type="text" id="posisi" name="posisi" autocomplete="off" required placeholder="Posisi">
            </div>
            <div class="form-group col-12 row">
              <div class="col-sm-4">
                <label for="">PO/ Kontrak Jual-Beli</label><span class="images-info"> (Tipe pdf, Maksimal 20MB)</span>
                <input class="form-control product_images" type="file" value="" accept="pdf/*" id="pdf_po" name="pdf_po" >
              </div>
            </div>
            <div class="form-group col-12 row">
              <div class="col-sm-4">
                <label for="">Bukti Bayar</label><span class="images-info"> (Tipe pdf, Maksimal 20MB)</span>
                <input class="form-control product_images" type="file" value="" accept="pdf/*" id="pdf_bukti_bayar" name="pdf_bukti_bayar" >
              </div>
            </div>
            <div class="form-group">
              <label for="">Kondisi</label>
              <select class="form-control form-sm" name="kondisi" id="kondisi" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($kondisi)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Asset Status</label>
              <select class="form-control form-sm" name="asset_status" id="asset_status" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($asset_status)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Operation Status</label>
              <select class="form-control form-sm" name="operation_status" id="operation_status" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($operation_status)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Divisi</label>
              <select class="form-control form-sm" name="divisi" id="divisi" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($divisi)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Proyek</label>
              <select class="form-control form-sm" name="proyek" id="proyek" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($proyek)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Tahun Beli</label>
              <input class="form-control" type="text" id="tahun_beli" name="tahun_beli" autocomplete="off" required placeholder="Tahun Beli">
            </div>
            <div class="form-group">
              <label for="">Harga Beli</label>
              <input class="form-control" type="text" id="harga_beli" name="harga_beli" autocomplete="off" required placeholder="Harga Beli">
            </div>
            <div class="form-group">
              <label for="">Deskripsi</label>
              <input class="form-control" type="text" id="deskripsi" name="deskripsi" autocomplete="off" required placeholder="Deskripsi">
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?php echo base_url(); ?>peralatan" class="btn btn-primary btn-danger">Batal</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-peralatan" src="<?php echo base_url() ?>assets/js/require.js"></script>