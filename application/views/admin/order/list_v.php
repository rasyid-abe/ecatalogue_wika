 <section class="content-header">
     <h1>
         <?php echo ucwords($page) ?>
         <small></small>
     </h1>
     <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active"><?php echo ucwords($page) ?></li>
     </ol>
 </section>

 <section class="content">
     <?php if ($is_can_search) { ?>
         <div class="box box-bottom">
             <div class="box-header with-border">
                 <h3 class="box-title"><i class="fa fa-tag"></i> Pencarian <?php echo ucwords($page) ?></h3>
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
                                     <label>No Surat</label>
                                     <input type="text" class="form-control" id="no_surat" placeholder="No Surat" name="no_surat">
                                 </div>
                                 <div class="col-sm-4">
                                     <label>Nama Proyek</label>
                                     <input type="text" class="form-control" id="nm_project" placeholder="Nama Proyek" name="nm_project">
                                 </div>
                             </div>
                             <div class="form-group row">
                                 <div class="col-sm-4">
                                     <label>Nama Vendor</label>
                                     <input type="text" class="form-control" id="vendor_name" placeholder="Nama Vendor" name="vendor_name">
                                 </div>
                                 <div class="col-sm-4">
                                     <label>Lokasi</label>
                                     <input type="text" class="form-control" id="location_name" placeholder="Lokasi" name="location_name">
                                 </div>
                                 <div class="col-sm-4">
                                     <label>Perihal</label>
                                     <input type="text" class="form-control" id="perihal" placeholder="Perihal" name="perihal">
                                 </div>
                             </div>
                             <div class="form-group row">
                                 <div class="col-sm-4">
                                     <label>Tanggal</label>
                                     <input type="text" class="form-control" id="daterange" placeholder="Tanggal Mulai" name="daterange" autocomplete="off">
                                 </div>
                                 <div class="col-sm-4">
                                     <label>Departemen</label>
                                     <select class="form-control" id="departemen_id" data-selectjs="true">
                                         <option value="" selected>Semua</option>
                                         <?php
                                            echo array_to_options($departemen);
                                            ?>
                                     </select>
                                 </div>
                                 <div class="col-sm-4">
                                     <label>Status</label>
                                     <select class="form-control" name="po_status" id="po_status">
                                         <option value="1000" selected>Semua</option>
                                         <option value="1">Approval</option>
                                         <option value="0">On Process</option>
                                         <option value="3">Reject</option>
                                     </select>
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
             <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page) ?></h3>
             <a href="javascript:;" id="btn-export-to-excel">
                 <button class="btn btn-sm btn-success pull-right" type="button"><i class="fa fa-file-excel-o"></i> Export to Excel</button></p>
             </a>
         </div>
         <div class="box-body">
             <div class="box-header"></div>
             <div class="row">
                 <div class="col-md-12">
                     <div class="table-responsive">
                         <?php if (!empty($this->session->flashdata('message'))) { ?>
                             <div class="alert alert-info">
                                 <?php
                                    print_r($this->session->flashdata('message'));
                                    ?>
                             </div>
                         <?php } ?>
                         <?php if (!empty($this->session->flashdata('message_error'))) { ?>
                             <div class="alert alert-danger">
                                 <?php
                                    print_r($this->session->flashdata('message_error'));
                                    ?>
                             </div>
                         <?php } ?>
                         <table class="table table-striped table-bordered display nowrap" id="table">
                             <thead>
                                 <th width="2%">No</th>
                                 <th>No Order</th>
                                 <th>No Surat</th>
                                 <th>Nama Vendor</th>
                                 <th>Nama Proyek</th>
                                 <th>Tonase (Kg)</th>
                                 <th>Total Harga</th>
                                 <th>Tanggal Order</th>
                                 <th>Detail</th>
                             </thead>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <script data-main="<?php echo base_url() ?>assets/js/main/main-order" src="<?php echo base_url() ?>assets/js/require.js">
 </script>