<section class="content">
  <div class="full-width padding">
  <div class="padding-top">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <form class="form-horizontal" id="form" method="POST" action="" enctype="multipart/form-data">
          <input type="hidden" name="kd_kec_state" id="kd_kec_state" value="">
            <div class="box-body">
              <?php if(!empty($this->session->flashdata('message_error'))){?>
                <div class="alert alert-danger">
                <?php
                   print_r($this->session->flashdata('message_error'));
                ?>
                </div>
                <?php }?>
                <input type="hidden" name="id" id="user_id" value="<?php echo $id;?>">
                <input type="hidden" id="role_id_selected" value="<?php echo $role_id;?>">
                <?php if(!empty($foto)){?>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label"></label>
                  <div class="col-sm-9">
                   <img width="100px" src="<?php echo base_url()."assets/images/foto/".$foto;?>">
                  </div>
                </div>
                <?php }?>
                  <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo $first_name;?>">
                  </div>
                </div>
                <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 control-label">Photo</label>
                  <div class="col-sm-9">
                    <input type="file" class="form-control" id="photo" placeholder="Photo" name="photo">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 control-label">Username /NIK</label>
                  <div class="col-sm-9">
                   <input type="text" class="form-control" id="username" placeholder="Username / Email" name="username" value="<?php echo $username;?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-9">
                   <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $email;?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label  class="col-sm-3 control-label">Handphone</label>
                  <div class="col-sm-9">
                   <input type="number" class="form-control" id="phone" placeholder="Handphone" name="phone" value="<?php echo $phone;?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 control-label">Address</label>
                  <div class="col-sm-9">
                   <textarea class="form-control" name="address" placeholder="Address"><?php echo $address?></textarea>
                  </div>
                </div>
              <hr>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 control-label">Role</label>
                <div class="col-sm-9">
                   <select id="role_id" name="role_id" class="form-control">
                    <option value="">Pilih Role</option>
                    <?php
                    foreach ($roles as $key => $role) { ?>
                      <option value="<?php echo $role->id;?>" <?php echo $role->id == $role_id ? 'selected' : '' ?>><?php echo $role->name;?></option>
                    <?php }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row" id="departemen-cont">
                <label for="inputPassword3" class="col-sm-3 control-label">Departemen</label>
                <div class="col-sm-9">
                   <select id="departemen" name="departemen" class="form-control">
                    <option value="" disabled selected>Pilih Departemen</option>
                    <?php
                    foreach ($groups as $group) { ?>
                      <option value="<?php echo $group->id;?>" <?php echo $group->id == $group_id ? 'selected' : ''?>><?php echo $group->name;?></option>
                    <?php }
                    ?>
                  </select>
                </div>
              </div>
            </div>
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
      </div>
    </div>
  </div>
</div>
</section>

 <script data-main="<?php echo base_url()?>assets/js/main/main-user" src="<?php echo base_url()?>assets/js/require.js"></script>
