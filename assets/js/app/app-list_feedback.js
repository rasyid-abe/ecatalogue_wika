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
            $(".loadingpage").hide();
            App.initConfirm();
        },
        initConfirm :function(){

            $('#table tbody').on( 'click', '.detail-feedback', function () {
                $('#detail-list-feedback').find('.modal-body').html($(this).attr('data-isi-feedback'));
                $('#detail-list-feedback').modal('show');
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
                "ajax":{
                    "url": App.baseUrl+"list_feedback/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "order": [[ 4, "desc" ]],
                "columns": [
                    { "data": "id", "class" : "text-center"  },
                    { "data": "role_name" },
                    { "data": "nama_user" },
                    { "data": "kategori_name" },
                    { "data": "created_at" },
                    { "data": "action" , "orderable"  : false },
                ]
            });


            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                     rules: {
                        kategori_feedback_id: {
                            required: true
                        },
                        isi_feedback: {
                            required: true
                        },
                    },
                    messages: {
                        kategori_feedback_id: {
                            required: "Kategori feedback harus diisi"
                        },
                        isi_feedback: {
                            required: "Isi feedback harus diisi"
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
