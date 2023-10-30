<div class="container">
	<div class="row">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo base_url() ?>home">Home</a></li>
				<li class="breadcrumb-item"><a href="landing.html"><?= $detail->category_name ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?= $detail->full_name ?></li>
			</ol>
		</nav>
	</div>

	<div class="full-width">
		<div class="row">
			<div class="col-md-5">
				<div id="demo" class="carousel slide" data-ride="carousel" data-interval="false">
					<!-- The slideshow -->
					<div class="carousel-inner bordered">
						<?php
						if ($product_gallery) {
							foreach ($product_gallery as $key => $value) {
								$active = "";
								if ($key == 0) {
									$active = "active";
								} ?>
								<div class="carousel-item <?php echo $active ?>">
									<img src="<?php echo base_url('product_gallery/') . $value->filename ?>">
								</div>
							<?php }
						} else { ?>
							<div class="carousel-item active">
								<img src="<?php echo base_url() ?>assets/images/noimage.png">
							</div>
						<?php }
						?>
					</div>
					<!-- Indicators -->
					<ul class="carousel-indicators">
						<?php
						if ($product_gallery) {
							foreach ($product_gallery as $key => $value) {
								$active = "";
								if ($key == 0) {
									$active = "active";
								} ?>
								<li data-target="#demo" data-slide-to="<?php echo $key ?>" class="<?php echo $active ?>"><img src="<?php echo base_url('product_gallery/') . $value->filename ?>"></li>
							<?php }
						} else { ?>
							<li data-target="#demo" data-slide-to="0" class="active"> <img src="<?php echo base_url() ?>assets/images/noimage.png"></li>

						<?php } ?>
					</ul>

				</div>
			</div>
			<div class="col-md-7">
				<div class="box-white bg-detail pad-15 mbot-30">
					<div class="row">
						<div class="col-md-12">
							<p class="font-18 font-grey m-none"><?= $detail->code ?></p>
							<p class="bolder font-22 m-none"><?= $detail->full_name ?></p>
							<span class="tag in-block"><?= $detail->category_name ?></span>
							<p class="font-12 mbot-5 in-block"><span class="font-grey">Rating</span>
								<label>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
								</label>
							</p>
							<div class="row">
								<div class="col-12">
									<label class="font-grey font-12 mbot-0">Vendor</label>
									<p class="mbot-5"><?= $detail->vendor_name ?> <a href="<?= base_url() ?>Chat/find_room/<?= $detail->vendor_id ?>" class="btn btn-info btn-xs pull-right"><i class="fa fa-comment"></i> Chat</a></p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<p class="font-18 uppercase mtop-15 mbot-0 bolder">detail information</p>
						</div>
						<div class="col-md-6">
							<label class="font-grey font-12 mbot-0">Contract</label>
							<p class="mbot-5">
								<?= $contract ?>
							</p>
						</div>
						<div class="col-md-6">
							<label class="font-grey font-12 mbot-0">Update</label>
							<p class="mbot-5"><?php if ($detail->update_at) {
													echo date("j F Y", strtotime($detail->update_at));
												} ?></p>
							<?php
							if (!empty($volumes)) {
							?>
								<label class="font-grey font-12 mbot-0">Contract & Volume Availability</label>
							<?php
							}

							foreach ($volumes as $volume) {
							?>
								<br>
								<span><?= $volume['no_contract'] ?></span>
								<br>
								<span class="font-grey font-12 mbot-0">Volume : </span><span><?= rupiah($volume['volume']) ?></span>
								<br>
							<?php
							}
							if (!empty($volumes)) {
							?>
							<?php
							}
							?>
							<!-- <p class="mbot-5"><?= $detail->volume ?></p> -->
							<label class="font-grey font-12 mbot-0">Berat /Unit</label>
							<p class="mbot-5"><?= $detail->berat_unit . " " . $detail->uom_name ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<p class="font-18 uppercase mtop-15 mbot-0 bolder">Notes</p>
							<p>
								<?= $detail->note ?>
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12">
				<h4 class="uppercase mbot-30">produk berdasarkan metode pembayaran</h4>
				<?php
				if ($product_payment) {
					foreach ($product_payment as $key => $value) {
						$locationIds = str_replace(',', '_', $value->location_id);
						$locationDropdown = [];
						foreach (explode(',', $value->location_id) as $valueLoc) {
							if (isset($locationArr[$valueLoc])) {
								$locationDropdown[$valueLoc] = $locationArr[$valueLoc];
							}
						}
				?>
						<div class="box-white full mbot-15">
							<div class="thumb-info-lg">
								<p class="font-18 font-black m-0 bolder"><?= $value->full_name ?></p>
								<div class="row">
									<div class="col-12">
										<label class="font-grey font-12 mbot-0">Metode Pembayaran</label>
										<p class="font-16 bolder text-blue mbot-5"><?= $value->payment_method_full ?></p>
										<?php
										if ($value->notes_payment != '') {
										?>
											<label class="font-grey font-12 mbot-0">Catatan Pembayaran</label>
											<p class="font-14 mbot-5">
												<?= $value->notes_payment ?>
											</p>
										<?php
										}
										?>
										<label class="font-grey font-12 mbot-10">Lokasi</label>
										<div style="width : 200px">
											<select class="form-control location-dropdown" data-form-id="form-cart<?= $value->id ?>_<?= $value->payment_method_id . '_' . $locationIds ?>">
												<option value="" disabled selected>Pilih Lokasi</option>
												<?php
												foreach ($locationDropdown as $id => $name) {
												?>
													<option value="<?= $id ?>" data-location-name="<?= $name ?>"><?= $name ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="thumb-buy-lg">
								<form method="post" id="form-cart<?= $value->id ?>_<?= $value->payment_method_id . '_' . $locationIds ?>">
									<span class="font-blue font-18">Rp <?= number_format($value->product_price, '0', ',', '.') ?></span>
									<span class="font-18">/ <?= $value->uom_name ?></span>
									<br>
									<?php
									$total_include = 0;
									$estimasi = ($value->product_price * $value->default_weight);
									?>
									<div class="form-group">
										<label class="font-13 font-grey" for="location">Quantity</label>
										<input type="text" class="form-control number" id="quantity<?= $value->id ?>" name="quantity" min="1" value="1">
										<input type="hidden" class="form-control" id="product_id<?= $value->id ?>" name="product_id" value="<?= $value->id ?>">
										<input type="hidden" class="form-control" id="product_contract<?= $value->id ?>" name="product_contract" value="<?= $can_order === FALSE ? '0' : '1' ?>">
										<input type="hidden" class="form-control" id="product_detail<?= $value->id ?>" name="product_detail" value='<?= json_encode($value) ?>'>
										<input type="hidden" class="location_idnya" name="location_id" value="">
										<input type="hidden" class="location_namenya" name="location_name" value="">
									</div>
									<button class="btn btn-blue btn-shadow full-width uppercase btn-similar" type="button" data-id="<?= $value->id ?>_<?= $value->payment_method_id . '_' . $locationIds ?>" >Add to cart</button>
									estimasi : <?= rupiah($estimasi) ?>
								</form>
							</div>
						</div>
				<?php
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="modal fade" id="alert_belanja_lagi">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header alert-msg">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-default alert-reject" data-dismiss="modal">Lanjutkan Belanja</button>
					<a href="<?= base_url() ?>mycart"><button type="button" class="btn btn-sm btn-danger alert-approve">Ke Keranjang</button></a>
				</div>
			</div>
		</div>
	</div>
</div>
<script data-main="<?php echo base_url() ?>assets/js/main/main-detailproduct" src="<?php echo base_url() ?>assets/js/require.js"></script>