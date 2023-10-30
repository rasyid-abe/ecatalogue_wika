 <section class="content-header">
  <h1>
    <?php echo ucwords($page)?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?php echo ucwords($page) ?></li>
  </ol>
</section>

<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page) ?></h3>
        <?php if($is_can_create){?>
            <div class="col-md-2 datatableButton pull-right">
              <div class="row">
                <a href="<?php echo base_url()?>payment_method/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> <?php echo ucwords($page)?></a>
              </div>
            </div>
        <?php } ?>
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
            <div class="alert alert-info">
            <?php
               print_r($this->session->flashdata('message_error'));
            ?>
            </div>
            <?php }?>
            <table class="table table-striped" id="table">
              <thead>
                <th width ="3%">No Urut</th>
                 <th>Nama Metode Pembayaran</th>
                 <th>Deskripsi</th>
                <th>Action</th>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 <script data-main="<?php echo base_url()?>assets/js/main/main-payment_method" src="<?php echo base_url()?>assets/js/require.js"></script>
