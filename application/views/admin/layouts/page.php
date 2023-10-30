<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php   $this->load->view("admin/layouts/header");?>
<body class="hold-transition skin-blue-light fixed sidebar-mini">
	<div class="wrapper">
		 	<?php 	$this->load->view("admin/layouts/topbar");?>
		  	<?php   $this->load->view("admin/layouts/sidemenu");?>
        <div id="hideMe" class="loadingpage"><img src="<?php echo base_url()?>assets/images/loading.svg"></div>
        <div class="content-wrapper custom-height-wrapper">
          <?php   $this->load->view($content);?>
        </div>
            <?php   $this->load->view("admin/layouts/footer");?>
		  	<div class="modal fade" id="alert_modal">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-body alert-msg">
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-sm btn-default alert-cancel" data-dismiss="modal">Batal</button>
			        <button type="button" class="btn btn-sm btn-danger alert-ok">Ok</button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal fade" id="alert_approval">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-body alert-msg">
			      </div>
			      <div class="modal-footer">
			      	 <button type="button" class="btn btn-sm btn-default alert-cancel text-left" data-dismiss="modal">Cancel</button>
			        <button type="button" class="btn btn-sm btn-default alert-reject" data-dismiss="modal">Reject</button>
			        <button type="button" class="btn btn-sm btn-danger alert-approve">Approve</button>
			      </div>
			    </div>
			  </div>
			</div>

            <div class="modal fade" id="order_modal">
              <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form_set_order" method="POST" action="<?php echo base_url()?>order/set">
                        <input type="text" class="form-control" name="order_id" id="order_id">
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Uang Muka</label>
                                            <input type="text" class="form-control" name="dp" id="dp" onkeyup="App.format(this)">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nomor Surat</label>
                                            <input type="text" class="form-control" name="no_surat" id="no_surat">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default alert-cancel" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-sm btn-danger alert-ok">Ok</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>

			<div class="modal fade" id="modal_pakta_integritas">
              <div class="modal-dialog modal-lg">
				<div class="modal-title">
					cek
				</div>
                <div class="modal-content">
					<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Pakta Integritas</h4>
				    </div>
					<?php
					if($pakta_integritas)
					{
						?>
						<ul>
							<?php
							foreach ($pakta_integritas as $v)
							{
								?>
								<li><?= $v->description ?></li>
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
		</div>
	</div>
	<input type="hidden" id="base_url" value="<?php echo base_url();?>">
	<input type="hidden" id="users_login_id" value="<?php echo $users->id;?>">
	<input type="hidden" id="is_can_search" value="<?php echo $is_can_search;?>">
	<input type="hidden" id="is_can_read" value="<?php echo $is_can_read;?>">
	<input type="hidden" id="is_can_create" value="<?php echo $is_can_create;?>">
	<input type="hidden" id="is_can_edit" value="<?php echo $is_can_edit;?>">
	<input type="hidden" id="is_can_delete" value="<?php echo $is_can_delete;?>">
	<input type="hidden" id="is_pengecualian" value="<?php echo $is_pengecualian;?>">
	<input type="hidden" id="is_check_pakta" value="<?php echo $is_check_pakta;?>">
	<input type="hidden" id="app_version" value="<?php echo ENVIRONMENT == 'development' ? time() : '1.1';?>">
	<script type="text/javascript">
	require.config({
		urlArgs : 'v=' + document.getElementById("app_version").value
	})
	</script>
</body>
</html>
