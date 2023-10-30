<section class="content">
	<div class="full-width padding">
		<div class="box box-default color-palette-box">
			<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-tag"></i> Transfer Asset / Peralatan by Sub Category</h3>
			</div>
				<form class="form-horizontal" id="form" method="POST" action="" enctype="multipart/form-data">
					<div class="box-body">
						<?php if(!empty($this->session->flashdata('message_error'))){?>
						<div class="alert alert-danger">
						<?php
							print_r($this->session->flashdata('message_error'));
						?>
						</div>
						<?php }?>
						<?php echo validation_errors() ?>
						<div class="form-group row">
							<label for="category" class="col-sm-3 control-label">Category</label>
							<div class="col-sm-9">
								<select id="category" name="category" class="form-control" data-selectjs="true" required>
									<option value=""> -- Category -- </option>
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
							<label for="sub_category" class="col-sm-3 control-label">Sub Category</label>
							<div class="col-sm-9">
								<select id="sub_category" name="sub_category" class="form-control" data-selectjs="true" required>
									<option value=""> -- Sub Category -- </option>
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
							<label for="qty_stock" class="col-sm-3 control-label">Quantity Stock</label>
							<div class="col-sm-9">
								<input type="text" name="qty_stock" id="qty_stock" class="form-control" placeholder="Quantity Stock">
							</div>
						</div>
						<div class="form-group row">
							<label for="qty" class="col-sm-3 control-label">Quantity</label>
							<div class="col-sm-9">
								<input type="text" name="qty" id="qty" class="form-control" placeholder="Quantity">
							</div>
						</div>
						<h4>Transfer Asset To ...</h4>
						<div class="form-group row">
							<label for="asset_status" class="col-sm-3 control-label">New Site</label>
							<div class="col-sm-9">
								<select id="asset_status" name="asset_status" class="form-control" data-selectjs="true" required>
								<option value=""> -- Site -- </option>
									<?php
									$site = ['0' => 'Non Aktif', '1' => 'Aktif'];
									foreach ( $asset_stat as $key => $stat ) {
										echo '
										<option value="' . $key . '">' . $stat . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="delivery_date" class="col-sm-3 control-label">Delivery Date</label>
							<div class="col-sm-9">
								<input type="date" name="delivery_date" id="delivery_date" class="form-control" placeholder="Delivery Date" >
							</div>
						</div>
						<div class="form-group row">
							<label for="remarks" class="col-sm-3 control-label">Remarks</label>
							<div class="col-sm-9">
								<textarea id="remarks" name="remarks" class="form-control"></textarea>
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
