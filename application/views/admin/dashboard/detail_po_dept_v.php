<?php
$jml_volume = 0;
$jml_price = 0;
foreach ($data as $k => $v)
{
    $jml_volume += $v->volume;
    $jml_price += $v->total_price;
    ?>
    <tr>
        <td><?= $v->order_no ?></td>
        <td><?= $v->vendor_name ?></td>
        <td align="right"><?= rupiah($v->volume, 4) ?></td>
        <td align="right"><?= rupiah($v->total_price) ?></td>
    </tr>
    <?php
}
 ?>
 <tr  style="background: lightgreen">
     <th colspan="2">Total Keseluruhan</th>
     <td align="right" style="font-size: 18px"><b><?= rupiah($jml_volume,4) ?></b></td>
     <td align="right" style="font-size: 18px"><b><?= rupiah($jml_price) ?></b></td>
 </tr>
