define([
    "jQuery",
    "jqvalidate",
    "bootstrap",
    "sidebar",
    "datatables",
    "datatablesBootstrap",
    "bootstrapDatepicker",
    "highchart",
    "Handsontable",
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
    Handsontable,
    select2
    ) {
    return {
        table:null,
        req:false,
        init: function () {
            App.formSubmit();
            App.setdate();
            App.formUploadCsv();
            App.initEvent();
            App.btnSave();
            App.initChart();
            // App.getdatabtn();
            App.initHandson();
            $(".loading").hide();
        },
        initEvent : function()
        {
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
                    "url": App.baseUrl+"forecast/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" },
                    { "data": "created_at" },
                    { "data": "tipe_forecast" },
                    { "data": "detail" ,"orderable": false}
                ]
            });

            //table forecasst detail

            // App.table = $('#table-detail').DataTable({
            //     "language": {
            //         "search": "Cari",
            //         "lengthMenu": "Tampilkan _MENU_ baris per halaman",
            //         "zeroRecords": "Data tidak ditemukan",
            //         "info": "Menampilkan _START_  dari _END_ ",
            //         "infoEmpty": "Tidak ada data yang ditampilkan ",
            //         "infoFiltered": "(pencarian dari _MAX_ total records)",
            //         "paginate": {
            //             "first":      "Pertama",
            //             "last":       "Terakhir",
            //             "next":       "Selanjutnya",
            //             "previous":   "Sebelum"
            //         },
            //     },
            //     "processing": true,
            //     "serverSide": true,
            //     "searching": App.searchDatatable,
            //     "ajax":{
            //         "url": App.baseUrl+"forecast/dataListDetail/"+$('#product_forecast_id').val(),
            //         "dataType": "json",
            //         "type": "POST",
            //     },
            //     "columns": [
            //         { "data": "id" },
            //         { "data": "full_name" },
            //         { "data": "vendor_name" },
            //         { "data": "price", 'class' : 'text-right'}
            //     ]
            // });
        },
        formSubmit : function()
        {
            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                    rules: {
                        start_date: {
                            required: true
                        },
                        end_date: {
                            required: true
                        },
                        data_from:{
                          required : true
                        },
                        separator:{
                          required : true
                        },
                    },
                    messages: {
                        start_date: {
                            required: "Tanggal Awal Harus Diisi"
                        },
                        end_date: {
                            required: "Tanggal Akhir Harus Diisi"
                        },
                        data_from:
                        {
                            required: "Data Dari Harus Diisi"
                        },
                        separator:
                        {
                            required: "Separator Harus Diisi"
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
                        var data_from = $('#data_from_1').is(':checked') ? 1 : 0;
                        var separator = $('#separator_1').is(':checked') ? 1 : 0;
                        var url = App.baseUrl+'forecast/export_to_csv?start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val()+'&data_from='+data_from+'&separator='+separator;
                        // window.open(url);
                        var url = App.baseUrl+"forecast/getdata"
                        form_data = $("#form").serializeArray();
                        $.ajax({
                              method: "POST",
                              url: url,
                              data:form_data,
                            }).done(function(jqXHR, textStatus, errorThrown ) {
                                $('#hot').removeClass('hidden');
                                $('#btn-save').prop('disabled',false);
                                data = JSON.parse(jqXHR);
                                App.initHandson(data.data);
                            }).fail(function (jqXHR, textStatus, errorThrown) {
                                App.alert(errorThrown);
                            });

                    }
                });
            }
        },
        initHandson : function(forecast){
            console.log(forecast);
            console.log(typeof(forecast));
            ipValidatorRegexp = /^(?:\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b|null)$/;
            emailValidator = function (value, callback) {
              setTimeout(function(){
                if (/.+@.+/.test(value)) {
                  callback(true);
                }
                else {
                  callback(false);
                }
              }, 1000);
            };
            if($('#hot').length > 0){
                var container = document.getElementById('hot');
                var removeCommaAndDot = function(str)
                {
                    var rr = new String(str);
                    var r = rr.replace(/[ ,.]/g, '');
                    return isNaN(r) ? r : parseInt(r);
                    //return r;
                }

                var styleHeaderHot = function(headernya)
                {
                    return '<label style = "font-size: 12px">'+headernya+'</label>';
                }
                App.hot = new Handsontable(container, {
                    data: forecast,
                      columns: [
                        {data: 'product_id',readOnly:true},
                        {data: 'volume',readOnly:true},
                        {data: 'industrial_plant',type:'numeric',numericFormat:{pattern: '0,0'}},
                        {data: 'plant_energy',type:'numeric',numericFormat:{pattern: '0,0'}},
                        {data: 'luar_negeri',type:'numeric',numericFormat:{pattern: '0,0'}},
                        {data: 'sipil1',type:'numeric',numericFormat:{pattern: '0,0'}},
                        {data: 'sipil2',type:'numeric',numericFormat:{pattern: '0,0'}},
                        {data: 'sipil3',type:'numeric',numericFormat:{pattern: '0,0'}},
                        {data: 'total',type:'numeric',readOnly:true,numericFormat:{pattern: '0,0',culture:'en_US'}},
                        {data: 'satuan',readOnly:true},
                      ],
                    dataSchema: {product_id:null,volume: null, industrial_plant: 0, plant_energy: 0, luar_negeri: 0,sipil1: 0, sipil2: 0, sipil3:0, total: 0, satuan:null},
                    colHeaders: [styleHeaderHot('ID<br>PRODUCT'),styleHeaderHot('VOLUME'),styleHeaderHot('INDUSTRIAL<br>PLANT'), styleHeaderHot('PLANT & <br>ENERGY'), styleHeaderHot('LUAR<br>NEGERI'),styleHeaderHot('SIPIL<br>UMUM 1'), styleHeaderHot('SIPIL<br>UMUM 2'),styleHeaderHot('SIPIL<br>UMUM 3'),styleHeaderHot('TOTAL'),styleHeaderHot('SATUAN')],
                    minRows: 1,
                    rowHeaders: true,

                    autoColumnSize: true,
                    //colWidths: [20,120, 40, 40, 40, 40, 40, 40, 40,30],
                    contextMenu: true,
                    allowInsertColumn : true,
                    manualColumnMove: false,
                    manualRowMove: true,
                    manualColumnResize: true,
                    manualRowResize: true,
                    sortIndicator: true,
                    columnSorting: true,
                    //width: 1080,
                    height: 320,
                    stretchH: "all",
                    beforeChange : function(changes, source)
                    {
                        //console.log(source);
                        //console.log(changes);
                         for (var i = changes.length - 1; i >= 0; i--) {
                             if(source == 'CopyPaste.paste')
                             changes[i][3] = removeCommaAndDot(changes[i][3]);
                         }

                    },
                    afterChange: function(c,s){
                        if(!c) {
                            return;
                        }
                        $.each(c, function(i, element) {
                            var row = element[0];
                            var col = element[1];
                            var oldVal = element[2];
                            var newVal = element[3];
                            //console.log(element);
                            if(col == 'industrial_plant' || col == 'plant_energy' || col == 'luar_negeri' || col == 'sipil1'|| col == 'sipil2'|| col == 'sipil3'){

                                if(forecast[row]['industrial_plant'] == undefined || ! Number.isInteger(forecast[row]['industrial_plant']) ){
                                    forecast[row]['industrial_plant'] = 0;
                                }
                                if(forecast[row]['plant_energy'] == undefined || ! Number.isInteger(forecast[row]['plant_energy'])){
                                    forecast[row]['plant_energy'] = 0;
                                }
                                if(forecast[row]['luar_negeri'] == undefined || ! Number.isInteger(forecast[row]['luar_negeri'])){
                                    forecast[row]['luar_negeri'] = 0;
                                }
                                if(forecast[row]['sipil1'] == undefined || ! Number.isInteger(forecast[row]['sipil1'])){
                                    forecast[row]['sipil1'] = 0;
                                }
                                if(forecast[row]['sipil2'] == undefined || ! Number.isInteger(forecast[row]['sipil2'])){
                                    forecast[row]['sipil2'] = 0;
                                }
                                if(forecast[row]['sipil3'] == undefined || ! Number.isInteger(forecast[row]['sipil3'])){
                                    forecast[row]['sipil3'] = 0;
                                }
                                var total = forecast[row]['industrial_plant']+forecast[row]['plant_energy']+forecast[row]['luar_negeri']+forecast[row]['sipil1']+forecast[row]['sipil2']+forecast[row]['sipil3'];
                                forecast[row]['total'] = total;
                                App.hot.loadData(forecast);
                            }
                        });
                    }
                });
            }

        },
        btnSave :function(){
            $('#btn-save').on( 'click', function () {
                App.confirm('Simpan?',function(){
                    getdata = App.hot.getData();
                    product_id = new Array();
                    volume = new Array();
                    industrial_plant = new Array();
                    plant_energy = new Array();
                    luar_negeri = new Array();
                    sipil1 = new Array();
                    sipil2 = new Array();
                    sipil3 = new Array();
                    total = new Array();
                    satuan = new Array();
                    for(var i=0; i< getdata.length;i++){
                        product_id[i] = getdata[i][0];
                        volume[i] = getdata[i][1];
                        industrial_plant[i] = getdata[i][2];
                        plant_energy[i] = getdata[i][3];
                        luar_negeri[i] = getdata[i][4];
                        sipil1[i] = getdata[i][5];
                        sipil2[i] = getdata[i][6];
                        sipil3[i] = getdata[i][7];
                        total[i] = getdata[i][8];
                        satuan[i] = getdata[i][9];
                    }
                    var data_from = $('#data_from_1').is(':checked') ? 1 : 0;
                    $.ajax({
                      method: "POST",
                      url: App.baseUrl+"forecast/insert_handsone/",
                      data: {
                        product_id:product_id,
                        volume:volume,
                        industrial_plant:industrial_plant,
                        plant_energy:plant_energy,
                        luar_negeri:luar_negeri,
                        sipil1:sipil1,
                        sipil2:sipil2,
                        sipil3:sipil3,
                        total:total,
                        satuan:satuan,
                        start_date:$('#start_date').val(),
                        end_date:$('#end_date').val(),
                        data_from:data_from,
                      },
                      beforeSend:function(){
                        $('.loadingpage').show();
                      },
                      success:function(jqXHR){
                        $('.loadingpage').hide();
                        data = JSON.parse(jqXHR);
                        if(data.status ==true){
                            window.location.replace(App.baseUrl+"forecast?status=true&message="+data.message+"");
                        }else{
                            window.location.replace(App.baseUrl+"forecast?status=false&message="+data.message+"");
                        }
                      }
                    }).done(function( msg ) {
                        $('.loadingpage').hide();
                        //App.table.ajax.reload(null,true);
                    });
                });
            });
        },
        initChart : function(){
            if ($('#container').length >0) {
                data = JSON.parse($('#chartdata').val())
                console.log(data.valuex[0].data);
                Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Forecast '
                    },
                    xAxis: {
                        categories: data.product,
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Harga'
                        },
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontWeight: 'bold',
                                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                            }
                        }
                    },
                    legend: {
                        align: 'right',
                        x: -30,
                        verticalAlign: 'top',
                        y: 25,
                        floating: true,
                        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                        borderColor: '#CCC',
                        borderWidth: 1,
                        shadow: false
                    },
                    tooltip: {
                        headerFormat: '<b>{point.x}</b><br/>',
                        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal',
                            dataLabels: {
                                enabled: true,
                                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                            }
                        }
                    },
                    series: [
                        {
                            name: data.valuex[0].name,
                            data: data.valuex[0].data,
                        },
                        {
                            name: data.valuex[1].name,
                            data: data.valuex[1].data,
                        },
                        {
                            name: data.valuex[2].name,
                            data: data.valuex[2].data,
                        },
                        {
                            name: data.valuex[3].name,
                            data: data.valuex[3].data,
                        },
                        {
                            name: data.valuex[4].name,
                            data: data.valuex[4].data,
                        },
                        {
                            name: data.valuex[5].name,
                            data: data.valuex[5].data,
                        },
                    ]
                });
            }
        },
        setdate : function(){
            $('*[data-datepicker="true"] input[type="text"]').datepicker({
                format: 'yyyy-mm-dd',
                orientation: "bottom center",
                autoclose: true,
                todayHighlight: true
            });
        },

        formUploadCsv : function()
        {
            if($("#form-import-csv").length > 0){
                $("#form-import-csv").validate({
                    rules: {
                        csv_file: {
                            required: true
                        },
                    },
                    messages: {
                        csv_file: {
                            required: "File Harus Diisi"
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
                        var form_data = new FormData($('#form-import-csv')[0]);
                        $.ajax({
                            url : App.baseUrl+'forecast/import_act',
                            dataType : 'json',
                            data : form_data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            method : "POST",
                        }).done(function(data, textStatus, errorThrown ) {
                            // data = JSON.parse(data);

                            if(data.status == true){
                                // App.alert(data.messages);
                                // $(".loadingpage").hide();
                                //window.location.href =App.baseUrl+"finishorder/generatepdf/"+data.data['order_no'];
                                $('#modalimport').modal('show');
                                $('#title').html(data.message);
                                $('#container-error').html('');
                            }else{
                                $(".loadingpage").hide();
                                $('#modalimport').modal('show');
                                $('#title').html(data.message);
                                $('#container-error').html(data.data.join('<br>'));
                            }
                        }).fail(function (data, textStatus, errorThrown) {
                                $(".loadingpage").hide();

                            App.alert(errorThrown);
                        });
                    }
                });
            }
        }

    }
});
