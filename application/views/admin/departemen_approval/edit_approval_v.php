<?php
//var_dump($user_pemantau_list);
?>
<section class="content">
  <div class="full-width padding">
  <div class="padding-top">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-tag"></i> Edit Approval</h3>
            </div>
          <form id="form" method="POST" action="" enctype="multipart/form-data">
            <div class="box-body">
              <?php if(!empty($this->session->flashdata('message_error'))){?>
                <div class="alert alert-danger">
                <?php
                   print_r($this->session->flashdata('message_error'));
                ?>
                </div>
                <?php }?>
                <input type="hidden" name="departemen_id" value="<?= $departemen->id;?>">
                <div class="form-group row">
                    <div class="col-md-10">
                        <label for="">Departemen</label>
                        <input type="text" class="form-control" value="<?= $departemen->name ?>" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-info form-control" type="button" id="btn-tambah-role">
                            <i class="fa fa-plus"></i> Tambah Role
                        </button>
                    </div>
                </div>
                <?php
                $i = 1;
                foreach ($approve_po as $k => $v)
                {
                    ?>
                    <div class="form-group role-list row">
                        <div class="col-md-10">
                            <label for="" class="approval-label">Approval Ke <?= $i ?></label>
                                <select class="form-control" name="role_id[]" data-selectjs="true">
                                <?= array_to_options($roles, $v->role_id)?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-danger form-control" type="button" onclick="$(this).parent().parent().remove();App.update_label_approval()">
                                <i class="fa fa-trash-o"></i> Hapus Role
                            </button>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
                 ?>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                            <button type="submit" class="btn btn-primary" id="save-btn">Simpan</button>
                            <a href="<?php echo base_url();?><?= $cont ?>" class="btn btn-primary btn-danger">Batal</a>
                   </div>
                    </div>
                </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="template" id="dropdown_roles">
  <div class="form-group role-list row">
      <div class="col-md-10">
          <label for="" class="approval-label">Role</label>
              <select class="form-control" name="role_id[]" data-selectjs="true">
              <?= array_to_options($roles)?>
          </select>
      </div>
      <div class="col-md-2">
          <label for="">&nbsp;</label>
          <button class="btn btn-danger form-control" type="button" onclick="$(this).parent().parent().remove();App.update_label_approval()">
              <i class="fa fa-trash-o"></i> Hapus Role
          </button>
      </div>
  </div>
  </script>
</div>
</section>

 <script data-main="<?php echo base_url()?>assets/js/main/main-<?= $cont ?>" src="<?php echo base_url()?>assets/js/require.js"></script>
