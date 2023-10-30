<html>

<head>
    <title></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/pdf.css">
</head>
<style>
    body {
        font-size: 11px;
    }

    .box-body-surat {
        margin-left: 10%;
        margin-right: 10%;
    }

    .box-body-surat p {
        margin-top: 5px;
        text-align: justify;
        margin-bottom: 5px;
    }

    #table-header {
        font-size: 11px;
    }

    #table-header td {
        padding: 3px;
    }

    #table-header td.border {
        border-bottom: 2px solid black
    }

    td ol.alphabetic-list {
        list-style-type: lower-alpha;
    }
</style>

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
            <td class="text-right font-11">
                <?php echo $departemen ?>
            </td>
        </tr>
        <tr>
            <td class="font-11 text-center" colspan="2" style="padding-top:10px; border-top:1px solid blue">
                Jl. D.I. Panjaitan Kav. 9-10. Jakarta 13340, PO Box 4174/JKTJ, Phone: +62-21 8192808, 8508640, 8508650, Fax: +62-21 8590 4147
            </td>
        </tr>
    </table>
    <div class="box-body-surat">
        <h3 class="text-center"><u>PERJANJIAN PENGANGKUTAN</u></h3>
        <table border="1" width="100%" id="table-header" border="0">
            <tr>
                <td class="bolder" width="30%">Nomor</td>
                <td width="2%">:</td>
                <td><?php echo 'T' . $order_no ?></td>
            </tr>
            <tr>
                <td class="bolder">Tanggal</td>
                <td>:</td>
                <td><?php echo tgl_indo($dataOrder->created_at) ?></td>
            </tr>
            <tr>
                <td class="bolder border">Proyek</td>
                <td class="border">:</td>
                <td class="border"><?php echo $nama_project ?></td>
            </tr>
        </table>
        <?php
        $hari = hari(date('w', strtotime($dataOrder->tgl_kontrak)));
        $tanggalHuruf = terbilang(date('d', strtotime($dataOrder->tgl_kontrak)));
        $bulanHuruf = bulan(date('n', strtotime($dataOrder->tgl_kontrak)));
        $tahunHuruf = terbilang(date('Y', strtotime($dataOrder->tgl_kontrak)));
        ?>
        <p>
            SURAT PERJANJIAN ini termasuk semua lampirannya merupakan bagian yang tidak terpisahkan dari surat perjanjian,
            selanjutnya disebut Perjanjian dibuat pada hari <?php echo $hari ?> tanggal <?php echo $tanggalHuruf ?>
            bulan <?php echo $bulanHuruf ?> Tahun <?php echo $tahunHuruf ?> (<?php echo date('d-m-Y', strtotime($dataOrder->tgl_kontrak)) ?>)
        </p>
        <table border="0" width="100%">
            <tr>
                <td class="bolder" width="58%">Mengacu pada Perjanjian Pengadaan Jasa Transportasi</td>
                <td class="bolder" width="10%">No.</td>
                <td class="bolder" width="2%">:</td>
                <td class="bolder"><?php echo $no_kontrak_transport ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="bolder">Tanggal</td>
                <td class="bolder">:</td>
                <td class="bolder"><?php echo $tgl_kontrak ?></td>
            </tr>
        </table>
        <table border="0" width="100%">
            <tr>
                <td width="7%" valign="top">I.</td>
                <td width="40%" valign="top" class="bolder">PT. WIJAYA KARYA ( Persero) Tbk</td>
                <td width="2%" valign="top">:</td>
                <td valign="top" style="text-align:justify">
                    Berkedudukan di Jl. D.I. Panjaitan Kav.9 Jakarta 13340, yang dalam hal ini diwakili oleh <?php echo ucwords($gm) ?>
                    selaku General Manager <?php echo ucwords(strtolower($departemen)) ?>, oleh karena itu sah untuk mewakili perusahaan
                    yang selanjutnya disebut PIHAK PERTAMA
                </td>
            </tr>
            <tr>
                <td valign="top">II.</td>
                <td valign="top" class="bolder"><?php echo $nama_vendor ?></td>
                <td valign="top">:</td>
                <td valign="top" style="text-align:justify">
                    Berkedudukan di
                    <?php echo ucwords(strtolower($dataOrder->alamat_vendor)) ?> yang dalam hal ini diwakili oleh
                    <?php echo ucwords(strtolower($dataOrder->nama_direktur)) ?> selaku <?php echo ucwords(strtolower($dataOrder->jabatan)) ?>
                    oleh karena itu sah untuk mewakili Perusahaan <?php echo $nama_vendor ?> :
                    yang selanjutnya disebut PIHAK KEDUA
                </td>
            </tr>
        </table>
        <p>
            Menyatakan bahwa PIHAK KEDUA telah sepakat untuk mengikat dan berjanji akan melaksanakan ketentuan - ketentuan
            dan syarat-syarat sebagai berikut :
        </p>
        <table width="100%" border="0">
            <tr>
                <td valign="top" width="6%" style="padding-left:20px" rowspan="4">1.</td>
                <td valign="top" class="bolder" width="30%" rowspan="4">
                    Untuk Melaksanakan
                </td>
                <td width="2%" valign="top" rowspan="4">:</td>
                <td valign="top" colspan="2">
                    Pekerjaan pengangkutan besi beton dari pabrik <?php echo $detail_order->vendor_name ?>
                    atas PO No : <?php echo 'T' . $order_no; ?> ke <?php echo $nama_project ?>, <?php echo $dataOrder->alamat ?>,
                    dan melaksanakan / mengikuti semua prosedur dan persyaratan seperti ISO 9001, 2000, SMP,
                    K3/OHSAS 18001 : 1999,
                </td>
            </tr>
            <tr>
                <td valign="top" width="5%">a.</td>
                <td style="padding-left:10px">
                    Dalam melaksanakan pekerjaan dilapangan harus memperhatikan perlengkapan K3 (Seperti : Helm, sabuk pengaman,
                    sepatu safety, dll).
                </td>
            </tr>
            <tr>
                <td valign="top">b.</td>
                <td style="padding-left:10px">
                    Untuk pengangkutan material yang menggunakan jalan umum harus mengikuti semua peraturan lalu lintas dan angkutan
                    jalan No. 14/1992, dan menjaga keselamatan pekerja dan barang.
                </td>
            </tr>
            <tr>
                <td valign="top">c.</td>
                <td style="padding-left:10px">
                    Dalam pelaksanaan pekerjaan baik itu dilokasi pabrikasi pekerjaan atau di lokasi pabrikasi (workshop) harus mematuhi
                    ketentuan peraturan SMK3L/OHSAS (System Manajement Keselamatan dan Kesehatan Kerja Lingkungan) yang diterapkan oleh
                    PT. Wijaya Karya (Persero) Tbk, dan tidak diperkenankan memperkerjakan Tenaga Kerja dengan usia dibawah umur yang
                    ditentukan oleh DEPNAKER, serta mengasuransikan Tenaga Kerja yang diperkerjakan di lokasi Proyek (Asuransi JAMSOSTEK)
                </td>
            </tr>
            <tr>
                <td style="padding-left:20px" valign="top">2.</td>
                <td class="bolder" valign="top">Sifat Kontrak</td>
                <td valign="top">:</td>
                <td colspan="2">
                    <span class="bolder">FOT (Freight on truck)</span><br>
                    Lokasi Ambil : <?php echo $detail_order->vendor_name ?><br>
                    Wilayah : <?php echo $dataOrder->origin_name ?><br>
                    Alamat : <?php echo $detail_order->alamat_vendor ?><br>
                    Lokasi Kirim : <?php echo $nama_project ?><br>
                    Alamat Proyek : <?php echo $dataOrder->alamat ?><br>
                    <span class="bolder">Contact Person : <?php echo $dataOrder->contact_person ?></span><br>
                    <span class="bolder">HP : <?php echo $dataOrder->no_hp ?></span>
                </td>
            </tr>
            <tr>
                <td style="padding-left:20px" valign="top">3.</td>
                <td class="bolder" valign="top">Volume Pekerjaan</td>
                <td valign="top">:</td>
                <td colspan="2" class="bolder">
                    <?php echo rupiah($dataOrder->total_weight, 2) ?> Kg <i>atau</i> <?php echo rupiah($dataOrder->total_qty) ?> Batang
                </td>
            </tr>
            <tr>
                <td style="padding-left:20px" valign="top">4.</td>
                <td class="bolder" valign="top">Biaya Pekerjaan</td>
                <td valign="top">:</td>
                <td colspan="2" class="">
                    <span class="bolder">
                        <?php echo rupiah($dataOrder->total_biaya_transport) ?>
                    </span><br>
                    <i># <?php echo terbilang($dataOrder->total_biaya_transport) ?> #</i>
                </td>
            </tr>
            <!-- <tr>
                    <td style="padding-left:20px" valign="top" rowspan="2">5.</td>
                    <td class="bolder" valign="top" rowspan="2">Cara Pembayaran</td>
                    <td valign="top" rowspan="2">:</td>
                    <td colspan="" class="" valign="top">
                        5.1,
                    </td>
                    <td>
                        Konfensional 30 (tiga puluh) hari jika nilai dibawah 100 juta dengan
                        kondisi setelah barang terkirim & diterima proyek, dan invoice tagihan diterima dengan lengkap
                        & benar oleh PT. WIKA.
                    </td>
                </tr> -->
            <tr>
                <td style="padding-left:20px" valign="top" rowspan="">5.</td>
                <td class="bolder" valign="top" rowspan="">Cara Pembayaran</td>
                <td valign="top" rowspan="">:</td>
                <td colspan="" class="" valign="top">
                    5.1,
                </td>
                <td>
                    <?php echo substr($dataOrder->keterangan_transport,6) ?> jika nilai diatas 100 juta dengan
                    kondisi setelah barang terkirim & diterima proyek, dan invoice tagihan diterima dengan lengkap
                    & benar oleh PT. WIKA.
                </td>
            </tr>
            <tr>
                <td style="padding-left:20px" valign="top" rowspan="3">6.</td>
                <td class="bolder" valign="top" rowspan="3">Ketentuan & Syarat-Syarat Umum</td>
                <td valign="top" rowspan="3">:</td>
                <td colspan="" class="" valign="top">
                    6.1,
                </td>
                <td>
                    PT. Wijaya Karya berhak memutuskan/membatalkan SPK ini secara sepihak
                    tanpa tuntutan apapun dari <?php echo $nama_vendor ?>, apabila pengiriman
                    terlambat 2 (dua) hari dari waktu pelaksanaan yang ditetapkan oleh PT. Wijaya Karya (Persero).
                </td>
            </tr>
            <tr>
                <td colspan="" class="" valign="top">
                    6.2,
                </td>
                <td>
                    Kerusakan/ kehilangan barang diluar cakupan asuransi merupakan tanggung jawab <?php echo $nama_vendor ?>.
                </td>
            </tr>
            <tr>
                <td colspan="" class="" valign="top">
                    6.3,
                </td>
                <td>
                    Waktu pelaksanaan sejak diterbitkan perjanjian ini.
                </td>
            </tr>
            <tr>
                <td style="padding-left:20px" valign="top" rowspan="2">7.</td>
                <td class="bolder" valign="top" rowspan="2">Force Majeure</td>
                <td valign="top" rowspan="2">:</td>
                <td colspan="" class="" valign="top">
                    7.1,
                </td>
                <td style="text-align:justify">
                    Dalam SPK ini Force Majeure berarti suatu peristiwa yang berada diluar kemampuan
                    PT. Wijaya Karya (Persero) Tbk dan <?php echo $nama_vendor ?> yang menyebabkan pelaksanaan
                    pekerjaan ini mengalami keterlambatan disebabkan karena : (Kerusuhan, Gempa Bumi, Tsunami,
                    Ombak besar, Kegiatan Teroris, Sabotase, Pemberontakan).
                </td>
            </tr>
            <tr>
                <td colspan="" class="" valign="top">
                    7.2,
                </td>
                <td style="text-align:justify">
                    Apabila terjadi peristiwa Force Majeure, yang menyebabkan terjadinya gangguan pengiriman material
                    ke lokasi proyek, maka <?php echo $nama_vendor ?> harus mengirimkan pemberitahuan tertulis kepada
                    PT. Wijaya Karya (Persero) Tbk. selambat-lambatnya dalam waktu 3 (tiga) hari setelah perjalanan
                    pengiriman material terhambat karena peristiwa Force Majeure tersebut.
                </td>
            </tr>
            <tr>
                <td style="padding-left:20px" valign="top" rowspan="2">8.</td>
                <td class="bolder" valign="top" rowspan="2">Penyelesaian Perselisihan</td>
                <td valign="top" rowspan="2">:</td>
                <td colspan="" class="" valign="top">
                    8.1,
                </td>
                <td style="text-align:justify">
                    Pada dasarnya setiap perselisihan atau perbedaan pendapat dalam menjalankan
                    pekerjaan ini akan diselesaikan dengan cara musyawarah untuk mufakat
                </td>
            </tr>
            <tr>
                <td colspan="" class="" valign="top">
                    8.2,
                </td>
                <td style="text-align:justify">
                    Bila musyawarah tidak berhasil mencapai kesepakatan, semua perbedaan pendapat atau
                    sengketa atau perselisihan yang timbul dalam Perjanjian ini akan diputus dan diselesaikan
                    melalui Pengadilan Negeri yang berwenang sesuai dengan ketentuan perundang udangan yang berlaku
                </td>
            </tr>
        </table>
        <p>
            Demikian surat ini dibuat dalam rangkap 2 (dua) bermaterai cukup, setelah disetujui dan ditandatangani
            oleh kedua belah pihak dinyatakan sah dan mempunyai kekuatan hukum yang sama.
        </p>
        <!-- <tr>
                <td>Lokasi Kirim</td>
                <td>:<?php echo $nama_project ?></td>
            </tr>
            <tr>
                <td>Alamat Proyek</td>
                <td>:<?php echo $dataOrder->alamat ?></td>
            </tr>
            <tr>
                <td class="bolder">Contact Person</td>
                <td>:<?php echo $dataOrder->contact_person ?></td>
            </tr>
            <tr>
                <td class="bolder">HP</td>
                <td>: <?php echo $dataOrder->no_hp ?></td>
            </tr> -->
        <!-- <ol type="a">
                <li>
                    Dalam melaksanakan pekerjaan
                </li>
            </ol> -->
        <table class="full-width" border="0">
            <tr>
                <td width="60%"></td>
                <td width="40%">
                    Dikeluarkan di : Jakarta<br>
                    Pada Tanggal : <?php echo $tgl_approve; ?>
                </td>
            </tr>
            <tr>
                <td class="">
                    Menyetujui/menyanggupi<br>
                    Untuk dan atas nama angkutan
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="">
                    <span class="bolder">
                        <?php echo $nama_vendor; ?>
                    </span>
                    <?php echo str_repeat('<br>', 10) ?>

                </td>
                <td>
                    <span class="bolder">
                        PT Wijaya Karya (Persero) Tbk.
                    </span><br>
                    <?php echo $departemen; ?>
                    <?php echo str_repeat('<br>', 10) ?>
                </td>
            </tr>
            <tr>
                <td class="">
                    <span class="bolder">
                        <u>
                            <?php echo $nama_direktur; ?>
                        </u>
                    </span><br>
                    <i>
                        <?php echo $jabatan; ?>
                    </i>
                </td>
                <td>
                    <span class="bolder">
                        <u>
                            <?php echo $gm; ?>
                        </u>
                    </span><br>
                    <i>
                        <?php echo 'General Manager ' ?>
                    </i>
                </td>
            </tr>
        </table>
    </div>
    <p style="page-break-after: always;	"></p>



    <h3 class="mbot-0">LAMPIRAN PERJANJIAN PENGANGKUTAN</h3>
    No : <?php echo 'T' . $order_no; ?><br>
    Tgl : <?php echo $tgl_order; ?>
    <h3 class="text-center">
        Rincian Volume dan Harga Satuan<br>
        <!-- Pekerjaan : <span class="font-biru">Angkutan Besi Beton???</span><br> -->
        <?php echo $nama_project; ?><br>
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

        <tbody>
            <?php
            $no = 1;
            $jumlahBatang = 0;
            $jumlahVolume = 0;
            $jumlahHarga  = 0;
            foreach ($dataPekerjaan as $value) { ?>
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
                        $volume = round($value->qty * $value->weight, 2);
                        echo rupiah($volume, 2);
                        ?>
                    </td>
                    <td class="text-center">
                        <?php echo rupiah($dataOrder->biaya_transport, 2); ?>
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
            <?php }

            ?>
        </tbody>
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
            <?php
            // jika minimum Weight tidak tercapai
            if ($jumlahVolume < ($_beratMin = $dataOrder->weight_minimum * 1000)) {
            ?>
                <tr>
                    <td colspan="3" class="">
                        berat minimum = <?php echo rupiah($dataOrder->weight_minimum) ?> Ton
                    </td>
                    <td class="text-right bolder">
                        <?php echo rupiah($_beratMin, 2); ?>
                    </td>
                    <td class="text-right no-border-right bolder">
                        Rp.
                    </td>
                    <td class="text-right no-border-left bolder">
                        <?php echo rupiah($jumlahHarga = $_beratMin * $dataOrder->biaya_transport, 2) ?>
                    </td>
                    <td></td>
                </tr>
            <?php
            }
            ?>
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
                Pada Tanggal : <?php echo $tgl_approve; ?>
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
                </span><br>
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
                <?php echo 'GM ' . $departemen; ?>
            </td>
        </tr>
    </table>
</body>

</html>