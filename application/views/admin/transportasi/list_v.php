<section class="content-header">
    <h1>
        <?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?>
        </li>
    </ol>
</section>

<section class="content">
    <!-- <?php if ($is_can_search) { ?>
      <div class="box box-bottom">
        <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> Pencarian <?php echo ucwords($page) ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
           <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Vendor</label>
                <div class="col-sm-4">
                 <select class="form-control" id="vendor_id" name="vendor_id" data-selectjs="true">
                     <option value="">Pilih Vendor</option>
                     <?php
                        echo array_to_options($vendor);
                        ?>
                 </select>
                </div>
               <label for="inputPassword3" class="col-sm-2 control-label">Origin</label>
                <div class="col-sm-4">
                    <select class="form-control" name="origin_location_id" id="origin_location_id" data-selectjs="true">
                    <option value="" selected>Pilih Origin</option>
                    <?php
                    echo array_to_options($location);
                    ?>
                </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 control-label">Destinasi</label>
                <div class="col-sm-4">
                    <select class="form-control" name="destination_location_id" id="destination_location_id" data-selectjs="true">
                    <option value="" selected>Pilih Destinasi</option>
                    <?php
                    echo array_to_options($location_destination);
                    ?>
                </select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">Harga</label>
                <div class="col-sm-4">
                    <input type="text" name="price" id="price" class="form-control">
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

    <?php } ?> -->
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-tag"></i><?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?></h3>
            <?php
            /*
            if ($this->data['is_can_create']) {?>

                <a href="<?php echo base_url(). $cont ?>/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></a>

            <?php }
            */
            ?>
        </div>
        <div class="box-body" style="height:500px">

            <div style="width:600px;margin-bottom:10px">
                <select class="form-control" name="" data-selectjs="true" id="vendorSelectHandson">
                    <option value="" disabled selected>Pilih Vendor</option>
                    <?php
                    echo array_to_options($vendor);
                    ?>
                </select>
            </div>

            <div style="display:block">
                <button class="btn btn-success btn-sm hidden btn-download" type="button" data-btn="wilayah">
                    Download Wilayah
                </button>
                <button class="btn btn-success btn-sm hidden btn-download" type="button" data-btn="transport">
                    Download Data Transportasi
                </button>
            </div>
            <div id="handson">

            </div>
            <!-- <div class="box-header">
            </div> -->
            <!-- <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <?php if (!empty($this->session->flashdata('message'))) { ?>
                            <div class="alert alert-info">
                                <?php
                                print_r($this->session->flashdata('message'));
                                ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($this->session->flashdata('message_error'))) { ?>
                            <div class="alert alert-danger">
                                <?php
                                print_r($this->session->flashdata('message_error'));
                                ?>
                            </div>
                        <?php } ?>
                        <table class="table table-striped table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th width ="3%">No Urut</th>
                                    <th>Nama Vendor</th>
                                    <th>Origin</th>
                                    <th>Destinasi</th>
                                    <th>Harga</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div> -->
        </div>
        <?php
        if ($is_can_create) {
        ?>
            <div class="box-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button type="button" class="btn btn-info hidden" id="btn-generate">Simpan</button>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</section>
<input type="hidden" id="sda" value='<?php echo json_encode(array_values($sda)) ?>'>
<input type="hidden" id="location_destination" value='<?php echo json_encode(array_values($location_destination)) ?>'>
<input type="hidden" id="location" value='<?php echo json_encode(array_values($location)) ?>'>
<input type="hidden" id="data_vendor" value='<?php echo json_encode(array_values($vendor)) ?>'>
<input type="hidden" id="vendorId" value='<?php echo $users->vendor_id ?>'>
<script data-main="<?php echo base_url() ?>assets/js/main/main-transportasi" src="<?php echo base_url() ?>assets/js/require.js">
</script>