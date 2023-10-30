<section class="content-header">
 <h1>
   Detail Kontrak
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active">Detail Kontrak
   </li>
 </ol>
</section>

<section class="content">
 <div class="box box-default color-palette-box">
   <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i> Detail <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?> <?= $detail_kontrak->name ?></h3>
      <div class="full-width datatableButton text-right">
         <a href="<?php echo base_url(). $cont ?>" class="btn btn-sm btn-warning pull-right"><i class='fa fa-arrow-left'></i> Kembali</a>
       </div>
   </div>
   <div class="box-body">
   <div class="box-header">
   </div>
   <div class="row">
     <div class="col-md-12">
         <table border="0" width="100%">
             <tr>
                 <td width="20%">Nama Kontrak</td>
                 <td width="30%"><b>: <?= $detail_kontrak->name ?> </b></td>
                 <td width="20%">Nama Vendor</td>
                 <td width="30%"><b>: <?= $detail_kontrak->vendor_name ?></b></td>
             </tr>
             <tr>
                 <td width="20%">Tanggal</td>
                 <td width="30%"><b>: <?= tgl_indo($detail_kontrak->tanggal) ?></b></td>
                 <td width="20%">Nama Departemen Pemantau</td>
                 <td width="30%"><b>: <?= $detail_kontrak->dept_name ?></b></td>
             </tr>
             <tr>
                 <td width="20%">No Kontrak</td>
                 <td width="30%"><b>: <?= $detail_kontrak->no_contract ?></b></td>
                 <td width="20%">User Pemantau</td>
                 <td width="30%"><b>: <?= $detail_kontrak->user_name ?></b></td>
             </tr>
             <tr>
                 <td width="20%">Awal Kontrak</td>
                 <td width="30%"><b>: <?= tgl_indo($detail_kontrak->start_contract) ?></b></td>
                 <td width="20%">Volume (Kg)</td>
                 <td width="30%"><b>: <?= rupiah($detail_kontrak->volume,2) ?></b></td>
             </tr>
             <tr>
                 <td width="20%">Akhir Kontrak</td>
                 <td width="30%"><b>: <?= tgl_indo($detail_kontrak->end_contract) ?></b></td>
                 <td width="20%">Harga Kontrak (Rp)</td>
                 <td width="30%"><b>: <?= rupiah($detail_kontrak->harga) ?></b></td>
             </tr>
         </table>
         <h3>
            List Amandemen
         </h3>
         <div class="table-responsive">
         <table class="table table-striped table-bordered" id="table2">
           <thead>
              <th>No Kontrak</th>
              <th>Department</th>
              <th>Nama Vendor</th>
              <th>Awal Kontrak</th>
              <th>Akhir Kontrak</th>
              <th>Tanggal Amandemen</th>
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
 <?php $this->load->view('admin/kontrak/modal_amandemen_produk')?>
</section>
<input type="hidden" id="id_project" value="<?= $id_project ?>">
<script
 data-main="<?php echo base_url()?>assets/js/main/main-kontrak"
 src="<?php echo base_url()?>assets/js/require.js">
</script>
