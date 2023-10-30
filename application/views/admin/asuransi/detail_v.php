<section class="content-header">
 <h1>
   Detail Amandemen Asuransi
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active">Detail Amandemen
   </li>
 </ol>
</section>

<section class="content">
 <div class="box box-default color-palette-box">
   <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i> Detail Amandemen Asuransi <?= $detail_amandemen->no_contract ?></h3>
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
                 <td width="20%">No Kontrak</td>
                 <td width="30%"><b>: <?= $detail_amandemen->no_contract ?> </b></td>
                 <td width="20%">Nama Vendor</td>
                 <td width="30%"><b>: <?= $detail_amandemen->vendor_name ?></b></td>
             </tr>
             <tr>
                 <td width="20%">Tanggal</td>
                 <td width="30%"><b>: <?= tgl_indo($detail_amandemen->tgl_kontrak) ?></b></td>
                 <!-- <td width="20%">Nama Departemen Pemantau</td> -->
                 <!-- <td width="30%"><b>: <?= $detail_amandemen->dept_name ?></b></td> -->
             </tr>
             <!-- <tr>
                 <td width="20%">No Kontrak</td>
                 <td width="30%"><b>: <?= $detail_amandemen->no_contract ?></b></td>
                 <td width="20%">User Pemantau</td>
                 <td width="30%"><b>: <?= $detail_amandemen->user_name ?></b></td>
             </tr> -->
             <tr>
                 <td width="20%">Awal Kontrak</td>
                 <td width="30%"><b>: <?= tgl_indo($detail_amandemen->start_contract) ?></b></td>
             </tr>
             <tr>
                 <td width="20%">Akhir Kontrak</td>
                 <td width="30%"><b>: <?= tgl_indo($detail_amandemen->end_contract) ?></b></td>
                 
             </tr>
         </table>
         <h3>
            List Amandemen
         </h3>
         <div class="table-responsive">
         <table class="table table-striped" id="table2">
           <thead>
              <th>No Kontrak</th>
              <th>Nama Vendor</th>
              <th>Awal Kontrak</th>
              <th>Akhir Kontrak</th>
              <th>Nilai Harga Minimum</th>
              <th>Nilai Asuransi</th>
              <th>Jenis Asuransi</th>
           </thead>
         </table>
       </div>
     </div>
   </div>
   </div>
 </div>
 </section>
<input type="hidden" id="id_asuransi" value="<?= $id_asuransi ?>">
<script
 data-main="<?php echo base_url()?>assets/js/main/main-amandemen-asuransi"
 src="<?php echo base_url()?>assets/js/require.js">
</script>
