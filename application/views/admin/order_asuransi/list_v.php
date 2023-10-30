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
           </div>
           <div class="box-body">
             <div class="row">
               <div class="col-md-12">
                   <form id="form-search">
                       <div class="form-group row">
                           <div class="col-sm-4">
                               <label>No Order</label>
                               <input type="text" class="form-control" id="order_no" placeholder="No Order" name="order_no">
                           </div>
                           <div class="col-sm-4">
                               <label>Nama Proyek</label>
                               <input type="text" class="form-control" id="nm_project" placeholder="Nama Proyek" name="nm_project">
                           </div>
                           <div class="col-sm-4">
                               <label>Nama Vendor</label>
                               <input type="text" class="form-control" id="vendor_name" placeholder="Nama Vendor" name="vendor_name">
                           </div>
                       </div>
                   <div class="form-group row">
                     <div class="col-sm-12 text-right">
                       <a href="javascript:;" class="btn btn-sm btn-danger" id="reset">Hapus</a>
                       <a href="javascript:;" class="btn btn-sm btn-primary" id="search">Cari</a>
                     </div>
                   </form>
                 </div>
               </div>
             </div>
           </div>
       </div>
   <?php } ?>
   <div class="box box-default color-palette-box">
       <div class="box-header with-border">
           <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page)?></h3>
           <!-- <a href="javascript:;" id="btn-export-to-excel">
               <button class="btn btn-sm btn-success pull-right" type="button"><i class="fa fa-file-excel-o"></i> Export to Excel</button></p>
           </a> -->
       </div>
       <div class="box-body">
           <div class="box-header"></div>
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
                       <table class="table table-striped table-bordered display nowrap" id="table">
                         <thead>
                             <tr>
                                 <th width="2%">No</th>
                                 <th>No Order</th>
                                 <th>Nama Project</th>
                                 <th>Nama Vendor</th>
                                 <th>Nilai PO</th>
                                 <th>Harga Asuransi</th>
                                 <th>Nilai Asuransi</th>
                                 <th>Tanggal Order</th>
                                 <th>Action</th>
                             </tr>
                         </thead>
                       </table>
                   </div>
               </div>
           </div>
       </div>
   </div>
</section>
<script
 data-main="<?php echo base_url()?>assets/js/main/main-order_asuransi"
 src="<?php echo base_url()?>assets/js/require.js">
</script>
