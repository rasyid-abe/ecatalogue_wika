<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page) ?></h3>
    </div>
     <form id="form" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" id="user_id" value="0">
      <div class="box-body">
        <?php echo validation_errors()?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">Nama Vendor</label>
              <input class="form-control" type="text" id="name" name="name" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="">Nama Direktur</label>
              <input class="form-control" type="text" id="nama_direktur" name="nama_direktur" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="">No Telp</label>
              <input class="form-control" type="text" id="no_telp" name="no_telp" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="">No Fax</label>
              <input class="form-control" type="text" id="no_fax" name="no_fax" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="">Email Vendor</label>
              <input class="form-control" type="email" id="email" name="email" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="">Deskripsi</label>
              <textarea class="form-control" id="description" name="description" autocomplete="off"></textarea>
            </div>
            <div class="form-group">
              <label for="">Alamat</label>
              <textarea class="form-control" id="address" name="address" autocomplete="off"></textarea>
            </div>
            <hr>
            <!-- <div class="form-group">
              <label for="">Email user sebagai username</label>
              <input class="form-control" type="email" id="email_user" name="email_user" autocomplete="off" required>
            </div> -->
            <div class="form-group">
              <label for="">Username</label>
              <input type="name" class="form-control" id="username" placeholder="Username" name="username">
            </div>
            <div class="form-group">
              <label for="">Password</label>
              <input type="password" class="form-control" id="password"  name="password">
            </div>
            <div class="form-group">
              <label for="">Ulangi Password</label>
              <input type="password" class="form-control" id="password_confirm" name="password_confirm">
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
</section>


<script data-main="<?php echo base_url()?>assets/js/main/main-vendors" src="<?php echo base_url()?>assets/js/require.js"></script>
