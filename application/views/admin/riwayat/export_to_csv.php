<?php

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=perubahan_harga_'.time().'.csv');
header('Pragma: no-cache');
header("Expires: 0");

$fp = fopen('php://memory', 'r+');;

$i=0;
$no = 1;
foreach($riwayat as $k => $v)
{
    if($i == 0)
    {
        fputcsv($fp, ["NO_URUT","NAMA_PRODUK","TGL_PERUBAHAN","HARGA_LAMA","HARGA_BARU"]);
    }
    fputcsv($fp, [$no++,$v->fullname,$v->tgl,$v->old_price,$v->new_price]);
    $i++;
}
rewind($fp);
$csv_line = stream_get_contents($fp);
echo rtrim($csv_line);

 ?>
