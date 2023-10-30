<section class="content">

    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-upload"></i> History Upload Data Lelang</h3>
            <div class="full-width datatableButton text-right">
                <a href="<?php echo base_url() . $cont ?>" class="btn btn-sm btn-warning pull-right"><i class='fa fa-arrow-left'></i> Kembali</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-striped table-bordered display" id="table-history">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th>User Upload</th>
                        <th>Departemen</th>
                        <th>Jumlah Row</th>
                        <th>Tgl Upload</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

<script data-main="<?php echo base_url() ?>assets/js/main/main-data_lelang_new" src="<?php echo base_url() ?>assets/js/require.js"></script>