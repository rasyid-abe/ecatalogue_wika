<section class="content-header">
 <h1>
   Dashboard
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active">Dashboard</li>
 </ol>
</section>


<!-- Main content -->
<section class="content">
   <div class="row">
       <div class="col-lg-4 col-xs-4">
         <!-- small box -->
         <div class="small-box bg-purple">
           <div class="inner">
             <h3><?= $feedback_vendor ?></h3>

             <p>Feedback dari User</p>
           </div>
           <div class="icon">
             <i class="fa fa-comments"></i>
           </div>
         </div>
       </div>
       <div class="col-lg-4 col-xs-4">
         <!-- small box -->
         <div class="small-box bg-red">
           <div class="inner">
             <h3><?= rupiah($dana) ?></h3>

             <p>Jumlah Uang Terserap</p>
           </div>
           <div class="icon">
             <i class="fa fa-bar-chart"></i>
           </div>
         </div>
       </div>
       <div class="col-lg-4 col-xs-4">
         <!-- small box -->
         <div class="small-box bg-aqua">
           <div class="inner">
             <h3><?= rupiah($jml_order) ?></h3>

             <p>Total Order</p>
           </div>
           <div class="icon">
             <i class="fa fa-shopping-cart"></i>
           </div>
         </div>
       </div>
   </div>
   <div class="row">
       <section class="col-lg-12 connectedSortable">
         <!-- Custom tabs (Charts with tabs)-->
         <div class="nav-tabs-custom">
           <!-- Tabs within a box -->
           <ul class="nav nav-tabs pull-right">

             <li class="pull-left header"></i>Penyerapan Uang Vendor</li>
             <div class="pull-right" style="width : 100px; padding : 10px">
                 <select class="form-control" name="" onchange="App.penyerapan_vendor_chart($(this).val())">
                     <option value="" disabled>Pilih Tahun</option>
                     <?php
                     $tahun = date('Y');
                     foreach (range($tahun - 2,$tahun) as $v)
                     {
                         $sel = "";
                         if($tahun == $v)
                         {
                             $sel = "selected";
                         }
                         ?>
                         <option value="<?= $v ?>" <?= $sel?>><?= $v ?></option>
                         <?php
                     }

                     ?>
                 </select>
             </div>
           </ul>
           <div class="tab-content no-padding">
             <!-- Morris chart - Sales -->
             <div id="penyerapan-vendor-chart" style="min-width: 310px; height: 300px; max-width: 100%; margin: 0 auto"></div>
           </div>
         </div>
         <!-- /.nav-tabs-custom -->
         <!-- /.box -->

       </section>
       <section class="col-lg-12 connectedSortable">
         <!-- Custom tabs (Charts with tabs)-->
         <div class="nav-tabs-custom">
           <!-- Tabs within a box -->
           <ul class="nav nav-tabs pull-right">

             <li class="pull-left header"></i>Penyerapan Volume</li>
             <div class="pull-right" style="width : 100px; padding : 10px">
                 <select class="form-control" name="" onchange="App.penyerapan_volume_vendor_chart($(this).val())">
                     <option value="" disabled>Pilih Tahun</option>
                     <?php
                     $tahun = date('Y');
                     foreach (range($tahun - 2,$tahun) as $v)
                     {
                         $sel = "";
                         if($tahun == $v)
                         {
                             $sel = "selected";
                         }
                         ?>
                         <option value="<?= $v ?>" <?= $sel?>><?= $v ?></option>
                         <?php
                     }

                     ?>
                 </select>
             </div>
           </ul>
           <div class="tab-content no-padding">
             <!-- Morris chart - Sales -->
             <div id="penyerapan-volume-vendor-chart" style="min-width: 310px; height: 300px; max-width: 100%; margin: 0 auto"></div>
           </div>
         </div>
         <!-- /.nav-tabs-custom -->
         <!-- /.box -->

       </section>
   </div>
   <div class="row">
       <div class="col-md-6">
           <div class="box box-info box-solid">
           <div class="box-header with-border">
             <h3 class="box-title"><i class="fa fa-bell"></i> Aktifitas Terakhir</h3>


             <!-- /.box-tools -->
           </div>
           <!-- /.box-header -->
           <div class="box-body">
               <table class="table table-striped">
                 <tbody>
                 <?php
                 foreach ($activity_vendor as $k => $v)
                 {
                     ?>
                     <tr>
                         <td width="10%" align="center"><span class="label label-default"><i class="fa fa-book"></i></span></td>
                         <td><?= $v->description ?></td>
                         <td align="right">
                             <footer><cite title="2 Hours"><?= get_timeago($v->created_at) ?></cite></footer>
                         </td>
                     </tr>
                     <?php
                 }
                 ?>
                </tbody>
               </table>
           </div>
           <!-- /.box-body -->
         </div>
       </div>
       <div class="col-md-6">
           <div class="box box-success box-solid">
           <div class="box-header with-border">
             <h3 class="box-title"><i class="fa fa-check"></i> Notifikasi</h3>


             <!-- /.box-tools -->
           </div>
           <!-- /.box-header -->
           <div class="box-body">
               <table class="table table-striped">
                 <tbody>
                 <?php
                 foreach ($notif_vendor as $k => $v)
                 {
                     ?>
                     <tr>
                         <td width="10%" align="center"><span class="label label-default"><i class="fa fa-bell"></i></span></td>
                         <td><?= $v->deskripsi ?></td>
                         <td align="right">
                             <footer><cite title="<?= tgl_indo($v->created_at, TRUE) ?>"><?= get_timeago($v->created_at) ?></cite></footer>
                         </td>
                     </tr>
                     <?php
                 }
                  ?>
               </tbody>
               </table>
           </div>
           <!-- /.box-body -->
         </div>
       </div>
   </div>


</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-dashboard_user" src="<?php echo base_url()?>assets/js/require.js"></script>
