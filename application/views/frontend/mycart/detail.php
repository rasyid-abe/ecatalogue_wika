<form id="form-pay">
	<div class="container">
		<div class="row">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url() ?>home">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">My Cart</li>
				</ol>
			</nav>
		</div>
		<div class="row">
			<div class="col-md-9">
				<div class="box-white pad-15 full mbot-30">
					<p class="mbot-5 font-18">My Cart</p>
					<div class="table-responsive">
						<table class="table table-cart">
							<thead class="font-14">
								<tr>
									<th class="text-center">Barang</th>
									<th class="text-center">Metode Pembayaran</th>
									<th width="220px;" class="text-center">Jumlah/ Berat</th>
									<th width="100px;" class="text-center">Harga/ unit(Rp)</th>
									<th width="100px;" class="text-center">Keterangan</th>
									<th class="text-center">Sub Total(Rp)</th>
									<th colspan="2"></th>
								</tr>
							</thead>
							<tbody class="font-13">
								<?php
								$total_price = 0;
								if ($cart) {
									$vendorId_locationId = NULL;
									foreach ($cart as $key => $value) {
										$total_price += (int) $value['product_total_price'];
										//echo (int) ($value['product_weight'] * $value['product_price'] * $value['quantity']);
										// buat itung include_price
										$include_price = 0;
										// json_include untuk menyimpan detail include_price nama
										$json_include = array();
										if ($value['includes']) {
											foreach ($value['includes'] as $v) {
												$include_price += $v->price;
												$json_include[] = array(
													'description' 	=> $v->description,
													'price'			=> $v->price,
												);
											}
										}
										// $total_price += ($include_price * $value['quantity']);
										// end itung include_price
										//$total_price += $value['include_price'];
								?>
										<tr style="border-top: 3px solid black;" class="<?= $value['id_session'] ?>">
											<td colspan="6">
												<p style="margin:3px" class="font-13"><?= $value['product_name'] . ' - ' . $value['location_name'] ?></p>
											</td>
											<td>
												<button class="btn btn-danger btn-sm btn-shadow deleteitem" id="deleteitem<?= $key ?>" data-session="<?= $value['id_session'] ?>" data-for-order="<?= $value['for_order'] ?>" data-delete-rab="<?= $key ?>" type="button"><i class="fa fa-trash"></i></button>
											</td>
										</tr>
										<tr class="tr-product <?= $value['id_session'] ?>">
											<td>
												<div class="thumb-cart">
													<?php
													if (file_exists("product_gallery/" . $value['image'])) {
														$scr = base_url() . "product_gallery/" . $value['image'];
													} else {
														$scr = base_url() . "assets/images/frontend/dummy.png";
													}
													?>

													<img src="<?php echo $scr ?>">
												</div>
											</td>
											<td>
												<?= $value['payment_method_full'] ?>
												<input type="hidden" name="noOrder[]" value="<?= $value['order_no'] ?>">
												<input type="hidden" name="noSurat[]" value="<?= $value['no_surat'] ?>">
												<input type="hidden" name="isRev[]" value="<?= $value['is_rev'] ?>">
											</td>
											<td>
												<div class="input-group mb-3 btn-shadow">
													<div class="input-group-prepend">
														<button class="btn btn-blue btn-sm btn-number" data-type="minus" data-field="quantity" type="button" data-all-price="<?= $all_price = $value['product_price'] * $value['product_weight'] ?>" data-price="<?= $value['product_price'] ?>" data-include-price="<?= $include_price ?>" data-id-session="<?= $value['id_session'] ?>"><i class="fa fa-minus"></i></button>
													</div>
													<input type="text" name="quantity[]" maxlength="6" max="999999" class="form-control form-control-sm text-center qty_<?= $value['for_order'] ?> input-number bg-white quantity" autocomplete="off" value="<?= $value['quantity'] ?>" min="1" max="99999" aria-label="" aria-describedby="basic-addon1" id="quantity<?= $key ?>" data-all-price="<?= $value['product_price'] * $value['product_weight'] ?>" data-price="<?= $value['product_price'] ?>" data-include-price="<?= $include_price ?>" data-berat="<?= $value['product_weight'] ?>" data-id-session="<?= $value['id_session'] ?>" data-key="<?= $value['for_order'] ?>">
													<div class="input-group-append">
														<button class="btn btn-blue btn-sm btn-number" data-type="plus" data-all-price="<?= $value['product_price'] * $value['product_weight'] ?>" data-price="<?= $value['product_price'] ?>" data-include-price="<?= $include_price ?>" data-field="quantity" data-id-session="<?= $value['id_session'] ?>" type="button"><i class="fa fa-plus"></i></button>
													</div>
												</div>
												<input type="hidden" name="arr_product_id[]" value="<?= $value['product_id'] ?>">
												<input type="hidden" name="arr_product_contract[]" value="<?= $value['product_contract'] ?>">
												<input type="hidden" name="arr_uom_id[]" value="<?= $value['product_uom_id'] ?>">
												<input type="hidden" class="price_<?= $value['for_order'] ?>" name="arr_price[]" id="price_<?= $key ?>" value="<?= $value['product_price'] ?>">
												<input type="hidden" class="weight_<?= $value['for_order'] ?>" name="arr_weight[]" id="weight_<?= $key ?>" value="<?= $value['product_weight'] ?>">
												<input type="hidden" name="arr_payment_method_id[]" value="<?= $value['payment_method_id'] ?>">
												<input type="hidden" name="arr_include_price[]" value="<?= $value['include_price'] ?>">
												<input type="hidden" name="full_name_product[]" value="<?= $value['full_product_name'] ?>">
												<input type="hidden" name="payment_method_full[]" value="<?= $value['payment_method_full'] ?>">
												<input type="hidden" name="uom_name[]" value="<?= $value['product_uom_name'] ?>">
												<input type="hidden" class="product-vendor_id" name="vendor_id[]" value="<?= $value['vendor_id'] ?>">
												<input type="hidden" name="vendor_name[]" value="<?= $value['vendor_name'] ?>">
												<input type="hidden" name="json_include[]" value='<?= json_encode($json_include) ?>'>
												<input type="hidden" name="include_price[]" value="<?= $include_price ?>">
												<input type="hidden" class="product-location_id" name="location_id[]" value="<?= $value['location_id'] ?>">
												<input type="hidden" name="location_name[]" value="<?= $value['location_name'] ?>">
												<input type="hidden" name="is_matgis[]" value="<?= $value['is_matgis'] ?>">
												<input type="hidden" name="category_id[]" value="<?= $value['category_id'] ?>">
												<div class="text-center"><span id="berat_quantity<?= $key ?>"><?= rupiah($value['product_weight'] * $value['quantity'], 3) ?></span> <?= $value['product_uom_name'] ?></div>
											</td>
											<td class="text-right">
												<p><?= number_format($value['product_price'], '0', ',', '.') ?></p>
												<p id="hrgRab<?= $key ?>"></p>
												<p id="selisih<?= $key ?>"></p>
												<p id="tglUpdated<?= $key ?>"></p>
												<p id="tglRab<?= $key ?>"></p>
												<input type="hidden" name="product_price<?= $key ?>" id="product_price<?= $key ?>" value="<?= $value['product_price'] ?>">
												<input type="hidden" class="pengadaan_pmcs<?= $key ?>" name="periode_pengadaan_pmcs[]" value="">
												<input type="hidden" class="price_pmcs<?= $key ?>" name="price_pmcs[]" value="">
											</td>
											<td class="text-left">
												<p>Harga</p>
												<p id="kethrgRab<?= $key ?>"></p>
												<p id="ketselisih<?= $key ?>"></p>
												<p id="kettglUpdated<?= $key ?>"></p>
												<p id="kettglRab<?= $key ?>"></p>
											</td>
											<td class="text-right">
												<span id="sub_quantity<?= $key ?>"><?= rupiah((int)($value['product_weight'] * $value['product_price'] * $value['quantity'])) ?></span>
											</td>
											<td colspan="2"></td>
										</tr>
										<?php
										if (isset($cart[$key + 1])) {
											if ($value['for_order'] != $cart[$key + 1]['for_order']) {
										?>
												<tr id="for_transportasi_<?= $value['for_order'] ?>">
													<td colspan="2">
														<div class="custom-control custom-checkbox mbot-10">
															<input type="checkbox" class="custom-control-input is_use_transport" name="is_use_transport[]" value="1" id="is_use_transport_<?= $value['for_order'] ?>">
															<label class="custom-control-label" for="is_use_transport_<?= $value['for_order'] ?>">Menggunakan Transportasi</label>
														</div>
													</td>
													<td>
														<div class="for-select-transportasi hidden">
															<select class="form-control mbot-0 vendor-transportasi" name="transportasi_id[<?php echo $value['vendor_id'] ?>][<?php echo $value['location_id'] ?>][<?php echo $value['category_id'] ?>]" id="transportasi_<?= $value['for_order'] ?>" data-selectjs="true" data-vendor-location="<?= $value['for_order'] ?>" data-location-id="<?= $value['location_id'] ?>" data-vendor-id="<?= $value['vendor_id'] ?>">
																<option value="" selected data-harga="0">Pilih Vendor</option>

															</select>
															<select class="form-control mbot-10 sda-transportasi" name="sda_transportasi[<?php echo $value['vendor_id'] ?>][<?php echo $value['location_id'] ?>][<?php echo $value['category_id'] ?>]" id="sda_transportasi_<?= $value['for_order'] ?>" data-selectjs="false" data-sda-location="<?= $value['for_order'] ?>" data-location-id="<?= $value['location_id'] ?>" data-vendor-id="<?= $value['vendor_id'] ?>">
																<option value="" selected>Pilih Transportasi</option>
															</select>
															<select class="form-control mbot-10 harga-transportasi" name="harga_transportasi[<?php echo $value['vendor_id'] ?>][<?php echo $value['location_id'] ?>][<?php echo $value['category_id'] ?>]" id="harga_transportasi_<?= $value['for_order'] ?>" data-selectjs="true" data-sda-location="<?= $value['for_order'] ?>" data-location-id="<?= $value['location_id'] ?>" data-vendor-id="<?= $value['vendor_id'] ?>">
																<option value="" selected>Pilih Harga</option>
															</select>
														</div>
													</td>
													<td id="harga_satuan_tranport_<?= $value['for_order'] ?>" class="text-right"></td>
													<td class="text-right"></td>
													<td id="sub_total_tranport_<?= $value['for_order'] ?>" class="text-right"></td>
													<td colspan="2"><input type="hidden" name="keterangan_satuan_tranport[<?php echo $value['vendor_id'] ?>][<?php echo $value['location_id'] ?>][<?php echo $value['category_id'] ?>]s" id="keterangan_satuan_tranport_<?= $value['for_order'] ?>"></td>

												</tr>
											<?php
											}
										} else {
											?>
											<tr id="for_transportasi_<?= $value['for_order'] ?>">
												<td colspan="2">
													<div class="custom-control custom-checkbox mbot-10">
														<input type="checkbox" class="custom-control-input is_use_transport" name="is_use_transport[]" value="1" id="is_use_transport_<?= $value['for_order'] ?>">
														<label class="custom-control-label" for="is_use_transport_<?= $value['for_order'] ?>">Menggunakan Transportasi</label>
													</div>
												</td>
												<td>
													<div class="for-select-transportasi hidden">
														<select class="form-control mbot-0 vendor-transportasi" name="transportasi_id[<?php echo $value['vendor_id'] ?>][<?php echo $value['location_id'] ?>][<?php echo $value['category_id'] ?>]" id="transportasi_<?= $value['for_order'] ?>" data-selectjs="true" data-vendor-location="<?= $value['for_order'] ?>" data-location-id="<?= $value['location_id'] ?>" data-vendor-id="<?= $value['vendor_id'] ?>">
															<option value="" selected data-harga="0">Pilih Vendor</option>

														</select>
														<select class="form-control mbot-10 sda-transportasi" name="sda_transportasi[<?php echo $value['vendor_id'] ?>][<?php echo $value['location_id'] ?>][<?php echo $value['category_id'] ?>]" id="sda_transportasi_<?= $value['for_order'] ?>" data-selectjs="false" data-sda-location="<?= $value['for_order'] ?>" data-location-id="<?= $value['location_id'] ?>" data-vendor-id="<?= $value['vendor_id'] ?>">
															<option value="" selected>Pilih Transportasi</option>
														</select>
														<select class="form-control mbot-10 harga-transportasi" name="harga_transportasi[<?php echo $value['vendor_id'] ?>][<?php echo $value['location_id'] ?>][<?php echo $value['category_id'] ?>]" id="harga_transportasi_<?= $value['for_order'] ?>" data-selectjs="true" data-sda-location="<?= $value['for_order'] ?>" data-location-id="<?= $value['location_id'] ?>" data-vendor-id="<?= $value['vendor_id'] ?>">
															<option value="" selected>Pilih Harga</option>
														</select>
													</div>
												</td>
												<td id="harga_satuan_tranport_<?= $value['for_order'] ?>" class="text-right"></td>
												<td class="text-right"></td>
												<td id="sub_total_tranport_<?= $value['for_order'] ?>" class="text-right"></td>
												<td colspan="2"><input type="hidden" name="keterangan_satuan_tranport[<?php echo $value['vendor_id'] ?>][<?php echo $value['location_id'] ?>][<?php echo $value['category_id'] ?>]" id="keterangan_satuan_tranport_<?= $value['for_order'] ?>"></td>

											</tr>
										<?php
										}
										?>
										<tr id="smcb_data_<?= $key ?>">
											<td colspan="6">
												<p class="font-14 font-grey mbot-10">Sumber Daya RAB</p>
												<select class="form-control mbot-10 smcb_data" name="smcb_data[]" data-selectjs="true" data-changeRab="<?= $key ?>">
													<option value="">Pilih Sumber Daya RAB</option>
												</select>
											</td>
										</tr>
									<?php } ?>
								<?php } else { ?>
									<tr>
										<td colspan="7" class="text-center">Keranjang Kosong</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<button class="btn btn-danger btn-shadow full-width" id="empty_cart" type="button">Empty Cart</button>
						<p class="text-red">(*) Pesanan besi diinput dengan satuan batang</p>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="box-white pad-15 mbot-30">
					<p class="uppercase font-18 bolder">total</p>
					<p class="font-14 font-grey mbot-0">Total Harga</p>
					<span class="font-18 font-blue">Rp.</span><span class="font-18 font-blue" id="total_price"><?= number_format($total_price, '0', ',', '.') ?></span>
					<p class="font-14 font-grey mbot-0">Perihal</p>
					<textarea class="form-control mbot-15" id="perihal" name="perihal"><?= $val_perihal ?></textarea>

					<p class="font-14 font-grey mbot-0">Catatan</p>
					<textarea class="form-control mbot-15" id="catatan" name="catatan"><?= $val_catatan ?></textarea>

					<p class="font-14 font-grey mbot-0">Jenis Pengiriman</p>
					<select class="form-control mbot-30" name="shipping_id" id="shipping_id" data-selectjs="true">
						<option value="" disabled selected>Pilih Jenis Pengiriman</option>
						<?php foreach ($shipping as $key => $value) { ?>
							<option value="<?= $value->id ?>" <?= $value->id == $val_shipping_id ? 'selected' : '' ?>><?= $value->name ?></option>
						<?php } ?>
					</select>

					<p class="font-14 font-grey mbot-0">Project</p>
					<select class="form-control mbot-10" name="project_id" id="project_id" data-selectjs="true">
						<option value="" disabled selected>Pilih Project</option>
						<?php
						if ($project) {
							$is_one = count($project) == 1 ? TRUE : FALSE;
							foreach ($project as $key => $value) {
						?>
								<option value="<?= $value->id ?>" data-destination_location_id="<?= $value->location_id ?>" <?= $value->id == $val_project_id ? 'selected' : '' ?>><?= $value->name ?></option>
						<?php
							}
						}
						?>
					</select>

					<p class="font-14 font-grey mbot-0">Lokasi Destinasi</p>
					<select class="form-control mbot-30" name="destination_location_id" id="destination_location_id" data-selectjs="true">
						<?php if ($val_is_rev > 0) { ?>
							<option value="<?= $val_location_id ?>" selected><?= $val_location_name ?></option>
						<?php } else { ?>
							<option value="" disabled selected>Pilih Lokasi Destinasi</option>
						<?php } ?>
						<?php
						echo array_to_options($location);
						?>
					</select>

					<p class="font-14 font-grey mbot-0">Kapan Diambil</p>
					<div class="" data-datepicker="true">
						<input type="text" name="tgl_diambil" id="tgl_diambil" class="form-control mbot-10" autocomplete="off" value="<?= $val_tgl_diambil ?>">
					</div>
					<div class="custom-control custom-checkbox mbot-10">
						<input type="checkbox" class="custom-control-input" id="is_use_asuransi" name="is_use_asuransi" value="1" <?= $val_asuransi_id != '' ? 'checked' : '' ?>>
						<label class="custom-control-label" for="is_use_asuransi">Asuransi</label>
					</div>
					<div class="mbot-10 <?= $val_asuransi_id != '' ? '' : 'hidden' ?>" id="vendor_asuransi">
						<p class="font-14 font-grey mbot-0">Vendor Asuransi</p>
						<select class="form-control mbot-0" name="asuransi_id" id="asuransi_id" data-selectjs="true">
							<option value="" selected data-nilai_asuransi="0">Pilih Asuransi</option>
							<?php
							if ($asuransi) {
								foreach ($asuransi as $key => $value) {
							?>
									<option value="<?= $value->id ?>" data-nilai_asuransi="<?= $value->nilai_asuransi ?>" data-jenis_asuransi="<?= $value->jenis_asuransi ?>" <?= $val_asuransi_id == $value->id ? 'selected' : '' ?>><?= $value->vendor_name . ' (' . $value->no_contract . ')' ?></option>
							<?php
								}
							}
							?>
						</select>
					</div>

					<?php if ($departemencode == 'WG') { ?>
						<p class="font-14 font-grey mbot-0">No Surat</p>
						<input type="text" name="nosuratmanual" id="nosuratmanual" class="form-control mbot-10" autocomplete="off">
					<?php } ?>

					<button class="btn btn-blue btn-shadow full-width" type="submit">PAY</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script data-main="<?php echo base_url() ?>assets/js/main/main-cart" src="<?php echo base_url() ?>assets/js/require.js"></script>