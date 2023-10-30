define([
     "jQuery",
    "bootstrap",
    "datatables",
    "datatablesBootstrap",
    "sidebar",
    "select2",
    "jqvalidate",
    "bootstrapDatepicker",
    ], function (
    $,
    bootstrap,
    datatables,
    datatablesBootstrap,
    sidebar,
    select2,
    jqvalidate,
    bootstrapDatepicker,
    ) {
    return {
        table:null,
        init: function () {
            App.initFunc();
            App.initEvent();
            App.initConfirm();
            $(".loadingpage").hide();


        },
        initEvent : function(){
            $('*[data-datepicker="true"] input[type="text"]').datepicker({
                format: 'yyyy-mm-dd',
                orientation: "bottom center",
                autoclose: true,
                todayHighlight: true
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
                    "url": App.baseUrl + "asuransi/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id", 'class' : 'text-center' },
                    { "data": "no_contract" },
                    { "data": "vendor_name" },
                    { "data": "tgl_kontrak" },
                    { "data": "start_date" },
                    { "data": "end_date" },
                    { "data": "nilai_asuransi", 'class' : 'text-right' },
                    { "data": "action" ,"orderable": false}
                ]
            });

            if($("#form").length > 0){
                $("#form").validate({
                     rules: {
                        vendor_id: {
                            required: true
                        },
                        tgl_kontrak: {
                            required: true
                        },
                        no_contract: {
                            required: true
                        },
                        nilai_asuransi: {
                            required: true
                        },
                        start_date: {
                            required: true
                        },
                        end_date: {
                            required: true
                        },
                        jenis_asuransi: {
                            required: true
                        },
                        nilai_harga_minimum: {
                            required: true
                        },
                        tahun: {
                            required: true
                        },
                        no_cargo_insurance: {
                            required: true
                        },

                    },
                    messages: {
                        tgl_kontrak: {
                            required: "Tanggal Kontrak harus diisi"
                        },
                        vendor_id: {
                            required: "Vendor harus diisi"
                        },
                        no_contract: {
                            required: "No Kontrak harus diisi"
                        },
                        nilai_asuransi: {
                            required: "Nilai Asuransi harus diisi"
                        },
                        start_date: {
                            required: "Start date harus diisi"
                        },
                        end_date: {
                            required: "End date harus diisi"
                        },
                        jenis_asuransi: {
                            required: "jenis asuransi harus dipilih"
                        },
                        nilai_harga_minimum: {
                            required: "Nilai Harga Minimum harus diisi"
                        },
                        tahun: {
                            required: 'Tahun harus diisi'
                        },
                        no_cargo_insurance: {
                            required: "No Kargo Insurance harus diisi"
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
                        App.noFormattedNumber('#nilai_asuransi');
                        App.noFormattedNumber('#nilai_harga_minimum');
                        //return false;
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
                        App.table.ajax.reload(null,false);
                    });
                })
            });
        },
	}
});
