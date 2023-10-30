define([
    "jQuery",
    "jqvalidate",
    "bootstrap",
    "sidebar",
    "datatables",
    "datatablesBootstrap",
    "bootstrapDatepicker",
    "select2",
    ], function (
    $,
    jqvalidate,
    bootstrap,
    sidebar ,
    datatables,
    datatablesBootstrap,
    bootstrapDatepicker,
    select2
    ) {
    return {
        table:null,
        req:false,
        init: function () {
            App.initFunc();
            App.initEvent();
            App.searchTable();
            App.setdate();
            App.resetSearch();
            App.exportExcel();
            $(".loadingpage").hide();
        },
        initEvent : function(){
            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_  dari _END_ ",
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
                    "url": App.baseUrl+"riwayat/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" },
                    { "data": "fullname" },
                    { "data": "name_vendor" },
                    { "data": "tgl"},
                    { "data": "old_price","class": "text-right"  },
                    { "data": "new_price","class": "text-right"  },
                ]
            });
            $('.dataTables_filter').hide();
            $('.dataTables_info').hide();

        },
        searchTable:function(){
            $('#search').on('click', function () {
                console.log("SEARCH");
                var name_vendor = $("#name_vendor").val();
                var spesifikasi = $("#spesifikasi").val();
                var start_contract = $("#start_contract").val();
                var end_contract = $("#end_contract").val();

                App.table.column(1).search(name_vendor,true,true);
                App.table.column(2).search(spesifikasi,true,true);
                App.table.column(3).search(start_contract,true,true);
                App.table.column(4).search(end_contract,true,true);

                App.table.draw();

            });
        },

        resetSearch:function(){
            $('#reset').on( 'click', function () {
                $("#name_vendor").val("");
                $("#spesifikasi").val("");
                $("#start_contract").val("");
                $("#end_contract").val("");

                App.table.search( '' ).columns().search( '' ).draw();
            });
        },

        exportExcel:function(){
            $('#btn-export').on('click', function(){
                var name_vendor = $("#name_vendor").val();
                var spesifikasi = $("#spesifikasi").val();
                var start_contract = $("#start_contract").val();
                var end_contract = $("#end_contract").val();
                var link = App.baseUrl+'riwayat/export_to_excel/?nama_vendor='+name_vendor+'&spesifikasi='+spesifikasi+'&start_date='+start_contract+'&end_date='+end_contract;
                window.open(link);
            });
        },

        setdate : function(){
            $('*[data-datepicker="true"] input[type="text"]').datepicker({
                format: 'yyyy-mm-dd',
                orientation: "bottom center",
                autoclose: true,
                todayHighlight: true
            });
        },

	}
});
