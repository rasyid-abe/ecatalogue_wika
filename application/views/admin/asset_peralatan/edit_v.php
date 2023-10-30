<?php
//var_dump($user_pemantau_list);
?>
<section class="content">
	<div class="full-width padding">
	<div class="padding-top">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
						<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-tag"></i> Berkas Kategori</h3>
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
								<input type="hidden" name="id" value="<?php echo $id;?>">
								<div class="form-group row">
								 <label for="inputEmail3" class="col-sm-3 control-label">Nama</label>
								 <div class="col-sm-9">
									 <input type="name" class="form-control" id="name" placeholder="Nama" name="name" value="<?= $name ?>">
								 </div>
							 </div>
							 <div class="form-group row">
								<label for="inputEmail3" class="col-sm-3 control-label">No Surat</label>
								<div class="col-sm-9">
									<input type="name" class="form-control" id="no_surat" placeholder="No Surat" name="no_surat" value="<?= $no_surat ?>">
								</div>
							</div>
							<div class="form-group row">
							 <label for="inputEmail3" class="col-sm-3 control-label">Tanggal</label>
							 <div class="col-sm-9">
									 <div class="" data-datepicker="true">
										 <input class="form-control" type="text" id="tgl" name="tgl" autocomplete="off" value="<?= $tanggal ?>">
									 </div>
							 </div>
						 </div>
						 <div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 control-label">Deskripsi</label>
							<div class="col-sm-9">
								<textarea class="form-control" id="deskripsi" name="deskripsi"><?= $description ?></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword3" class="col-sm-3 control-label">Departemen</label>
							<div class="col-sm-9">
								 <select id="departemen" name="departemen[]" class="form-control" data-selectjs="true" multiple="multiple">
									<option value="" disabled>Pilih Departemen</option>
									<?php
									foreach ($groups as $group) { ?>
										<option value="<?php echo $group->id;?>" <?php echo in_array($group->id, $group_id) ? 'selected' : ''?>><?php echo $group->name;?></option>
									<?php }
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword3" class="col-sm-3 control-label">List Pengguna</label>
							<div class="col-sm-9">
									<select class="form-control" id="users" name="users[]" data-selectjs="true" multiple="multiple">
											<option value="" disabled>Pilih User</option>
											<?php
											foreach($user_id as $v)
											{
													$sel = in_array($v->id, $user_ids) ? 'selected' : '';
													?>
													<option value="<?= $v->id ?>" <?= $sel ?> data-group-id=<?= $v->group_id ?>><?= $v->first_name ?></option>
													<?php
											}
											?>
									</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-3 control-label">Vendor</label>
							<div class="col-sm-9">
									<select class="form-control" id="vendor_id" name="vendor_id" data-selectjs="true">
											<option value="">Pilih Vendor</option>
											<?php
											foreach ($vendor as $key => $value) {
													$select="";
													if($value->id == $vendor_id){
															$select="selected";
													}
													?>
													<option value="<?php echo $value->id?>" <?php echo $select?>><?php echo $value->name?></option>
											<?php } ?>
									</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-3 control-label">Product</label>
							<div class="col-sm-9">
									<select class="form-control" id="product_id" name="product_id[]" data-selectjs="true" multiple="true">
											<option value="" disabled>Pilih Product</option>
											<?php
											if($products)
											{
													foreach($products as $product)
													{
															$sel = '';
															if(in_array($product->id, $arr_products))
															$sel = "selected";
															?>
															<option value="<?= $product->id ?>" <?= $sel ?>><?= $product->full_name ?></option>
															<?php
													}
											}
											?>
									</select>
							</div>
						</div>
						<div class="form-group">
								<label for="inputPassword3" class="col-sm-3 control-label">Nomor Kontrak</label>
								<div class="col-sm-9">
										<input class="form-control" type="text" id="no_contract" name="no_contract" autocomplete="off" value="<?= $no_contract ?>">
								</div>
						 </div>
						<div class="form-group">
						 <label for="inputPassword3" class="col-sm-3 control-label">Berkas Kontrak</label>
								 <div class="col-sm-9">
										 <input class="form-control" type="file" value="" id="file_contract" name="file_contract">
								 </div>
						 </div>
						 <div class="form-group">
								 <label for="inputPassword3" class="col-sm-3 control-label">Awal Kontrak</label>
								 <div class="col-sm-9">
										 <div class="" data-datepicker="true">
											 <input class="form-control" type="text" id="start_contract" name="start_contract" autocomplete="off" value="<?= $start_contract ?>">
										 </div>
								 </div>
							</div>
							<div class="form-group">
									<label for="inputPassword3" class="col-sm-3 control-label">Akhir Kontrak</label>
									<div class="col-sm-9">
											<div class="" data-datepicker="true">
												<input class="form-control" type="text" id="end_contract" name="end_contract" autocomplete="off" value="<?= $end_contract ?>">
											</div>
									</div>
							 </div>
							 <div class="form-group row">
								 <label for="inputPassword3" class="col-sm-3 control-label">Departemen Pemantau</label>
								 <div class="col-sm-9">
										<select id="departemen_pemantau" name="departemen_pemantau" class="form-control" data-selectjs="true" required>
										 <option value="" disabled selected>Pilih Departemen</option>
										 <?php
										 foreach ($groups as $group) {
												 $sel = '';
												 if($group->id == $departemen_pemantau_id)
												 {
														 $sel = 'selected';
												 }
												 ?>
											 <option value="<?php echo $group->id;?>" <?= $sel ?>><?php echo $group->name;?></option>
										 <?php }
										 ?>
									 </select>
								 </div>
							 </div>
							 <div class="form-group row">
								 <label for="inputPassword3" class="col-sm-3 control-label">User Pemantau</label>
								 <div class="col-sm-9">
										 <select class="form-control" id="user_pemantau" name="user_pemantau" data-selectjs="true">
												 <option value="" disabled>Pilih User</option>
												 <?php
												 foreach($user_pemantau_list as $v)
												 {
														 $sel = '';
														 if($v->id == $user_pemantau_id)
														 {
																 $sel = 'selected';
														 }
														 ?>
													 <option value="<?php echo $v->id;?>" <?= $sel ?>><?php echo $v->first_name;?></option>
												 <?php
												 }
													?>
										 </select>
								 </div>
							 </div>
							 <div class="form-group">
									 <label for="inputPassword3" class="col-sm-3 control-label">Volume</label>
									 <div class="col-sm-9">
										 <input class="form-control number" type="text" id="volume" name="volume" autocomplete="off" value="<?= $volume ?>">
									 </div>
								</div>
								<div class="form-group">
										<label for="inputPassword3" class="col-sm-3 control-label">Harga</label>
										<div class="col-sm-9">
												<input class="form-control" type="text" id="harga" name="harga" autocomplete="off" onkeyup="App.format(this)" value="<?= rupiah($harga) ?>">
										</div>
								 </div>
						<div class="box-footer pad-15 full-width bg-softgrey border-top bot-rounded">
							<button type="submit" class="btn btn-primary pull-right mleft-15" id="save-btn">Simpan</button>
							<a href="<?php echo base_url();?><?= $cont ?>" class="btn btn-default pull-right">Batal</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</section>

 <script data-main="<?php echo base_url()?>assets/js/main/main-project" src="<?php echo base_url()?>assets/js/require.js"></script>
