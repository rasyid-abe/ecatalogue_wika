<section class="content-header">
 <h1>
   Detail <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?>
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="<?= base_url()?>forecast"><?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></a></li>
   <li class="active">Detail <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></li>
 </ol>
</section>
<input type="hidden" name="chartdata" id="chartdata" value='<?=$chartdata?>'>
<section class="content">
 <div class="box box-default color-palette-box">
   <div class="box-header with-border">
       <h3 class="box-title"><i class="fa fa-tag"></i>Detail <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
       <a href="<?= base_url()?>forecast" class="btn btn-sm btn-warning pull-right"><i class='fa fa-arrow-left'></i> Kembali</a>
   </div>
   <div class="box-body">
   <div class="box-header">

   </div>
     <div class="row">
       <div class="col-md-12">
           <div class="table-responsive">
           <table class="table table-striped" id="table-detail">
             <thead>
                 <th>No Urut</th>
                 <th>category</th>
                 <th>Bulan</th>
                 <th>Tahun</th>
                 <th>Harga Bawah</th>
                 <th>Harga Atas</th>
                 <th>Status</th>
             </thead>
             <tbody>
                 <?php
                 if($detail)
                 {
                     $no = 1;
                     foreach($detail as $v)
                     {
                         ?>
                         <tr>
                             <td><?= $no++ ?></td>
                             <td><?= $v->category_name ?></td>
                             <td><?= bulan($v->month) ?></td>
                             <td><?= $v->year ?></td>
                             <td><?= rupiah($v->price) ?></td>
                             <td><?= rupiah($v->price_upper) ?></td>
                             <td><?= $v->is_deleted == 0 ? 'Digunakan' : 'Tidak Digunakan' ?></td>
                         </tr>
                         <?php
                     }
                 }
                 ?>

             </tbody>
           </table>
         </div>
       </div>
     </div>
   </div>
 </div>
</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-forecast" src="<?php echo base_url()?>assets/js/require.js"></script>
