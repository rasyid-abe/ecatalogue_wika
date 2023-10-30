define([
    "jQuery",
    "jQueryUI",
	"bootstrap",
    "highchart",
    "sidebar",
    "datatables",
    "datatablesBootstrap",
	], function (
    $,
    jQueryUI,
	bootstrap,
    highchart,
    sidebar ,
    datatables,
    datatablesBootstrap
	) {
    return {
        table:null,
        init: function () {
        	App.initFunc();
            App.initEvent();
            console.log("LOADED");

            $('#example1 tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );

            var table1 = $('#example1').DataTable();
             // Apply the search
            table1.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            $('#example2 tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );
            var table2 = $('#example2').DataTable();
             // Apply the search
            table2.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            var table3 = $('#example3').DataTable();
            $('#example3 tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );
             // Apply the search
            table3.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            $(".loadingpage").hide();
		},
        initWikaChart : function(tahun = null)
        {
            if(tahun == null)
            {
                tahun = new Date().getFullYear()
            }
            var vendor_index, nama_vendor, category_id = 72;
            $.ajax({
                url : App.baseUrl+'dashboard/get_monev_chart/' + tahun + '/' + category_id,
                type : 'GET',
                dataType : 'json',
                success : function(result)
                {
                    vendor_index = result.vendor_index;
                    Highcharts.chart('wikachart', {
                        chart: {
                            type: 'bar',
                            //marginLeft: 50,
                            marginBottom: 90,
                            zoomType: 'y'
                            //width : 500,
                        },
                        title: {
                            text: 'AF - BAJA TULANGAN BETON / BESI BETON / REBAR ATAU REINFORCING BAR - KHR & SUS'
                        },
                        legend: {
                            enabled: false
                        },
                        xAxis: {
                            categories: result.categories,
                        },
                        yAxis : {
                            title: {
                                text: 'Volume'
                            },
                            labels: {
                                //format: 'Rp. {value}'
                                formatter : function ()
                                {
                                    return App.toRp(this.value) + ' Kg '
                                },
                            }
                            // min: 0,
                        },
                        tooltip : {
                            shared: true,
                            formatter : function(){
                                var ret = '';
                                var ar = this.points;
                                $.each(ar, function(key, val){
                                    ret += val.key + ' : <b>' + App.toRp(val.y) + '</b><br>'
                                });
                                // if (ret > 0) {
                                    // console.log(ret);
                                    return ret;
                                // }
                            }
                        },

                        plotOptions: {
                            series: {
                                stacking: 'normal',
                                point: {
                                    events : {
                                        click : function(e){
                                            var vendor_id = vendor_index[e.point.index];
                                            nama_vendor = result.categories[e.point.index];
                                            modal_po_vendor(vendor_id)
                                        },
                                    },
                                },
                            },
                        },
                        series: result.series,
                    });
                }
            })

            var modal_po_vendor = function(vendor_id)
            {
                $('#modal_po_vendor').modal('show');
                $('#modal_po_vendor').find('.judul').html('' + nama_vendor + ' Tahun ' + tahun);
                $('#modal_po_vendor')
                .find('.table-modal tbody')
                .html('<tr><td colspan="4" align="center"><i class="fa fa-spin fa-spinner"></i>Loading</td></tr>')
                .load(App.baseUrl + 'dashboard/detail_penyerapan_vendor/' + vendor_id + '/' + tahun + '/' + category_id);
            }
        },
        initProductChart : function(tahun = null)
        {
            if(tahun == null)
            {
                tahun = new Date().getFullYear()
            }
            var vendor_index, bulan_index, nama_product;
            $.ajax({
                url : App.baseUrl+'dashboard/get_total_penjualan_product/' + tahun,
                type : 'GET',
                dataType : 'json',
                success : function(result)
                {
                    vendor_index = result.vendor_index;
                    bulan_index = result.bulan_index;
                    Highcharts.chart('productchart', {
                        chart: {
                            type: 'bar',
                        },
                        title: {
                            text: '',
                            align : 'left',
                            style : { "color": "#333333", "fontSize": "10px" },
                            margin : 1,
                        },
                        xAxis: {
                            categories: result.category,
                        },
                        yAxis: {
                            min: 0,
                        },
                        legend: {
                            reversed: true,
                            verticalAlign : 'top',
                            align : 'left',
                            padding : 4,
                            title : {
                                text : 'Month'
                            }
                        },
                        plotOptions: {
                            series: {
                                stacking: 'normal',
                                point: {
                                    events : {
                                        click : function(e){
                                            var vendor_id = vendor_index[e.point.index];
                                            bulan = bulan_index[e.point.color];
                                            nama_product = result.category[e.point.index];
                                            modal_po_vendor(vendor_id, bulan)
                                        },
                                    },
                                },
                            },
                        },
                        series: result.series
                    });
                }
            });

            var modal_po_vendor = function(vendor_id, bulan)
            {
                $('#modal_po_vendor').modal('show');
                $('#modal_po_vendor').find('.judul').html('' + nama_product + ' Bulan ' + App.nama_bulan(bulan - 1) + ' Tahun ' + tahun);
                $('#modal_po_vendor')
                .find('.table-modal tbody')
                .html('<tr><td colspan="4" align="center"><i class="fa fa-spin fa-spinner"></i>Loading</td></tr>')
                .load(App.baseUrl + 'dashboard/detail_po_product/' + vendor_id + '/' + bulan + '/' + tahun);
            }
        },
        initVendorChart : function(tahun = null)
        {
            if(tahun == null)
            {
                tahun = new Date().getFullYear()
            }
            var vendor_index, bulan_index, nama_vendor;
            $.ajax({
                url : App.baseUrl+'dashboard/get_total_penjualan_vendor/' + tahun,
                type : 'GET',
                dataType : 'json',
                success : function(result)
                {
                    vendor_index = result.vendor_index;
                    bulan_index = result.bulan_index;
                    Highcharts.chart('vendorchart', {
                        chart: {
                            type: 'bar',
                        },
                        title: {
                            text: '',
                            align : 'left',
                            style : { "color": "#333333", "fontSize": "10px" },
                            margin : 1,
                        },
                        xAxis: {
                            categories: result.category,
                        },
                        yAxis: {
                            min: 0,
                        },
                        legend: {
                            reversed: true,
                            verticalAlign : 'top',
                            align : 'left',
                            padding : 4,
                            title : {
                                text : 'Month'
                            }
                        },
                        plotOptions: {
                            series: {
                                stacking: 'normal',
                                point: {
                                    events : {
                                        click : function(e){
                                            var vendor_id = vendor_index[e.point.index];
                                            bulan = bulan_index[e.point.color];
                                            nama_vendor = result.category[e.point.index];
                                            modal_po_vendor(vendor_id, bulan)
                                        },
                                    },
                                },
                            },
                        },
                        series: result.series
                    });
                }
            });

            var modal_po_vendor = function(vendor_id, bulan)
            {
                $('#modal_po_vendor').modal('show');
                $('#modal_po_vendor').find('.judul').html('PO vendor ' + nama_vendor + ' Bulan ' + App.nama_bulan(bulan - 1) + ' Tahun ' + tahun);
                $('#modal_po_vendor')
                .find('.table-modal tbody')
                .html('<tr><td colspan="4" align="center"><i class="fa fa-spin fa-spinner"></i>Loading</td></tr>')
                .load(App.baseUrl + 'dashboard/detail_po_vendor/' + vendor_id + '/' + tahun + '/' + bulan );
            }
        },
        penyerapan_volume_vendor_chart : function (tahun = null)
        {
            if(tahun == null)
            {
                tahun = new Date().getFullYear()
            }

            $.ajax({
                url : App.baseUrl+'dashboard/get_penyerapan_volume_vendor/' + tahun + '/user',
                type : 'GET',
                dataType : 'json',
                success : function(result)
                {
                    Highcharts.chart('penyerapan-volume-vendor-chart',{
                        chart: {
                            type: 'area',
                            zoomType: 'x',
                            panning: true,
                            panKey: 'shift',
                            scrollablePlotArea:
                            {
                                minWidth: 600
                            }
                        },
                        title:
                        {
                            text: 'Penyerapan Volume User'
                        },
                        xAxis: {
                            categories: result.categories
                        },

                        yAxis: {
                            startOnTick: true,
                            endOnTick: false,
                            maxPadding: 0.35,
                            title: {
                                text: null
                            },
                            labels: {
                                //format: 'Rp. {value}'
                                formatter : function ()
                                {
                                    return App.toRp(this.value) + ' Kg '
                                }
                            },
                            min : 0,
                        },

                        tooltip: {
                            headerFormat: 'Bulan: {point.x}<br>',
                            pointFormat: 'Rp {point.y} ',
                            shared: false
                        },

                        legend: {
                            enabled: false
                        },

                        series: [{
                            data: result.data,
                            lineColor: Highcharts.getOptions().colors[1],
                            color: '#0594fc',
                            fillOpacity: 0.5,
                            name: 'a',
                            marker: {
                                enabled: false
                            },
                            threshold: null
                        }]
                    })
                }
            });
        },
        penyerapan_vendor_chart : function (tahun = null)
        {
            if(tahun == null)
            {
                tahun = new Date().getFullYear()
            }

            $.ajax({
                url : App.baseUrl+'dashboard/get_penyerapan_vendor/' + tahun + '/user',
                type : 'GET',
                dataType : 'json',
                success : function(result)
                {
                    Highcharts.chart('penyerapan-vendor-chart',{
                        chart: {
                            type: 'area',
                            zoomType: 'x',
                            panning: true,
                            panKey: 'shift',
                            scrollablePlotArea:
                            {
                                minWidth: 600
                            }
                        },
                        title:
                        {
                            text: 'Penyerapan Uang'
                        },
                        xAxis: {
                            categories: result.categories
                        },

                        yAxis: {
                            startOnTick: true,
                            endOnTick: false,
                            maxPadding: 0.35,
                            title: {
                                text: null
                            },
                            labels: {
                                //format: 'Rp. {value}'
                                formatter : function ()
                                {
                                    return 'Rp. '+App.toRp(this.value)
                                }
                            },
                            min : 0,
                        },

                        tooltip: {
                            headerFormat: 'Bulan: {point.x}<br>',
                            pointFormat: 'Rp {point.y} ',
                            shared: false
                        },

                        legend: {
                            enabled: false
                        },

                        series: [{
                            data: result.data,
                            lineColor: Highcharts.getOptions().colors[1],
                            color: '#0594fc',
                            fillOpacity: 0.5,
                            name: 'a',
                            marker: {
                                enabled: false
                            },
                            threshold: null
                        }]
                    })
                }
            });
        },
        initEvent : function(){

        if($('#volumechart').length > 0)
        {
            Highcharts.chart('volumechart', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Top Items By Volume',
                    align : 'left',
                    style : { "color": "#333333", "fontSize": "10px" },
                    margin : 1
                },
                xAxis: {
                    categories: ['Barang1', 'Barang2', 'Barang3', 'Barang4', 'Barang5'],
                },
                yAxis: {
                    min: 0,
                },
                legend: {
                    reversed: true,
                    verticalAlign : 'top',
                    align : 'left',
                    padding : 4,
                    title : {
                        text : 'Month'
                    }
                },
                plotOptions: {
                    series: {
                        stacking: 'bar'
                    }
                },
                series:
                [
                    {
                        name: 'April',
                        data: [1, 5, 1, 5, 8],
                        color : '#f3ca0c',
                    },
                    {
                        name: 'March',
                        data: [4, 2, 4, 2, 5],
                        color : '#fc7a00',
                    },
                    {
                        name: 'Feb',
                        data: [10, 2, 3, 2, 1],
                        color : '#05b7ab',
                    },
                    {
                        name: 'Jan',
                        data: [1, 5, 4, 7, 2],
                        color : '#70ae49',
                    },
                ]
            });
        }

        if ($('#wikachart').length > 0)
        {
            App.initWikaChart();
        }

        if ($('#productchart').length > 0)
        {
            App.initProductChart();
        }

        if($('#vendorchart').length > 0)
        {
            App.initVendorChart();
        }

        if($('#penyerapan-vendor-chart').length > 0)
        {
            App.penyerapan_vendor_chart();
        }

        if($('#penyerapan-volume-vendor-chart').length > 0)
        {
            App.penyerapan_volume_vendor_chart();
        }


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
                  "url": App.baseUrl+"dashboard/dataList",
                  "dataType": "json",
                  "type": "POST",
              },
              "columns": [
                  { "data": "id" },
                  { "data": "name" },
                  { "data": "no_contract" },
                  { "data": "address" },
                  { "data": "email"},
              ]
          });

          if($('#usercount').length > 0)
          {
              Highcharts.chart('usercount', {
                  chart: {
                      type: 'line'
                  },
                  title:false,
                  subtitle:false,
                  credits: {
                      enabled: false
                  },
                  xAxis: {
                      categories: ['2010', '2011', '2012', '2013', '2014', '2015',
                      '2016', '2017']
                  },
                  yAxis: {
                      title: {
                          text: 'Sales (Rupiah)'
                      }
                  },
                  tooltip: {
                      headerFormat: '<span style="font-size:10px">{point.key}</span><br>',
                      pointFormat:  '{point.y:.2f} Rupiah'
                  },
                  plotOptions: {
                      line: {
                          enableMouseTracking: true
                      }
                  },
                  series: [{
                      name: 'Manufacturing',
                      data: [25000,23000,30000,30000,32000,30000,38000,40000]
                  },{
                      name: 'Sales & distribution',
                      data: [12000,19000,17000,20000,20000,22000,33000,39500]
                  }, {
                      name: 'Project Development',
                      data: [0,0,9000,11000,15000,21000,32000,32000]
                  }]
              });
          }



            // Build the chart
            if ($('#locationcount').lenght > 0)
            {
                Highcharts.chart('locationcount', {
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    title :false,
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            depth: 35,
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}'
                            }
                        }
                    },
                    series: [{
                        type: 'pie',
                        name: 'Persentase',
                        data: [
                            ['HPS', 45.0],
                            ['Efisiensi', 26.8],
                            {
                                name: 'Kontrak',
                                y: 12.8,
                                sliced: true,
                                selected: true
                            },
                        ]
                    }]
                });
            }

            if ($('#departement').length > 0)
            {
                Highcharts.chart('departement', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Stacked column chart'
                    },
                    title:false,
                    xAxis: {
                        categories: ['Pengadaan 1', 'Pengadaan 2', 'Pengadaan 3', 'Pengadaan 4', 'Pengadaan 5']
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total fruit consumption'
                        }
                    },
                    tooltip: {
                        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                        shared: true
                    },
                    plotOptions: {
                        column: {
                            stacking: 'percent'
                        }
                    },
                    series: [{
                        name: 'DSU1',
                        data: [5, 3, 4, 7, 2]
                    }, {
                        name: 'DSU2',
                        data: [2, 2, 3, 2, 1]
                    }, {
                        name: 'DSU3',
                        data: [3, 4, 4, 2, 5]
                    }]
                });
            }

            if ($('#project').length > 0)
            {
                Highcharts.chart('project', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Stacked column chart'
                    },
                    title : false,
                    xAxis: {
                        categories: ['Proyek A', 'Proyek B', 'Proyek C', 'Proyek D', 'Proyek E']
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total fruit consumption'
                        }
                    },
                    tooltip: {
                        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                        shared: true
                    },
                    plotOptions: {
                        column: {
                            stacking: 'percent'
                        }
                    },
                    series: [{
                        name: 'Hps',
                        data: [5, 3, 4, 7, 2]
                    }, {
                        name: 'Efisiensi',
                        data: [2, 2, 3, 2, 1]
                    }, {
                        name: 'Kontrak',
                        data: [3, 4, 4, 2, 5]
                    }]
                });
            }

            if ($('#status_contract').length > 0)
            {
                Highcharts.chart('status_contract', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Stacked bar chart'
                    },
                    title:false,
                    xAxis: {
                        categories: ['Kontrak Payung Rmx 1', 'Kontrak Payung Semen', 'Kontrak Payung Besi Beton']
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total fruit consumption'
                        }
                    },
                    legend: {
                        reversed: true
                    },
                    plotOptions: {
                        series: {
                            stacking: 'normal'
                        }
                    },
                    series: [{
                        name: 'sisa',
                        data: [5000000, 6000000, 8000000]
                    }, {
                        name: 'pembayaran',
                        data: [5000000, 4000000, 2000000]
                    }]
                });
            }

            if ($('#vendor').length > 0)
            {
                Highcharts.chart('vendor', {
                    chart: {
                        type: 'scatter',
                        zoomType: 'xy'
                    },
                    title: {
                        text: 'Vendor Performance'
                    },
                    subtitle: {
                        text: 'Source: Wika  2019'
                    },
                    xAxis: {
                        title: {
                            enabled: true,
                            text: 'Height (cm)'
                        },
                        startOnTick: true,
                        endOnTick: true,
                        showLastLabel: true
                    },
                    yAxis: {
                        title: {
                            text: 'Weight (kg)'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'left',
                        verticalAlign: 'top',
                        x: 100,
                        y: 70,
                        floating: true,
                        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
                        borderWidth: 1
                    },
                    plotOptions: {
                        scatter: {
                            marker: {
                                radius: 5,
                                states: {
                                    hover: {
                                        enabled: true,
                                        lineColor: 'rgb(100,100,100)'
                                    }
                                }
                            },
                            states: {
                                hover: {
                                    marker: {
                                        enabled: false
                                    }
                                }
                            },
                            tooltip: {
                                headerFormat: '<b>{series.name}</b><br>',
                                pointFormat: '{point.x} cm, {point.y} kg'
                            }
                        }
                    },
                    series: [{
                        name: 'Vendor',
                        color: 'rgba(119, 152, 191, .5)',
                        data: [[174.0, 65.6], [175.3, 71.8], [193.5, 80.7], [186.5, 72.6], [187.2, 78.8],
                        [181.5, 74.8], [184.0, 86.4], [184.5, 78.4], [175.0, 62.0], [184.0, 81.6],
                        [180.0, 76.6], [177.8, 83.6], [192.0, 90.0], [176.0, 74.6], [174.0, 71.0],
                        [184.0, 79.6], [192.7, 93.8], [171.5, 70.0], [173.0, 72.4], [176.0, 85.9],
                        [176.0, 78.8], [180.5, 77.8], [172.7, 66.2], [176.0, 86.4], [173.5, 81.8],
                        [178.0, 89.6], [180.3, 82.8], [180.3, 76.4], [164.5, 63.2], [173.0, 60.9],
                        [183.5, 74.8], [175.5, 70.0], [188.0, 72.4], [189.2, 84.1], [172.8, 69.1],
                        [170.0, 59.5], [182.0, 67.2], [170.0, 61.3], [177.8, 68.6], [184.2, 80.1],
                        [186.7, 87.8], [171.4, 84.7], [172.7, 73.4], [175.3, 72.1], [180.3, 82.6],
                        [182.9, 88.7], [188.0, 84.1], [177.2, 94.1], [172.1, 74.9], [167.0, 59.1],
                        [169.5, 75.6], [174.0, 86.2], [172.7, 75.3], [182.2, 87.1], [164.1, 55.2],
                        [163.0, 57.0], [171.5, 61.4], [184.2, 76.8], [174.0, 86.8], [174.0, 72.2],
                        [177.0, 71.6], [186.0, 84.8], [167.0, 68.2], [171.8, 66.1], [182.0, 72.0],
                        [167.0, 64.6], [177.8, 74.8], [164.5, 70.0], [192.0, 101.6], [175.5, 63.2],
                        [171.2, 79.1], [181.6, 78.9], [167.4, 67.7], [181.1, 66.0], [177.0, 68.2],
                        [174.5, 63.9], [177.5, 72.0], [170.5, 56.8], [182.4, 74.5], [197.1, 90.9],
                        [180.1, 93.0], [175.5, 80.9], [180.6, 72.7], [184.4, 68.0], [175.5, 70.9],
                        [180.6, 72.5], [177.0, 72.5], [177.1, 83.4], [181.6, 75.5], [176.5, 73.0],
                        [175.0, 70.2], [174.0, 73.4], [165.1, 70.5], [177.0, 68.9], [192.0, 102.3],
                        [176.5, 68.4], [169.4, 65.9], [182.1, 75.7], [179.8, 84.5], [175.3, 87.7],
                        [184.9, 86.4], [177.3, 73.2], [167.4, 53.9], [178.1, 72.0], [168.9, 55.5],
                        [157.2, 58.4], [180.3, 83.2], [170.2, 72.7], [177.8, 64.1], [172.7, 72.3],
                        [165.1, 65.0], [186.7, 86.4], [165.1, 65.0], [174.0, 88.6], [175.3, 84.1],
                        [185.4, 66.8], [177.8, 75.5], [180.3, 93.2], [180.3, 82.7], [177.8, 58.0],
                        [177.8, 79.5], [177.8, 78.6], [177.8, 71.8], [177.8, 116.4], [163.8, 72.2],
                        [188.0, 83.6], [198.1, 85.5], [175.3, 90.9], [166.4, 85.9], [190.5, 89.1],
                        [166.4, 75.0], [177.8, 77.7], [179.7, 86.4], [172.7, 90.9], [190.5, 73.6],
                        [185.4, 76.4], [168.9, 69.1], [167.6, 84.5], [175.3, 64.5], [170.2, 69.1],
                        [190.5, 108.6], [177.8, 86.4], [190.5, 80.9], [177.8, 87.7], [184.2, 94.5],
                        [176.5, 80.2], [177.8, 72.0], [180.3, 71.4], [171.4, 72.7], [172.7, 84.1],
                        [172.7, 76.8], [177.8, 63.6], [177.8, 80.9], [182.9, 80.9], [170.2, 85.5],
                        [167.6, 68.6], [175.3, 67.7], [165.1, 66.4], [185.4, 102.3], [181.6, 70.5],
                        [172.7, 95.9], [190.5, 84.1], [179.1, 87.3], [175.3, 71.8], [170.2, 65.9],
                        [193.0, 95.9], [171.4, 91.4], [177.8, 81.8], [177.8, 96.8], [167.6, 69.1],
                        [167.6, 82.7], [180.3, 75.5], [182.9, 79.5], [176.5, 73.6], [186.7, 91.8],
                        [188.0, 84.1], [188.0, 85.9], [177.8, 81.8], [174.0, 82.5], [177.8, 80.5],
                        [171.4, 70.0], [185.4, 81.8], [185.4, 84.1], [188.0, 90.5], [188.0, 91.4],
                        [182.9, 89.1], [176.5, 85.0], [175.3, 69.1], [175.3, 73.6], [188.0, 80.5],
                        [188.0, 82.7], [175.3, 86.4], [170.5, 67.7], [179.1, 92.7], [177.8, 93.6],
                        [175.3, 70.9], [182.9, 75.0], [170.8, 93.2], [188.0, 93.2], [180.3, 77.7],
                        [177.8, 61.4], [185.4, 94.1], [168.9, 75.0], [185.4, 83.6], [180.3, 85.5],
                        [174.0, 73.9], [167.6, 66.8], [182.9, 87.3], [160.0, 72.3], [180.3, 88.6],
                        [167.6, 75.5], [186.7, 101.4], [175.3, 91.1], [175.3, 67.3], [175.9, 77.7],
                        [175.3, 81.8], [179.1, 75.5], [181.6, 84.5], [177.8, 76.6], [182.9, 85.0],
                        [177.8, 102.5], [184.2, 77.3], [179.1, 71.8], [176.5, 87.9], [188.0, 94.3],
                        [174.0, 70.9], [167.6, 64.5], [170.2, 77.3], [167.6, 72.3], [188.0, 87.3],
                        [174.0, 80.0], [176.5, 82.3], [180.3, 73.6], [167.6, 74.1], [188.0, 85.9],
                        [180.3, 73.2], [167.6, 76.3], [183.0, 65.9], [183.0, 90.9], [179.1, 89.1],
                        [170.2, 62.3], [177.8, 82.7], [179.1, 79.1], [190.5, 98.2], [177.8, 84.1],
                        [180.3, 83.2], [180.3, 83.2]]
                    }]
                });
            }


        }
	}
});
