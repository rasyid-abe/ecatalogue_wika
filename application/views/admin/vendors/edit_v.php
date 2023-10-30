<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page) ?></h3>
    </div>
     <form id="form" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" id="user_id" value="<?php echo $id ?>">
      <div class="box-body">
         <?php echo validation_errors() ?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">Nama Vendor</label>
              <input class="form-control" type="text" id="name" name="name" autocomplete="off" required value="<?php echo $name?>" readonly>
            </div>
            <div class="form-group">
              <label for="">Nama Direktur</label>
              <input class="form-control" type="text" id="nama_direktur" name="nama_direktur" autocomplete="off" required value="<?php echo $nama_direktur?>" readonly>
            </div>
            <div class="form-group">
              <label for="">No Telp</label>
              <input class="form-control" type="text" id="no_telp" name="no_telp" autocomplete="off" required value="<?php echo $no_telp?>" readonly>
            </div>
            <div class="form-group">
              <label for="">No Fax</label>
              <input class="form-control" type="text" id="no_fax" name="no_fax" autocomplete="off" required value="<?php echo $no_fax?>" readonly>
            </div>
            <div class="form-group">
              <label for="">Email Vendor</label>
              <input class="form-control" type="email" id="email" name="email" autocomplete="off" required value="<?php echo $email?>" readonly>
            </div>
            <div class="form-group">
              <label for="">Deskripsi</label>
              <textarea class="form-control" id="description" name="description" autocomplete="off" readonly><?php echo $description?></textarea>
            </div>
            <div class="form-group">
              <label for="">Alamat</label>
              <textarea class="form-control" id="address" name="address" autocomplete="off" readonly><?php echo $address?></textarea>
            </div>
            <!-- <div class="form-group">
              <label for="">Email user sebagai username</label>
              <input class="form-control" type="email" id="email_user" name="email_user" autocomplete="off" readonly value = "<?= $email_user ?>">
            </div> -->
            <div class="form-group">
              <label for="">Username</label>
              <input type="name" class="form-control" id="username" placeholder="Name" name="username" readonly value = "<?= $firtname ?>">
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="">Nama Penandatangan</label>
                    <input type="text" name="ttd_name" value="<?php echo $ttd_name ?>" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="">Jabatan Penandatangan</label>
                    <input type="text" name="ttd_pos" value="<?php echo $ttd_pos ?>" class="form-control">
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?php echo base_url();?>vendors" class="btn btn-primary btn-danger">Batal</a>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Riwayat Kontrak Vendor</h3>
    </div>
    <div class="box-body">
    <div class="box-header">

    </div>
      <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
            <table class="table table-striped" id="table2">
              <thead>
                 <th>No Kontrak</th>
                 <th>Department</th>
                 <th>Nama Vendor</th>
                 <th>Awal Kontrak</th>
                 <th>Akhir Kontrak</th>
                 <th>SKU</th>
                 <th>Volume</th>
                 <th>Unit</th>
                 <th>Harga</th>
              </thead>
              <tbody>
                  <tr>
                      <td>004/SPJB/WK/IWSMI/V/2014</td>
                      <td>DSU</td>
                      <td>Interworld Steel</td>
                      <td>05-05-2014</td>
                      <td>15-05-2014</td>
                      <td>Steel Bar</td>
                      <td>2.000.000</td>
                      <td>Kg</td>
                      <td>IDR 7.520 </td>
                  </tr>
                  <tr>
                      <td>008/SPJB/WK/IWSMI/V/2014</td>
                      <td>DSU</td>
                      <td>Interworld Steel</td>
                      <td>01-12-2014</td>
                      <td>31-12-2015</td>
                      <td>Steel Bar</td>
                      <td>2.500.000</td>
                      <td>Kg</td>
                      <td>IDR 7.100 </td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</section>


<script data-main="<?php echo base_url()?>assets/js/main/main-vendors" src="<?php echo base_url()?>assets/js/require.js"></script>
