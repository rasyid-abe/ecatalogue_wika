define([
     "jQuery",
    "bootstrap",
    "datatables",
    "datatablesBootstrap",
    "sidebar",
    ], function (
    $,
    bootstrap,
    datatables,
    datatablesBootstrap,
    sidebar,
    ) {
    return {
        table:null,
        init: function () {
            App.initEvent();
            $(".loadingpage").hide();
        },
        initEvent : function(){

            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_",
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
                "serverSide": true,
                "searching": App.searchDatatable,
                "ajax":{
                    "url": App.baseUrl+"notifikasi/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" },
                    { "data": "deskripsi" }
                ]
            });

        },
	}
});
