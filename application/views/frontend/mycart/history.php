
<div class="container">
	<div class="row">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo base_url()?>home">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">History</li>
			</ol>
		</nav>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box-white pad-15 full mbot-30">
				<p class="mbot-15 font-18">Pencarian Order</p>
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
							<select class="form-control" name="is_matgis" id="departemen_id" data-selectjs="true">
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
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box-white pad-15 full mbot-30">
				<p class="mbot-15 font-18">Riwayat Pemesanan
					<a href="javascript:;" id="btn-export-to-excel">
						<button class="btn btn-sm btn-success pull-right" type="button"><i class="fa fa-file-excel-o"></i> Export to Excel</button></p>
					</a>
					<div class="table-responsive">
						<table class="table table-striped display" id="table">
							<thead>
								<th>Order No</th>
								<th style="width: 15%" class="text-center">Nomor Surat</th>
								<th style="width: 15%">Nama Vendor</th>
								<th style="width: 15%">Nama Proyek</th>
								<th style="width: 15%">Harga</th>
								<th>Tanggal Order</th>
								<th>Status</th>
								<th>Aksi</th>
							</thead>
						</table>
					</div>
					<div class="col-md-12 mtop-15">
						<button class="btn btn-blue btn-shadow full-width" type="button" id="btn-back">Kembali</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<script data-main="<?php echo base_url()?>assets/js/main/main-orderhistory" src="<?php echo base_url()?>assets/js/require.js"></script>
