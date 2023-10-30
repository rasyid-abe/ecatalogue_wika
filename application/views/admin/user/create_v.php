<section class="content">
<div class="full-width padding">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Pengguna Baru</h3>
    </div>
      <form class="form-horizontal" id="form" method="POST" action="" enctype="multipart/form-data">
      <input type="hidden" name="kd_kec_state" id="kd_kec_state" value="">
      <input type="hidden" name="id" id="user_id" value="0">
        <div class="box-body">
          <?php if(!empty($this->session->flashdata('message_error'))){?>
          <div class="alert alert-danger">
          <?php
             print_r($this->session->flashdata('message_error'));
          ?>
          </div>
          <?php }?>
           <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-9">
              <input type="name" class="form-control" id="name" placeholder="Name" name="name">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 control-label">Photo</label>
              <div class="col-sm-9">
                <input type="file" class="form-control" id="photo" placeholder="Photo" name="photo">
              </div>
            </div>

          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
             <input type="email" class="form-control" id="email" placeholder="Email" name="email">
            </div>
          </div>
          <div class="form-group row">
            <label  class="col-sm-3 control-label">Handphone</label>
            <div class="col-sm-9">
             <input type="text" class="form-control number" maxlength="13" id="phone" placeholder="Handphone" name="phone">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label">Address</label>
            <div class="col-sm-9">
             <textarea class="form-control" name="address"></textarea>
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Role</label>
            <div class="col-sm-9">
               <select id="role_id" name="role_id" class="form-control" data-selectjs="true">
                <option value="" disabled selected>Pilih Role</option>
                <?php
                foreach ($roles as $key => $role) { ?>
                  <option value="<?php echo $role->id;?>"><?php echo $role->name;?></option>
                <?php }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row hidden" id="departemen-cont">
            <label for="inputPassword3" class="col-sm-3 control-label">Departemen</label>
            <div class="col-sm-9">
               <select id="departemen" name="departemen" class="form-control" data-selectjs="true">
                <option value="" disabled selected>Pilih Departemen</option>
                <?php
                foreach ($groups as $group) { ?>
                  <option value="<?php echo $group->id;?>"><?php echo $group->name;?></option>
                <?php }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Username/NIK</label>
            <div class="col-sm-9">
             <input type="text" class="form-control" id="username" placeholder="Username" name="username">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
             <input type="password" class="form-control" id="password"  name="password">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Ulangi Password</label>
            <div class="col-sm-9">
             <input type="password" class="form-control" id="password_confirm" name="password_confirm">
            </div>
          </div>
        </div>
        <!-- <div class="box-footer pad-15 full-width bg-softgrey border-top bot-rounded">

          <button type="submit" class="btn btn-primary pull-right mleft-15" id="save-btn">Simpan</button>
          <a href="<?php echo base_url();?>user" class="btn btn-default pull-right">Batal</a>
        </div> -->
        <div class="box-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                    <button type="submit" class="btn btn-primary" id="save-btn">Simpan</button>
                    <a href="<?php echo base_url();?>user" class="btn btn-primary btn-danger">Batal</a>
           </div>
            </div>
        </div>
      </form>
    </div>
</section>

<script data-main="<?php echo base_url()?>assets/js/main/main-user" src="<?php echo base_url()?>assets/js/require.js"></script>
