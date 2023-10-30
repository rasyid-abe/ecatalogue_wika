<section class="content-header">
	<h1>
	<!-- <?php
	echo '<pre>';
	print_r( $page );
	echo '</pre>';
	?> -->
		<?php echo ucwords($page)?>
		<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><?php echo ucwords($page) ?></li>
	</ol>
</section>

<section class="content">
	<?php
		$is_can_search = 1;
		if($is_can_search){
	?>
	<div class="box box-bottom">
		<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-tag"></i>Pencarian <?php echo ucwords($page) ?></h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
				<div class="form-group row">
					<div class="col-sm-12">
						<label>Jenis Vendor</label>
						<select class="form-control" id="vendor_type_id" name="vendor_type_id">
								<option value="">Semua</option>
								<option value="1">Margis</option>
								<option value="2">Non Margis</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12 text-right">
						<a class="btn btn-sm btn-primary" id="search">Search</a>
						<a class="btn btn-sm btn-danger" id="reset">Reset</a>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		}
	?>
	<div class="box box-default color-palette-box">
		<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords($page) ?></h3>
		<?php
			if($is_can_create){
		?>
				<!-- <div class="col-md-2 datatableButton pull-right">
					<div class="row">
						<a href="<?php echo base_url()?>vendors/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> <?php echo ucwords($page) ?></a>
					</div>
				</div> -->
		<?php 
		}
		?>
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
								<th>#</th>
								 <th>Category Code</th>
								 <th>Asset Category</th>
								 <th>Qty</th>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
 <script data-main="<?php echo base_url()?>assets/js/main/main-asset_peralatan" src="<?php echo base_url()?>assets/js/require.js"></script>
