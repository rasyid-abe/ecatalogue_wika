<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables.net-bs/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/css/select.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/css/dataTables.checkboxes.css">
<style media="screen">
    .box-body {
        font-size: 9pt;
    }
    .border_right {
        border-right: 2px solid lightgray;
    }
</style>
<section class="content">
    <div class="full-width padding">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-sm-6">
                        <h4><i class="fa fa-tag"></i> Show <?= $title ?> Data</h4>
                    </div>
                    <div class="col-sm-6 text-right">
                        <h4>Total <?= $total_sync_yet ?> data belum di sinkronisasi</h4>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div id="my_alert" class=""></div>
                <table class="table table-sm table-striped" id="sync_table">
                    <thead>
                        <tr>
                            <th colspan="25" class="text-center border_right">API Data</th>
                            <th colspan="3" class="text-center">SQL Data</th>
                        </tr>
                        <tr>
                            <th>id</th>
                            <th>id</th>
                            <th>Kode SPK</th>
                            <th>Project</th>
                            <th>dept_code</th>
                            <th>Dept</th>
                            <th>group_smbd_code</th>
                            <th>group_smbd_name</th>
                            <th>smbd_type</th>
                            <th>smbd_code</th>
                            <th class="border_right">SMBD</th>
                            <th>unit</th>
                            <th>smbd_quantity</th>
                            <th>periode_pengadaan</th>
                            <th>price</th>
                            <th>total</th>
                            <th>coa_code</th>
                            <th>coa_name</th>
                            <th>currency</th>
                            <th>user_id</th>
                            <th>user_name</th>
                            <th>periode_locking</th>
                            <th>created_date</th>
                            <th>updated_date</th>
                            <th>is_matgis</th>
                            <th>Kode SPK</th>
                            <th>Project</th>
                            <th>SMBD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key => $value): ?>
                            <tr>
                                <td><?= $value['api_id'] ?></td>
                                <td><?= $value['api_id'] ?></td>
                                <td><?= $value['api_spk_code'] ?></td>
                                <td><?= $value['api_project_name'] ?></td>
                                <td><?= $value['api_dept_code'] ?></td>
                                <td><?= $value['api_dept_name'] ?></td>
                                <td><?= $value['api_group_smbd_code'] ?></td>
                                <td><?= $value['api_group_smbd_name'] ?></td>
                                <td><?= $value['api_smbd_type'] ?></td>
                                <td><?= $value['api_smbd_code'] ?></td>
                                <td class="border_right"><?= $value['api_smbd_name'] ?></td>
                                <td><?= $value['api_unit'] ?></td>
                                <td><?= $value['api_smbd_quantity'] ?></td>
                                <td><?= $value['api_periode_pengadaan'] ?></td>
                                <td><?= $value['api_price'] ?></td>
                                <td><?= $value['api_total'] ?></td>
                                <td><?= $value['api_coa_code'] ?></td>
                                <td><?= $value['api_coa_name'] ?></td>
                                <td><?= $value['api_currency'] ?></td>
                                <td><?= $value['api_user_id'] ?></td>
                                <td><?= $value['api_user_name'] ?></td>
                                <td><?= $value['api_periode_locking'] ?></td>
                                <td><?= $value['api_created_date'] ?></td>
                                <td><?= $value['api_updated_date'] ?></td>
                                <td><?= $value['api_is_matgis'] ?></td>
                                <td><?= $value['sql_spk_code'] ?></td>
                                <td><?= $value['sql_project_name'] ?></td>
                                <td><?= $value['sql_smbd_name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables.net-bs/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/js/dataTables.select.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/js/dataTables.checkboxes.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    refresh_table();
});

function refresh_table() {
    var table = $('#sync_table').DataTable( {
        'language': {
            'url':'<?= base_url() ?>assets/indonesian.json',
            'sEmptyTable':'Tidads'
        },
        dom: 'Bfrtip',
        'columnDefs': [
            {
                "targets": [ 1,4,5,6,7,8,9,11,12,13,14,15,16,17,18,19,20,21,22,23,24 ],
                "visible": false,
                "searchable": false
            },
            {
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }
        ],
        'select': {
            'style': 'multi'
        },
        buttons: [
            {
                text: 'Proses Sync',
                action: function () {
                    if (table.rows( { selected: true } ).count() < 1) {
                        alert('Anda belum memilih data!');
                    } else {
                        proses_sync(table.rows( { selected: true } ));
                    }
                }
            },
            {
                text: 'Back',
                action: function () {
                    top.location.href = '<?= base_url('sync/create') ?>';
                }
            }
        ]
    } );
}

function proses_sync(params) {
    let selected = params.data();
    let data = [];
    $.each(selected, function(i, v) {
        cache = [
            v[1],v[2],v[3],v[4],v[5],v[6],v[7],v[8],v[9],v[10],
            v[11],v[12],v[13],v[14],v[15],v[16],v[17],v[18],v[19],v[20],
            v[21],v[22],v[23],v[24]
        ];
        data.push(cache);
    });

    let api_data = data.length < 100 ? data : 'all_api';

    $.ajax({
        type: 'post',
        url: '<?= base_url('sync/'.$ajax_url) ?>',
        data: {
            'data':api_data,
            'total_sync_yet':'<?= $total_sync_yet ?>',
            'total_api_data':'<?= $total_api_data ?>',
            'method': '<?= $title ?>',
        },
        dataType: 'json',
        success: function(response) {
            if (response.status == true) {
                top.location.href = '<?= base_url('sync') ?>';//redirection
            }
        }
    });
}

</script>
<script data-main="<?= base_url()?>assets/js/main/main-<?= $cont ?>" src="<?= base_url()?>assets/js/require.js"></script>
