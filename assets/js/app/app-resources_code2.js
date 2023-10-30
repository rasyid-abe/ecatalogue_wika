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
            App.lvl1show();
            // App.initChart();
            // App.yearFilter();
            App.editData();
            App.checkAll();
            App.enableDelete();
            App.clearForm();
            $(".loadingpage").hide();
        },
        clearForm : function() {
            $('.show_modal').on('click', function() {
                $('#code').val('');
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
                $('.modal-content form').attr('action', App.baseUrl+"resources_code2/update");

                const id = $(this).data('id');
                $.ajax({
                    url: App.baseUrl+"resources_code2/edit",
                    data: {id:id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        $('#code_log').val(data.code);
                        $('#name').val(data.name);
                        $('#desc').val(data.description);
                        $('#id').val(data.resources_code_id);
                        if (data.sts_matgis > 1) {
                            $('#nonmatgis').prop('checked',true);
                        } else {
                            $('#matgis').prop('checked',true);
                        }
                    }

                })
            });
        },
        selectKategori : function(){
            $('.kategori_show').on('click', function() {
                $.ajax({
                    url: App.baseUrl+"resources_code2/get_kategori",
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        parent = '<option value="">- Pilih -</option>';
                        $.each(data, function(key, val){
                            parent += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        });
                        $('#parent').html(parent);
                    }
                })
            })
        },
        lvl1show : function(){
            $("#table").on("click", ".modalUbah", function() {
                const id = $(this).data('id');
                $.ajax({
                    url: App.baseUrl+"resources_code2/get_kategori_edit",
                    data: {id:id},
                    method: 'post',
                    dataType: 'json',
                    success: function(res) {
                        parent = '<option value="'+res.code+'">'+res.code +' - '+ res.name+'</option>';
                        // $.each(res.data, function(key, val){
                        //     if (res.code != val.code) {
                        //         parent += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        //     }
                        // });
                        $('#parent').html(parent).prop('disabled', true);
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
                        parent: {
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
                        parent: {
                            required: "Kategori Harus Diisi"
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
        // yearFilter : function(){
        //     $('#year_filter').on('change', function(){
        //         App.initChart($('#bulan_filter').val(), $(this).val());
        //     });
        //     $('#bulan_filter').on('change', function(){
        //         App.initChart($(this).val(), $('#year_filter').val());
        //     });
        // },
        initChart : function(bulan = null,tahun = null){
            console.log(tahun);
            if(tahun == null){
                tahun = new Date().getFullYear()
            }
            if(bulan == null)
            {
                bulan = new Date().getMonth();
            }
            if($('#salesMonth').length >0){
                $.ajax({
                    method: "GET",
                    url:  App.baseUrl+"forecast/getGraphCategory",
                    beforeSend : function(){
                        $('.loading').show();
                    },
                    data:{year_filter : tahun, bulan_filter : bulan}
                }).done(function( ret ) {

                    // $('#loading').hide();
                    data = JSON.parse(ret);
                    console.log(data.category);
                    if(data.category != null){
                        $('#chart-forecast').removeClass('hidden');
                        // console.log(data.category)
                        Highcharts.chart('salesMonth', {
                            chart: {
                                type: 'arearange',
                                zoomType: 'xy',
                            },
                            title: {
                                text: 'Forecast Kategori'
                            },
                            subtitle: {
                                text: 'Tahun '+tahun
                            },
                            credits: {
                                enabled: false
                            },
                            xAxis: {
                                categories: data.month
                            },
                            yAxis: {
                                title: {
                                    text: 'Sales (Rupiah)'
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><br>',
                                // pointFormat:  '{point.y:.2f} Rupiah',
                                crosshairs: true,
                                shared: true,
                            },
                            plotOptions: {
                                line: {
                                    enableMouseTracking: true
                                }
                            },
                            series: data.category
                        });

                    }
                });
            }

        },

    }
});
