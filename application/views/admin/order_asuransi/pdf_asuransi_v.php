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

    th.none {
        border-style: none;
    }

    tr.none {
        height: 1px;
    }


    ol.a {
        list-style-position: outside;
    }
</style>

<div class="paper">
    <?php //var_dump($department)   ; 
    ?>
    <table class="header">
        <tr>
            <td><img src="<?php echo base_url() ?>assets/images/frontend/logo2.png" width="100" height="60"></td>
            <td>
                <h5 class="mtop-0 mbot-10 font-16">PT. WIJAYA KARYA (Persero) Tbk</h5>
                <p><?php echo strtoupper($departemen); ?></p>
                <p class="m-0 font-14">Proyek : <?php echo $nama_project; ?></p>
            </td>
            <td>
                <h5 class="mtop-0 mbot-10 font-14">ASURANSI</h5>
                <p class="m-0 font-14">No.Pemesanan Barang : <?php echo $order_no ?></p>
            </td>
        </tr>
    </table>
    <div class="separator"></div>
    <table class="mbot-20" border="">
        <tr>
            <td width="50%">
                <p>Kepada:</p>
                <p class="mbot-30 bolder"><?php echo $vendor_name;  ?></p>
                <p><?php echo $alamat_vendor; ?></p>
                <p><span class="bolder">Fax:</span> <?php echo $no_fax; ?></p>
                <p class="bolder">Up: <?php echo $vendor_nama_direktur; ?></p>
            </td>
            <td valign="top" align="center">
                <p>Jakarta, <?php echo tgl_indo(date('Y-m-d')) ?></p>

            </td>
        </tr>
    </table>
    <table class="mbot-20" border="0">
        <tr>
            <td>
                <p>Perihal : <?php echo $perihal ?></p>
                <p>Dengan Hormat, </p>
                <p class="m-0">Berdasarkan Perjanjian Jual Beli</p>
                <p class="m-0">Nomor Kontrak Asuransi : <?php echo $no_contract ?></p>
                <p class="m-0">Tanggal : <?php echo $start_date . ' - ' . $end_date; ?></p>
                <p class="m-0">Maka dengan ini kami sampaikan data-data barang kiriman yang akan diasuransikan sebagai berikut :</p>
            </td>
        </tr>
    </table>
    <table class="bordered">
        <tr height="30px">
            <th height="50">No</th>
            <th>Nama Barang dan Spesifikasi</th>
            <th>Vol. <br>(Batang)</th>
            <th>Volume (Kg)</th>
            <!-- <th>Harga Satuan <br>(Rp / Kg)</th> -->
            <th>Total Harga</th>
        </tr>
        <tbody>
            <?php
            $sub_total = 0;
            $total_asuransi = 0;
            $jml_weight = 0;
            $total_biaya_tambahan = 0;
            $jml_qty = 0;
            $biayaTransport = 0;
            foreach ($order_menu as $key => $value) {
                $jml_weight += $value->weight * $value->qty;
                $jml_qty += $value->qty;
                $sub_total += (int) ($value->price * $value->qty * $value->weight);
            ?>
                <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td><?php echo $value->full_name_product ?></td>
                    <td class="text-right"><?php echo rupiah($value->qty) ?></td>
                    <!-- <td class="text-right"><?php echo number_format($berat = $value->weight * $value->qty, 2, ',', '.') ?></td> -->
                    <td class="text-right"><?php echo $jenis_asuransi == 'percent' ? 'Rp. ' . number_format($value->price, 0, ',', '.') : '' ?></td>
                    <td class="text-right"><?php echo $jenis_asuransi == 'percent' ? 'Rp. ' . number_format((int) ($value->price * $value->qty * $value->weight), 0, ',', '.') : '' ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td class="text-right bolder"><?php echo rupiah($jml_qty) ?></td>
                <td class="text-right bolder"><?= number_format($jml_weight, 2, ',', '.') ?></td>
                <td></td>

            </tr>
            <tr>
                <td colspan="4" class="text-right bolder">Nilai Asuransi</td>
                <td class="text-right"><?php echo rupiah($nilai_asuransi, 2) . ($jenis_asuransi == 'percent' ? ' %' : ' / Kg')  ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right bolder">Nilai Minimum Asuransi</td>
                <td class="text-right">Rp <?php echo rupiah($nilai_harga_minimum)  ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right bolder">Total Asuransi</td>
                <td class="text-right">
                    <?php
                    if ($jenis_asuransi == 'percent') {
                        $total_asuransi = $nilai_asuransi / 100 * $sub_total;
                    } else {
                        $total_asuransi = $nilai_asuransi * $jml_weight;
                    }
                    $total_asuransi = $nilai_harga_minimum < $total_asuransi ? $total_asuransi : $nilai_harga_minimum;

                    echo 'Rp ' . number_format($total_asuransi, 0, ',', '.') ?></td>
            </tr>

        </tbody>
    </table>
    <br>
    <table border="0">
        <tr>
            <td style="width: 60%;" valign="top">
                <p class="m-0">Menyetujui,</p>
                <p class="m-0 bolder"><?php echo $vendor_name ?></p>
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
                    <li><i>Proyek <?= $nama_project; ?></i></li>
                    <li><i><?= $departemen; ?></i></li>
                </ul>
            </td>
        </tr>
    </table>
</div>