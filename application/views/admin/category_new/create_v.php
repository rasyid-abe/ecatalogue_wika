<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Tambah <?= ucwords($page) ?></h3>
    </div>
     <form id="form" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="">Nama Kategori</label>
            <input class="form-control" type="name" id="name" name="name" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="">Code Kategori</label>
            <input class="form-control" type="name" id="code" name="code" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="">Icon</label>
            <input class="form-control" type="file" id="icon_file" name="icon_file" autocomplete="off" accept="image/*">
          </div>
        </div>
      </div>
    </div>
         <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="<?php echo base_url();?><?= $cont ?>" class="btn btn-primary btn-danger">Batal</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>


<script data-main="<?php echo base_url()?>assets/js/main/main-<?= $cont ?>" src="<?php echo base_url()?>assets/js/require.js"></script>
