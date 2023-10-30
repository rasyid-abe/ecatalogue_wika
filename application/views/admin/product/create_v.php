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
      <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page) ?></h3>
    </div>
    <form id="form" method="post" enctype="multipart/form-data">
      <div class="box-body">
        <?php echo validation_errors() ?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">Level 1</label>
              <select class="form-control form-sm" name="level1" id="level1" data-selectjs="true" required>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($level1)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Level 2</label>
              <select class="form-control form-sm" name="level2" id="level2" data-selectjs="true" disabled>
                <option value="">Pilih</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Level 3</label>
              <select class="form-control form-sm" name="level3" id="level3" data-selectjs="true" disabled>
                <option value="">Pilih</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Level 4</label>
              <select class="form-control form-sm" name="level4" id="level4" data-selectjs="true" disabled>
                <option value="">Pilih</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Level 5</label>
              <select class="form-control form-sm" name="level5" id="level5" data-selectjs="true" disabled>
                <option value="">Pilih</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Level 6</label>
              <select class="form-control form-sm" name="level6" id="level6" data-selectjs="true" disabled>
                <option value="">Pilih</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Nama Product</label>
              <input class="form-control" type="text" id="name" name="name" autocomplete="off" required placeholder="Nama Produk">
            </div>
            <div class="form-group">
              <label for="">Berat/Unit</label>
              <select class="form-control form-sm" name="berat_unit" id="berat_unit" data-selectjs="true" disabled>
                <option value="">Pilih</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Satuan Dasar</label>
              <select class="form-control" id="uom_id" name="uom_id" data-selectjs="true">
                <option value="">Pilih Satuan Dasar</option>
                <?php
                foreach ($uom as $key => $value) { ?>
                  <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Vendor</label>
              <select class="form-control" id="vendor_id" name="vendor_id" data-selectjs="true">
                <option value="" disabled selected>Pilih Vendor</option>
                <?php
                foreach ($vendor as $key => $value) {
                  $select = "";
                  if ($value->id == $users->vendor_id) {
                    // $select="selected";
                  }
                ?>
                  <option value="<?php echo $value->id ?>" <?php echo $select ?>><?php echo $value->name ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Term Of Delivery</label>
              <select class="form-control" id="term_of_delivery_id" name="term_of_delivery_id" data-selectjs="true">
                <option value="">Pilih Term Of Delivery</option>
                <?php
                foreach ($tod as $key => $value) { ?>
                  <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Catatan</label>
              <textarea class="form-control" id="note" name="note" autocomplete="off"></textarea>
            </div>
            <div class="form-group col-12 row">
              <div class="col-sm-4">
                <label for="">Gambar Utama</label><span class="images-info"> (Tipe Image, Maksimal 20MB)</span>
                <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery0" name="product_gallery0" data-id="0">
              </div>
              <div class="col-sm-2 product-images">
                <img src="<?php echo base_url() ?>assets/images/noimage.png" id="images0">
              </div>
              <div class="col-sm-4">
                <label for="">Gallery 1</label><span class="images-info"> (Tipe Image, Maksimal 20MB)</span>

                <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery1" name="product_gallery1" data-id="1">
              </div>
              <div class="col-sm-2 product-images">
                <img src="<?php echo base_url() ?>assets/images/noimage.png" id="images1">
              </div>
            </div>
            <div class="form-group col-12 row">
              <div class="col-sm-4">
                <label for="">Gallery 2</label><span class="images-info"> (Tipe Image, Maksimal 20MB)</span>

                <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery2" name="product_gallery2" data-id="2">
              </div>
              <div class="col-sm-2 product-images">
                <img src="<?php echo base_url() ?>assets/images/noimage.png" id="images2">
              </div>
              <div class="col-sm-4">
                <label for="">Gallery 3</label><span class="images-info"> (Tipe Image, Maksimal 20MB)</span>

                <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery3" name="product_gallery3" data-id="3">
              </div>
              <div class="col-sm-2 product-images">
                <img src="<?php echo base_url() ?>assets/images/noimage.png" id="images3">
              </div>
            </div>
            <!-- <div class="form-group">
              <label for="">Metode Pembayaran</label>
              <select class="form-control" id="payment_method" name="payment_method" data-selectjs="true" multiple="multiple">
               <option value="" disabled>Pilih Metode Pembayaran</option>
               <?php
                foreach ($payment_method as $key => $value) { ?>
                    <option value="<?php echo $value->id ?>"><?php echo $value->full_name ?></option>
                <?php } ?>
             </select>
            </div> -->
            <table class="table table-bordered table-responsive-md table-striped table-input">
              <thead>
                <tr>
                  <td class="text-center" width="24%"><b>Metode Pembayaran</b></td>
                  <td class="text-center" width="24%"><b>Lokasi</b></td>
                  <td class="text-center" width="23%"><b>Harga</b></td>
                  <td class="text-center" width="23%"><b>Notes</b></td>
                  <td class="text-center" width="6%"><button type="button" class="btn btn-info" id="btn-add-row"><i class="fa fa-plus"></i></button></td>
                </tr>
              </thead>
              <tbody id="tbody-row">
                <tr>
                  <td class="aduh">
                    <select class="select-td" name="payment_id[0]" required>
                      <option value="" disabled selected>Pilih Metode Pembayaran</option>
                      <?php echo result_to_options($payment_method, '', 'id', 'full_name') ?>
                    </select>
                  </td>
                  <td class="aduh">
                    <select class="select-td select-location" name="location_id_ar[0][]" required multiple="true">
                      <option value="" disabled>Lokasi Belum tersedia, silahkan pilih vendor terlebih dahulu</option>
                      <!-- <?php echo result_to_options($location, '', 'id', 'name') ?> -->
                    </select>
                  </td>
                  <td><input type="text" name="harga[0]" class="" autocomplete="off" style="text-align:right" onkeyup="App.format(this)" required></td>
                  <td><input type="text" name="notes[0]" class="" autocomplete="off"></td>
                  <td class="text-center">
                    <!-- <button class="btn btn-danger btn-xs" type="button" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash-o"></i></button> -->
                    <button class="btn btn-danger btn-xs" type="button" onclick="if($('#tbody-row tr').length > 1) { $(this).closest('tr').remove() }"><i class="fa fa-trash-o"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>

            <!-- <div class="form-group">
                <label for="">Include Price
                    <button class="btn btn-xs btn-success" type="button" id="btn-tambah-include"><i class="fa fa-plus"></i></button>
                </label>
            </div> -->
            <!-- <div class="form-group row include-price">
                <div class="col-sm-6">
                    <input type="text" name="" id="" class="form-control" placeholder="deskripsi">
                </div>
                <div class="col-sm-6">
                    <input type="text" name="" id="" class="form-control" placeholder="harga">
                </div>
            </div> -->
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?php echo base_url(); ?>product" class="btn btn-primary btn-danger">Batal</a>
          </div>
        </div>
      </div>
    </form>
  </div>
  <script type="template" id="template-row-product">
    <tr>
      <td class="aduh">
          <select class="select-td" name="payment_id[countArraynyaDigantiNanti]" required>
              <option value="" disabled selected>Pilih Metode Pembayaran</option>
              <?php echo result_to_options($payment_method, '', 'id', 'full_name') ?>
          </select>
      </td>
      <td class="aduh">
          <select class="select-td select-location" name="location_id_ar[countArraynyaDigantiNanti][]" required multiple="true">
              <option value="" disabled>Pilih Lokasi</option>

          </select>
      </td>
      <td><input type="text" name="harga[countArraynyaDigantiNanti]" class="" autocomplete="off" style="text-align:right" onkeyup="App.format(this)" required></td>
      <td><input type="text" name="notes[countArraynyaDigantiNanti]" class="" autocomplete="off"></td>
      <td class="text-center">
          <!-- <button class="btn btn-danger btn-xs" type="button" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash-o"></i></button> -->
          <button class="btn btn-danger btn-xs" type="button" onclick="if($('#tbody-row tr').length > 1) { $(this).closest('tr').remove() }"><i class="fa fa-trash-o"></i></button>
      </td>
  </tr>
  </script>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-product" src="<?php echo base_url() ?>assets/js/require.js"></script>