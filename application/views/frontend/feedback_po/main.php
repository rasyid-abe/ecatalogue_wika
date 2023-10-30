
	<div class="container">
		<div class="row">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?php echo base_url()?>home">Home</a></li>
			    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo base_url()?>mycart">My Cart</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Feedback</li>
			  </ol>
			</nav>
		</div>
		<div class="row">
            <div class="col-md-12">
                <div class="box-white pad-15 full mbot-30">
                    <h2 class="text-left">
						<?php
						if ($email_not_sent === TRUE)
						{
							?>
							Terjaid kesalahan pada server email. Email tidak terkirim<br>
							<?php
						}
						?>
                        Pesanan Sedang Diproses, Anda Bisa Mengecek Status Pesanan di Tab Riwayat
                    </h2>
                    <!-- <div class="text-center mtop-20 mbot-20">
                        <img class="" src="<?php echo base_url()?>assets/images/frontend/img-banner.png">
                    </div> -->
                    <p class="mbot-5 font-18 bolder mtop-20">Tolong Berikan Feedback Pada Vendor Terkait</p>
                    <div class="table-responsive">
                        <form id="form-feedback-po" method="POST" action="" enctype="multipart/form-data">
                            <table class="table table-striped display nowrap" id="table_detail">
                              <thead>
                                <th class="text-center" width="40px;">No</th>
                                <th class="text-center">Nama Vendor</th>
                                <th class="text-center">Isi Feedback</th>
                              </thead>
                              <tbody>
                                    <?php
                                        if($vendor_po){
                                            foreach ($vendor_po as $key => $value) { ?>
                                                <tr>
                                                    <th><?php echo $key+1?></th>
                                                    <th><?php echo $value->name?></th>
                                                    <th>
                                                        <input type="hidden" name="vendor_id[]" value="<?php echo $value->id?>">
                                                        <textarea class="form-control" name="isi_feedback[]"></textarea>
                                                    </th>
                                                </tr>
                                            <?php }
                                        }
                                    ?>
                              </tbody>
                            </table>
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <button class="btn btn-blue btn-shadow full-width" type="button" onclick="window.location.href='<?php echo base_url()?>home'">Kembali</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-green btn-shadow full-width" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
<script data-main="<?php echo base_url()?>assets/js/main/main-feedbackpo" src="<?php echo base_url()?>assets/js/require.js"></script>
