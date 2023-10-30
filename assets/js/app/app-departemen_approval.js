define([
     "jQuery",
    "bootstrap",
    "datatables",
    "datatablesBootstrap",
    "sidebar",
    "select2",
    "jqvalidate",
    ], function (
    $,
    bootstrap,
    datatables,
    datatablesBootstrap,
    sidebar,
    select2,
    jqvalidate,
    ) {
    return {
        table:null,
        init: function () {
            App.initEvent();
            $(".loadingpage").hide();
        },
        update_label_approval : function(){
            var elem_role = $('.role-list');
            if (elem_role.length == 0)
            {
                return false;
            }
            console.log(elem_role);
            var hit = 1;
            $.each(elem_role, function(key, value){
                $(this).find('.approval-label').html('Approval Ke ' + hit);

                hit++;
            })
        },
        initEvent : function(){

            $('#btn-tambah-role').on('click', function(){
                var elem_role = $('.role-list');
                var count = elem_role.length;
                var template = $('#dropdown_roles').html();
                var after;
                if(count == 0)
                {
                    after = $(this).parent().parent();
                }
                else
                {
                    after = elem_role.last();
                }

                $(template).insertAfter(after);

                $('*select[data-selectjs="true"]').select2({width: '100%'});
                App.update_label_approval();
            });            

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
                    "url": App.baseUrl+"departemen_approval/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "order": [[ 1 , "asc" ]],
                "columns": [
                    { "data": "id", "class" : "text-center" },
                    { "data": "departemen_name" },
                    { "data": "action" ,"orderable": false}
                ]
            });

            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                     rules: {
                        departemen_id: {
                            required: true
                        },
                        role_id: {
                            required: true
                        },
                        sequence : {
                            required : true
                        }
                    },
                    messages: {
                        departemen_id: {
                            required: "Departemen harus diisi"
                        },
                        role_id: {
                            required: "Role harus diisi"
                        },
                        sequence : {
                            required : "Urutan harus diisi"
                        }
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
