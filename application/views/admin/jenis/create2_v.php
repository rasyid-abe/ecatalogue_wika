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
            <label for="">Kategori</label>
            <select class="form-control form-sm" name="parent" id="parent">
                <option value="">Pilih</option>
                <option value="" disabled selected>Pilih </option>
                <?php
                echo array_to_options($jenis)
                ?>
            </select>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="">Nama Sub Kategori</label>
            <input class="form-control" type="name" id="name" name="name" autocomplete="off" required>
          </div>
        </div>
      </div>
    </div>
         <div class="box-footer"> 
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="<?php echo base_url();?>jenis_sub" class="btn btn-primary btn-danger">Batal</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>


<script data-main="<?php echo base_url()?>assets/js/main/main-jenis_sub" src="<?php echo base_url()?>assets/js/require.js"></script>
