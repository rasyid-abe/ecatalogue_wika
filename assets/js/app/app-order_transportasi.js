define([
     "jQuery",
    "bootstrap",
    "datatables",
    "datatablesBootstrap",
    "sidebar",
    "select2",
    ], function (
    $,
    bootstrap,
    datatables,
    datatablesBootstrap,
    sidebar,
    select2
    ) {
    return {
        table:null,
        init: function () {
            App.initFunc();
            App.initEvent();
            App.searchTable();
            App.resetSearch();
            $(".loadingpage").hide();
            $('[data-toggle="tooltip"]').tooltip();            
        },
        initEvent : function(){
            $('#form_set_order').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url : $(this).attr('action'),
                    data : $(this).serializeArray(),
                    type : 'POST',
                    dataType : 'json',
                    success : function(result)
                    {
                        if (result.status == false)
                        {
                            html = $('#alert-gagal');
                            $html = $(html.html());
                            $html.find('.message').html(result.message);
                            $('#for_notif').html($html);
                        }
                        else
                        {
                            html = $('#alert-sukses').html();
                            $('#for_notif').html(html);
                            App.table.ajax.reload(null,false);
                            setTimeout(function(){
                                $('#modal_nopol').modal('hide');
                            }, 500);
                        }
                    }
                });
            });

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
                    "url": App.baseUrl+"order_transportasi/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "order": [[9, 'desc']],
                "columns": [
                    { "data": "id" , "orderable": false, 'class' : 'text-center'},
                    { "data": "order_no" },
                    { "data": "project_name" },
                    { "data": "vendor_name" },
                    { "data": "origin_name" },
                    { "data": "destination_name" },
                    { "data": "total_weight", 'class' : 'text-right' },
                    { "data": "biaya_transport", 'class' : 'text-right' },
                    { "data": "total_biaya_transport", 'class' : 'text-right' },
                    { "data": "created_at" },
                    { "data": "action" ,"orderable": false}
                ]
            });

            $('.dataTables_filter').hide();
            $('.dataTables_info').hide();

            $('#table tbody').on( 'click','.set-nopol', function(){
                var nopol = $(this).attr('data-traller'),
                arrNopol = nopol.split(','),
                nopolInputed = $(this).attr('data-traller-inputed'),
                arrNopolInputed = nopolInputed.split(','),
                select = $('#data_traller');

                $('#order_id').val($(this).attr('data-orderid'));
                select.html('');

                $.each(arrNopol, function(key, value){
                    if (arrNopol.length == 1 && arrNopol[0] == '')
                    {
                        return false;
                    }

                    sel = '';
                    $.each(arrNopolInputed, function(k, v){
                        if (v.trim() == value.trim())
                        {
                            sel = 'selected';
                        }
                    });
                    select.append('<option value="' + value + '" ' + sel + '>' + value + '</option>');
                });

                select.select2({width:'100%'});
                $('#for_notif').html('');
                $('#modal_nopol').modal('show');
            })

        },
        searchTable:function(){
            $('#search').on('click', function () {

                var filter = [{
                    order_no : $("#order_no").val(),
                    nm_project : $("#nm_project").val(),
                    vendor_name : $("#vendor_name").val(),
                    location_origin_name : $("#location_origin_name").val(),
                    location_destination_name : $("#location_destination_name").val(),
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
                $("#location_origin_name").val('');
                $("#location_destination_name").val('');

                App.table.search( '' ).columns().search( '' ).draw();
            });
        },
	}
});
