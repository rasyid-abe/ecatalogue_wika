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
            <h3 class="box-title"><i class="fa fa-tag"></i> Edit Pakta Integritas</h3>
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
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <input type="hidden" name="role_id" value="<?= $data->role_id ?>">                
                <div class="form-group">
                    <label for="">Role</label>
                    <input type="text" name="" value="<?= $roles[$data->role_id] ?>" readonly class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Deskripsi</label>
                    <?= form_textarea([
                        'class' => 'form-control',
                        'name'   => 'description',
                        'rows' => 5,
                    ],
                    $data->description
                    )
                    ?>
                </div>
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
</div>
</section>

 <script data-main="<?php echo base_url()?>assets/js/main/main-project" src="<?php echo base_url()?>assets/js/require.js"></script>
