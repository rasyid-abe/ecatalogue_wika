<section class="content-header">
 <h1>
   <?php echo ucwords($page)?>
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active"><?php echo ucwords($page)?>
   </li>
 </ol>
</section>

<section class="content">
 <div class="box box-default color-palette-box">
   <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i><?php echo ucwords($page)?></h3>
      <div class="full-width datatableButton text-right">

       </div>
   </div>
   <div class="box-body">
   <div class="box-header">
   </div>
     <div class="row">
       <div class="col-md-12">
           <table class="table table-striped display nowrap" id="table">
             <thead>
               <th width ="3%">No Urut</th>
               <th>Deskripsi</th>
             </thead>
           </table>
         </div>
       </div>
     </div>
   </div>
 </div>
</section>
<script
 data-main="<?php echo base_url()?>assets/js/main/main-notifikasi"
 src="<?php echo base_url()?>assets/js/require.js">
</script>
