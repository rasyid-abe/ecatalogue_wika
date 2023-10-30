<input type="hidden" name="json_size" id="json_size" value='<?php echo $json_size ?>'>
<input type="hidden" id="is_createpage" value="1">
<input type="hidden" id="countArray" value="1">
<input type="hidden" id="count_harga" value="0">
<input type="hidden" id="arrPayment" value="">
<input type="hidden" id="arrLocationVendor" value='[]'>
<input type="hidden" id="arrLocation" value='<?= ($location) ? json_encode($location) : '[]' ?>'>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-tag"></i> Edit <?php echo ucwords($page) ?></h3>
    </div>
    <form id="form" method="post" enctype="multipart/form-data">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">Kategori</label>
              <select class="form-control form-sm" name="kategori" id="kategori" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($sel_kategori,$kode_kategori)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Sub Kategori</label>
              <select id="sub_kategori" name="sub_kategori" class="form-control" data-selectjs="true">
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($sel_sub_kategori, $kode_sub_kategori)
                ?>
              </select>
            </div>
            <?php echo $sub_kategori ?>
            <div class="form-group">
              <label for="">Nama Alat</label>
              <input type="hidden" id="id_peralatan" name="id_peralatan" value="<?php echo $id_peralatan ?>">
              <input class="form-control" type="text" id="name" name="name" autocomplete="off" required placeholder="Nama Alat" value="<?php echo $name ?>">
            </div>
            <div class="form-group">
              <label for="">Merek / Type</label>
              <input class="form-control" type="text" id="merek" name="merek" autocomplete="off" required placeholder="Merek / Type" value="<?php echo $merek ?>">
            </div>
            <div class="form-group">
              <label for="">No Inventaris</label>
              <input class="form-control" type="text" id="no_inventaris" name="no_inventaris" autocomplete="off" required placeholder="No Inventaris" value="<?php echo $no_inventaris ?>">
            </div>
            <div class="form-group">
              <label for="">Quantity</label>
              <input class="form-control" type="text" id="qty" name="qty" autocomplete="off" placeholder="Quantity" value="<?php echo $qty ?>">
            </div>
            <div class="form-group">
              <label for="">No Rangka</label>
              <input class="form-control" type="text" id="no_rangka" name="no_rangka" autocomplete="off" placeholder="No Rangka" value="<?php echo $no_rangka ?>">
            </div>
            <div class="form-group">
              <label for="">No Mesin</label>
              <input class="form-control" type="text" id="no_mesin" name="no_mesin" autocomplete="off" placeholder="No Mesin" value="<?php echo $no_mesin ?>">
            </div>
            <div class="form-group">
              <label for="">Posisi</label>
              <input class="form-control" type="text" id="posisi" name="posisi" autocomplete="off" required placeholder="Posisi" value="<?php echo $posisi ?>">
            </div>
            <div class="form-group col-12 row">
              <div class="col-sm-4">
                <label for="">PO/ Kontrak Jual-Beli</label><span class="images-info"> (Tipe pdf, Maksimal 20MB)</span>
                <input class="form-control product_images" type="file" value="" accept="pdf/*" id="pdf_po" name="pdf_po" >
                <a>
                <?= $pdf_po ?>
                </a>
                <input type="hidden" name="old_pdf_po" id="old_pdf_po" value="<?php echo $pdf_po ?>">
              </div>
              
            </div>
            <div class="form-group col-12 row">
              <div class="col-sm-4">
                <label for="">Bukti Bayar</label><span class="images-info"> (Tipe pdf, Maksimal 20MB)</span>
                <input class="form-control product_images" type="file" value="" accept="pdf/*" id="pdf_bukti_bayar" name="pdf_bukti_bayar" >
                <a>
                <?= $pdf_bukti_bayar ?>
                </a>
                <input type="hidden" name="old_pdf_bukti_bayar" id="old_pdf_bukti_bayar" value="<?php echo $pdf_bukti_bayar ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="">Kondisi</label>
              <select class="form-control form-sm" name="kondisi" id="kondisi" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($kondisi,$id_kondisi)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Asset Status</label>
              <select class="form-control form-sm" name="asset_status" id="asset_status" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($asset_status,$id_asset_status)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Operation Status</label>
              <select class="form-control form-sm" name="operation_status" id="operation_status" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($operation_status,$id_operation_status)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Divisi</label>
              <select class="form-control form-sm" name="divisi" id="divisi" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($divisi,$id_divisi)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Proyek</label>
              <select class="form-control form-sm" name="proyek" id="proyek" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($proyek,$id_proyek)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Tahun Beli</label>
              <input class="form-control" type="text" id="tahun_beli" name="tahun_beli" autocomplete="off" required placeholder="Tahun Beli" value="<?php echo $tahun_beli ?>">
            </div>
            <div class="form-group">
              <label for="">Harga Beli</label>
              <input class="form-control" type="text" id="harga_beli" name="harga_beli" autocomplete="off" required placeholder="Harga Beli" value="<?php echo $harga_beli ?>">
            </div>
            <div class="form-group">
              <label for="">Deskripsi</label>
              <input class="form-control" type="text" id="deskripsi" name="deskripsi" autocomplete="off" required placeholder="Deskripsi" value="<?php echo $deskripsi ?>">
            </div>
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