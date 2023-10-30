<style>
	div.gallery {
		box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.19), 0 2px 2px 0 rgba(0, 0, 0, 0.19);
		margin-left: 6px;
		float: left;
		width: 24.1%;
		background-color: #efefef;
		border: 2px solid rgba(0, 0, 0, 0);
	}

	div.gallery:hover {
		border: 2px solid lightgray;
	}

	div.gallery img {
		position: relative;
		display: table;
		margin: auto;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		height: 150px;
	}

	div.desc {
		background-color: white;
		width: auto;
		height: 200px;
		color: #04adf0;
		padding: 5px;
		text-align: left;
	}

	#inner {
		display: table;
		margin: 0 auto;
	}

	#outer {
		padding-top: 5px;
		width: 100%
	}
</style>
<div class="col-12 banner">
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<div class="padside-30">
					<p class="font-30 font-white mtop-30 mbot-0 single">E-Katalog Wika ESCM</p>
					<p class="font-14 font-white">E-katalog harga margis yang dikelola ESCM</p>
				</div>
			</div>
			<div class="col-md-7">
				<div class="banner-img">
					<img src="<?= base_url()?>assets/images/frontend/img-banner.png">
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container mbot-30">
	<div class="row">
		<div class="col-md-4 col-lg-3">
			<button type="button" class="btn btn-blue btn-shadow full-width mbot-15" id="btn-sort">Sort & Filter</button>
			<div class="box-white wrap mbot-30 animate slideIn" id="filter">
				<div class="full-width pad-15 borbot">
					<p class="mbot-0 bolder">Urutkan</p>
					<p class="font-grey font-13">Urutkan Produk Berdasarkan</p>
					<form>
						<div class="custom-control custom-checkbox mbot-10">
							<input type="checkbox" class="custom-control-input" id="highprice" name="highprice" value="1" <?php echo $order_check == 'desc' ? 'checked' : '' ?>>
							<label class="custom-control-label" for="highprice">Harga Tertinggi</label>
						</div>
						<div class="custom-control custom-checkbox mbot-10">
							<input type="checkbox" class="custom-control-input" id="lowprice" name="lowprice" value="2" <?php echo $order_check == 'asc' ? 'checked' : '' ?>>
							<label class="custom-control-label" for="lowprice">Harga Terendah</label>
						</div>
						<div class="custom-control custom-checkbox mbot-10">
							<input type="checkbox" class="custom-control-input" id="terkontrak" name="terkontrak" value="1" <?php echo $terkontrak ? 'checked' : '' ?>>
							<label class="custom-control-label" for="terkontrak">Terkontrak</label>
						</div>
						<div class="custom-control custom-checkbox mbot-10">
							<input type="checkbox" class="custom-control-input" id="tidak_terkontrak" name="tidak_terkontrak" value="1" <?php echo $tidak_terkontrak ? 'checked' : '' ?>>
							<label class="custom-control-label" for="tidak_terkontrak">Tidak Terkontrak</label>
						</div>
						<div class="custom-control custom-checkbox mbot-10">
							<input type="checkbox" class="custom-control-input" id="rating" name="rating" value="3">
							<label class="custom-control-label" for="rating">Rating</label>
						</div>
						<div class="custom-control custom-checkbox mbot-10">
							<input type="checkbox" class="custom-control-input" id="popularity" name="popularity" value="4">
							<label class="custom-control-label" for="popularity">Popularitas Tertinggi</label>
						</div>
					</form>
				</div>
				<div class="full-width pad-15">
					<p class="mbot-0"><span class="bolder">Filter</span> <a href="javascript:;" class="font-13 pull-right font-blue" id="btn-reset-filter">Reset</a></p>
					<p class="font-grey font-13">Tampilkan Produk Berdasarkan Kategori</p>
					<!-- <p class="mbot-5 bolder">Rating</p>
					<form class="mbot-15">
						<div class="custom-control custom-checkbox mbot-10">
						    <input type="checkbox" class="custom-control-input" id="5rate" name="5rate" value="1">
						    <label class="custom-control-label" for="5rate">
						    	<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
							</label>
						</div>
						<div class="custom-control custom-checkbox mbot-10">
						    <input type="checkbox" class="custom-control-input" id="4rate" name="4rate" value="1">
						    <label class="custom-control-label" for="4rate">
						    	<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
							</label>
						</div>
						<div class="custom-control custom-checkbox mbot-10">
						    <input type="checkbox" class="custom-control-input" id="3rate" name="3rate" value="1">
						    <label class="custom-control-label" for="3rate">
						    	<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
							</label>
						</div>
						<div class="custom-control custom-checkbox mbot-10">
						    <input type="checkbox" class="custom-control-input" id="2rate" name="2rate" value="1">
						    <label class="custom-control-label" for="2rate">
						    	<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
							</label>
						</div>
						<div class="custom-control custom-checkbox mbot-10">
						    <input type="checkbox" class="custom-control-input" id="1rate" name="1rate" value="1">
						    <label class="custom-control-label" for="1rate">
						    	<span class="fa fa-star checked"></span>
							</label>
						</div>
					</form> -->
					<!-- <p class="mbot-0 bolder filter mtop-15 <?php echo !empty($vendor_ar) ? '' : 'collapsed' ?>" data-toggle="collapse" href="#collapsevendor" role="button" aria-expanded="<?php echo !empty($vendor_ar) ? 'true' : 'false' ?>" aria-controls="collapsevendor">Vendor</p>
					<div class="collapse <?php echo !empty($vendor_ar) ? 'show' : '' ?>" id="collapsevendor">
						<form>
							<?php foreach ($vendor as $key => $value) { ?>
								<div class="custom-control custom-checkbox mbot-10">
								    <input type="checkbox" class="custom-control-input" id="vendor<?= $value->id ?>" name="vendor[]" value="<?= $value->id ?>" <?php if (in_array($value->id, $vendor_ar)) echo 'checked' ?>>
								    <label class="custom-control-label" for="vendor<?= $value->id ?>"><?= $value->name ?></label>
								</div>
							<?php } ?>
						</form>
					</div> -->
					<p class="mbot-0 bolder filter mtop-15 <?php echo !empty($location_ar) ? '' : 'collapsed' ?>" data-toggle="collapse" href="#collapselocation" role="button" aria-expanded="<?php echo !empty($location_ar) ? 'true' : 'false' ?>" aria-controls="collapselocation">Location</p>
					<div class="collapse <?php echo !empty($location_ar) ? 'show' : '' ?>" id="collapselocation">
						<form>
							<div class="form-group">
								<select class="form-control" name="location[]" data-selectjs="true" multiple="true" id="arr_location">
									<?php
									if ($location) {
										foreach ($location as $k => $v) {
											$sel = "";
											if (in_array($v->id, $location_ar)) {
												$sel = "selected";
											}
									?>
											<option value="<?= $v->id ?>" <?= $sel ?>><?= $v->name ?></option>
									<?php
										}
									}
									?>
								</select>
							</div>
							<?php
							/*
							 foreach ($location as $key => $value) {?>
								<div class="custom-control custom-checkbox mbot-10 hidden">
								    <input type="checkbox" class="custom-control-input" id="location<?=$value->id?>" name="location[]" value="<?=$value->id?>" <?php if(in_array($value->id, $location_ar)) echo 'checked'?>>
								    <label class="custom-control-label" for="location<?=$value->id?>"><?=$value->name?></label>
								</div>
							<?php }
							*/
							?>
						</form>
					</div>
					<button class="btn btn-blue btn-shadow pull-right uppercase mtop-15" id="btn-filter">Filter</button>
				</div>
			</div>
			<!--			<div class="box-white wrap mbot-30 animate
slideIn">
				<div class="full-width pad-15 borbot">
					<p class="mbot-0 bolder">Mandor</p>
					<p class="font-grey font-13">Daftar Mandor</p>
					<?php
					//var_dump($mandor);
					if ($mandor) {
						foreach ($mandor as $v) {
					?>
							<div class="custom-control custom-checkbox mbot-10">
								<?= $v->first_name ?>
							</div>
							<?php
						}
					}
							?>
				</div>
			</div> -->
		</div>
		<div class="col-md-8 col-lg-9">
			<div class="box-white box-category">
				<a href="javascript:;" class="btn btn-cat active pull-left change-cat" value="all"><img src="<?= base_url() ?>assets/images/frontend/icon-1.png"> All</a>
				<?php
				if ($category) {
					$i = 1;
					foreach ($category as $k => $v) {
						$icon_category = file_exists("image_upload/category/" . $v->icon) ? "image_upload/category/" . $v->icon : "assets/images/frontend/icon-1.png";
						if ($i == 4) {
				?>
							<div class="dropdown pull-right">
								<button class="btn btn-blue dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-th-list"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
								<?php
							}
							if (in_array($i, [1, 2, 3])) {
								?>
									<a title="<?php echo $v->name ?>" href="javascript:;" class="btn btn-cat pull-left change-cat" value="<?php echo $v->id ?>"><img src="<?= base_url() . $icon_category ?>"> <?php echo $v->name ?></a>
								<?php
							} else {
								?>
									<a title="<?php echo $v->name ?>" class="dropdown-item change-cat" href="javascript:;" value="<?php echo $v->id ?>"><img src="<?= base_url() . $icon_category ?>"> <?php echo $v->name ?></a>
								<?php
							}
							$i++;
						}
						if ($i > 4) {
								?>
								</div>
							</div>
					<?php
						}
					}
					?>
			</div>
			<div class="row">
				<div class="col-md-12 mbot-15">
					<input type="text" class="form-control form-shadow form-search pull-left" name="" id="search-product" placeholder="Search">
					<button class="btn btn-blue btn-shadow pull-right uppercase" id="btn-search-product">Search</button>
				</div>
			</div>
			<div class="full-width" id="forScroll">
				<?php
				if ($product) {
					foreach ($product as $key => $value) {
				?>
						<div class="gallery mbot-5">
							<a href="<?php echo base_url() ?>detailproduct/<?= $value->id ?>">
								<!-- <p><?= base_url() . "product_gallery/" . $value->filename; ?></p> -->
								<?php
								if (empty($value->filename)) {
									$image = "assets/images/noimage.png";
								} else {
									$image = "product_gallery/" . $value->filename;
									// if (file_exists(base_url() . "product_gallery/" . $value->filename) == true) {
									// } else {
									// 	$image = "assets/images/noimage.png";
									// }
								}
								?>
								<div class="imgfix">
									<img src="<?php echo base_url() . $image ?>">
								</div>
								<!-- <img src="img_5terre.jpg" alt="Cinque Terre" width="600" height="400"> -->
							</a>
							<div class="desc">
								<a href="<?php echo base_url() ?>detailproduct/<?= $value->id ?>">
									<label class="font-blue font-12 mbot-0" style="display: block;"><strong><?= $value->name ?></strong></label>
								</a>
								<p class="font-12 mbot-5">
									<?php
									if (isset($location_payment_method_by_product_id[$value->id])) {
										$loc = $location_payment_method_by_product_id[$value->id];
										$tampung = [];
										foreach ($loc as $v) {
											if (!in_array($v, $tampung)) {
												$tampung[] = $v;
											} else {
												continue;
											}
									?>
											<span class="badge badge-primary"><?= $v ?></span>
									<?php
										}
									}
									?>
								</p>
								<label class="font-grey font-12 mbot-0">Vendor</label>
								<p class="font-12 mbot-0"><?= $value->vendor_name ?></p>
								<span class="font-black font-14">
									<strong>Rp <?= number_format($value->product_min_price, '0', ',', '.') ?></strong>
									<span class="font-14">/ <?= $value->uom_name ?></span>
								</span>
								<p class="font-12">
									<?php
									if (in_array($value->id, $arr_terkontrak)) {
									?>
										<span class="badge badge-success">Terkontrak</span>
									<?php
									} else {
									?>
										<span class="badge badge-danger">Tidak Terkontrak</span>
									<?php
									}
									?>
								</p>
							</div>
						</div>
				<?php }
				}
				?>
			</div>

			<div id="outer">
				<?php echo $this->pagination->create_links(); ?>
			</div>
			<!-- <button class="btn btn-success form-control" id="btn-load-more">Tampilkan Lebih Banyak</button> -->
		</div>
	</div>
</div>
<input type="hidden" id="pageForScroll" value="1">
<input type="hidden" id="filterForScroll" value="all">
<!--
<script src="<?php echo base_url() ?>html/assets/js/jquery.js"></script>
		<script src="<?php echo base_url() ?>html/assets/js/popper.min.js"></script>
		<script src="<?php echo base_url() ?>html/assets/bootstrap/js/bootstrap.min.js"></script> -->
<script data-main="<?php echo base_url() ?>assets/js/main/main-home" src="<?php echo base_url() ?>assets/js/require.js"></script>
