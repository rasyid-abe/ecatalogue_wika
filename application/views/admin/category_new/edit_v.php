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
            <h3 class="box-title"><i class="fa fa-tag"></i> Ubah Kategori</h3>
            </div>
          <form  id="form" method="POST" action="" enctype="multipart/form-data">
            <div class="box-body">
              <?php if(!empty($this->session->flashdata('message_error'))){?>
                <div class="alert alert-danger">
                <?php
                   print_r($this->session->flashdata('message_error'));
                ?>
                </div>
                <?php }?>
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <div class="form-group">
                  <label for="">Nama Kategori</label>
                  <input class="form-control" type="name" id="name" name="name" autocomplete="off" required value="<?= $name ?>">
                </div>
                <div class="form-group">
                  <label for="">Code Kategori</label>
                  <input class="form-control" type="name" id="code" name="code" autocomplete="off" required value="<?= $code ?>">
                </div>
                <div class="form-group">
                  <label for="">Icon</label>
                  <input class="form-control" type="file" id="icon_file" name="icon_file" autocomplete="off" accept="image/*">
                </div>
            <div class="box-footer pad-15 full-width bg-softgrey border-top bot-rounded">
              <button type="submit" class="btn btn-primary pull-right mleft-15" id="save-btn">Simpan</button>
              <a href="<?php echo base_url();?><?= $cont ?>" class="btn btn-default pull-right">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

 <script data-main="<?php echo base_url()?>assets/js/main/main-<?= $cont ?>" src="<?php echo base_url()?>assets/js/require.js"></script>
