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
            App.initFunc();
            App.initEvent();
            App.searchTable();
            App.resetSearch();
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
                "ajax":{
                    "url": App.baseUrl+"order_asuransi/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "order": [[6, 'desc']],
                "columns": [
                    { "data": "id" , "orderable": false, 'class' : 'text-center'},
                    { "data": "order_no" },
                    { "data": "project_name" },
                    { "data": "vendor_name" },
                    { "data": "nilai_po", 'class' : 'text-right' },
                    { "data": "nilai_asuransi", 'class' : 'text-right' },
                    { "data": "total_nilai_asuransi", 'class' : 'text-right' },
                    { "data": "created_at" },
                    { "data": "action" ,"orderable": false}
                ]
            });

            $('.dataTables_filter').hide();
            $('.dataTables_info').hide();

        },
        searchTable:function(){
            $('#search').on('click', function () {

                var filter = [{
                    order_no : $("#order_no").val(),
                    nm_project : $("#nm_project").val(),
                    vendor_name : $("#vendor_name").val(),
                }];

                //var email = $("#email").val();
                App.filter = filter[0];
                App.table.column(1).search(JSON.stringify(filter),true,true);
                App.table.draw();

            });
        },
        filter : [],
        resetSearch:function(){
            $('#reset').on( 'click', function () {
                $("#order_no").val('');
                $("#nm_project").val('');
                $("#vendor_name").val('');

                App.table.search( '' ).columns().search( '' ).draw();
            });
        },
	}
});
