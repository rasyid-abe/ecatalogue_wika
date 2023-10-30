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
                               <div class="col-sm-6">
                                   <label>Lokasi Origin</label>
                                   <input type="text" class="form-control" id="location_origin_name" placeholder="Lokasi">
                               </div>
                               <div class="col-sm-6">
                                   <label>Lokasi Destinasi</label>
                                   <input type="text" class="form-control" id="location_destination_name" placeholder="Lokasi">
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
                                 <th>Origin</th>
                                 <th>Destination</th>
                                 <th>Total Berat</th>
                                 <th>Harga/Kg</th>
                                 <th>Total Harga</th>
                                 <th>Tanggal Order</th>
                                 <th>Aksi</th>
                             </tr>
                         </thead>
                       </table>
                   </div>
               </div>
           </div>
       </div>
   </div>
</section>
<script type="template" id="alert-gagal">
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
    <div class="message">

    </div>
</div>
</script>

<script type="template" id="alert-sukses">
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
    Set No Polisi Berhasil
</div>
</script>
<div class="modal fade" id="modal_nopol">
  <div class="modal-dialog">
    <div class="modal-content">
        <form id="form_set_order" method="POST" action="<?php echo base_url() ?>order_transportasi/setNopol">
            <input type="hidden" class="form-control" name="order_no" id="order_id">
            <div class="modal-body">
                <div class="box-body">
                    <div id="for_notif">

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">No Polisi</label>
                                <select class="form-control" name="data_traller[]" id="data_traller" multiple="true">

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default alert-cancel" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-sm btn-danger alert-ok">Ok</button>
            </div>
        </form>
    </div>
  </div>
</div>
<script
 data-main="<?php echo base_url()?>assets/js/main/main-order_transportasi"
 src="<?php echo base_url()?>assets/js/require.js">
</script>
