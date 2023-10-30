<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php  echo ucwords($page) ?></h3>
    </div>
     <form id="form" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
            <div class="form-group">
              <label for="">Kategori</label>
              <select id="category_new_id" name="category_new_id" class="form-control" data-selectjs="true" required>
               <option value="" disabled selected>Pilih Kategori</option>
               <?php
               foreach ($category_new as $v)
               {
                   $sel = '';
                   if($category_new_id == $v->id)
                   {
                       $sel = 'selected';
                   }
                   ?>
                   <option value="<?= $v->id ?>" <?= $sel ?>><?= $v->name ?></option>
                   <?php
               }
                ?>
             </select>
            </div>
          <div class="form-group">
            <label for="">Nama Jenis</label>
            <input class="form-control" value="<?php echo $name;?>" type="name" id="name" name="name" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="">Code Jenis</label>
            <input class="form-control" type="name" id="code" name="code" autocomplete="off" required value="<?php echo $code;?>">
          </div>
          <div class="form-group">
            <label for="">Icon</label>
            <input class="form-control" type="file" id="icon_file" name="icon_file" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" autocomplete="off"><?php echo $description;?></textarea>
          </div>
          <div class="form-group">
              <div class="radio">
                  <label>
                      <input type="radio" name="is_margis" <?php echo $is_margis == 1 ? 'checked' : '' ?> value="matgis">Matgis
                  </label>
              </div>
              <div class="radio">
                  <label>
                      <input type="radio" name="is_margis" <?php echo $is_non_margis == 1 ? 'checked' : '' ?> value="non_matgis">Non Matgis
                  </label>
              </div>
          </div>
        </div>
      </div>
    </div>
         <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="<?php echo base_url();?>category" class="btn btn-primary btn-danger">Batal</a>
            </div>
        </div>
      </div>
    </form>
  </div>
</section>


<script data-main="<?php echo base_url()?>assets/js/main/main-category" src="<?php echo base_url()?>assets/js/require.js"></script>


</section>
