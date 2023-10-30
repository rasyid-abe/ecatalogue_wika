<input type="hidden" name="json_size" id="json_size" value='<?php echo $json_size ?>'>
<input type="hidden" id="arrLocationVendor" value='[]'>
<section class="content-header">
  <h1>
    <?php echo ucwords($page) ?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?php echo ucwords($page) ?></li>
  </ol>
</section>

<section class="content">
  <?php if ($is_can_search) { ?>
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
                <select class="form-control" id="vendor_id" data-selectjs="true">
                  <option value="">Pilih Vendor</option>
                  <?php
                  foreach ($vendor as $key => $value) {
                    $select = "";
                    if ($value->id == $users->vendor_id) {
                      $select = "selected";
                    }
                  ?>
                    <option value="<?php echo $value->id ?>" <?php echo $select ?>><?php echo $value->name ?></option>
                  <?php } ?>
                </select>
              </div>
              <label for="inputPassword3" class="col-sm-2 control-label">Sumber Daya</label>
              <div class="col-sm-4">
                <select class="form-control" id="sda_code" data-selectjs="true">
                  <option value="">Pilih Sumber Daya</option>
                  <?php
                  foreach ($kode_sda as $key => $value) { ?>
                    <option value="<?php echo $value->code_1 ?>"><?php echo $value->code_1 ?> - <?php echo $value->name ?></option>
                  <?php }  ?>
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
      <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page) ?></h3>
      <?php if ($is_can_create) { ?>
        <div class="col-md-2 datatableButton pull-right">
          <div class="row">
            <a href="<?php echo base_url() ?>product/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> <?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?></a>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="box-body">
      <div class="box-header">
      </div>
      <div class="row">
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
            <table class="table table-striped" id="table">
              <thead>
                <tr>
                  <th>No Urut</th>
                  <th>Vendor</th>
                  <th>Nama Produk</th>
                  <th>Kode Produk</th>
                  <th>Sumber daya</th>
                  <th width="15%">Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-product" src="<?php echo base_url() ?>assets/js/require.js"></script>