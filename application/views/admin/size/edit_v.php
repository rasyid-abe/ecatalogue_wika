<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page) ?></h3>
    </div>
     <form id="form" method="post">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <select id="specification_id" name="specification_id" class="form-control" required data-selectjs="true">
                <option value="">Pilih Sumber Daya</option>
                <?php
                $last_cat = 0;
                $spec_code = "";
                foreach ($specification as $key => $value)
                {
                    if($last_cat != $value->category_id)
                    {
                        ?>
                        <optgroup label="<?= $value->category_name ?>">
                        <?php
                        $last_cat = $value->category_id;
                    }
                $select = "";
                  if($value->id == $specification_id){
                    $spec_code = $value->category_code.$value->code;
                    $select="selected";
                  }
                  ?>
                  <option value="<?php echo $value->id;?>" <?php echo $select ?> data-code-cat="<?= $value->category_code.$value->code ?>"><?php echo $value->name;?></option>
                <?php
                    if(isset($specification[$key + 1]))
                    {
                        $next = $specification[$key + 1];
                        if($last_cat != $next->category_id)
                        {
                            ?>
                            </optgroup>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                        </optgroup>
                        <?php
                    }
                }
                ?>
              </select>
          </div>
          <div class="form-group">
            <label for="">Nama Spesifikasi</label>
            <input class="form-control" value="<?php echo $name;?>" type="text" id="name" name="name" autocomplete="off" required>
          </div>
          <div class="form-group col-12 row">
            <div class="col-sm-6">
                <label for="">Kode Sumber Daya</label>
                <input class="form-control" type="text" id="code_1" name="code_1" autocomplete="off" required placeholder="Kode Sumber Daya" readonly value="<?= $spec_code ?>">
            </div>
            <div class="col-sm-6">
                <label for="">Kode Spesifikasi</label>
                <input class="form-control" type="text" id="code" name="code" autocomplete="off" placeholder="Kode Spesifikasi" maxlength="25" value="<?= $code?>">
            </div>
          </div>
          <div class="form-group">
            <label for="">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" autocomplete="off"><?php echo $description;?></textarea>
          </div>
          <div class="form-group">
            <label for="">Total Berat /unit</label>
            <input class="form-control number" value="<?php echo $default_weight;?>" type="text" id="default_weight" name="default_weight" autocomplete="off" required>
          </div>
        </div>
      </div>
    </div>
         <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="<?php echo base_url();?>size" class="btn btn-primary btn-danger">Batal</a>
            </div>
        </div>
      </div>
    </form>
  </div>
</section>


<script data-main="<?php echo base_url()?>assets/js/main/main-size" src="<?php echo base_url()?>assets/js/require.js"></script>


</section>
