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
                <table class="table table-sm table-striped" id="sync_table">
                    <thead>
                        <tr>
                            <th colspan="7" class="text-center border_right">API Data</th>
                            <th colspan="3" class="text-center">SQL Data</th>
                        </tr>
                        <tr>
                            <th>API VK ID</th>
                            <th>API VK ID</th>
                            <th>VVH ID</th>
                            <th>Vendor Id</th>
                            <th>Vendor Name</th>
                            <th>Score</th>
                            <th class="border_right">Tanggal</th>
                            <th>VVH ID</th>
                            <th>Vendor Name</th>
                            <th>Score</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key => $value): ?>
                            <tr>
                                <td><?= $value['api_vk_id'] ?></td>
                                <td><?= $value['api_vk_id'] ?></td>
                                <td><?= $value['api_vvh_id'] ?></td>
                                <td><?= $value['api_vvh_vendor_id'] ?></td>
                                <td><?= $value['api_vendor_name'] ?></td>
                                <td><?= $value['api_vk_score_total'] ?></td>
                                <td class="border_right"><?= $value['api_vvh_date'] ?></td>
                                <td><?= $value['sql_vvh_id'] ?></td>
                                <td><?= $value['sql_vendor_name'] ?></td>
                                <td><?= $value['sql_vk_score_total'] ?></td>
                                
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
                "targets": [1, 2, 3, 7],
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
        cache = [v[1],v[2],v[3],v[4],v[5],v[6],v[7]];
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
