<style type="text/css">
	body {
		font-family: 'Arial';
		font-size: 12px;
	}

	.paper {
		width: 21cm;
		display: table;
		margin: auto;
		padding: 10px 10px;
	}

	table {
		width: 100%;
		border-collapse: collapse;
	}

	.bordered th,
	.bordered td {
		border: 1px solid #000;
		padding: 5px;
		font-size: 11px;
		padding: 2px 5px;
	}

	.bordered th {
		padding: 10px 5px;
	}

	.header td {
		vertical-align: top;
	}

	.font-14 {
		font-size: 14px;
	}

	.font-16 {
		font-size: 16px;
	}

	.font-18 {
		font-size: 18px;
	}

	.font-20 {
		font-size: 20px;
	}

	.m-0 {
		margin: 0;
	}

	.mtop-0 {
		margin-top: 0;
	}

	.mbot-0 {
		margin-bottom: 0px;
	}

	.mbot-10 {
		margin-bottom: 10px;
	}

	.mbot-20 {
		margin-bottom: 20px;
	}

	.mbot-30 {
		margin-bottom: 30px;
	}

	h5 {
		font-size: 22px;
	}

	.separator {
		display: table;
		width: 100%;
		height: 2px;
		border-bottom: 2px solid #000;
		border-top: 2px solid #000;
		margin-top: 15px;
	}

	.bg-grey {
		background: #898989;
	}

	.bg-white {
		background: #FFFFFF;
	}

	ol {
		list-style-type: decimal;
	}

	.bolder {
		font-weight: bold;
	}

	.sign {
		height: 150px;
		width: 200px;
	}

	.sign-1 {
		height: 150px;
		width: 200px;
	}

	ul {
		list-style-type: none;
	}

	ul li:before {
		content: '-';
		position: absolute;
		margin-left: -20px;
	}

	.text-right {
		text-align: right;
	}

	ol.a {
		list-style-position: outside;
	}
</style>

<div class="paper">
	<?php //var_dump($department)	; 
	?>
	<table class="header">
		<tr>
			<td><img src="<?php echo base_url() ?>assets/images/frontend/logo2.png" width="100" height="60"></td>
			<td>
				<h5 class="mtop-0 mbot-10 font-16">PT. WIJAYA KARYA (Persero) Tbk</h5>
				<p><?= strtoupper($department->department_name) ?></p>
				<p class="m-0 font-14">Proyek : <?= $order->project_name ?></p>
			</td>
			<td>
				<h5 class="mtop-0 mbot-10 font-14">PEMESANAN BARANG</h5>
				<p class="m-0 font-14">No.Pemesanan Barang : <?php echo $order->order_no ?></p>
				<p class="m-0 font-14">No.Surat : <?php echo $order->no_surat ?></p>
				<!-- <p class="m-0 font-14">No.DPPM :</p> -->
			</td>
		</tr>
	</table>
	<div class="separator"></div>
	<table class="mbot-20" border="">
		<tr>
			<td width="50%">
				<p>Kepada:</p>
				<p class="mbot-30 bolder"><?php echo $order_menu[0]->vendor_name ?></p>
				<p><?php echo $order_menu[0]->vendor_address ?></p>
				<p><span class="bolder">Fax:</span> <?php echo $order_menu[0]->vendor_no_fax ?></p>
				<p class="bolder">Up: <?php echo $order_menu[0]->vendor_nama_direktur ?></p>
			</td>
			<td valign="top" align="center">
				<p>Jakarta, <?php echo tgl_indo(($order->generatepdf_time != '') ? $order->generatepdf_time : $order->created_at) ?></p>

			</td>
		</tr>
	</table>
	<table class="mbot-20" border="0">
		<tr>
			<td>
				<p>Perihal : <?php echo $order->perihal ?></p>
				<p>Dengan Hormat, </p>
				<p class="m-0">Berdasarkan Perjanjian Jual Beli</p>
				<p class="m-0">Nomor Kontrak : <?php echo $no_contract ?></p>
				<p class="m-0">Tanggal : <?php echo tgl_indo($tgl_contract) ?></p>
				<p class="m-0">Maka dengan ini kami memesan material seperti yang tercantum dibawah ini :</p>
			</td>
		</tr>
	</table>
	<table class="bordered">
		<thead>
			<tr>
				<th style="width: 30px;">No</th>
				<th>Nama Barang dan Spesifikasi</th>
				<th>Vol. <br>(Batang)</th>
				<th>Volume (Kg)</th>
				<th>Harga Satuan <br>(Rp / Kg)</th>
				<th width="20%">Total Harga</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_price = 0;
			$jml_weight = 0;
			$total_biaya_tambahan = 0;
			$jml_qty = 0;
			$biayaTransport = 0;
			foreach ($order_menu as $key => $value) {
				$jml_weight += $value->weight * $value->qty;
				$jml_qty += $value->qty;
				$biayaTransport += (int) ($value->weight * $value->qty * $value->biaya_transport);
				//$total_price += $value->product_price * $value->qty * $value->default_weight;
				$subTotal = round($value->price * $value->qty * $value->weight, 2);
				$total_price += $subTotal;
				//$total_price += $value->include_price;
				$arr_biaya_tambahan = json_decode($value->json_include_price);
				if (is_array($arr_biaya_tambahan)) {
					foreach ($arr_biaya_tambahan as $v) {
						$total_biaya_tambahan += ($v->price * $value->qty);
					}
				}
			?>
				<tr>
					<td><?php echo $key + 1 ?></td>
					<td><?php echo $value->full_name_product ?></td>
					<td class="text-right"><?php echo rupiah($value->qty) ?></td>
					<td class="text-right"><?php echo number_format($berat = $value->weight * $value->qty, 2, ',', '.') ?></td>
					<td class="text-right">Rp. <?php echo number_format($value->price, 0, ',', '.') ?></td>
					<td class="text-right">Rp. <?php echo number_format($subTotal, 2, ',', '.') ?></td>
				</tr>
			<?php } ?>
			<tr>
				<td></td>
				<td></td>
				<td class="text-right bolder"><?php echo rupiah($jml_qty) ?></td>
				<td class="text-right bolder"><?= number_format($jml_weight, 2, ',', '.') ?></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td rowspan="8" colspan="2" align="center" style="padding-top:5px"><span class="bolder"></span></td>
				<td colspan="3">&nbsp;</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right bolder">Sub Total</td>
				<td class="text-right"><?php echo number_format($total_price, 2, ',', '.') ?></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right">Potongan UM 10%</td>
				<td class="text-right">-</td>
			</tr>
			<tr>
				<td colspan="3" class="text-right">Dasar Pengenaan Pajak</td>
				<td class="text-right"><?php echo number_format($tot = $total_price, 2, ',', '.') ?></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right">PPN 10%</td>
				<td class="text-right"><?php echo number_format($ppn = $tot * 0.1, 2, ',', '.') ?></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right">Pph 1,5%</td>
				<td class="text-right"><?php echo number_format($pph = $tot * 0.015, 2, ',', '.') ?></td>
			</tr>
			<?php
			$asuransi = 0;
			if ($order->nilai_asuransi != 0) {
				if ($order->jenis_asuransi == 'percent') {
					$asuransi = (int) ($tot * $order->nilai_asuransi / 100);
				} else {
					$asuransi = (int) ($jml_weight * $order->nilai_asuransi);
				}
			}

			?>
			<!-- <tr>
					<td colspan="3" class="text-right">Biaya Transportasi</td>
					<td class="text-right"><?php echo number_format($biayaTransport, 0, ',', '.') ?></td>
				</tr>
				<tr>
					<td colspan="3" class="text-right">Asuransi</td>
					<td class="text-right"><?php echo number_format($asuransi, 0, ',', '.') ?></td>
				</tr> -->
			<tr>
				<td colspan="3" class="text-right bolder">Total = Subtotal + PPN</td>
				<td class="text-right"><?php echo number_format($tot + $ppn, 2, ',', '.') ?></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right bolder">Tagihan Yang Harus Dibayarkan</td>
				<td class="text-right"><?php echo number_format($tot - $pph, 2, ',', '.') ?></td>
			</tr>
		</tbody>
	</table>
	<p style="page-break-after: always;	"></p>
	<p class="mbot-0">Kondisi :</p>
	<ol class="a">
		<li class="mbot-10">
			Barang yang terkirim harus memenuhi persyaratan/spesifikasi sesuai dengan pesanan kami, dalam keadaan baik dan baru
		</li>

		<li class="mbot-10">
			Barang yang tidak memenuhi persyaratan harus diganti barang baru tanpa tambahan biaya
		</li>

		<li class="mbot-10">Material <?= $order->shipping_name ?> <?php echo $order_menu[0]->vendor_name ?> dikirim ke
			<span class="bolder"><?= $order->project_name ?></span> dengan angkutan yang ditunjuk oleh PT. Wijaya Karya ( Persero) Tbk.
		</li>

		<li class="mbot-10">
			Pembayaran dilakukan dengan pola <?php echo $order->full_name ?> setelah akseptasi Bank,
			beban bunga menjadi tanggunan pihak supplier
		</li>

		<li class="mbot-10">
			Pengiriman material ke proyek yang bersangkutan harus disertai Mill Certificate dan surat jalan dari Pabrik.
		</li>

		<li class="mbot-10">
			Penyimpangan terhadap hal-hal diatas dapat menyebabkan pembatalan pemesanan.
		</li>

		<li class="mbot-10">
			Melaksanakan SMK3L (Sistem Manajemen Kesehatan, Keselamatan Kerja, dan Lingkungan) dan SMP (Sistem Manajemen Pengamanan).
		</li>
	</ol>
	<br>
	<table border="0">
		<tr>
			<td style="width: 60%;" valign="top">
				<p class="m-0">Menyetujui,</p>
				<p class="m-0 bolder"><?php echo $order_menu[0]->vendor_name ?></p>
				<br>
				<br>
				<br>

			</td>
			<td valign="top" align="center">
				<p class="m-0">Pemesan,</p>
				<p class="m-0 bolder">PT Wijaya Karya (Persero)Tbk.
					<?php
					if ($pake_ttd === TRUE && file_exists('./image_upload/ttd_gm/' . $department->ttd && $department->ttd != '')) {
					?>
						<img src="<?= base_url() ?>image_upload/ttd_gm/<?= $department->ttd ?>" alt="" width="100px" style="margin:auto">
					<?php
					}
					?>
			</td>
		</tr>
		<tr>
			<td class="sign">
				<u><?php echo $order_menu[0]->vendor_nama_direktur ?></u>

				<p class="m-0"><?php echo $order_menu[0]->vendor_dir_pos ?></p>
			</td>
			<td align="center" class="sign">
				<u><?= $department->general_manager ?></u>

				<p class="m-0">GM <?= $department->department_name ?></p>
			</td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td colspan="2" style="padding-top:10px">
				<p class="mbot-0">Tembusan</p>
				<ul>
					<li><i>Proyek <?= $order->project_name ?></i></li>
					<li><i><?= $department->department_name ?></i></li>
				</ul>
			</td>
		</tr>
	</table>
</div>