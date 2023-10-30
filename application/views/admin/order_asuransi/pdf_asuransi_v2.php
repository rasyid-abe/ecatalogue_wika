<html>

<head>
    <title>PDF Asuransi</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/pdf.css">
    <style>
        body {
            font-size: 12px;
        }

        .body-surat {
            margin-top: 20px;
            font-size: 11px;
        }

        .body-surat p {
            margin-top: 2px;
            margin-bottom: 2px;
        }

        p.header-surat {
            margin-top: 2px;
            margin-bottom: 2px;
        }

        .box-header-surat {
            width: 30%;
        }

        #table-pertanggunan {
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 12px;
        }

        #table-pertanggunan td {
            padding: 3px;
        }

        #table-barang {
            width: 100%;
        }

        #table-barang tbody tr.pertama td {
            padding-top: 40px;
        }

        #table-barang tbody tr.terakhir td {
            padding-bottom: 40px;
        }

        #table-barang td {
            font-weight: bold;
            font-size: 10px;
            padding: 5px;
        }

        #table-barang th {
            font-weight: bold;
            font-size: 10px;
            text-align: left;
            padding: 5px;
        }
    </style>
</head>

<body>
    <table width="100%" border="0">
        <tr>
            <td class="text-right" width="85%">
                PT WIJAYA KARYA (Persero) Tbk.
            </td>
            <td rowspan="2" class="text-center" style="padding-bottom:10px;padding-top:10px">
                <img src="<?php echo base_url() ?>assets/images/frontend/logo2.png" width="100" height="60">
            </td>
        </tr>
        <tr>
            <td class="text-right font-9">
                - INDUSTRY - INFRASTRUCTURE & BUILDING - ENERGY & INDUSTRIAL PLANT - REALTY & PROPERTY - INVESTMENT
            </td>
        </tr>
        <tr>
            <td class="font-11 text-center" colspan="2" style="padding-top:10px; border-top:1px solid blue">
                Jl. D.I. Panjaitan Kav. 9-10. Jakarta 13340, PO Box 4174/JKTJ, Phone: +62-21 8192808, 8508640, 8508650, Fax: +62-21 8590 4147
            </td>
        </tr>
    </table>
    <div class="body-surat">
        <div class="box-header-surat">
            <p class="header-surat">Kepada,</p>
            <p class="header-surat bolder"><?php echo $vendor_name;  ?></p>
            <p class="header-surat"><?php echo $alamat_vendor; ?></p>
            <p class="header-surat">Telp. <?php echo $dataOrder->no_telp ?><?php echo ($dataOrder->no_fax) ? ', Fax : ' . $dataOrder->no_fax : '' ?></p>
            <p class="header-surat bolder">Up. <?php echo $dataOrder->vendor_nama_direktur ?></p>
        </div>
        <p>Dengan Hormat, </p>
        <p>Berdasarkan perjanjian open cover marine cargo insurance tahun <?php echo $dataOrder->tahun ?> No. <?php echo $dataOrder->no_cargo_insurance ?>, maka bersama ini kami sampaikan data-data barang kiriman
            yang akan diasuransikan sebagai berikut : </p>
        <table id="table-barang" border="0">
            <tr>
                <th>Nama Barang dan Jenis Barang</th>
                <th width="8%" align="center">Jml Btg</th>
                <th width="12%" align="center">Tonase Kg</th>
                <th width="15%" align="center">Harga</th>
            </tr>
            <tbody>
                <?php
                $jmlAsuransi = 0;
                $jmlWeight = 0;
                foreach ($order_menu as $key => $value) {
                    $class = "";
                    $class .= $key == 0 ? 'pertama' : '';
                    $class .= $key + 1 == count($order_menu) ? ' terakhir' : '';
                    $asuransi = $dataOrder->jenis_asuransi == 'percent'
                        ? $value->qty * $value->weight * $value->price * $dataOrder->nilai_asuransi / 100
                        : $value->qty * $value->weight * $dataOrder->nilai_asuransi;
                ?>
                    <tr class="<?php echo $class ?>">
                        <td><?php echo $value->full_name_product ?></td>
                        <td align="right"><?php echo rupiah($value->qty) ?></td>
                        <td align="right"><?php echo rupiah($weight = $value->qty * $value->weight, 2) ?></td>
                        <td align="right"><?php echo rupiah($asuransi) ?></td>
                    </tr>
                <?php
                    $jmlWeight += $weight;
                    $jmlAsuransi += $asuransi;
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td align="center" colspan="2">Total</td>
                    <td align="right"><?php echo rupiah($jmlWeight, 2) ?></td>
                    <td align="right"><?php echo rupiah($jmlAsuransi) ?></td>
                </tr>
                <?php
                if ($jmlAsuransi < $dataOrder->nilai_harga_minimum) {
                ?>
                    <tr>
                        <td align="" colspan="2" style="font-weight: thin;"><i>Harga minimum asuransi = <?php echo rupiah($dataOrder->nilai_harga_minimum) ?></i></td>
                        <td align="right"></td>
                        <td align="right"><?php echo rupiah($dataOrder->nilai_harga_minimum) ?></td>
                    </tr>
                <?php
                }
                ?>
            </tfoot>
        </table>
        <table width="100%" border="0" id="table-pertanggunan">
            <tr>
                <td width="25%">Nilai Pertanggungan</td>
                <td width="2%">:</td>
                <td><?php echo rupiah($jmlAsuransi) ?></td>
            </tr>
            <tr>
                <td>Lokasi Muat</td>
                <td>:</td>
                <td>
                    <?php echo $vendorProduct->name ?> <?php echo $vendorProduct->address ?>
                </td>
            </tr>
            <tr>
                <td>Tujuan</td>
                <td>:</td>
                <td>
                    <?php echo $dataOrder->nama_project ?>
                </td>
            </tr>
            <tr>
                <td>Jenis Pengiriman</td>
                <td>:</td>
                <td>
                    Darat dan Laut
                </td>
            </tr>
            <tr>
                <td>Tanggal Pengiriman</td>
                <td>:</td>
                <td>
                    <?php echo tgl_indo($orderProduct->created_at) ?> s.d <?php echo tgl_indo($orderProduct->tgl_diambil) ?>
                </td>
            </tr>
            <tr>
                <td valign="top">Nama Forwarding</td>
                <td valign="top">:</td>
                <td>
                    <?php
                    if ($orderTransport) {
                    ?>
                        <span class="bolder">
                            <?php echo $orderTransport->nama_vendor ?>
                        </span>
                        <br>
                        <?php echo $orderTransport->alamat_vendor ?>
                        <br>
                        <?php echo $orderTransport->data_traller ?>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        </table>
        <p>Demikian kami sampaikan, atas perhatiannya kami ucapkan terima kasih.</p>
        <p>Deklarasi ini dibuat dan disampaikan kepada <?php echo $vendor_name ?></p>
        <p>Tanggal, <?php echo tgl_indo($dataOrder->generatepdf_time != '' ? $dataOrder->generatepdf_time : $dataOrder->created_at) ?></p>

        <table border="0" width="100%">
            <tr>
                <td width="60%">
                    Hormat Kami,
                </td>
                <td>
                    Telah diterima dan disetujui untuk dicover
                </td>
            </tr>
            <tr>
                <td>
                    <span class="bolder">PT.Wijaya Karya (persero) Tbk.</span><br>
                    <?php echo $departemen ?>
                </td>
                <td>
                    <span class="bolder"><?php echo $dataOrder->vendor_nama_direktur ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo str_repeat('<br>', 10) ?>
                </td>
            </tr>
            <tr>
                <td class="bolder">
                    <?= $department->general_manager ?>
                </td>
                <td class="bolder">
                    <?= $dataOrder->vendor_nama_direktur ?>
                </td>
            </tr>
        </table>
        <?php echo str_repeat('<br>', 3) ?>
        <span class="bolder">Note</span> : Dimohon surat penutupan ini dilampirkan pada saat penyerahan polis dan kwitansi tagihan
    </div>
</body>

</html>