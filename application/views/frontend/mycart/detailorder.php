<form id="form-pay">
	<div class="container">
		<div class="row">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url() ?>home">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">History</li>
				</ol>
			</nav>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="box-white pad-15 full mbot-30">
					<p class="mbot-5 font-18">Detail Pesanan No. <?= $detail_order->order_no .' '. $rev_time ?>
						<?php if ($detail_order->pdf_name && is_file("pdf/po/" . $detail_order->pdf_name)) { ?>
							<a target='_blank' href='<?php echo base_url() . "pdf/po/" . $detail_order->pdf_name; ?>' class='btn btn-sm btn-success pull-right'><i class='fa fa-file-pdf-o'></i> Lihat Pdf</a></p>
				<?php } ?>

				<table border="0" width="100%">
					<tr>
						<td colspan="4" style="font-size:20px; padding-bottom:20px" class="text-center"><b>PO Vendor</b></td>
					</tr>
					<tr>
						<td width="20%">No Surat</td>
						<td width="30%" class="bolder">: <?= $detail_order->no_surat ?></td>
						<td width="20%">Nama Vendor</td>
						<td width="30%" class="bolder">: <?= $detail_order->vendor_name ?></td>
					</tr>
					<tr>
						<td width="20%">Nama Proyek</td>
						<td width="30%" class="bolder">: <?= $detail_order->project_name ?></td>
						<td width="20%">Nama Departemen</td>
						<td width="30%" class="bolder">: <?= $detail_order->dept_name ?></td>
					</tr>
					<tr>
						<td width="20%">Perihal</td>
						<td width="30%" class="bolder">: <?= $detail_order->perihal ?></td>
						<td width="20%">Jenis Pengiriman</td>
						<td width="30%" class="bolder">: <?= $detail_order->shipping_name ?></td>
					</tr>
					<tr>
						<td width="20%">Jenis PO</td>
						<td width="30%" class="bolder">: <?= $detail_order->is_matgis == 0 ? 'Non Matgis' : 'Matgis' ?></td>
						<td width="20%">Nama Pembuat</td>
						<td width="30%" class="bolder">: <?= $detail_order->created_name ?></td>
					</tr>
					<?php
					if ($list_approval_name) {
						$index = 0;
						foreach ($list_approval_name as $key => $value) {
							$index++;
					?>
							<tr>
								<td width="20%">Approval <?php echo $index ?></td>
								<td width="30%" class="bolder">:
									<?php
									if (isset($value['approve_acc'])) {
										$text = '';
										if ($value['status_approve'] == 1) {
											$text = "(Approved)";
										} else if ($value['status_approve'] == 2) {
											$text = "(Rejected)";
										}

										echo $value['user_approve_name'] . $text;
									} else {
										echo implode(" / ", $value['approve_name']);
									}
									?>
								</td>
								<td width="20%"></td>
								<td width="30%" class="bolder"></td>
							</tr>
					<?php }
					}
					?>
				</table>
				<div class="table-responsive">
					<table class="table table-striped table-bordered nowrap" id="table_detail">
						<thead>
							<th width="40px;">No</th>
							<th width="160px;" class="text-center">Nama Barang</th>
							<th class="text-center">Metode Pembayaran</th>
							<th class="text-center">Quantity</th>
							<th class="text-center">Unit</th>
							<th class="text-center">Harga/unit</th>
							<th class="text-center">Total Harga</th>
						</thead>
						<tbody>
							<?php
							if ($order_product) {
								$total = 0;
								$total_weight = 0;
								$biayaTransport = 0;
								$grandTotal = 0;
								foreach ($order_product as $key => $value) {
									$total_weight += $value->qty * $value->weight;
									$biayaTransport += (int) ($value->weight * $value->qty * $value->biaya_transport);
									$price = $value->price * $value->qty * $value->weight;
									$total += $price;
									//$total += $value->include_price;
									$biaya_tambahan = 0;
									$include = json_decode($value->json_include_price);
									$include_text = " - ";
									if ($include) {
										//var_dump($include);
										$include_text = "";
										foreach ($include as $v) {
											$include_text .= $v->description . " Rp. " . rupiah($v->price) . "<br>";
											$biaya_tambahan += $v->price;
										}
									}
									// $total += ($biaya_tambahan * $value->qty);
							?>
									<tr>
										<td class="text-center"><?= $key + 1 ?></td>
										<td><?= $value->full_name_product ?></td>
										<td class="text-center"><?= $value->payment_mehod_name ?></td>
										<td class="text-right"><?= number_format($value->qty * $value->weight, '2', ',', '.') ?></td>
										<td class="text-center"><?= $value->uom_name ?></td>
										<td class="text-right">Rp. <?= number_format($value->price, '0', ',', '.') ?></td>
										<td class="text-right">Rp. <?= number_format($price + ($biaya_tambahan * $value->qty), '0', ',', '.') ?></td>
									</tr>
								<?php } ?>
						<tfoot>
							<tr>
								<th colspan="3" class="text-right">Total :</th>
								<th class="text-right"><?php echo number_format($total_weight, '2', ',', '.') ?></th>
								<th colspan="2"></th>
								<th class="text-right"><?php echo 'Rp ' . number_format($total, '0', ',', '.') ?></th>
							</tr>
						</tfoot>
					<?php }
					?>
					</tbody>
					</table>
				</div>
				</div>
				<?php if ($orderTransportasi) { ?>
					<div class="box-white pad-15 full mbot-30">
						<p class="mbot-5 font-18">Detail Pesanan No. <?= $detail_order->order_no .' '. $rev_time ?>
							<a target='_blank' href='<?php echo base_url() . "order_transportasi/pdfTransport/" . $detail_order->order_no; ?>' class='btn btn-sm btn-success pull-right'><i class='fa fa-file-pdf-o'></i> Lihat Pdf</a>
						</p>

						<table border="0" width="100%">
							<tr>
								<td colspan="4" style="font-size:20px; padding-bottom:20px" class="text-center"><b>PO Tranportasi</b></td>
							</tr>
							<tr>
								<td width="20%">No Surat</td>
								<td width="30%" class="bolder">: <?= $detail_order->no_surat ?></td>
								<td width="20%">Nama Vendor</td>
								<td width="30%" class="bolder">: <?= $orderTransportasi->nama_vendor ?></td>
							</tr>
							<tr>
								<td width="20%">Nama Proyek</td>
								<td width="30%" class="bolder">: <?= $detail_order->project_name ?></td>
								<td width="20%">Nama Departemen</td>
								<td width="30%" class="bolder">: <?= $detail_order->dept_name ?></td>
							</tr>
							<tr>
								<td width="20%">Perihal</td>
								<td width="30%" class="bolder">: <?= $detail_order->perihal ?></td>
								<td width="20%">Jenis Pengiriman</td>
								<td width="30%" class="bolder">: <?= $detail_order->shipping_name ?></td>
							</tr>
							<tr>
								<td width="20%">Jenis PO</td>
								<td width="30%" class="bolder">: <?= $detail_order->is_matgis == 0 ? 'Non Matgis' : 'Matgis' ?></td>
								<td width="20%">Nama Pembuat</td>
								<td width="30%" class="bolder">: <?= $detail_order->created_name ?></td>
							</tr>
							<tr>
								<td width="20%">Kota Asal</td>
								<td width="30%" class="bolder">: <?= $detail_order->location_name ?></td>
								<td width="20%">Kota Tujuan</td>
								<td width="30%" class="bolder">: <?= $orderTransportasi->destination_name ?></td>
							</tr>
							<tr>
								<td width="20%">Nama Vendor Material</td>
								<td width="30%" class="bolder">: <?= $detail_order->vendor_name ?></td>
								<td width="20%"></td>
								<td width="30%" class="bolder">
								</td>
							</tr>
							<?php
							if ($list_approval_name) {
								$index = 0;
								foreach ($list_approval_name as $key => $value) {
									$index++;
							?>
									<tr>
										<td width="20%">Approval <?php echo $index ?></td>
										<td width="30%" class="bolder">:
											<?php
											if (isset($value['approve_acc'])) {
												$text = '';
												if ($value['status_approve'] == 1) {
													$text = "(Approved)";
												} else if ($value['status_approve'] == 2) {
													$text = "(Rejected)";
												}

												echo $value['user_approve_name'] . $text;
											} else {
												echo implode(" / ", $value['approve_name']);
											}
											?>
										</td>
										<td width="20%"></td>
										<td width="30%" class="bolder"></td>
									</tr>
							<?php }
							}
							?>
						</table>
						<div class="table-responsive">
							<table class="table table-striped table-bordered nowrap">
								<thead>
									<th width="40px;">No</th>
									<th width="160px;" class="text-center">Nama Barang</th>
									<th class="text-center">Jumlah</th>
									<th class="text-center">Volume</th>
									<th class="text-center">Harga Satuan</th>
									<th class="text-center">Jumlah</th>
								</thead>
								<tbody>
									<?php
									if ($orderTransportasiDetail) {
										$jmlBatang = 0;
										$jmlVolume = 0;
										$jmlHarga = 0;
										foreach ($orderTransportasiDetail as $key => $value) {
											$jmlBatang += $value->qty;
											$jmlVolume += $value->qty * $value->weight;
											$jmlHarga += (int) ($value->qty * $value->weight * $orderTransportasi->biaya_transport);
									?>
											<tr>
												<td class="text-center"><?= $key + 1 ?></td>
												<td><?php echo $value->full_name_product; ?></td>
												<td class="text-right"><?php echo rupiah($value->qty); ?></td>
												<td class="text-right">
													<?php echo rupiah($volume = $value->qty * $value->weight, 2); ?></td>
												<td class="text-center"><?php echo rupiah($orderTransportasi->biaya_transport); ?></td>
												<td class="text-right">Rp.
													<?php echo rupiah((int)($volume * $orderTransportasi->biaya_transport)) ?></td>
											</tr>
										<?php } ?>
								<tfoot>
									<tr>
										<th colspan="2" class="text-right">Total :</th>
										<th class="text-right"><?php echo number_format($jmlBatang, '0', ',', '.') ?></th>
										<th class="text-right"><?php echo number_format($jmlVolume, '2', ',', '.') ?></th>
										<th colspan="1"></th>
										<th class="text-right"><?php echo 'Rp ' . number_format($jmlHarga, '0', ',', '.') ?></th>
									</tr>
									<?php
										if ($jmlVolume < ($_beratMin = $orderTransportasi->weight_minimum * 1000)) {
									?>
										<tr>
											<th colspan="2" class="">
												berat minimum = <?php echo rupiah($orderTransportasi->weight_minimum) ?> Ton
											</th>
											<th class="text-right"></th>
											<th class="text-right"><?php echo number_format($_beratMin, '2', ',', '.') ?></th>
											<th colspan="1"></th>
											<th class="text-right"><?php echo 'Rp ' . number_format($_beratMin * $orderTransportasi->biaya_transport, '0', ',', '.') ?></th>
										</tr>
									<?php
										}
									?>
								</tfoot>
							<?php }
							?>
							</tbody>
							</table>
						</div>
					</div>
				<?php } ?>
				<?php if ($orderAsuransi) { ?>
					<div class="box-white pad-15 full mbot-30">
						<p class="mbot-5 font-18">Detail Pesanan No. <?= $detail_order->order_no .' '. $rev_time ?>
							<a target='_blank' href='<?php echo base_url() . "order_asuransi/pdfAsuransi/" . $detail_order->order_no; ?>' class='btn btn-sm btn-success pull-right'><i class='fa fa-file-pdf-o'></i> Lihat Pdf</a>
						</p>
						<table border="0" width="100%">
							<tr>
								<td colspan="4" style="font-size:20px; padding-bottom:20px" class="text-center"><b>PO Asuransi</b></td>
							</tr>
							<tr>
								<td width="20%">No Surat</td>
								<td width="30%" class="bolder">: <?= $detail_order->no_surat ?></td>
								<td width="20%">Nama Vendor</td>
								<td width="30%" class="bolder">: <?= $orderAsuransi->vendor_name ?></td>
							</tr>
							<tr>
								<td width="20%">Nama Proyek</td>
								<td width="30%" class="bolder">: <?= $detail_order->project_name ?></td>
								<td width="20%">Nama Departemen</td>
								<td width="30%" class="bolder">: <?= $detail_order->dept_name ?></td>
							</tr>
							<tr>
								<td width="20%">Perihal</td>
								<td width="30%" class="bolder">: <?= $detail_order->perihal ?></td>
								<td width="20%">Jenis Pengiriman</td>
								<td width="30%" class="bolder">: <?= $detail_order->shipping_name ?></td>
							</tr>
							<tr>
								<td width="20%">Jenis PO</td>
								<td width="30%" class="bolder">: <?= $detail_order->is_matgis == 0 ? 'Non Matgis' : 'Matgis' ?></td>
								<td width="20%">Nama Pembuat</td>
								<td width="30%" class="bolder">: <?= $detail_order->created_name ?></td>
							</tr>
							<?php
							if ($list_approval_name) {
								$index = 0;
								foreach ($list_approval_name as $key => $value) {
									$index++;
							?>
									<tr>
										<td width="20%">Approval <?php echo $index ?></td>
										<td width="30%" class="bolder">:
											<?php
											if (isset($value['approve_acc'])) {
												$text = '';
												if ($value['status_approve'] == 1) {
													$text = "(Approved)";
												} else if ($value['status_approve'] == 2) {
													$text = "(Rejected)";
												}

												echo $value['user_approve_name'] . $text;
											} else {
												echo implode(" / ", $value['approve_name']);
											}
											?>
										</td>
										<td width="20%"></td>
										<td width="30%" class="bolder"></td>
									</tr>
							<?php }
							}
							?>
						</table>
						<div class="table-responsive">
							<table class="table table-striped table-bordered nowrap">
								<thead>
									<th width="40px;">No</th>
									<th width="160px;" class="text-center">Nama Barang</th>
									<th class="text-center">Jumlah</th>
									<th class="text-center">Volume (Kg)</th>
									<th class="text-center">Harga/unit </th>
									<th class="text-center">Jumlah</th>
								</thead>
								<tbody>
									<?php
									if ($orderAsuransiDetail) {
										$jmlBatang = 0;
										$jmlVolume = 0;
										$jmlHarga = 0;
										foreach ($orderAsuransiDetail as $key => $value) {
											$jmlBatang += $value->qty;
											$jmlVolume += $value->qty * $value->weight;
											$jmlHarga += (int) ($value->qty * $value->weight * $value->price);
									?>
											<tr>
												<td class="text-center"><?= $key + 1 ?></td>
												<td><?php echo $value->full_name_product; ?></td>
												<td class="text-right"><?php echo rupiah($value->qty); ?></td>
												<td class="text-right"><?php echo rupiah($volume = $value->qty * $value->weight, 2); ?></td>
												<td class="text-right">Rp. <?php echo rupiah($value->price); ?></td>
												<td class="text-right">Rp.<?php echo rupiah((int) ($volume * $value->price), 2) ?></td>

											</tr>
										<?php } ?>
								<tfoot>
									<tr>
										<th colspan="2" class="text-right">Total :</th>
										<th class="text-right"><?php echo number_format($jmlBatang, '0', ',', '.') ?></th>
										<th class="text-right"><?php echo number_format($jmlVolume, '2', ',', '.') ?></th>
										<th colspan="1"></th>
										<th class="text-right"><?php echo 'Rp ' . number_format($jmlHarga, '0', ',', '.') ?></th>
									</tr>
									<tr>
										<th colspan="2" class="text-right">Nilai Asuransi :</th>
										<?php $nilaiAsuransi =  ($orderAsuransi->jenis_asuransi == 'percent' ? '' : 'Rp. ') . $orderAsuransi->nilai_asuransi . ($orderAsuransi->jenis_asuransi == 'percent' ? ' %' : ' /Kg') ?>
										<th class="text-right" colspan="4"><?php echo $nilaiAsuransi ?></th>
									</tr>
									<tr>
										<th colspan="2" class="text-right">Nilai Minimum Asuransi :</th>
										<?php $nilaiAsuransi =  ($orderAsuransi->jenis_asuransi == 'percent' ? '' : 'Rp. ') . $orderAsuransi->nilai_asuransi . ($orderAsuransi->jenis_asuransi == 'percent' ? ' %' : ' /Kg') ?>
										<th class="text-right" colspan="4">Rp. <?php echo rupiah($orderAsuransi->nilai_harga_minimum) ?></th>
									</tr>
									<tr>
										<th colspan="2" class="text-right">Total Asuransi :</th>
										<?php
										if ($orderAsuransi->jenis_asuransi == 'percent') {
											$total_asuransi = $orderAsuransi->nilai_asuransi / 100 * $jmlHarga;
										} else {
											$total_asuransi = $orderAsuransi->nilai_asuransi * $jmlVolume;
										}
										$total_asuransi = $orderAsuransi->nilai_harga_minimum < $total_asuransi ? $total_asuransi : $orderAsuransi->nilai_harga_minimum;
										?>
										<th class="text-right" colspan="4">Rp. <?php echo rupiah($total_asuransi) ?></th>
									</tr>
								</tfoot>
							<?php }
							?>
							</tbody>
							</table>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="box-white pad-15 full mbot-30">
					<button class="btn btn-blue btn-shadow full-width" type="button" onclick="window.history.back()">Kembali</button>
					<hr>
					<div class="table-responsive">
						<?php
						if ($log_cancel) {
						?>
						<table class="table table-striped table-bordered nowrap">
							<thead>
								<th width="40px;">No</th>
								<th class="text-center">Alasan</th>
								<th class="text-center">Keterangan</th>
								<th width="200px;" class="text-center">User</th>
								<th width="150px;" class="text-center">status</th>
								<th width="200px;"  class="text-center">Tanggal</th>
							</thead>
							<tbody>
								<?php
									foreach ($log_cancel as $key => $value) {
										if($value->status_cancel == 1)
											$status = 'Approve';
										elseif($value->status_cancel == 2)
											$status = 'Cancel';
										else
											$status = 'Revisi';
								?>
										<tr>
											<td class="text-center"><?= $key + 1 ?></td>
											<td><?php echo $value->alasan; ?></td>
											<td><?php echo $value->keterangan; ?></td>
											<td><?php echo $value->first_name; ?></td>
											<td class="text-center"><?php echo $status; ?></td>
											<td class="text-right"><?php echo $value->created_at; ?></td>

										</tr>
									<?php }
								?>
							</tbody>
						</table>
						<?php }
						?>
					</div>
					<?php if ($cekApporval == "0" && $cekStatusOrder== 1) {
							if ($cekRole->role_id == $users_groups->id) {

						?>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-3 control-label">Status</label>
								<div class="col-sm-9">
								<select id="status" name="status" class="form-control" data-selectjs="true" required>
									<option value="">Pilih status</option>
									<option value="1">Approve</option>
									<option value="2">Revisi</option>
									<option value="3">Cancel</option>
								</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-3 control-label">Alasan</label>
								<div class="col-sm-9">
								<select id="alasan" name="alasan" class="form-control" data-selectjs="true" required>
									<option value="">Pilih Alasan</option>
								</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-3 control-label">Keterangan</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" placeholder="Keterangan" name="keterangan" id="keterangan">
									<input type="hidden" class="form-control" name="order_no" id="order_no" value="<?php echo $detail_order->order_no ?>">
									<input type="hidden" class="form-control" name="users_groups" id="users_groups" value="<?php echo $users_groups->id ?>">
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
								<a href='javascript:;' id="detail_submit" url_approve='<?php echo base_url() . "order/"; ?>' class='btn btn-xs btn-success approve'>SUBMIT
								</a>
								
							</div>
					<?php  }
						}
					?>
				</div>
			</div>
		</div>
	</div>
</form>
<script data-main="<?php echo base_url() ?>assets/js/main/main-orderhistory" src="<?php echo base_url() ?>assets/js/require.js"></script>
