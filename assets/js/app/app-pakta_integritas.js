define([
     "jQuery",
    "bootstrap",
    "datatables",
    "datatablesBootstrap",
    "sidebar",
    "jqvalidate",
    "select2",
    ], function (
    $,
    bootstrap,
    datatables,
    datatablesBootstrap,
    sidebar,
    jqvalidate,
    select2,
    ) {
    return {
        table:null,
        init: function () {
            App.initEvent();
            App.initConfirm();
            $(".loadingpage").hide();
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
        },
        initEvent : function(){
            $('*select[data-selectjs="true"]').select2({width: '100%'});

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
                    "url": App.baseUrl+"pakta_integritas/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id", "class" : "text-center" },
                    { "data": "role_name" },
                    { "data": "description" },
                    { "data": "action" ,"orderable": false}
                ]
            });

            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                     rules: {
                        role_id: {
                            required: true
                        },
                        description: {
                            required: true
                        },
                    },
                    messages: {
                        role_id: {
                            required: "Role harus diisi"
                        },
                        description: {
                            required: "Deskripsi harus diisi"
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
	}
});
