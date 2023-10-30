
  <div class="container">
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url()?>home">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
      </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
            <div class="box box-primary">
              <div class="box-body box-white">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Profil Pengguna</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Ganti Password</a>
                  </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                      <input type="hidden" id="user_id" value="">
                <form class="form-horizontal" id="form" method="POST" action="">
                  <div class="box-body ">
                    <?php if(!empty($this->session->flashdata('message_error'))){?>
                    <div class="alert alert-danger mtop-10">
                    <?php
                       print_r($this->session->flashdata('message_error'));
                    ?>
                    </div>
                    <?php }?>
                    <?php if(!empty($this->session->flashdata('message'))){?>
                    <div class="alert alert-info mtop-10">
                    <?php
                       print_r($this->session->flashdata('message'));
                    ?>
                    </div>
                    <?php }?>
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 control-label">Nama Lengkap</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_lengkap" placeholder="Nama Lengkap" name="nama_lengkap" value="<?php echo $name;?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="user_name" placeholder="username" name="user_name" value="<?php echo $user_name;?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputPassword3" class="col-sm-3 control-label">Email</label>
                      <div class="col-sm-9">
                       <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $email;?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 control-label">Nomor Handphone</label>
                      <div class="col-sm-9">
                       <input type="text" class="form-control" id="phone" placeholder="Nomor Handphone" name="phone" value="<?php echo $phone;?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Alamat</label>
                      <div class="col-sm-9">
                       <textarea class="form-control" id="address" name="address"><?php echo $address?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <div class="col-sm-12 text-right">
                      <a href="<?php echo base_url();?>home" class="btn btn-sm btn-secondary ">Batal</a>
                      <button type="submit" class="btn btn-sm btn-blue" name="profil_pengguna" value="1" id="save-btn">Simpan</button>
                    </div>
                  </div>
                </form>
                  </div>
                  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                      <form class="form-horizontal" id="forms" method="POST" action="<?php echo base_url()?>profile">
                        <div class="box-body">
                          <?php if(!empty($this->session->flashdata('messages'))){?>
                          <div class="alert alert-success">
                          <?php
                             print_r($this->session->flashdata('messages'));
                          ?>
                          </div>
                          <?php }?>
                          <input type="hidden" name="id" value="<?php echo $id;?>">
                          <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 control-label">Password Lama</label>
                            <div class="col-sm-9">
                              <input type="password" class="form-control" id="old_password"  name="old_password">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 control-label">Password Baru</label>
                            <div class="col-sm-9">
                              <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 control-label">Konfirmasi Password Baru</label>
                            <div class="col-sm-9">
                             <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                          </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-sm-12 text-right">
                              <a href="<?php echo base_url();?>home" class="btn btn-sm btn-secondary ">Batal</a>
                              <button type="submit" class="btn btn-sm btn-blue" name="password_pengguna" value="1" id="save-btn2">Simpan</button>
                            </div>
                        </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  </div>
<script data-main="<?php echo base_url()?>assets/js/main/main-userprofile" src="<?php echo base_url()?>assets/js/require.js"></script>
