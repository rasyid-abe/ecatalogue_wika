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
<div class="row hidden" id="chart-forecast">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <h4 class="title pull-left">Forecast</h4>
                <div class="pull-right" style="width: 250px">
                    <select class="form-control" id="year_filter" name="year_filter" data-selectjs="true">
                        <option value="" disabled selected>Pilih Tahun</option>
                        <?php
                            foreach ($year as $key => $value) {
                                $select ="";
                                    if($value == $year_now){
                                        $select ="selected";
                                    }
                                ?>
                                <option value="<?php echo $value?>" <?php echo $select?>><?php echo $value?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="pull-right" style="width: 250px;margin-right:10px">
                    <select class="form-control" id="bulan_filter" name="bulan_filter" data-selectjs="true">
                        <option value="" disabled selected>Pilih Bulan</option>
                        <?php
                        $month_now = date('m');
                        for($i = 1; $i <= 12; $i++)
                        {
                            $select ="";
                            if($i == $month_now)
                            {
                                $select ="selected";
                            }
                            ?>
                            <option value="<?php echo $i?>" <?php echo $select?>><?php echo bulan($i)?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="box-body">
                <div id="salesMonth" style="height:400px"></div>
            </div>
        </div>
    </div>
</div>

<section class="content">
 <div class="box box-default color-palette-box">
   <div class="box-header with-border">
       <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
       <?php
       if ($is_can_create)
       {
           ?>
           <a href="<?= base_url()?>forecast/create" class="btn btn-sm btn-primary pull-right" id = "btn-export"><i class='fa fa-plus'></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></a>
           <?php
       }
        ?>
   </div>
   <div class="box-body">
     <div class="row">
       <div class="col-md-12">
           <div class="table-responsive">
            <?php if(!empty($_GET['status'])){
              if($_GET['status']=='true'){?>
                <div class="alert alert-info">
                  <?php echo $_GET['message']?>
                </div><?php
              }else{?>
                <div class="alert alert-danger">
                  <?php echo $_GET['message']?>
                </div><?php } ?>
            <?php }?>
            <?php if(!empty($this->session->flashdata('message'))){?>
            <div class="alert alert-info">
            <?php
               print_r($this->session->flashdata('message'));
            ?>
            </div>
            <?php }?>
             <?php if(!empty($this->session->flashdata('message_error'))){?>
            <div class="alert alert-info">
            <?php
               print_r($this->session->flashdata('message_error'));
            ?>
            </div>
            <?php }?>
           <table class="table table-striped" id="table">
             <thead>
                <th>No Urut</th>
                <th>Kategori</th>
                <th>Tanggal Forecast</th>
                <th>Bulan Mulai</th>
                <th>Tahun</th>
                <th>Periode</th>
                <th>Detail</th>
             </thead>
           </table>
         </div>
       </div>
     </div>
   </div>
 </div>
</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-forecast" src="<?php echo base_url()?>assets/js/require.js"></script>
