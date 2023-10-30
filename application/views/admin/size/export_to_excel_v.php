<?php
header("Content-Type: text/csv");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 2010 05:00:00 GMT");
header("content-disposition: attachment;filename=sumber_daya_".time().".xls");
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>9.7a Nomenklatur Sumber Daya - Material</title>
        <style>
        table#table-detail {
            border-collapse: collapse;
            width: 100%;
        }

        #table-detail th {
            padding: 10px;
        }

        #table-detail td {
            padding: 5px;
        }

        th.red {
            background-color: red;
        }

        th.orange {
            background-color: orange;
        }
        </style>
    </head>
    <body>
        <table id="table-detail" border="1">
            <tr>
                <th colspan="2">Level 1</th>
                <th>Level 2</th>
                <th></th>
                <th>Level 3</th>
                <th></th>
                <th>Level 4</th>
            </tr>
            <tr>
                <th colspan="3" class="red">Jenis</th>
                <th class="orange">Kode</th>
                <th class="red">Nama Sumber Daya</th>
                <th class="orange">Kode</th>
                <th class="red">Sub Item</th>
            </tr>
            <?php
            foreach ($categoryNew as $k => $valueCatNew)
            {
                ?>
                <tr>
                    <td><?php echo $valueCatNew->code ?></td>
                    <td colspan="2"><?php echo $valueCatNew->name ?></td>
                    <?php
                    echo str_repeat('<td></td>', 4)
                     ?>
                </tr>
                <?php
                if (isset($category[$valueCatNew->id]))
                {
                    foreach ($category[$valueCatNew->id] as $k2 => $valueCat)
                    {
                        ?>
                        <tr>
                            <td></td>
                            <td><?php echo $valueCat->code ?></td>
                            <td><?php echo $valueCat->name ?></td>
                            <?php
                            echo str_repeat('<td></td>', 4)
                             ?>
                        </tr>
                        <?php
                        if (isset($specification[$valueCat->id]))
                        {
                            foreach ($specification[$valueCat->id] as $k3 => $valueSpec)
                            {
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo $valueCat->code . '' . $valueSpec->code ?></td>
                                    <td><?php echo $valueSpec->name ?></td>
                                    <?php
                                    echo str_repeat('<td></td>', 2)
                                     ?>
                                </tr>
                                <?php
                                if (isset($size[$valueSpec->id]))
                                {
                                    foreach ($size[$valueSpec->id] as $k4 => $valueSize)
                                    {
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo $valueCat->code . '' . $valueSpec->code . '' . $valueSize->code ?></td>
                                            <td><?php echo $valueSize->name ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                }
            }
             ?>
        </table>
    </body>
</html>
