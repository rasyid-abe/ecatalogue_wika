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
                <h3 class="box-title"><i class="fa fa-tag"></i> Show <?= $title ?> Data</h3>
            </div>
            <div class="box-body">
                <div id="my_alert" class=""></div>
                <table class="table table-sm table-striped" width="100%" id="sync_table">
                    <thead>
                        <tr>
                            <th colspan="11" class="text-center border_right">API Data</th>
                            <th colspan="6" class="text-center">SQL Data</th>
                        </tr>
                        <tr>
                            <th>SCM</th>
                            <th>No Amandemen</th>
                            <th>contract_id</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Akhir</th>
                            <th>currency</th>
                            <th>Harga</th>
                            <th>ammend_description</th>
                            <th>ammend_reason</th>
                            <th>status</th>
                            <th>current_approver_pos</th>
                            <th>ammended_date</th>
                            <th>contract_type</th>
                            <th>contract_type_2</th>
                            <th>contract_number</th>
                            <th>rental_payment_period</th>
                            <th>rental_payment_unit</th>
                            <th>rental_payment_term</th>
                            <th>current_approver_level</th>
                            <th>subject_work</th>
                            <th>scope_work</th>
                            <th>ammend_doc</th>
                            <th>No Amandemen</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Akhir</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key => $value): ?>
                            <tr>
                                <td><?= $value['api_ammend_id'] ?></td>
                                <td><?= $value['api_ammend_id'] ?></td>
                                <td><?= $value['api_contract_id'] ?></td>
                                <td><?= $value['api_start_date'] ?></td>
                                <td><?= $value['api_end_date'] ?></td>
                                <td><?= $value['api_currency'] ?></td>
                                <td><?= $value['api_contract_amount'] ?></td>
                                <td><?= $value['api_ammend_description'] ?></td>
                                <td><?= $value['api_ammend_reason'] ?></td>
                                <td><?= $value['api_status'] ?></td>
                                <td><?= $value['api_current_approver_pos'] ?></td>
                                <td><?= $value['api_ammended_date'] ?></td>
                                <td><?= $value['api_contract_type'] ?></td>
                                <td><?= $value['api_contract_type_2'] ?></td>
                                <td><?= $value['api_contract_number'] ?></td>
                                <td><?= $value['api_rental_payment_period'] ?></td>
                                <td><?= $value['api_rental_payment_unit'] ?></td>
                                <td><?= $value['api_rental_payment_term'] ?></td>
                                <td><?= $value['api_current_approver_level'] ?></td>
                                <td><?= $value['api_subject_work'] ?></td>
                                <td><?= $value['api_scope_work'] ?></td>
                                <td><?= $value['api_ammend_doc'] ?></td>
                                <td><?= $value['sql_no_amandemen'] ?></td>
                                <td><?= $value['sql_start_contract'] ?></td>
                                <td><?= $value['sql_end_contract'] ?></td>
                                <td><?= $value['sql_harga'] ?></td>
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
                "targets": [ 2,5,7,8,,9,10,11,12,13,14,15,16,17,18,19,20,21 ],
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
            v[11],v[12],v[13],v[14],v[15],v[16],v[17],v[18],v[19],v[20],v[21],
        ];
        data.push(cache);
    });

    let api_data = data.length < 100 ? data : 'all_api';

    $.ajax({
        type: 'post',
        url: '<?= base_url('sync/'.$ajax_url) ?>',
        data: {
            'data':api_data,
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
