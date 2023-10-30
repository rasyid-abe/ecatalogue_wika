<?php

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=forecast_'.time().'.csv');
header('Pragma: no-cache');
header("Expires: 0");



$fp = fopen('php://memory', 'r+');;

// set headernya;
$header = [
    "ID_PRODUK",
    "TIPE_FORECAST",
    "NAMA_PRODUK",
    "NAMA_VENDOR",
    "LOKASI_VENDOR",
    "START_DATE",
    "END_DATE",
    "FORECAST"
];
fputcsv($fp, $header, $separator);


foreach($csv as $k => $v)
{
    $isi = [
        $v->id,
        $data_from,
        $v->full_name,
        $v->vendor_name,
        $v->vendor_address,
        $start_date,
        $end_date,
        '0' // dikosongkan untuk dimasukan kembali
    ];
    fputcsv($fp, $isi, $separator);
}
rewind($fp);
$csv_line = stream_get_contents($fp);
echo rtrim($csv_line);

 ?>
