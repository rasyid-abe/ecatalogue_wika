define([
    "jQuery",
    "jqvalidate",
    "bootstrap",
    "sidebar",
    "datatables",
    "datatablesBootstrap",
    "bootstrapDatepicker",
    "highchart",
    "highchartmore",
    "select2",
], function (
    $,
    jqvalidate,
    bootstrap,
    sidebar ,
    datatables,
    datatablesBootstrap,
    bootstrapDatepicker,
    highchart,
    highchartmore,
    select2
) {
    return {
        table:null,
        req:false,
        init: function () {
            App.initFunc();
            App.formSubmit();
            App.initEvent();
            App.selectKategori();
            App.selectJenis();
            App.selectLevel3();
            App.editData();
            App.checkAll();
            App.enableDelete();
            App.jenisShow();
            App.clearForm();
            $(".loadingpage").hide();
        },
        clearForm : function() {
            $('.show_modal').on('click', function() {
                $('#kategori').val('');
                $('#jenis').html('<option value="">- Pilih -</option>').prop('disabled', true);
                $('#level3').html('<option value="">- Pilih -</option>').prop('disabled', true);
                $('#name').val('');
                $('#desc').val('');
                $('#id').val('');
                $('#nonmatgis').prop('checked',false);
                $('#matgis').prop('checked',false);
            })
        },
        editData : function() {
            $("#table").on("click", ".modalUbah", function() {
                $('#judulModalLabel').html('Form Ubah')
                $('.modal-footer button[type=submit]').html('Ubah Data');
                $('.modal-content form').attr('action', App.baseUrl+"resources_code4/update");

                const id = $(this).data('id');
                $.ajax({
                    url: App.baseUrl+"resources_code4/edit",
                    data: {id:id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        $('#code_log').val(data.code);
                        $('#name').val(data.name);
                        $('#desc').val(data.description);
                        // $('.kategori select').val(kategori);
                        $('#id').val(data.resources_code_id);
                    }
                })
            });
        },
        selectKategori : function(){
            $('.kategori_show').on('click', function() {
                $.ajax({
                    url: App.baseUrl+"resources_code4/get_kategori",
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        kategori = '<option value="">- Pilih -</option>';
                        $.each(data, function(key, val){
                            kategori += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        });
                        $('#kategori').html(kategori);
                    }
                })
            })
        },
        selectJenis : function(){
            $('#kategori').on('change', function() {
                let kategori = $('#kategori').val();
                $.ajax({
                    url: App.baseUrl+"resources_code4/get_jenis",
                    data: {kategori:kategori},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        jenis = '<option value="">- Pilih -</option>';
                        $.each(data, function(key, val){
                            jenis += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        });
                        $('#jenis').html(jenis).removeAttr( 'disabled' );
                        $('#level3').html('<option value="">Pilih</option>').prop('disabled', true);
                    }
                })
            })
        },
        selectLevel3 : function(){
            $('#jenis').on('change', function() {
                let jenis = $('#jenis').val();
                $.ajax({
                    url: App.baseUrl+"resources_code4/get_level3",
                    data: {jenis:jenis},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        level3 = '<option value="">- Pilih -</option>';
                        $.each(data, function(key, val){
                            level3 += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        });
                        $('#level3').html(level3).removeAttr( 'disabled' );
                    }
                })
            })
        },
        jenisShow : function(){
            $("#table").on("click", ".jenis_show", function() {
                const id = $(this).data('id');
                $.ajax({
                    url: App.baseUrl+"resources_code4/get_jenis_edit",
                    data: {id:id},
                    method: 'post',
                    dataType: 'json',
                    success: function(res) {
                        jenis = '<option value="'+res.code+'">'+res.code +' - '+ res.name+'</option>';
                        // $.each(res.data, function(key, val){
                        //     if (res.code != val.code) {
                        //         jenis += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        //     }
                        // });
                        $('#jenis').html(jenis).prop('disabled', true);
                    }
                })

                $.ajax({
                    url: App.baseUrl+"resources_code4/get_level1_edit",
                    data: {id:id},
                    method: 'post',
                    dataType: 'json',
                    success: function(res) {
                        kategori = '<option value="'+res.code+'">'+res.code +' - '+ res.name+'</option>';
                        // $.each(res.data, function(key, val){
                        //     if (res.code != val.code) {
                        //         kategori += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        //     }
                        // });
                        $('#kategori').html(kategori).prop('disabled', true);;
                    }
                })

                $.ajax({
                    url: App.baseUrl+"resources_code4/get_level3_edit",
                    data: {id:id},
                    method: 'post',
                    dataType: 'json',
                    success: function(res) {
                        level3 = '<option value="'+res.code+'">'+res.code +' - '+ res.name+'</option>';
                        // $.each(res.data, function(key, val){
                        //     if (res.code != val.code) {
                        //         level3 += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        //     }
                        // });
                        $('#level3').html(level3).prop('disabled', true);
                    }
                })
            })
        },
        enableDelete : function(){
            $('#btnHapus').on('click', function() {
                if ($('input[name="idsData[]"]:checked').length > 0) {
                    return confirm('Anda yakin menghapus data yang dipilih?');
                } else {
                    alert('Anda belum memilih data untuk dihapus.')
                    return false;
                }
            })
            $('#btnReject').on('click', function() {
                if ($('input[name="idsData[]"]:checked').length > 0) {
                    return confirm('Anda yakin reject data yang dipilih?');
                } else {
                    alert('Anda belum memilih data untuk di-reject.')
                    return false;
                }
            })
            $('#btnApprove').on('click', function() {
                if ($('input[name="idsData[]"]:checked').length > 0) {
                    return confirm('Anda yakin approve data yang dipilih?');
                } else {
                    alert('Anda belum memilih data untuk di-approve.')
                    return false;
                }
            })
        },
        checkAll : function(){
            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        },
        initEvent : function()
        {
            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_  sampai _END_ dari _MAX_ data",
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
                "serverSide": false,
                "searching": true,
                // "paging": true,
                "columnDefs": [
                    { "orderable": false, "targets": [0,1] },
                ],
                "order": [[2, 'desc']],
            });

        },
        formSubmit : function()
        {
            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                    rules: {
                        code: {
                            required: true
                        },
                        name: {
                            required: true
                        },
                        kategori: {
                            required: true
                        },
                        jenis: {
                            required: true
                        },
                        level3: {
                            required: true
                        },
                        // desc: {
                        //     required: true
                        // },
                    },
                    messages: {
                        code: {
                            required: "Kode Harus Diisi"
                        },
                        name: {
                            required: "Nama Harus Diisi"
                        },
                        kategori: {
                            required: "Kategori Harus Diisi"
                        },
                        jenis: {
                            required: "Kategori Harus Diisi"
                        },
                        level3: {
                            required: "Level 3 Harus Diisi"
                        },
                        // desc: {
                        //     required: "Deskripsi Harus Diisi"
                        // },
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
                        var val;
                        function restoreMoneyValueFloatFromStr(str)
                        {
                            // fungsi ini utk mengembalikan string dari format money standar ke nilai float
                            // nilai float dengan saparator decimal titik biar php/javascript bisa parsing
                            var rr = new String(str);
                            var r = rr.replace(/ /g, '');
                            r = r.replace(/\./g, '');
                            r = r.replace(/,/, '#');
                            r = r.replace(/,/g, '');
                            r = r.replace(/#/, '.');
                            return r;
                        }

                        $('input[name^="harga_periode"]').each(function() {
                            val = restoreMoneyValueFloatFromStr($(this).val());
                            $(this).val(val);
                            //alert(restoreMoneyValueFloatFromStr($(this).val()));
                        });
                        $('input[name^="harga_periode_upper"]').each(function() {
                            val = restoreMoneyValueFloatFromStr($(this).val());
                            $(this).val(val);
                            //alert(restoreMoneyValueFloatFromStr($(this).val()));
                        });

                        var val = restoreMoneyValueFloatFromStr($('#price').val());
                        $('#price').val(val);

                        var val2 = restoreMoneyValueFloatFromStr($('#price_upper').val());
                        $('#price_upper').val(val2);
                        //return;

                        form.submit();

                    }
                });
            }
            if($("#formimp").length > 0){

                $("#save-btn").removeAttr("disabled");
                $("#formimp").validate({
                    rules: {
                        ImportExcel:{
                            required : true
                        },
                    },
                    messages: {
                        ImportExcel:
                        {
                            required: "Import Excel Harus Dipilih"
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
                        var val;
                        function restoreMoneyValueFloatFromStr(str)
                        {
                            // fungsi ini utk mengembalikan string dari format money standar ke nilai float
                            // nilai float dengan saparator decimal titik biar php/javascript bisa parsing
                            var rr = new String(str);
                            var r = rr.replace(/ /g, '');
                            r = r.replace(/\./g, '');
                            r = r.replace(/,/, '#');
                            r = r.replace(/,/g, '');
                            r = r.replace(/#/, '.');
                            return r;
                        }

                        $('input[name^="harga_periode"]').each(function() {
                            val = restoreMoneyValueFloatFromStr($(this).val());
                            $(this).val(val);
                            //alert(restoreMoneyValueFloatFromStr($(this).val()));
                        });
                        $('input[name^="harga_periode_upper"]').each(function() {
                            val = restoreMoneyValueFloatFromStr($(this).val());
                            $(this).val(val);
                            //alert(restoreMoneyValueFloatFromStr($(this).val()));
                        });

                        var val = restoreMoneyValueFloatFromStr($('#price').val());
                        $('#price').val(val);

                        var val2 = restoreMoneyValueFloatFromStr($('#price_upper').val());
                        $('#price_upper').val(val2);
                        //return;

                        form.submit();

                    }
                });
            }
        },
    }
});
