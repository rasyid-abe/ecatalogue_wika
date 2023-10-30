<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i><?php echo ucwords($page) ?></h3>
    </div>
     <form id="form" method="post">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
        <div class="form-group">
          <label for="">Jenis</label>
          <select name = "category_id" id = "category_id" class="form-control" data-selectjs="true">
              <option value = "" disabled selected>Jenis</option>
              <?php
              foreach($category  as $k => $v)
              {
                  ?>
                  <option value = "<?= $v->id ?>" data-code-cat="<?= $v->code ?>"><?= $v->name     ?></option>
                  <?php
              }
              ?>
          </select>
        </div>
          <div class="form-group">
            <label for="">Nama Sumber Daya</label>
            <input class="form-control" type="name" id="name" name="name" autocomplete="off" required>
          </div>
          <div class="form-group col-12 row">
            <div class="col-sm-6">
                <label for="">Kode Jenis</label>
                <input class="form-control" type="text" id="code_1" name="code_1" autocomplete="off" required placeholder="Kode Jenis" readonly>
            </div>
            <div class="col-sm-6">
                <label for="">Kode Sumber Daya</label>
                <input class="form-control" type="text" id="code" name="code" autocomplete="off" placeholder="Kode Sumber Daya" maxlength="25">
            </div>
          </div>
          <!-- <div class="form-group">
            <label for="">Code Spesifikasi</label>
            <input class="form-control" type="name" id="code" name="code" autocomplete="off" required>
          </div> -->
          <div class="form-group">
            <label for="">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" autocomplete="off"></textarea>
          </div>
        </div>
      </div>
    </div>
         <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="<?php echo base_url();?>specification" class="btn btn-primary btn-danger">Batal</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>


<script data-main="<?php echo base_url()?>assets/js/main/main-specification" src="<?php echo base_url()?>assets/js/require.js"></script>
