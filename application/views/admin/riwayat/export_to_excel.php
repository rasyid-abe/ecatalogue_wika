<?php
header("Content-Type: text/csv");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 2010 05:00:00 GMT");
header("content-disposition: attachment;filename=perubahan_harga_".time().".csv");
 ?>

<table width = "100%">
    <tr>
        <th>No Urut</th>
        <th>Nama Produk</th>
        <th>Nama Vendor</th>
        <th>Tgl Perubahan</th>
        <th>Harga Lama</th>
        <th>Harga Baru</th>
    </tr>
    <?php
    $no = 1;
    foreach($riwayat as $key => $value)
    {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $value->fullname ?></td>
            <td><?= $value->name_vendor ?></td>
            <td><?= $value->tgl ?></td>
            <td><?= $value->old_price ?></td>
            <td><?= $value->new_price ?></td>
        </tr>
        <?php
    }
    ?>
</table>
