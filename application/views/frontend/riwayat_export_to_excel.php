<?php
header("Content-Type: application/force-download");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 2010 05:00:00 GMT");
header("content-disposition: attachment;filename=riwayat_po_" . time() . ".xls");
 ?>
<table border="1">
    <tr>
        <td colspan="8" align="center"><h4>Daftar PO Ecatalogue</h4></td>
    </tr>
    <tr>
        <td>No</td>
        <td>No Order</td>
        <td>No Surat</td>
        <td>Nama Vendor</td>
        <td>Nama Proyek</td>
        <td>Total Harga</td>
        <td>Tgl Order</td>
        <td>Status</td>
    </tr>
    <?php
    $no = 1;
    foreach ($data as $key => $value)
    {
        $status = "";
        if($value->is_approve_complete == 0)
        {
            $status = "Approval";
        }
        else
        {
            if($value->order_status == 2)
            {
                $status = "On procces";
            }
            else if($value->order_status == 3)
            {
                $status = "Rejected";
            }
        }
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $value->order_no ?></td>
            <td><?= $value->no_surat ?></td>
            <td><?= $value->vendor_name ?></td>
            <td><?= $value->project_name ?></td>
            <td><?= $value->total_price ?></td>
            <td><?= tgl_indo($value->created_at,TRUE) ?></td>
            <td><?= $status ?></td>
        </tr>
        <?php
    }
     ?>
</table>
