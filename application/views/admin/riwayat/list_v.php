 <section class="content-header">
  <h1>
    <?php echo ucwords($page)?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?php echo ucwords($page)?></li>
  </ol>
</section>

<section class="content">
<?php if($is_can_search){?>
  <div class="box box-bottom">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Pencarian <?php echo ucwords($page)?></h3>
    <div class="full-width datatableButton text-right">

    </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
       <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 control-label">Nama Vendor</label>
            <div class="col-sm-4">
              <input type="name" class="form-control" id="name_vendor" placeholder="Nama Vendor" name="name">
            </div>
           <label for="inputPassword3" class="col-sm-2 control-label">Spesifikasi</label>
            <div class="col-sm-4">
             <input type="name" class="form-control" id="spesifikasi" placeholder="Spesifikasi" name="spesifikasi">
            </div>
          </div>
          <div class="form-group col-12 row">
            <label for="inputPassword3" class="col-sm-2 control-label">Awal Kontrak</label>
            <div class="col-sm-4">
              <div class="" data-datepicker="true">
                <input class="form-control" type="text" value="" id="start_contract" name="start_contract" autocomplete="off">
              </div>
            </div>
            <label for="inputPassword3" class="col-sm-2 control-label">Akhir Kontrak</label>
              <div class="col-sm-4">
              <div class="" data-datepicker="true">
                <input class="form-control" type="text" value="" id="end_contract" name="end_contract" autocomplete="off">
              </div>
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
        <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
         <a href="javascript:;" class="btn btn-sm btn-success pull-right" id = "btn-export"><i class='fa fa-plus'></i> Export To Excel</a>
    </div>
    <div class="box-body">
    <div class="box-header">

    </div>
      <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
            <?php if(!empty($this->session->flashdata('message'))){?>
            <div class="alert alert-info">
            <?php
               print_r($this->session->flashdata('message'));
            ?>
            </div>
            <?php }?>
             <?php if(!empty($this->session->flashdata('message_error'))){?>
            <div class="alert alert-danger">
            <?php
               print_r($this->session->flashdata('message_error'));
            ?>
            </div>
            <?php }?>
            <table class="table table-striped" id="table">
              <thead>
                  <th width ="3%">No Urut</th>
                  <th>Nama Produk</th>
                  <th>Nama Vendor</th>
                  <th>Tgl Perubahan</th>
                  <th>Harga Lama</th>
                  <th>Harga Baru</th>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 <script data-main="<?php echo base_url()?>assets/js/main/main-riwayat" src="<?php echo base_url()?>assets/js/require.js"></script>
