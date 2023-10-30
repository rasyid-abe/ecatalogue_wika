<section class="content">
    <div class="full-width padding">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Asuransi</h3>
            </div>
            <form id="form" method="POST" action="" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <?php if(!empty($this->session->flashdata('message_error'))){?>
                        <div class="alert alert-danger">
                            <?php
                            print_r($this->session->flashdata('message_error'));
                            ?>
                        </div>
                    <?php }?>
                    <?php echo validation_errors() ?>
                    <div class="form-group">
                        <label for="">No Kontrak</label>
                        <input type="text" name="no_contract" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Vendor</label>
                        <select class="form-control" name="vendor_id" data-selectjs="true">
                            <option value="" disabled selected>Pilih Vendor</option>
                            <?php
                            echo array_to_options($vendor);
                             ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Kontrak</label>
                        <div class="" data-datepicker="true">
                            <input class="form-control" type="text" id="tgl_kontrak" name="tgl_kontrak" autocomplete="off"  value="" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="">Tahun</label>
                             <input class="form-control number" type="text" id="tahun" name="tahun" autocomplete="off"  value="" maxlength="4">
                        </div>
                        <div class="col-md-6">
                            <label for="">No Kargo Insurance</label>
                            <input class="form-control" type="text" id="no_cargo_insurance" name="no_cargo_insurance" autocomplete="off"  value="" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="">Start Date</label>
                            <div class="" data-datepicker="true">
                              <input class="form-control" type="text" id="start_date" name="start_date" autocomplete="off"  value="" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">End Date</label>
                            <div class="" data-datepicker="true">
                              <input class="form-control" type="text" id="end_date" name="end_date" autocomplete="off"  value="" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Nilai Harga Minimum</label>
                        <input type="text" name="nilai_harga_minimum" id="nilai_harga_minimum" value="" onkeyup="App.format(this)" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Nilai Asuransi</label>
                        <input type="text" name="nilai_asuransi" id="nilai_asuransi" value="" onkeyup="App.format(this)" class="form-control">
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="jenis_asuransi" value="percent" checked>
                            Menggunakan Persentase (Asuransi akan dihitung berdasarkan persentase * Nilai PO)
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="jenis_asuransi" value="value">
                            Nilai Fix (Asuransi akan dikali weight )
                        </label>
                    </div>
                    <div class="box-footer pad-15 full-width bg-softgrey border-top bot-rounded">
                        <button type="submit" class="btn btn-primary pull-right mleft-15" id="save-btn">Simpan</button>
                        <a href="<?php echo base_url();?><?= $cont ?>" class="btn btn-default pull-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script data-main="<?php echo base_url()?>assets/js/main/main-asuransi" src="<?php echo base_url()?>assets/js/require.js"></script>
