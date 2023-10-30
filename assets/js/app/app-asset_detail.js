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
        init: function () {
            App.initFunc();
            App.initEvent();
            App.searchTable();
            App.resetSearch();
            App.initConfirm();
            App.setdate();
            $(".loadingpage").hide();
        },
        searchTable:function(){

            $('#search').on('click', function () {
                console.log("SEARCH");
                var vendor_type_id = $("#vendor_type_id").val();

                App.table.column(3).search(vendor_type_id,true,true);

                App.table.draw();

            });
        },
        resetSearch:function(){
            $('#reset').on( 'click', function () {
                $("#vendor_type_id").val('');

                App.table.search( '' ).columns().search( '' ).draw();
            });
        },
        initEvent : function(){

             $('*select[data-selectjs="true"]').select2({width: '100%'});

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
                    "url": App.baseUrl+"vendors/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "address" },
                    { "data": "email" },
                    // { "data": "nama_direktur" },
                    // { "data": "action" ,"orderable": false}
                ]
            });


            // //append button to datatables
            // add_btn = '<a href="'+App.baseUrl+'vendors/create" class="btn btn-sm btn-primary ml-2 mt-1"><i class="fa fa-plus"></i> Jabatan</a>';
            // $('#table_filter').append(add_btn);

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
                        address: {
                            required: true
                        },
                        start_contract: {
                            required: true
                        },
                        end_contract: {
                            required: true
                        },
                        no_contract: {
                            required: true
                        },
                        /*
                        is_margis:{
                          required : true
                        },
                        email_user: {
                            required: ($("#user_id").val().length > 0),
                        },

                        username: {
                            required: ($("#user_id").val().length > 0),
                        },
                        password: {
                            required: ($("#user_id").val().length > 0),
                            minlength: 8
                        },
                        password_confirm: {
                            required: ($("#user_id").val().length > 0),
                            minlength: 8,
                            equalTo: "#password"
                        },
                        */
                        department : {
                            required : false,
                        },
                        nama_direktur : {
                            required : false,
                        },
                        no_telp : {
                            required : false,
                        },
                        no_fax : {
                            required : false,
                        },
                    },
                    messages: {
                        name: {
                            required: "Nama Vendor Harus Diisi"
                        },
                        email: {
                            required: "Email Harus Diisi"
                        },
                        address: {
                            required: "Alamat Harus Diisi"
                        },
                        start_contract: {
                            required: "Tanggal Awal Harus Diisi"
                        },
                        end_contract: {
                            required: "Tanggal Akhir Harus Diisi"
                        },
                        no_contract: {
                            required: "Nomor Kontrak Harus Diisi"
                        },
                        /*
                        is_margis:
                        {
                            required: "Margis Harus Diisi"
                        },
                        email_user: {
                            required: "Email Harus Diisi"
                        },
                        */
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
                        department : {
                            required : "Departemen harus diisi",
                        },
                        nama_direktur : {
                            required : "Nama Direktur harus diisi",
                        },
                        no_telp : {
                            required : "No Telp harus diisi",
                        },
                        no_fax : {
                            required : "No Fax harus diis",
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
                        App.table.ajax.reload(null,true);
                    });
                })
            });
        },
        setdate : function(){
            $('*[data-datepicker="true"] input[type="text"]').datepicker({
                format: 'yyyy-mm-dd',
                orientation: "top center",
                autoclose: true,
                todayHighlight: true
            });
        },
	}
});
