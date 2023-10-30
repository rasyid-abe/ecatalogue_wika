<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Email</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  </head>
  <?php $path = 'assets/images/logo.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $image = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($image);
        ?>
    <body>
      <div style="width:100%;display: block;padding:30px 20px;background:#f0eff4;box-sizing: border-box;">
        <div style="background:#fff;width:100%;display: block;padding:15px 20px;box-sizing: border-box;border-bottom: 7px solid #3269c6;">
          <div style="width:100%;display: block;padding:0;border-bottom: 1px solid #3269c6;box-sizing: border-box;">
            <img src="<?php echo $base64?>" style="width:80px;">
          </div>
          <div style="width: 100%;display: block;padding:30px 15px;box-sizing: border-box;">
            <p>Yth. nama_penerima_approva_wika_ecatalogue ,</p>
            <p>Berikut kami lampirkan PO <?= $detail_order->sumber_daya_name ?> untuk proyek <?= $detail_order->project_name ?> dengan spesifikasi sebagai berikut :</p>
            <div style="display: table;width:100%;">
              <table border="0" width="100%">
                <tbody>
                  <tr>
                    <td width="20%">No Surat</td>
                    <td width="30%"><b>: <?= $detail_order->no_surat ?></b></td>
                    <td width="20%">Nama Vendor</td>
                    <td width="30%"><b>: <?= $detail_order->vendor_name ?></b></td>
                  </tr>
                  <tr>
                    <td width="20%">Nama Proyek</td>
                    <td width="30%"><b>: <?= $detail_order->project_name ?></b></td>
                    <td width="20%">Nama Departemen</td>
                    <td width="30%"><b>: <?= $detail_order->dept_name ?></b></td>
                  </tr>
                  <tr>
                    <td width="20%">Perihal</td>
                    <td width="30%"><b>: <?= $detail_order->perihal ?></b></td>
                    <td width="20%">Jenis Pengiriman</td>
                    <td width="30%"><b>: <?= $detail_order->shipping_name ?></b></td>
                  </tr>
                  <tr>
                    <td width="20%">Jenis PO</td>
                    <td width="30%"><b>: <?= $detail_order->is_matgis == 0 ? 'Non Matgis' : 'Matgis' ?></b></td>
                    <td width="20%">Nama Pembuat</td>
                    <td width="30%"><b>: <?= $detail_order->created_name ?></b></td>
                  </tr>
                  <?php
                      if($list_approval_name){
                          $index=0;
                          foreach ($list_approval_name as $key => $value) {
                          $index++;
                           ?>
                          <tr>
                              <td width="20%">Approval <?php echo $index?></td>
                              <td width="30%"><b>:
                                  <?php
                                      if(isset($value['approve_acc'])) {
                                          $text = '';
                                          if($value['status_approve'] == 1){
                                              $text = "(Approved)";
                                          }else if($value['status_approve'] == 2){
                                              $text = "(Rejected)";
                                          }

                                          echo $value['user_approve_name'].$text;
                                      } else{
                                          echo implode(" / ", $value['approve_name']);
                                      }
                                  ?>
                                  </b>
                              </td>
                              <td width="20%"></td>
                              <td width="30%" class="bolder"></td>
                          </tr>
                          <?php }
                      }
                  ?>
                </tbody>
              </table>
              <table class="" id="table-detail-order" style="width:100%; border-collapse:collapse; margin-top:20px" border="1">
                <thead>
                  <tr>
                    <th width="20px;" style="padding:5px;">No</th>
                    <th width="160px;" class="text-center" style="padding:5px;text-align:center !important;">Nama Barang</th>
                    <th style="padding:5px;">Metode Pembayaran</th>
                    <th style="padding:5px;">Quantity</th>
                    <th style="padding:5px;">Unit</th>
                    <th class="text-center" style="padding:5px;text-align:center !important;">Biaya Tambahan</th>
                    <th class="text-center" style="padding:5px;text-align:center !important;">Harga/unit</th>
                    <th class="text-center" style="padding:5px;text-align:center !important;">Total Harga</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        if($order_product){
                            $total =0;
                            $total_weight = 0;
                            foreach ($order_product as $key => $value) {
                                $total_weight += $value->qty * $value->weight;
                                $price = $value->price * $value->qty * $value->weight;
                                $total += $price;
                                //$total += $value->include_price;
                                $biaya_tambahan = 0;
                                $include = json_decode($value->json_include_price);
                                $include_text = " - ";
                                if($include)
                                {
                                    //var_dump($include);
                                    $include_text = "";
                                    foreach($include as $v)
                                    {
                                        $include_text .= $v->description . " Rp. " . rupiah($v->price) . "<br>";
                                        $biaya_tambahan += $v->price;
                                    }
                                }
                                $total += ($biaya_tambahan * $value->qty);
                                ?>
                                <tr>
                                    <td class="text-center" style="padding:5px;text-align:center !important;"><?=$key+1?></td>
                                    <td class="text-center" style="padding:5px;text-align:center !important;"><?=$value->full_name_product ?></td>
                                    <td class="text-center" style="padding:5px;text-align:center !important;"><?=$value->payment_mehod_name ?></td>
                                    <td class="text-right" style="padding:5px;text-align:right !important;"><?=number_format($value->qty * $value->weight,'2',',','.')?></td>
                                    <td class="text-center" style="padding:5px;text-align:center !important;"><?=$value->uom_name ?></td>
                                    <td class="text-right" style="padding:5px;text-align:right !important;"><?= $include_text ?></td>
                                    <td class="text-right" style="padding:5px;text-align:right !important;">Rp. <?=number_format($value->price,'0',',','.')?></td>
                                    <td class="text-right" style="padding:5px;text-align:right !important;">Rp. <?=number_format($price + ($biaya_tambahan * $value->qty),'0',',','.')?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right" style="padding:5px;text-align:right !important;">Total :</th>
                                    <th class="" style="padding:5px;"><?=number_format($total_weight,'2',',','.')?></th>
                                    <th colspan="3" style="padding:5px;"></th>
                                    <th class="text-right" style="padding:5px;text-align:right !important;"><?=number_format($total,'0',',','.')?></th>
                                </tr>
                            </tfoot>
                        <?php }
                    ?>
              </table>
              <p>
                Mohon review dan persetujuannya di ecatalogue.wika.co.id.
                    </p>
              <p>
                Demikian kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terimakasih.
                    </p>
              <p>
                *email ini dikirim otomatis dari aplikasi eCatalogue WIKA. Segala bentuk penyebaran informasi dan data dari aplikasi eCatalogue WIKA adalah tidak diperbolehkan dan menjadi tanggung jawab pengguna.
                    </p>
            </div>
            <p style="color: #999;">Silahkan login <a href="<?php echo base_url() ?>" target="_blank">disini</a></p>
          </div>
        </div>
      </div>
    </body>
  </html>
