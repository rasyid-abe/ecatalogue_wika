define([
    "jQuery",
    "jqvalidate",
    "bootstrap",
    "sidebar",
    "datatables",
    "datatablesBootstrap",
    "bootstrapDatepicker",
    "highchart",
    "highchartmore",
    "select2",
], function (
    $,
    jqvalidate,
    bootstrap,
    sidebar ,
    datatables,
    datatablesBootstrap,
    bootstrapDatepicker,
    highchart,
    highchartmore,
    select2
) {
    return {
        table:null,
        req:false,
        init: function () {
            App.initFunc();
            App.initEvent();
            App.table_log();
            App.checkAll();
            App.enableDelete();
            App.exportPDF();
            $(".loadingpage").hide();
        },
        exportPDF : function(){
            $('#export_treeview').on('click', function() {
                $.ajax({
                    url: App.baseUrl+"resources_treeview/generate_pdf",
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                    }
                })
            })
        },
        enableDelete : function(){
            $('#treeDel').on('click', function() {
                if ($('input[name="ids[]"]:checked').length > 0) {
                    return confirm('Anda yakin menghapus data yang dipilih?');
                } else {
                    alert('Anda belum memilih data untuk dihapus.')
                    return false;
                }
            })
        },
        checkAll : function(){
            $("#checkAll").click(function () {
                $('.check_delete').not(this).prop('checked', this.checked);
            });
        },
        initEvent : function()
        {
            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_  sampai _END_ dari _MAX_ data",
                    "infoEmpty": "Tidak ada data yang ditampilkan ",
                    "infoFiltered": "(pencarian dari _MAX_ total records)",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Selanjutnya",
                        "previous":   "Sebelum"
                    },
                },
                "processing": true,
                "serverSide": false,
                "searching": true,
                // "paging": true,
                "columnDefs": [
                    { "orderable": false, "targets": [0,1] },
                ],
                "order": [[2, 'desc']],
            });
        },
        table_log : function()
        {
            App.table = $('#table_log').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_  sampai _END_ dari _MAX_ data",
                    "infoEmpty": "Tidak ada data yang ditampilkan ",
                    "infoFiltered": "(pencarian dari _MAX_ total records)",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Selanjutnya",
                        "previous":   "Sebelum"
                    },
                },
                "processing": true,
                "serverSide": false,
                "searching": true,
                // "paging": true,
                "columnDefs": [
                    { "orderable": false, "targets": [0,1] },
                ],
                "order": [[3, 'desc']],
            });
        },
    }
});
