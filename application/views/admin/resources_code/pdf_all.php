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
	<table class="header">
		<tr>
			<td><img src="<?php echo base_url() ?>assets/images/frontend/logo2.png" width="100" height="60"></td>
			<td>
				<h5 class="mtop-0 mbot-10 font-16">PT. WIJAYA KARYA (Persero) Tbk</h5>
				<p>Daftar Sumber Daya Alam</p>
				<p class="m-0 font-14">Filter : <?php echo $level ?></p>
			</td>
		</tr>
	</table>
	<div class="separator"></div>
	<br>
	<table class="bordered">
		<thead>
			<tr>
				<th>Kode</th>
				<th>Parent</th>
				<th>Nama</th>
				<th>Matgis</th>
				<th>Keterangan</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		<tbody>
			<?php foreach ($data as $var) :
				if ($var['status'] == 0) {
					$status = 'Waiting';
					$class = 'info';
				} elseif ($var['status'] == 1) {
					$status = 'Approved';
					$class = 'success';
				} else {
					$class = 'warning';
					$status = 'Rejected';
				}

				if ($var['sts_matgis'] == 1) {
					$matgis = 'Matgis';
				} elseif ($var['sts_matgis'] == 2) {
					$matgis = 'Non Matgis';
				}
			?>
				<tr>
					<td><?php echo $var['code'] ?></td>
					<td><?php echo $var['parent_code'] != null ? $var['parent_code'] : '-' ?></td>
					<td><?php echo $var['name'] ?></td>
					<td><?php echo $var['sts_matgis'] != null ? $matgis : '-' ?></td>
					<td><?php echo $var['description'] != null ? $var['description'] : '-' ?></td>
					<td><span class="label label-<?= $class ?>"><?= $status ?></span></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		</tbody>
	</table>
	<br>
	<table>
		<tr>
			<td width=80%></td>
			<td style="text-align: center;"><?php echo $tgl_export ?></td>
		</tr>
		<tr>
			<td width=80%></td>
			<td class="text-center"></td>
		</tr>
		<tr>
			<td width=80%></td>
			<td class="text-center"></td>
		</tr>
		<tr>
			<td width=80%></td>
			<td class="text-center"></td>
		</tr>
		<tr>
			<td width=80%></td>
			<td style="text-align: center;"><strong><?php echo $user ?></strong></td>
		</tr>
	</table>
</div>