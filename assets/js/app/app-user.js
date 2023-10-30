define([
     "jQuery",
    "jQueryUI",
    "bootstrap",
    "bootstrapDatepicker",
    "datatables",
    "datatablesBootstrap",
    "sidebar",
    "jqvalidate",
    "select2"
    ], function (
    $,
    jQueryUI,
    bootstrap,
    datatables,
    bootstrapDatepicker,
    datatablesBootstrap,
    jqvalidate,
    sidebar,
    select2,
    ) {
    return {
        table:null,
        init: function () {
            App.initFunc();
            App.initEvent();
            App.initConfirm();

            App.searchTable();
            App.resetSearch();
            App.roleChange();

            $(".dataTables_filter").hide();
            $(".loadingpage").hide();
        },
        roleChange : function(){
            if($('#role_id').val() == 4){
                $('#departemen-cont').removeClass('hidden');
                $('#departemen').prop('required',true);
            }else{
                $('#departemen').prop('required',false);
                $('#departemen').val('').trigger('change');
                $('#departemen-cont').addClass('hidden');
            }
            $('#role_id').on('change', function(){
                if($(this).val() == 4){
                    $('#departemen-cont').removeClass('hidden');
                    $('#departemen').prop('required',true);
                }else{
                    $('#departemen').prop('required',false);
                    $('#departemen').val('').trigger('change');
                    $('#departemen-cont').addClass('hidden');
                }
            });
        },
        initEvent : function(){

            $('*select[data-selectjs="true"]').select2({width: '100%'});


            //$('.select2').select2();
            $('#datepicker').datepicker({
                defaultViewDate: '01/01/1990',
                uiLibrary: 'bootstrap4',
                format: 'dd/mm/yyyy',
            });
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
                    "url": App.baseUrl+"user/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" },
                    { "data": "role_name" },
                    { "data": "name" },
                    { "data": "phone" },
                    { "data": "email" },
                    { "data": "username" },
                    { "data": "action" ,"orderable": false}
                ]
            });

            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                     rules: {
                        name: {
                            required: true
                        },
                        email: {
                            required: true
                        },
                        kode_kab: {
                            required: true
                        },
                        username: {
                            required: true,
                        },
                        password: {
                            required: true,
                            //minlength: 8
                        },
                        password_confirm: {
                            required: true,
                            //minlength: 8,
                            equalTo: "#password"
                        },
                        role_id: {
                             required: true,
                        }
                    },
                    messages: {
                        name: {
                            required: "Nama Harus Diisi"
                        },
                        email: {
                            required: "Email Harus Diisi"
                        },
                        nip: {
                            required: "NIP Harus Diisi"
                        },
                        kode_kab: {
                            required: "Kabupaten harus dipilih"
                        },
                        username: {
                            required: "Username Harus Diisi"
                        },
                        password: {
                            required: "Password Harus Diisi",
                            minlength: "Minimal 8 "
                        },
                        password_confirm: {
                            required: "Ulangi Password Harus Diisi",
                            minlength: "Minimal 8 ",
                            equalTo: "Password Tidak Sama"
                        },
                        role_id: {
                            required: "Role Harus Diisi"
                        },
                        departemen: {
                            required: "Departemen Harus Diisi"
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

        searchTable:function(){
            $('#search').on('click', function () {
                console.log("SEARCH");
                var name = $("#name").val();
                var company_field = $("#company").val();
                var phone = $("#phone").val();
                var email = $("#email").val();
                var role_id = $("#role_id").val();
                var group_id = $("#group_id").val();

                App.table.column(1).search(role_id,true,true);
                App.table.column(2).search(group_id,true,true);
                App.table.column(3).search(name,true,true);
                App.table.column(4).search(phone,true,true);
                App.table.column(5).search(email,true,true);

                App.table.draw();

            });
        },
        resetSearch:function(){
            $('#reset').on( 'click', function () {
                $("#name").val("");
                $("#company").val("");
                $("#handphone").val("");
                $("#email").val("");
                $("#role_id").val('').trigger('change');
                $("#group_id").val('').trigger('change');

                App.table.search( '' ).columns().search( '' ).draw();
            });
        },

        initConfirm :function(){
            $('#table tbody').on( 'click', '.delete', function () {
                var url = $(this).attr("url");
                App.confirm("Apakah Anda Yakin Untuk Mengubah Ini?",function(){
                   $.ajax({
                      method: "GET",
                      url: url
                    }).done(function( msg ) {
                        App.table.ajax.reload(null,false);
                    });
                })
            });
        }
	}
});
