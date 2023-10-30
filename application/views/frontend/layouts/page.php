<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!DOCTYPE html>
<html>
<?php   $this->load->view("frontend/layouts/header");?>

<?php
	if($is_login_page){?>
	<?php   $this->load->view($content);?>

	<?php } else{?>

		<body class="bg-softgrey">
		<div id="hideMe" class="loadingpage"><img src="<?php echo base_url()?>assets/images/loading.svg"></div>
			<div class="wrapper">
				<?php   $this->load->view("frontend/layouts/topbar");?>
				 <!-- Content Wrapper. Contains page content -->
				 <div class="content-wrapper">
				    <!-- Content Header (Page header) -->

				    <!-- Main content -->
				    <section class="content">
				       	<?php   $this->load->view($content);?>
				    </section>
				    <!-- /.content -->
				</div>
			</div>
			<div class="modal fade" id="alert_modal">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header alert-msg">
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-sm btn-default alert-cancel" data-dismiss="modal">Batal</button>
			        <button type="button" class="btn btn-sm btn-danger alert-ok">Ok</button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal fade" id="alert_confirm">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header alert-msg">
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-sm btn-default alert-cancel" data-dismiss="modal">Batal</button>
			        <button type="button" class="btn btn-sm btn-danger alert-ok" id="btn-alert-approve">Ok</button>
			      </div>
			    </div>
			  </div>
			</div>


			<div class="modal fade" id="alert_approval">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header alert-msg">
			      </div>
			      <div class="modal-footer">
			      	 <button type="button" class="btn btn-sm btn-default alert-cancel text-left" data-dismiss="modal">Cancel</button>
			        <button type="button" class="btn btn-sm btn-default alert-reject" data-dismiss="modal">Reject</button>
			        <button type="button" class="btn btn-sm btn-danger alert-approve">Approve</button>
			      </div>
			    </div>
			  </div>
			</div>
			<div class="modal fade" id="modal_pakta_integritas">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
					<div class="modal-header">
				        <h4 class="modal-title">Pakta Integritas</h4>
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				    </div>
					<?php
					if($pakta_integritas)
					{
						?>
						<ul style="padding-left:20px">
							<?php
							foreach ($pakta_integritas as $v)
							{
								?>
								<li style="font-weight: bold;"><?= $v->description ?></li>
								<?php
							}
							?>
						</ul>
						<?php
					}
					 ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default alert-cancel" data-dismiss="modal">Tidak Setuju</button>
                        <button type="button" class="btn btn-sm btn-danger alert-ok" id="btn-ok-pakta-integritas">Setuju</button>
                    </div>
                </div>
              </div>
            </div>

			<div class="modal fade" id="modal_feedback">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
					<div class="modal-header">
				        <h4 class="modal-title">Feedback</h4>
				    </div>
					<form id="form-feedback" method="post">
						<div class="modal-body">
							<div class="alert hidden" id="alert-feedback">

							</div>
							<div class="form-group">
								<label for="">Kategori Feedback</label>
								<select class="form-control" name="" id="kategori_feedback_id" required>
									<option value="">Pilih Kategori Feedback</option>
								</select>
							</div>
							<div class="form-group">
				                <label for="">Feedback</label>
				                <textarea name="isi_feedback" rows="8" cols="80" class="form-control" id="isi_feedback" required></textarea>
				            </div>
						</div>
		                <div class="modal-footer">
							<button type="submit" class="btn btn-sm btn-danger alert-ok">Simpan</button>
		                    <button type="button" class="btn btn-sm btn-default alert-cancel" data-dismiss="modal" id="dismiss-modal-feedback">Batal</button>
		                </div>
					</form>
                </div>
              </div>
            </div>

			<input type="hidden" id="base_url" value="<?php echo base_url();?>">
			<input type="hidden" id="users_login_id" value="<?php echo $users->id;?>">
            <input type="hidden" id="is_pengecualian" value="<?php echo $is_pengecualian;?>">
            <input type="hidden" id="is_check_pakta" value="<?php echo $is_check_pakta;?>">
			<input type="hidden" id="app_version" value="<?php echo ENVIRONMENT == 'development' ? time() : '1.1';?>">
			<script type="text/javascript">
			require.config({
				urlArgs : 'v=' + document.getElementById("app_version").value
			})
			</script>
		</body>
	<?php }?>
</html>
