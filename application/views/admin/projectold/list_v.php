<section class="content-header">
 <h1>
   <?php echo ucwords(str_replace("_"," ",$page))?>
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active"><?php echo ucwords(str_replace("_"," ",$page))?></li>
 </ol>
</section>

<section class="content">
 <div class="box box-default color-palette-box">
   <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i><?php echo ucwords(str_replace("_"," ",$page))?></h3>
      <div class="full-width datatableButton text-right">
         <a href="<?php echo base_url(). $cont ?>/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> <?php echo ucwords(str_replace("_"," ",$page))?></a>
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
           <table class="table table-striped display nowrap" id="table">
             <thead>
               <th width="5px" class="text-center">No</th>
               <th>Nama</th>
               <th>No Surat</th>
               <th>Tanggal</th>
               <th width="100px">Aksi</th>
             </thead>
           </table>
         </div>
       </div>
     </div>
   </div>
 </div>
</section>
<script
 data-main="<?php echo base_url()?>assets/js/main/main-project"
 src="<?php echo base_url()?>assets/js/require.js">
</script>
