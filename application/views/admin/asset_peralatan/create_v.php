<section class="content">
	<div class="full-width padding">
		<div class="box box-default color-palette-box">
			<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-tag"></i> Tambah Asset</h3>
			</div>
				<form class="form-horizontal" id="form" method="POST" action="" enctype="multipart/form-data">
					<div class="box-body">
						<h4>Primary Information</h4>
						<?php if(!empty($this->session->flashdata('message_error'))){?>
						<div class="alert alert-danger">
						<?php
							print_r($this->session->flashdata('message_error'));
						?>
						</div>
						<?php }?>
						<?php echo validation_errors() ?>
						<div class="form-group row">
							<label for="asset_type" class="col-sm-3 control-label">Asset Type</label>
							<div class="col-sm-9">
								<select id="asset_type" name="asset_type" class="form-control" data-selectjs="true" required>
									<option value=""> -- Asset Type -- </option>
									<?php
									// $asset_type = ['0' => 'Non Aktif', '1' => 'Aktif'];
									// foreach ( $asset_stat as $key => $stat ) {
									// 	echo '
									// 	<option value="' . $key . '">' . $stat . '</option>';
									// }
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="asset_category" class="col-sm-3 control-label">Asset Category</label>
							<div class="col-sm-9">
								<select id="asset_category" name="asset_category" class="form-control" data-selectjs="true" required>
									<option value=""> -- Asset Category -- </option>
									<?php
									// $asset_type = ['0' => 'Non Aktif', '1' => 'Aktif'];
									// foreach ( $asset_stat as $key => $stat ) {
									// 	echo '
									// 	<option value="' . $key . '">' . $stat . '</option>';
									// }
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="asset_sub_category" class="col-sm-3 control-label">Asset Sub Category</label>
							<div class="col-sm-9">
								<select id="asset_sub_category" name="asset_sub_category" class="form-control" data-selectjs="true" required>
									<option value=""> -- Asset Sub Category -- </option>
									<?php
									// $asset_type = ['0' => 'Non Aktif', '1' => 'Aktif'];
									// foreach ( $asset_stat as $key => $stat ) {
									// 	echo '
									// 	<option value="' . $key . '">' . $stat . '</option>';
									// }
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="order_number" class="col-sm-3 control-label">Order Number</label>
							<div class="col-sm-9">
								<input type="text" name="order_number" id="order_number" class="form-control" placeholder="Order Number">
							</div>
						</div>
						<div class="form-group row">
							<label for="location" class="col-sm-3 control-label">Location</label>
							<div class="col-sm-9">
								<input type="text" name="location" id="location" class="form-control" placeholder="Location">
							</div>
						</div>
						<div class="form-group row">
							<label for="divisi" class="col-sm-3 control-label">Divisi</label>
							<div class="col-sm-9">
								<input type="text" name="divisi" id="divisi" class="form-control" placeholder="Divisi">
							</div>
						</div>
						<div class="form-group row">
							<label for="asset_status" class="col-sm-3 control-label">Asset Status</label>
							<div class="col-sm-9">
								<select id="asset_status" name="asset_status" class="form-control" data-selectjs="true" required>
									<?php
									$asset_stat = ['0' => 'Non Aktif', '1' => 'Aktif'];
									foreach ( $asset_stat as $key => $stat ) {
										echo '
										<option value="' . $key . '">' . $stat . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="operation_status" class="col-sm-3 control-label">Operation Status</label>
							<div class="col-sm-9">
								<select id="operation_status" name="operation_status" class="form-control" data-selectjs="true" required>
									<?php
									$asset_stat = ['0' => 'Non Aktif', '1' => 'Aktif'];
									foreach ( $asset_stat as $key => $stat ) {
										echo '
										<option value="' . $key . '">' . $stat . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="functionality_status" class="col-sm-3 control-label">Functionality Status</label>
							<div class="col-sm-9">
								<select id="functionality_status" name="functionality_status" class="form-control" data-selectjs="true" required>
									<?php
									$asset_stat = ['0' => 'Non Aktif', '1' => 'Aktif'];
									foreach ( $asset_stat as $key => $stat ) {
										echo '
										<option value="' . $key . '">' . $stat . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="criticality" class="col-sm-3 control-label">Criticality</label>
							<div class="col-sm-9">
								<select id="criticality" name="criticality" class="form-control" data-selectjs="true" required>
								<?php
								$criticality = ['0' => 'Low', '1' => 'Medium', '2' => 'High'];
								foreach ( $criticality as $key => $critical ) {
									echo '
									<option value="' . $key . '">' . $critical . '</option>';
								}
								?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="notes_technician" class="col-sm-3 control-label">Notes To Technician</label>
							<div class="col-sm-9">
								<textarea id="notes_technician" name="notes_technician" class="form-control"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="waranty" class="col-sm-3 control-label">Warranty/Contract Notes</label>
							<div class="col-sm-9">
								<textarea id="waranty" name="waranty" class="form-control"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="asset_notes" class="col-sm-3 control-label">Asset Notes</label>
							<div class="col-sm-9">
								<textarea id="asset_notes" name="asset_notes" class="form-control"></textarea>
							</div>
						</div>
						<h4>Product Additional Information</h4>
						<div class="form-group row">
							<label for="manufacturer" class="col-sm-3 control-label">Manufacturer</label>
							<div class="col-sm-9">
								<input type="text" name="manufacturer" id="manufacturer" class="form-control" placeholder="Manufacturer" >
							</div>
						</div>
						<div class="form-group row">
							<label for="model_number" class="col-sm-3 control-label">Model Number</label>
							<div class="col-sm-9">
								<input type="text" name="model_number" id="model_number" class="form-control" placeholder="Model Number" >
							</div>
						</div>
						<div class="form-group row">
							<label for="serial_number" class="col-sm-3 control-label">Serial Number</label>
							<div class="col-sm-9">
								<input type="text" name="serial_number" id="serial_number" class="form-control" placeholder="Serial Number" >
							</div>
						</div>
						<div class="form-group row">
							<label for="engine_number" class="col-sm-3 control-label">Engine Number</label>
							<div class="col-sm-9">
								<input type="text" name="engine_number" id="engine_number" class="form-control" placeholder="Engine Number" >
							</div>
						</div>
						<div class="form-group row">
							<label for="capacity" class="col-sm-3 control-label">Capacity (Ton)</label>
							<div class="col-sm-9">
								<input type="text" name="capacity" id="capacity" class="form-control" placeholder="Capacity" >
							</div>
						</div>
						<div class="form-group row">
							<label for="weight" class="col-sm-3 control-label">Weight (Ton)</label>
							<div class="col-sm-9">
								<input type="text" name="weight" id="weight" class="form-control" placeholder="Weight" >
							</div>
						</div>
						<div class="form-group row">
							<label for="length" class="col-sm-3 control-label">Length</label>
							<div class="col-sm-9">
								<input type="text" name="length" id="length" class="form-control" placeholder="Length" >
							</div>
						</div>
						<div class="form-group row">
							<label for="diameter" class="col-sm-3 control-label">Diameter</label>
							<div class="col-sm-9">
								<input type="text" name="diameter" id="diameter" class="form-control" placeholder="Diameter" >
							</div>
						</div>
						<div class="form-group row">
							<label for="year_assambly" class="col-sm-3 control-label">Year Of Assambly</label>
							<div class="col-sm-9">
								<input type="text" name="year_assambly" id="year_assambly" class="form-control" placeholder="Year Of Assambly" >
							</div>
						</div>
						<div class="form-group row">
							<label for="supplier" class="col-sm-3 control-label">Supplier</label>
							<div class="col-sm-9">
								<input type="text" name="supplier" id="supplier" class="form-control" placeholder="Supplier" >
							</div>
						</div>
						<div class="form-group row">
							<label for="purchase_price" class="col-sm-3 control-label">Purchase Price</label>
							<div class="col-sm-9">
								<input type="text" name="purchase_price" id="purchase_price" class="form-control" placeholder="Purchase Price" >
							</div>
						</div>
						<div class="form-group row">
							<label for="rent_price" class="col-sm-3 control-label">Rent Price</label>
							<div class="col-sm-9">
								<input type="text" name="rent_price" id="rent_price" class="form-control" placeholder="Rent Price" >
							</div>
						</div>
						<div class="form-group row">
							<label for="price_replace_loss" class="col-sm-3 control-label">Price Replace Loss</label>
							<div class="col-sm-9">
								<input type="text" name="price_replace_loss" id="price_replace_loss" class="form-control" placeholder="Price Replace Loss" >
							</div>
						</div>
						<div class="form-group row">
							<label for="quantity" class="col-sm-3 control-label">Quantity</label>
							<div class="col-sm-9">
								<input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity" >
							</div>
						</div>
						<div class="form-group row">
							<label for="date_delivered" class="col-sm-3 control-label">Date Delivered</label>
							<div class="col-sm-9">
								<input type="date" name="date_delivered" id="date_delivered" class="form-control" placeholder="Date Delivered" >
							</div>
						</div>
						<div class="form-group row">
							<label for="date_acquired" class="col-sm-3 control-label">Date Acquired</label>
							<div class="col-sm-9">
								<input type="date" name="date_acquired" id="date_acquired" class="form-control" placeholder="Date Acquired" >
							</div>
						</div>
						<div class="form-group row">
							<label for="astimated_life" class="col-sm-3 control-label">Estimated Life</label>
							<div class="col-sm-9">
								<input type="text" name="astimated_life" id="astimated_life" class="form-control" placeholder="Estimated Life" >
							</div>
						</div>
						<div class="form-group row">
							<label for="current_value" class="col-sm-3 control-label">Current Value</label>
							<div class="col-sm-9">
								<input type="text" name="current_value" id="current_value" class="form-control" placeholder="Current Value" >
							</div>
						</div>
						<div class="form-group row">
							<label for="date_disposed" class="col-sm-3 control-label">Date Disposed</label>
							<div class="col-sm-9">
								<input type="date" name="date_disposed" id="date_disposed" class="form-control" placeholder="Date Disposed" >
							</div>
						</div>
						<div class="form-group row">
							<label for="stnk_date" class="col-sm-3 control-label">STNK Date</label>
							<div class="col-sm-9">
								<input type="date" name="stnk_date" id="stnk_date" class="form-control" placeholder="STNK Date" >
							</div>
						</div>
						<div class="form-group row">
							<label for="insurance_no" class="col-sm-3 control-label">Insurance No</label>
							<div class="col-sm-9">
								<input type="text" name="insurance_no" id="insurance_no" class="form-control" placeholder="Insurance No" >
							</div>
						</div>
						<div class="form-group row">
							<label for="insurance_value" class="col-sm-3 control-label">Insurance Value</label>
							<div class="col-sm-9">
								<input type="text" name="insurance_value" id="insurance_value" class="form-control" placeholder="Insurance Value" >
							</div>
						</div>
						<div class="form-group row">
							<label for="insurance_expiry_date" class="col-sm-3 control-label">Insurance Expiry Date</label>
							<div class="col-sm-9">
								<input type="date" name="insurance_expiry_date" id="insurance_expiry_date" class="form-control" placeholder="Insurance Expiry Date" >
							</div>
						</div>
						<div class="form-group row">
							<label for="sia_no" class="col-sm-3 control-label">SIA No</label>
							<div class="col-sm-9">
								<input type="text" name="sia_no" id="sia_no" class="form-control" placeholder="SIA No" >
							</div>
						</div>
						<div class="form-group row">
							<label for="sia_tgl_terbit" class="col-sm-3 control-label">SIA Tanggal Terbit</label>
							<div class="col-sm-9">
								<input type="date" name="sia_tgl_terbit" id="sia_tgl_terbit" class="form-control" placeholder="SIA Tanggal Terbit" >
							</div>
						</div>
						<div class="form-group row">
							<label for="sia_tgl_uji_pemeriksaan" class="col-sm-3 control-label">SIA Tanggal Uji Pemeriksaan</label>
							<div class="col-sm-9">
								<input type="date" name="sia_tgl_uji_pemeriksaan" id="sia_tgl_uji_pemeriksaan" class="form-control" placeholder="SIA Tanggal Uji Pemeriksaan" >
							</div>
						</div>
						<div class="form-group row">
							<label for="sia_expiry_date" class="col-sm-3 control-label">SIA Expiry Date</label>
							<div class="col-sm-9">
								<input type="date" name="sia_expiry_date" id="sia_expiry_date" class="form-control" placeholder="SIA Expiry Date" >
							</div>
						</div>
						<div class="form-group row">
							<label for="sio_no" class="col-sm-3 control-label">SIO No</label>
							<div class="col-sm-9">
								<input type="text" name="sio_no" id="sio_no" class="form-control" placeholder="SIO No" >
							</div>
						</div>
						<div class="form-group row">
							<label for="sio_expiry_date" class="col-sm-3 control-label">SIO Expiry Date</label>
							<div class="col-sm-9">
								<input type="date" name="sio_expiry_date" id="sio_expiry_date" class="form-control" placeholder="SIO Expiry Date" >
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
								<button type="submit" class="btn btn-primary">Simpan</button>
								<a href="<?php echo base_url( 'asset_peralatan' );?>" class="btn btn-primary btn-danger">Batal</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	<div>
</section>

<script data-main="<?php echo base_url()?>assets/js/main/main-project" src="<?php echo base_url()?>assets/js/require.js"></script>
