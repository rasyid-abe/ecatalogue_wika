<section class="content-header">

 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active">Import <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></li>
 </ol>
</section>

<section class="content">
<?php if($is_can_search){?>
 <div class="box box-bottom">
   <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i> Import <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
   <div class="full-width datatableButton text-right">

   </div>
   </div>
   <form id="form-import-csv" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group col-12 row">
            <div class="col-sm-12">
              <label for="">File</label>
              <div class="" data-datepicker="true">
                <input class="form-control" type="file" id="csv_file" name="csv_file">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
          <button type="submit" class="btn btn-success" id = "btn-upload">Simpan</button>
        </div>
      </div>
    </div>
  </form>
 </div>

<?php } ?>

<div class="modal fade" id="modalimport" data-backdrop="static">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header bg-grey">
        		<h5 class="m-none">Keterangan Hasil Import Data</h5>
      		</div>
      		<!-- Modal body -->
      		<div class="modal-body">
        		<div class="col-12">
          			<div class="row">
            			<div id="modal-body" class="col-12">
              				<div id="container-info" class="box-header">
                				<p id="title"></p>                				
              				</div>
             	 			<div class="ptop-10">
              					<button type="button" class="btn btn-blue btn-100" id="btn-detail">Lihat Detail</button>
              					<button type="button" class="btn btn-green btn-100" id="btn-end" data-dismiss="modal">Selesai</button>
              				</div>
			              <div id="container-error" class="box-header hidden-div scroll_error">

			              </div>
            			</div>
          			</div>
        		</div>
      		</div>
		    <div class="modal-footer no-border">
		    </div>
    	</div>
  	</div>
</div>

</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-forecast" src="<?php echo base_url()?>assets/js/require.js"></script>
