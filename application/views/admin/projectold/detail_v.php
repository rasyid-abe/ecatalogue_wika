<section class="content-header">
 <h1>
   Detail Project
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active">Detail Project
   </li>
 </ol>
</section>

<section class="content">
 <div class="box box-default color-palette-box">
   <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i>Detail <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
      <div class="full-width datatableButton text-right">
         <a href="<?php echo base_url(). $cont ?>" class="btn btn-sm btn-warning pull-right"><i class='fa fa-arrow-left'></i> Kembali</a>
       </div>
   </div>
   <div class="box-body">
   <div class="box-header">
   </div>
   <div class="row">
     <div class="col-md-12">
         <div class="table-responsive">
         <table class="table table-striped" id="table2">
           <thead>
              <th>No Kontrak</th>
              <th>Department</th>
              <th>Nama Vendor</th>
              <th>Awal Kontrak</th>
              <th>Akhir Kontrak</th>
              <th>Volume</th>
              <th>Harga</th>
              <th>Aksi</th>
           </thead>
         </table>
       </div>
     </div>
   </div>
   </div>
 </div>
 <?php $this->load->view('admin/project/modal_amandemen_produk')?>
</section>
<input type="hidden" id="id_project" value="<?= $id_project ?>">
<script
 data-main="<?php echo base_url()?>assets/js/main/main-project"
 src="<?php echo base_url()?>assets/js/require.js">
</script>
