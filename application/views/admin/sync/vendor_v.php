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
                            <th>SCM</th>
                            <th>Vendor</th>
                            <th>Nama</th>
                            <th>No Telp</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Direktur</th>
                            <th class="border_right">Posisi</th>
                            <th>Vendor</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>No Telp</th>
                            <th>Direktur</th>
                            <th>Posisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key => $value): ?>
                            <tr>
                                <td><?= $value['api_vendor_id'] ?></td>
                                <td><?= $value['api_vendor_id'] ?></td>
                                <td><?= $value['api_vendor_name'] ?></td>
                                <td><?= $value['api_contact_name'] ?></td>
                                <td><?= $value['api_contact_phone_no'] ?></td>
                                <td><?= $value['api_contact_email'] ?></td>
                                <td><?= $value['api_address_street'] ?></td>
                                <td><?= $value['api_login_id'] ?></td>
                                <td><?= $value['api_password'] ?></td>
                                <td><?= $value['api_dir_name'] ?></td>
                                <td class="border_right"><?= $value['api_dir_pos'] ?></td>
                                <td><?= $value['sql_name'] ?></td>
                                <td><?= $value['sql_address'] ?></td>
                                <td><?= $value['sql_email'] ?></td>
                                <td><?= $value['sql_no_telp'] ?></td>
                                <td><?= $value['sql_nama_direktur'] ?></td>
                                <td><?= $value['sql_dir_pos'] ?></td>
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
                "targets": [ 1,3,4,5,6,7,8,12,13,14 ],
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
        cache = [v[1],v[2],v[3],v[4],v[5],v[6],v[7],v[8],v[9],v[10]];
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
