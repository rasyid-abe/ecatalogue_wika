 <section class="content-header">
  <h1>
    <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></li>
  </ol>
</section>

<section class="content">
    <?php if($is_can_search){?>
      <div class="box box-bottom">
        <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> Pencarian <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
           <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Nama Karyawan</label>
                <div class="col-sm-4">
                  <input type="name" class="form-control" id="name" placeholder="Nama Karyawan" name="name">
                </div>
               <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-4">
                 <input type="name" class="form-control" id="email" placeholder="Email" name="email">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 control-label">Handphone</label>
                <div class="col-sm-4">
                 <input type="name" class="form-control" id="phone" placeholder="Handphone" name="handphone">
                </div>
              </div>
              <div class="form-group row">
                   <label for="inputEmail3" class="col-sm-2 control-label">Role</label>
                   <div class="col-sm-4">
                     <select class="form-control" id="role_id" data-selectjs="true">
                         <option value="">Pilih Role</option>
                         <?php
                         asort($roles);
                         echo array_to_options($roles);
                          ?>
                     </select>
                   </div>
                  <label for="inputPassword3" class="col-sm-2 control-label">Departemen</label>
                   <div class="col-sm-4">
                       <select class="form-control" id="group_id" data-selectjs="true">
                           <option value="">Pilih Departemen</option>
                           <?php
                           asort($groups);
                           echo array_to_options($groups);
                            ?>
                       </select>
                   </div>
                 </div>
              <div class="form-group row">
                <div class="col-sm-12 text-right">
                  <a href="javascript:;" class="btn btn-sm btn-danger" id="reset">Hapus</a>
                  <a href="javascript:;" class="btn btn-sm btn-primary" id="search">Cari</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <?php } ?>
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    <?php if($is_can_create){?>
        <!-- <div class="full-width datatableButton text-right">
              <a href="<?php echo base_url()?>user/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> Pengguna</a>
        </div> -->
    <?php } ?>
    </div>
    <div class="box-body">
    <div class="box-header">
    </div>
      <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
            <?php if(!empty($this->session->flashdata('message'))){?>
            <div class="alert alert-info">
            <?php
               print_r($this->session->flashdata('message'));
            ?>
            </div>
            <?php }?>
             <?php if(!empty($this->session->flashdata('message_error'))){?>
            <div class="alert alert-danger">
            <?php
               print_r($this->session->flashdata('message_error'));
            ?>
            </div>
            <?php }?>
            <table class="table table-striped display nowrap" id="table">
              <thead>
                  <tr>                      
                      <th width ="3%">No Urut</th>
                      <th>Jabatan</th>
                      <th>Nama</th>
                      <th>No HP</th>
                      <th>Email</th>
                      <th>Username/NIK</th>
                      <th>Action</th>
                  </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script
  data-main="<?php echo base_url()?>assets/js/main/main-user"
  src="<?php echo base_url()?>assets/js/require.js">
</script>
