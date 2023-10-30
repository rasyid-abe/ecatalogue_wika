<?php
header("Content-Type: text/csv");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 2010 05:00:00 GMT");
header("content-disposition: attachment;filename=wilayah_".time().".xls");
 ?>
<html>
    <head>
        <title>Download Wilayah</title>
    </head>
    <body>
        <table border="1">
            <tr>
                <td>Nama Wilayah</td>
            </tr>
            <?php
            foreach ($data as $key => $value)
            {
                ?>
                <tr>
                    <td><?php echo $value->name ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>
