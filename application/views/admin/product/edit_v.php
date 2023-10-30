<?php
$arrPayment = [];
//var_dump($payment_product);
if ($payment_product) {
  foreach ($payment_product as $k => $v) {
    $arrPayment[] = $v->payment_id;
  }
}
?>
<input type="hidden" name="json_size" id="json_size" value='<?php echo $json_size ?>'>
<input type="hidden" id="is_createpage" value="0">
<input type="hidden" id="countArray" value="<?= !$payment_product ? 1 : count($payment_product) ?>">
<input type="hidden" id="count_harga" value="<?= !$payment_product ? 0 : count($payment_product) ?>">
<input type="hidden" id="arrPayment" value="<?= implode(',', $arrPayment) ?>">
<input type="hidden" id="arrLocationVendor" value='<?= ($arrLocationVendor) ? json_encode($arrLocationVendor) : '[]' ?>'>
<input type="hidden" id="arrLocation" value='<?= ($location) ? json_encode($location) : '[]' ?>'>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-tag"></i> Edit <?php echo ucwords($page) ?></h3>
    </div>
    <form id="form" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id_yang_dihapus" id="id_yang_dihapus" value="">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <input type="hidden" id="category_id" name="category_id" value="<?php echo $category_id ?>">
            <!-- <div class="form-group">
                <label for="">Jenis</label>
                <select class="form-control" id="category_id" name="category_id" data-selectjs="true">
                 <option value="">Pilih Jenis</option>
                 <?php
                  $code_1 = "";
                  foreach ($category as $key => $value) {
                    $select = "";
                    if ($value->id == $category_id) {
                      $code_1 .= $value->code;
                      $select = "selected";
                    } ?>
                    <option value="<?php echo $value->id ?>" data-code="<?= $value->code ?>" <?php echo $select ?>><?php echo $value->name ?></option>
                  <?php } ?>
               </select>
              </div> -->

            <div class="form-group ">
              <label for="">level 1</label>
              <select id="level1" name="level1" class="form-control" data-selectjs="true">
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($sel_level1, $level1)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Level 2</label>
              <select id="level2" name="level2" class="form-control" data-selectjs="true">
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($sel_level2, $level2)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Level 3</label>
              <select id="level3" name="level3" class="form-control" data-selectjs="true">
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($sel_level3, $level3)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Level 4</label>
              <select id="level4" name="level4" class="form-control" data-selectjs="true">
                <option value="" disabled selected>Pilih</option>
                <?php
                echo array_to_options($sel_level4, $level4)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Level 5</label>
              <select id="level5" name="level5" class="form-control" data-selectjs="true">
                <option value="" disabled selected>Pilih</option>
                <?php
                echo array_to_options($sel_level5, $level5)
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Level 6</label>
              <select id="level6" name="level6" class="form-control" data-selectjs="true">
                <option value="" disabled selected>Pilih</option>
                <?php
                echo array_to_options($sel_level6, $level6)
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="">Nama Product</label>
              <input class="form-control" type="text" id="name" name="name" autocomplete="off" required placeholder="Nama Produk" value="<?php echo $name ?>">
            </div>
            <div class="form-group">
              <label for="">Berat/Unit</label>
              <select class="form-control" id="berat_unit" name="berat_unit" data-selectjs="true">
                <option value="">Pilih</option>
                <?php
                foreach ($sel_berat as $key => $value) {
                  $select = "";
                  if ($value['berat'] == $berat_unit) {
                    $select = "selected";
                  } ?>
                  <option value="<?php echo $value['berat'] ?>" <?php echo $select ?> data-key="<?php echo $value['satuan'] ?>"><?php echo $value['berat'] ?> </option>
                <?php } ?>
              </select>

            </div>
            <div class="form-group">
              <label for="">Satuan Dasar</label>
              <select class="form-control" id="uom_id" name="uom_id" data-selectjs="true">
                <option value="">Pilih Satuan Dasar</option>
                <?php
                foreach ($uom as $key => $value) {
                  $select = "";
                  if ($value->id == $uom_id) {
                    $select = "selected";
                  } ?>
                  <option value="<?php echo $value->id ?>" <?php echo $select ?>><?php echo $value->name ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Vendor</label>
              <select class="form-control" id="vendor_id" name="vendor_id" data-selectjs="true">
                <option value="">Pilih Vendor</option>
                <?php
                foreach ($vendor as $key => $value) {
                  $select = "";
                  if ($is_superadmin) {
                    if ($value->id == $users->vendor_id || $value->id == $vendor_id) {
                      $select = "selected";
                    }
                  } else {
                    if ($value->id == $users->vendor_id && $value->id == $vendor_id) {
                      $select = "selected";
                    }
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
                foreach ($tod as $key => $value) {
                  $select = "";
                  if ($value->id == $term_of_delivery_id) {
                    $select = "selected";
                  } ?>
                  <option value="<?php echo $value->id ?>" <?php echo $select ?>><?php echo $value->name ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="">Catatan</label>
              <textarea class="form-control" id="note" name="note" autocomplete="off"><?php echo $note ?></textarea>
            </div>
            <div class="form-group col-12 row">
              <div class="col-sm-4">
                <label for="">Gambar Utama</label><span class="images-info"> (Tipe Image, Maksimal 20MB)</span>
                <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery0" name="product_gallery0" data-id="0">
              </div>
              <div class="col-sm-2 product-images">
                <img src="<?php echo $old_product_gallery[0] ?>" id="images0">
                <input type="hidden" name="old_filename0" id="old_filename0" value="<?php echo $old_filename[0] ?>">
              </div>
              <div class="col-sm-4">
                <label for="">Gallery 1</label><span class="images-info"> (Tipe Image, Maksimal 20MB)</span>

                <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery1" name="product_gallery1" data-id="1">
              </div>
              <div class="col-sm-2 product-images">
                <img src="<?php echo $old_product_gallery[1] ?>" id="images1">
                <input type="hidden" name="old_filename1" id="old_filename1" value="<?php echo $old_filename[1] ?>">
              </div>
            </div>
            <div class="form-group col-12 row">
              <div class="col-sm-4">
                <label for="">Gallery 2</label><span class="images-info"> (Tipe Image, Maksimal 20MB)</span>

                <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery2" name="product_gallery2" data-id="2">
              </div>
              <div class="col-sm-2 product-images">
                <img src="<?php echo $old_product_gallery[2] ?>" id="images2">
                <input type="hidden" name="old_filename2" id="old_filename2" value="<?php echo $old_filename[2] ?>">
              </div>
              <div class="col-sm-4">
                <label for="">Gallery 3</label><span class="images-info"> (Tipe Image, Maksimal 20MB)</span>

                <input class="form-control product_images" type="file" value="" accept="image/*" id="product_gallery3" name="product_gallery3" data-id="3">
              </div>
              <div class="col-sm-2 product-images">
                <img src="<?php echo $old_product_gallery[3] ?>" id="images3">
                <input type="hidden" name="old_filename3" id="old_filename3" value="<?php echo $old_filename[3] ?>">
              </div>
            </div>
            <!-- <div class="form-group">
              <label for="">Metode Pembayaran</label>
              <select class="form-control" id="payment_method" name="payment_method" data-selectjs="true" multiple="multiple">
               <option value="">Pilih Metode Pembayaran</option>
               <?php
                foreach ($payment_method as $key => $value) {
                  $selected = "";
                  if (in_array($value->id, $arrPayment)) $selected = "selected";
                ?>
                    <option value="<?php echo $value->id ?>" <?= $selected ?>><?php echo $value->full_name ?></option>
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
                <?php
                if ($payment_product) {
                ?>

                  <?php
                  foreach ($payment_product as $key => $value) {
                    $arrLocation = explode(',', $value->location_id);
                  ?>
                    <tr>
                      <td class="aduh">
                        <select class="select-td" name="payment_id[<?= $key ?>]" required>
                          <option value="" disabled selected>Pilih Metode Pembayaran</option>
                          <?php echo result_to_options($payment_method, $value->payment_id, 'id', 'full_name') ?>
                        </select>
                      </td>
                      <td class="aduh">
                        <select class="select-td select-location" name="location_id_ar[<?= $key ?>][]" required multiple="true">
                          <option value="" disabled>Pilih Lokasi</option>
                          <?php
                          foreach ($arrLocationVendor as $kLocation => $vLocation) {
                            $sel = in_array($vLocation->wilayah_id, $arrLocation) ? 'selected' : '';
                          ?>
                            <option value="<?= $vLocation->wilayah_id ?>" <?php echo $sel ?>><?php echo $vLocation->wilayah_name ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </td>
                      <td><input type="text" name="harga[<?= $key ?>]" class="" autocomplete="off" style="text-align:right" onkeyup="App.format(this)" required value="<?php echo rupiah($value->price) ?>"></td>
                      <td><input type="text" name="notes[<?= $key ?>]" class="" autocomplete="off" value="<?php echo $value->notes ?>"></td>
                      <td class="text-center">
                        <!-- <button class="btn btn-danger btn-xs" type="button" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash-o"></i></button> -->
                        <button class="btn btn-danger btn-xs" type="button" onclick="if($('#tbody-row tr').length > 1) { $(this).closest('tr').remove() }"><i class="fa fa-trash-o"></i></button>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>

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