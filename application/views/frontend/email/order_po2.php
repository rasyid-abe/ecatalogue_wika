<style type="text/css">
	body {
		font-family: 'Arial';
		font-size: 15px;
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
		font-size: 12px;
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
		height: 100px;
		border-bottom: 1px solid #000;
		width: 200px;
	}

	.sign-1 {
		height: 80px;
		border-bottom: 1px solid #000;
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
</style>

<div class="paper">
	<table class="header">
		<tr>
			<td><img src="<?php echo base_url() ?>assets/images/frontend/logo2.png" width="100" height="60"></td>
			<td>
				<h5 class="mtop-0 mbot-10 font-16">PT. WIJAYA KARYA (Persero) Tbk</h5>
				<p class="m-0 font-14">Proyek :</p>
			</td>
			<td>
				<h5 class="mtop-0 mbot-10 font-14">PEMESANAN BARANG</h5>
				<p class="m-0 font-14">No.Pemesanan Barang : <?php echo $order->order_no ?></p>
				<!-- <p class="m-0 font-14">No.DPPM :</p> -->
			</td>
		</tr>
	</table>
	<div class="separator"></div>
	<table class="mbot-20">
		<tr>
			<td>
				<p>Kepada:</p>
				<p class="mbot-30"><?php echo $order_product['vendor_name'] ?></p>
				<br>
				<p>Perihal : <?php echo $order->perihal ?></p>
				<br>
				<p>Dengan Hormat</p>
				<br>
				<p class="m-0">Berdasarkan Perjanjian Jual Beli</p>
				<p class="m-0">Nomor : <?php echo $order_product['vendor_no_contract'] ?></p>
				<p class="m-0">Tanggal : <?php echo $order->created_at ?></p>
				<p class="m-0">Maka dengan ini kami memesan material seperti yang tercantum dibawah ini :</p>
			</td>
		</tr>
	</table>
	<table class="bordered">
		<thead>
			<tr>
				<th style="width: 30px;">No</th>
				<th>Nama Barang dan Spesifikasi</th>
				<th>Metode Pembayaran</th>
				<th>Volume</th>
				<th>Harga Satuan</th>
				<th>Biaya Tambahan</th>
				<th>Total Harga</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_price = 0;
			foreach ($order_product['products'] as $key => $value) {
				//$total_price += $value->product_price * $value->qty * $value->default_weight;
				$total_price += $value->price * $value->qty * $value->weight;
				$total_price += $value->include_price;
			?>
				<tr>
					<td><?php echo $key + 1 ?></td>
					<td><?php echo $value->full_name_product ?></td>
					<td><?php echo $value->payment_mehod_name ?></td>
					<td><?php echo number_format($value->qty * $value->weight, 2, ',', '.') . " " . $value->uom_name ?></td>
					<td class="text-right">Rp. <?php echo number_format($value->price, 0, ',', '.') ?></td>
					<td class="text-right">Rp. <?php echo number_format($value->include_price, 0, ',', '.') ?></td>
					<td class="text-right">Rp. <?php echo number_format($value->price * $value->qty * $value->weight + $value->include_price, 0, ',', '.') ?></td>
				</tr>
			<?php } ?>
			<tr>
				<td colspan="2" rowspan="7" class="bg-white"></td>
				<td colspan="4">Jumlah</td>
				<td class="text-right">Rp. <?php echo number_format($total_price, 0, ',', '.') ?></td>
			</tr>
			<tr>
				<td colspan="4">Potongan Uang Muka</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="4">Dasar Pengenaan PPN</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="4">PPN 10%</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="4">PPH</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="4">Total (Dasar Pengenaan PPN + PPH)</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="4" class="bolder">Dibulatkan</td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<br>
	<table>
		<tr>
			<td>
				<p class="mbot-0">Kondisi :</p>
				<ol>
					<br>
					<li class="mbot-10">Barang yang terkirim harus memiliki persyaratan/spesifikasi sesuai dengan ketentuan _____ dengan kondisi baru.</li>
					<!-- <br> -->
					<li class="mbot-10">Barang yang tidak memenuhi persyaratan harus diganti barang baru tanpa tambahan biaya.</li>
					<!-- <br> -->
					<li class="mbot-10">Barang tersebut sudah bisa kami ambil secara parsial dari tanggal : ________dengan penerbitan SPPM.</li>
					<!-- <br> -->
					<li class="mbot-10">Pembayaran dilakukan dengan cara <?php echo $order->full_name ?>.</li>
					<!-- <br> -->
					<li class="mbot-10">Kondisi penyerahan material tersebut _______________.</li>
					<!-- <br> -->
					<li class="mbot-10">Pengiriman material ke proyek yang bersangkutan harus disertai Mill Certificate dan surat jalan dari Pabrik.</li>
					<!-- <br> -->
					<li class="mbot-10">Penyimpangan terhadap hal-hal diatas dapat menyebabkan pembatalan pemesanan.</li>
					<!-- <br> -->
					<li class="mbot-10">Melaksanakan SMK3L (Sistem Manajemen Kesehatan, Keselamatan Kerja, dan Lingkungan) dan SMP (Sistem Manajemen Pengamanan).</li>
					<!-- <br> -->
					<li>_________________________________.</li>
				</ol>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td style="width: 70%;">
				<p class="m-0">Menyetujui,</p>
				<p class="m-0 bolder">Vendor</p>
				<br>
				<br>
				<br>
				<div class="sign"></div>
				<p class="m-0">Pemasok</p>
			</td>
			<td>
				<p class="m-0">Pemesan,</p>
				<p class="m-0 bolder">PT Wijaya Karya (Persero)Tbk.<br><br>
					<br>
					<br>Departemen _______________</p>
				<div class="sign-1"></div>
				<p class="m-0 bolder">General Manager</p>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p class="mbot-0">Tembusan</p>
				<ul>
					<li>Proyek</li>
					<li>Departemen</li>
					<li>Tembusan</li>
				</ul>
			</td>
		</tr>
	</table>
</div>