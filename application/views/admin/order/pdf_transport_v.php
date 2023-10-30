<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/pdf.css">
    </head>
    <style>

    </style>
    <body>
        <h3 class="mbot-0">LAMPIRAN PERJANJIAN PENGANGKUTAN</h3>
        No : <?php echo 'T'.$order_no;?><br>
        Tgl : <?php echo $tgl_order;?>
        <h3 class="text-center">
            Rincian Volume dan Harga Satuan<br>
            <!-- Pekerjaan : <span class="font-biru">Angkutan Besi Beton???</span><br> -->
            <?php echo $nama_project;?><br>
        </h3>
        <table class="full-width table-transport" border="1">
            <thead>
                <tr>
                    <td width="5%">No</td>
                    <td width="25%">Uraian Pekerjaan</td>
                    <td width="10%">
                        Jumlah<br>
                        (Btg)
                    </td>
                    <td width="15%">
                        Volume (Kg)
                    </td>
                    <td width="15%">
                        Harga<br>
                        Satuan
                    </td>
                    <td width="20%">
                        Jumlah
                    </td>
                    <td width="10%">
                        Keterangan
                    </td>
                </tr>
            </thead>

            <?php
                $no = 1;
                $jumlahBatang = 0;
                $jumlahVolume = 0;
                $jumlahHarga  = 0;
                 foreach ($dataPekerjaan as $value) { ?>
            <tbody>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td>
                        <?php echo $value->full_name_product; ?>
                    </td>

                    <td class="text-right">
                        <?php echo rupiah($value->qty); ?>
                    </td>
                    <td class="text-right">
                        <?php
                                $volume = $value->qty * $value->weight;
                                echo rupiah($volume, 2);
                        ?>
                    </td>
                    <td class="text-center">
                        <?php echo rupiah($dataOrder->biaya_transport); ?>
                    </td>
                    <td class="text-right">
                        <?php
                                $jumlah = $volume * $dataOrder->biaya_transport;
                                echo rupiah($jumlah, 2);
                                $jumlahBatang += $value->qty;
                                $jumlahVolume += $volume;
                                $jumlahHarga += $jumlah;
                        ?>
                    </td>
                    <td></td>
                </tr>
            </tbody>
            <?php } ?>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right bolder">
                        <?php echo  rupiah($jumlahBatang); ?></td>
                    <td class="text-right bolder">
                        <?php echo rupiah($jumlahVolume, 2); ?>
                    </td>
                    <td class="text-right no-border-right bolder">
                        Rp.
                    </td>
                    <td class="text-right no-border-left bolder">
                        <?php echo rupiah($jumlahHarga, 2) ?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5" class="no-border-bottom no-border-right"></td>
                    <td>&nbsp;</td>
                    <td rowspan="3"></td>
                </tr>
                <tr>
                    <td colspan="3" class="border-left-only"></td>
                    <td class="text-right bolder no-border">Jumlah</td>
                    <td class="text-right border-right-only bolder">
                        Rp.
                    </td>
                    <td class="bolder text-right no-border-left">
                        <?php echo rupiah($jumlahHarga, 2) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="no-border-top no-border-right"></td>
                    <td class="text-right bolder border-bottom-only">Dibulatkan</td>
                    <td class="text-right no-border-top no-border-left bolder">
                        Rp.
                    </td>
                    <td class="bolder text-right no-border-left">
                        <?php echo rupiah($jumlahHarga, 2); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <br>
        <table class="full-width" border="0">
            <tr>
                <td class="padl-50" colspan="2">
                    Terbilang : <br>
                    <i><?php echo terbilang($jumlahHarga); ?></i>
                </td>
            </tr>
            <tr>
                <td width="60%"></td>
                <td width="40%">
                    Dikeluarkan di : Jakarta<br>
                    Pada Tanggal : <?php echo $tgl_approve;?>
                </td>
            </tr>
            <tr>
                <td class="padl-50">
                    Menyetujui/menyanggupi<br>
                    Untuk dan atas nama angkutan
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="padl-50">
                    <span class="bolder">
                        <?php echo $nama_vendor; ?>
                    </span>
                    <?php echo str_repeat('<br>', 10) ?>

                </td>
                <td>
                    <span class="bolder">
                        PT Wijaya Karya (Persero) Tbk.
                    </span>
                    <?php echo $departemen; ?>
                    <?php echo str_repeat('<br>', 10) ?>
                </td>
            </tr>
            <tr>
                <td class="padl-50">
                    <span class="bolder">
                        <?php echo $nama_direktur; ?>
                    </span><br>
                    <?php echo $jabatan; ?>
                </td>
                <td>
                    <span class="bolder">
                        <?php echo $gm; ?>
                    </span><br>
                    <?php echo 'GM '.$departemen; ?>
                </td>
            </tr>
        </table>
    </body>

</html>
