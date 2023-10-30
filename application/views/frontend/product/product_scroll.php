<?php
if ($product) {
    foreach ($product as $key => $value) {
?>
        <div class="gallery mbot-5">
            <a href="<?php echo base_url() ?>detailproduct/<?= $value->id ?>">
                <!-- <p><?= base_url() . "product_gallery/" . $value->filename; ?></p> -->
                <?php
                if (empty($value->filename)) {
                    $image = "assets/images/noimage.png";
                } else {
                    $image = "product_gallery/" . $value->filename;
                    // if (file_exists(base_url() . "product_gallery/" . $value->filename) == true) {
                    // } else {
                    // 	$image = "assets/images/noimage.png";
                    // }
                }
                ?>
                <div class="imgfix">
                    <img src="<?php echo base_url() . $image ?>">
                </div>
                <!-- <img src="img_5terre.jpg" alt="Cinque Terre" width="600" height="400"> -->
            </a>
            <div class="desc">
                <a href="<?php echo base_url() ?>detailproduct/<?= $value->id ?>">
                    <label class="font-blue font-12 mbot-0" style="display: block;"><strong><?= $value->name ?></strong></label>
                </a>
                <p class="font-12 mbot-5">
                    <?php
                    if (isset($location_payment_method_by_product_id[$value->id])) {
                        $loc = $location_payment_method_by_product_id[$value->id];
                        $tampung = [];
                        foreach ($loc as $v) {
                            if (!in_array($v, $tampung)) {
                                $tampung[] = $v;
                            } else {
                                continue;
                            }
                    ?>
                            <span class="badge badge-primary"><?= $v ?></span>
                    <?php
                        }
                    }
                    ?>
                </p>
                <label class="font-grey font-12 mbot-0">Vendor</label>
                <p class="font-12 mbot-0"><?= $value->vendor_name ?></p>
                <span class="font-black font-14">
                    <strong>Rp <?= number_format($value->product_min_price, '0', ',', '.') ?></strong>
                    <span class="font-14">/ <?= $value->uom_name ?></span>
                </span>
                <p class="font-12">
                    <?php
                    if (in_array($value->id, $arr_terkontrak)) {
                    ?>
                        <span class="badge badge-success">Terkontrak</span>
                    <?php
                    } else {
                    ?>
                        <span class="badge badge-danger">Tidak Terkontrak</span>
                    <?php
                    }
                    ?>
                </p>
            </div>
        </div>
<?php }
}
?>
