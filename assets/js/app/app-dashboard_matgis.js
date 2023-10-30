define([
    "jQuery",
    "jQueryUI",
    "bootstrap",
    "highchart",
    "sidebar",
    "datatables",
    "datatablesBootstrap",
    "highchartmore",
], function (
    $,
    jQueryUI,
    bootstrap,
    highchart,
    sidebar ,
    datatables,
    datatablesBootstrap,
    highchartmore,
) {
    return {
        table:null,
        init: function () {
            App.getDataDashboard();
            App.getDetail();

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
        getDataDashboard : function(){
            function fnum(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            let filterTahun = $('#filter_tahun').val();
            let optionChartBulan = $('#option_chart_bulan').val();

            $.ajax({
                url: App.baseUrl+"dashboard_matgis/get_data_dashboard",
                method: "get",
                data: {
                    filterTahun : filterTahun,
                    optionChartBulan: optionChartBulan,
                },
                dataType: "json",
                success: function (data) {
                    $('#po_matgis').html(`<h2>${fnum(data.po_matgis)}</h2>`)
                    $('#kode_sda').html(`<h2>${fnum(data.kode_sda)}</h2>`)
                    $('#nilai_transaksi').html(`<h2>Rp. ${fnum(data.nilai_transaksi)}</h2>`)
                    $('#efisiensi_po').html(`<h2>Rp. ${fnum(data.efisiensi_po)}</h2>`)
                    $('#efisiensi_po_precent').html(`<h2>${fnum(parseFloat(data.efisiensi_po_precent).toFixed(2))} %</h2>`)
                    eva_vendor_besi(data.get_monev_chart);
                    top_10_product(data.get_total_penjualan_product);
                    total_penjualan_vendor(data.get_total_penjualan_vendor);
                    forecast(data.get_data_chart_forecast);
                    penyerapan_departemen(data.get_total_penyerapan_dept);
                    generate_maps(data.pin_maps);
                },
            })

            function generate_maps(data) {
                f_location = [-0.7031073524364783, 117.46582031250001];
                zoom = 4;
                locations = [];

                $.each(data, function(i,v){
                    arr = [v.name + ` [<a href="#" class="detail_maps" id="${v.id}" data-pn="${v.name}"><u>Detail</u></a>]` , v.lat, v.ln];
                    locations.push(arr);
                })

                var container = L.DomUtil.get('mapid');
                if(container != null){
                    container._leaflet_id = null;
                }
                var mymap = L.map('mapid').setView(f_location, zoom);

                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken: 'pk.eyJ1IjoicmF6eWlkNzIiLCJhIjoiY2s1Z2g1Z3NvMDc0YTNmcGVubmgzd2l5bCJ9.6jAMfgoFlE4HVP-BYqEFPw'
                }).addTo(mymap);

                for (var i = 0; i < locations.length; i++) {
                    marker = new L.marker([locations[i][1], locations[i][2]])
                    .bindPopup(locations[i][0])
                    .addTo(mymap);
                }
            }

            $(document).on('click', '.detail_maps', function() {
                $('#modal_title').html('')
                $('#modal_body').html('');

                let content = "";
                let id = $(this).attr('id');
                let pn = $(this).data('pn');
                let totall = 0;

                $.ajax({
                    url: App.baseUrl+"dashboard_matgis/get_detail_maps",
                    method: "post",
                    data: {
                        filterTahun : filterTahun,
                        id : id,
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        no = 1;
                        $.each(data, function(i,v) {
                            content += `
                            <tr>
                            <td>${no}</td>
                            <td>${v.order_no}</td>
                            <td>${v.vendor_name}</td>
                            <td>${v.no_surat}</td>
                            <td>${v.tanggal}</td>
                            <td>${v.name +' '+ v.day}</td>
                            <td class="text-right">Rp.${fnum(v.total_price)}</td>
                            </tr>
                            `;
                            totall += parseInt(v.total_price);
                            no++;
                        })

                        body = `
                        <table class="table">
                        <thead>
                        <tr>
                        <th>No</th>
                        <th>No Order</th>
                        <th>Vendor</th>
                        <th>No Surat</th>
                        <th>Tanggal</th>
                        <th>Metode Pembayaran</th>
                        <th class="text-right">Jumlah</th>
                        </tr>
                        </thead>
                        <tbody>
                        ${content}
                        <tr>
                        <th colspan="6">Total Transaksi</th>
                        <th class="text-right">Rp.${fnum(totall)}</th>
                        </tr>
                        </tbody>
                        </table>
                        `;

                        $('#modal_title').html('<h5><strong>Detail Project '+ pn +'</strong></h5>')
                        $('#modal_body').html(body);
                        $('#modal_detail').modal('show');
                    },
                })
            })

            function top_10_product(data){
                var vendor_index, bulan_index, nama_product;

                vendor_index = data.vendor_index;
                bulan_index = data.bulan_index;
                Highcharts.chart('productchart', {
                    chart: {
                        type: 'bar',
                        //marginLeft: 50,
                        marginBottom: 90,
                        zoomType: 'xy'
                        //width : 500,
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: data.category,
                        labels: {
                            style: {
                                fontSize:'9px'
                            }
                        }
                    },
                    yAxis : {
                        title: {
                            text: 'Pemakaian'
                        },
                        labels: {
                            //format: 'Rp. {value}'
                            formatter : function ()
                            {
                                return App.toRp(this.value) + ' Kg '
                            },
                        }
                        // min: 0
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
                                        nama_product = data.category[e.point.index];
                                        modal_po_top_10(vendor_id, bulan, nama_product)
                                    },
                                },
                            },
                        },
                    },
                    series: data.series,
                    credits: false
                });
            }

            var modal_po_top_10 = function(vendor_id, bulan, nama_product)
            {
                $('#modal_po_vendor').modal('show');
                $('#modal_po_vendor').find('.judul').html('' + nama_product + ' Bulan ' + App.nama_bulan(bulan - 1) + ' Tahun ' + $('#filter_tahun').val());
                $('#modal_po_vendor')
                .find('.table-modal tbody')
                .html('<tr><td colspan="4" align="center"><i class="fa fa-spin fa-spinner"></i>Loading</td></tr>')
                .load(App.baseUrl + 'dashboard_matgis/detail_po_product/' + vendor_id + '/' + bulan + '/' + $('#filter_tahun').val());
            }

            function eva_vendor_besi(data){
                var vendor_index, nama_vendor, category_id = 72;

                vendor_index = data.vendor_index;
                Highcharts.chart('wikachart', {
                    chart: {
                        type: 'bar',
                        //marginLeft: 50,
                        marginBottom: 120,
                        zoomType: 'xy',
                        height : 370,
                    },
                    title: {
                        text: 'Sentralisasi Besi Beton SNI 2017'
                    },
                    legend: {
                        enabled: false
                    },
                    xAxis: {
                        categories: data.categories,
                        labels: {
                            style: {
                                fontSize:'10px'
                            }
                        }
                    },
                    yAxis : {
                        title: {
                            text: '<span onclick = "App.modal_po_vendor_wika(\'-1\', '+$('#filter_tahun').val()+', '+72+')" style="cursor : pointer">Penyerapan <b>' + App.toRp(data.total_penyerapan) + '</b></span>',
                            useHTML : true,
                            margin : 0,
                        },
                        labels: {
                            //format: 'Rp. {value}'
                            formatter : function ()
                            {
                                return App.toRp(this.value) + ' Kg '
                            },
                        }
                        // min: 0
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
                                        nama_vendor = data.categories[e.point.index];
                                        modal_po_vendor_eva(vendor_id, nama_vendor)
                                    },
                                },
                            },
                        },
                    },
                    series: data.series,
                    credits: false
                });
            }

            var modal_po_vendor_eva = function(vendor_id, nama_vendor)
            {
                if (vendor_id == '-1')
                {
                    nama_vendor = 'Wika';
                }
                $('#modal_po_vendor').modal('show');
                $('#modal_po_vendor').find('.judul').html('' + nama_vendor + ' Tahun ' + $('#filter_tahun').val());
                $('#modal_po_vendor')
                .find('.table-modal tbody')
                .html('<tr><td colspan="7" align="center"><i class="fa fa-spin fa-spinner"></i>Loading</td></tr>')
                .load(App.baseUrl + 'dashboard_matgis/detail_penyerapan_vendor/' + vendor_id + '/' + $('#filter_tahun').val() + '/' + 72);
            }

            function total_penjualan_vendor(data){
                var vendor_index, bulan_index, nama_vendor;

                vendor_index = data.vendor_index;
                bulan_index = data.bulan_index;
                Highcharts.chart('vendorchart', {
                    chart: {
                        type: 'bar',
                        //marginLeft: 50,
                        marginBottom: 90,
                        zoomType: 'xy'
                        //width : 500,
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: data.category,
                        labels: {
                            style: {
                                fontSize:'10px'
                            }
                        }
                    },
                    yAxis : {
                        title: {
                            text: 'Jumlah Pesanan'
                        },
                        labels: {
                            //format: 'Rp. {value}'
                            formatter : function ()
                            {
                                return App.toRp(this.value)
                            },
                        }
                        // min: 0
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
                                        nama_vendor = data.category[e.point.index];
                                        modal_po_vendor_pemesanan(vendor_id, bulan, nama_vendor)
                                    },
                                },
                            },
                        },
                    },
                    series: data.series,
                    credits: false
                });
            }

            var modal_po_vendor_pemesanan = function(vendor_id, bulan, nama_vendor)
            {
                $('#modal_po_vendor').modal('show');
                $('#modal_po_vendor').find('.judul').html('PO vendor ' + nama_vendor + ' Bulan ' + App.nama_bulan(bulan - 1) + ' Tahun ' + $('#filter_tahun').val());
                $('#modal_po_vendor')
                .find('.table-modal tbody')
                .html('<tr><td colspan="4" align="center"><i class="fa fa-spin fa-spinner"></i>Loading</td></tr>')
                .load(App.baseUrl + 'dashboard_matgis/detail_po_vendor/' + vendor_id + '/' + $('#filter_tahun').val() + '/' + bulan );
            }

            function forecast(data){
                Highcharts.chart('salesMonth', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Pergerakan & Forecast Harga Kontrak Payung Besi Beton'
                    },
                    subtitle: {
                        text: 'WIKA Group'
                    },
                    xAxis: {
                        categories: data.bulan
                    },
                    yAxis: {
                        title: {
                            text: 'Harga'
                        }
                    },
                    tooltip: {
                        shared: true,
                        crosshairs: true
                    },
                    plotOptions: {
                        series: {
                            cursor: 'pointer',
                            point: {
                                events: {
                                    click: function (e) {
                                        hs.htmlExpand(null, {
                                            pageOrigin: {
                                                x: e.pageX || e.clientX,
                                                y: e.pageY || e.clientY
                                            },
                                            headingText: this.series.name,
                                            maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) + ':<br/> ' +
                                            this.y + ' sessions',
                                            width: 200
                                        });
                                    }
                                }
                            },
                            marker: {
                                lineWidth: 1
                            }
                        }
                    },
                    series: [{
                        name: ' ',
                        data: data.hargaatas
                    }, {
                        name: ' ',
                        data: data.harga
                    }, {
                        name: ' ',
                        data: data.hargabawah
                    }]
                });
            }

            function penyerapan_departemen(data) {
                var dept_index, bulan_index, nama_dept;

                dept_index = data.dept_index;
                bulan_index = data.bulan_index;
                Highcharts.chart('dept-chart', {
                    chart: {
                        type: 'bar',
                        //marginLeft: 50,
                        marginBottom: 90,
                        zoomType: 'y'
                        //width : 500,
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: data.category,
                        labels: {
                            style: {
                                fontSize:'9px'
                            }
                        }
                    },
                    yAxis : {
                        title: {
                            text: 'Pemakaian'
                        },
                        labels: {
                            //format: 'Rp. {value}'
                            formatter : function ()
                            {
                                return App.toRp(this.value) + ' Kg '
                            },
                        }
                        // min: 0
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
                                        var dept_id = dept_index[e.point.index];
                                        bulan = bulan_index[e.point.color];
                                        nama_dept = data.category[e.point.index];
                                        modal_po_vendor(dept_id, bulan, nama_dept)
                                    },
                                },
                            },
                        },
                    },
                    series: data.series,
                    credits: false
                });
            }

            var modal_po_vendor = function(dept_id, bulan, nama_dept)
            {
                $('#modal_po_dept').modal('show');
                $('#modal_po_dept').find('.judul').html('' + nama_dept + ' Bulan ' + App.nama_bulan(bulan - 1) + ' Tahun ' + $('#filter_tahun').val());
                $('#modal_po_dept')
                .find('.table-modal tbody')
                .html('<tr><td colspan="7" align="center"><i class="fa fa-spin fa-spinner"></i>Loading</td></tr>')
                .load(App.baseUrl + 'dashboard_matgis/get_detail_penyerapan_dept/' + dept_id + '/' + bulan + '/' + $('#filter_tahun').val());
            }
        },
        modal_po_vendor_wika : function(vendor_id, tahun, category_id)
        {
            if (vendor_id == '-1')
            {
                nama_vendor = 'Wika';
            }
            $('#modal_po_vendor').modal('show');
            $('#modal_po_vendor').find('.judul').html('' + nama_vendor + ' Tahun ' + $('#filter_tahun').val());
            $('#modal_po_vendor')
            .find('.table-modal tbody')
            .html('<tr><td colspan="7" align="center"><i class="fa fa-spin fa-spinner"></i>Loading</td></tr>')
            .load(App.baseUrl + 'dashboard_matgis/detail_penyerapan_vendor/' + vendor_id + '/' + tahun + '/' + category_id);
        },
        getDetail : function() {
            function fnum(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            $(document).on('click', '#nilai_tr', function () {
                $('#modal_title').html('')
                $('#modal_body').html('');
                let filterTahun = $('#filter_tahun').val();
                get_detail(filterTahun);
            })

            function get_detail(params) {
                content = "";
                allnilai = 0;

                $.ajax({
                    url: App.baseUrl+"dashboard_matgis/get_detail_nilai",
                    data: {
                        params: params,
                    },
                    method: "post",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        //   return false;
                        no = 1;
                        $.each(data, function(i, v){
                            content += `
                            <tr>
                            <td>${no}</td>
                            <td>${v.divisi}</td>
                            <td class="text-right">Rp. ${fnum(parseInt(v.nilai))}</td>
                            </tr>
                            `;

                            allnilai += parseInt(v.nilai);
                            no++;
                        })

                        body = `
                        <table class="table">
                        <thead>
                        <tr>
                        <th>No</th>
                        <th>Divisi</th>
                        <th class="text-right">Jumlah</th>
                        </tr>
                        </thead>
                        <tbody>
                        ${content}
                        <tr>
                        <th colspan="2">TOTAL TRANSAKSI</th>
                        <th class="text-right">Rp. ${fnum(allnilai)}</th>
                        </tr>
                        </tbody>
                        </table>
                        `;

                        $('#modal_title').html('<h5><strong>Total Nilai Transaksi Tahun ' + params + '</strong></h5>')
                        $('#modal_body').html(body);
                        $('#modal_detail').modal('show');
                    },
                })
            }
        }
    }
});
