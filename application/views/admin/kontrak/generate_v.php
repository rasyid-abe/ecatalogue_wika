<section class="content-header">
 <h1>
   Generate Harga
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="<?= base_url().$cont ?>"><i class="fa fa-book"></i>Kontrak</a></li>
   <li class="active">Generate Harga</li>
 </ol>
</section>
<section class="content">
  <div class="full-width padding">
  <div class="padding-top">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-tag"></i>Generate Harga</h3>
            <div class="full-width datatableButton text-right">
               <a href="<?php echo base_url(). $cont ?>" class="btn btn-sm btn-warning pull-right"><i class='fa fa-arrow-left'></i> Kembali</a>
             </div>
            </div>
            <div class="box-body">
                <div id="generate_harga">

                </div>
                <div id="generate_harga_baru">

                </div>
                <div class="box-footer">
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                          <button type="button" class="btn btn-info" id = "btn-generate">Simpan</button>
                      </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<input type="hidden" id="id_kontrak" value="<?= $id ?>">;

 <script data-main="<?php echo base_url()?>assets/js/main/main-kontrak" src="<?php echo base_url()?>assets/js/require.js"></script>
