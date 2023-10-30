define([
    "jQuery",
    "jQueryUI",
    "jqvalidate",
    "bootstrap",
    "sidebar",
    "datatables",
    "select2",
    "datatablesBootstrap",
    ], function (
    $,
    jQueryUI,
    jqvalidate,
    bootstrap,
    sidebar ,
    datatables,
    select2,
    datatablesBootstrap
    ) {
    return {
        table:null,
        init: function () {
            App.initFunc();
            App.initEvent();
            App.initConfirm();
            App.initPlugin();
            $(".loadingpage").hide();
        },
        initPlugin : function(){
             $('*select[data-selectjs="true"]').select2({width: '100%'});
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
                    "url": App.baseUrl+"payment_method/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" },
                    { "data": "day" },
                    { "data": "description" },
                    { "data": "action" ,"orderable": false}
                ]
            });

            // //append button to datatables
            // add_btn = '<a href="'+App.baseUrl+'payment_method/create" class="btn btn-sm btn-primary ml-2 mt-1"><i class="fa fa-plus"></i> Jabatan</a>';
            // $('#table_filter').append(add_btn);

            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                    rules: {
                        day: {
                            required: true
                        },
                        enum_payment_method_id: {
                            required: true
                        },

                    },
                    messages: {
                        day: {
                            required: "Nama Metode Pembayaran Harus Diisi"
                        },
                        enum_payment_method_id: {
                            required: "Metode Pembayaran Harus Diisi"
                        },
                    },
                    debug:true,

                    errorPlacement: function(error, element) {
                        var name = element.attr('name');
                        var errorSelector = '.form-control-feedback[for="' + name + '"]';
                        var $element = $(errorSelector);
                        if ($element.length) {
                            $(errorSelector).html(error.html());
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler : function(form) {
                        form.submit();
                    }
                });
            }

        },
        initConfirm :function(){
            $('#table tbody').on( 'click', '.delete', function () {
                var url = $(this).attr("url");
                App.confirm("Apakah Anda Yakin Untuk Mengubah Ini?",function(){
                   $.ajax({
                      method: "GET",
                      url: url
                    }).done(function( msg ) {
                        $(".loadingpage").show();
                        App.table.ajax.reload();
                        setTimeout(function(){
                        $('.loadingpage').hide();
                        }, 500);
                    });
                })
            });
        }
	}
});
