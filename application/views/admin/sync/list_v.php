<section class="content-header">
 <h1>
   <?php echo ucwords($page)?>
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active"><?php echo ucwords($page) ?>
   </li>
 </ol>
</section>

<section class="content">

 <div class="box box-default color-palette-box">
   <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
      <div class="full-width datatableButton text-right">
          <a href="<?php echo base_url()?>sync/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></a>
       </div>
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
           <table class="table table-striped display" id="table">
             <thead>
               <th width="2%">No</th>
               <th width="40%">Jenis Sync</th>
               <th>Tanggal Sinkronisasi</th>
             </thead>
           </table>
         </div>
       </div>
     </div>
   </div>
 </div>
</section>
<script
 data-main="<?php echo base_url()?>assets/js/main/main-sync"
 src="<?php echo base_url()?>assets/js/require.js">
</script>
