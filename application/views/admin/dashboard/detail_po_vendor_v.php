<?php
    $jml = 0;
    $jml_nom = 0;
    foreach($data as $k => $v)
    {
        $jml_per_dept = 0;
        $jml_nom_per_dept = 0;
        foreach ($v as $k2 => $v2)
        {
            $jml_per_dept += $v2->total_volume;
            $jml_nom_per_dept += $v2->total_price;
            if ($k2 == 0)
            {
                ?>
                <tr>
                <td rowspan="<?= count($v)?>" valign="center"><?= $v2->dept_name ?></td>
                <?php
            }
            else
            {
                ?>
                <tr>
                <?php
            }
            ?>
                <td><?= $v2->order_no ?></td>
                <td><?= $v2->name_payment_method ?></td>
                <td><?= $v2->location_name ?></td>
                <td><?= $v2->project_name ?></td>
                <td align="right"><?= rupiah($v2->total_volume,4) ?></td>
                <td align="right"><?= rupiah($v2->total_price) ?></td>
            <?php
        }
        $jml += $jml_per_dept;
        $jml_nom += $jml_nom_per_dept;
        ?>
        <tr style="background: lightblue">
            <th colspan="5">Total <?= $v2->dept_name ?></th>
            <td align="right" style="font-size: 16px"><b><?= rupiah($jml_per_dept,4) ?></b></td>
            <td align="right" style="font-size: 16px"><b><?= rupiah($jml_nom_per_dept) ?></b></td>
        </tr>
        <?php
    }
 ?>
 <tr  style="background: lightgreen">
     <th colspan="5">Total Keseluruhan</th>
     <td align="right" style="font-size: 18px"><b><?= rupiah($jml,4) ?></b></td>
     <td align="right" style="font-size: 16px"><b><?= rupiah($jml_nom) ?></b></td>
 </tr>
