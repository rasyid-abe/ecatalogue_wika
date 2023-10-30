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
        // App.yearFilter();
        App.getDataDashboard();
        App.getDetailPo();
        $(".loadingpage").hide();
		  },
      getDataDashboard : function(){
        let filterTahun = $('#filter_tahun').val();
        let filterBulan = $('#filter_bulan').val();
        let volumeBulanIniBulan = $('#volume_bulan_ini_bulan').val();
        let jumlahPemesananBulan = $('#jumlah_pemesanan_bulan').val();

        // return false;
        function fnum(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function split_num(x){
          a = x.split('.');
          b = parseInt(a[1].substring(2,3));
          c = a[1].substring(0,2);
          if (c.substring(0,1) == '0'){
            c0 = b > 5 ? parseInt(c.substring(1,2)) + 1 : c.substring(1,2);
            c1 = '0' + c0;
          } else {
            c1 = b > 5 ? parseInt(c) + 1 : parseInt(c);
          }
          d = c1;
          e = a[0] + '.' + (d > 0 ? d : '00');
          return e;
        }

        $.ajax({
          url: App.baseUrl+"dashboard_transportasi/get_data_dashboard",
          data: {
            filterTahun: filterTahun,
            filterBulan: filterBulan,
            defaultBulan: volumeBulanIniBulan,
            jumlahPemesananBulan: jumlahPemesananBulan,
          },
          method: "post",
          dataType: "json",
          success: function (data) {
            console.log(data);
            $('#total_nilai_trans').html(`<h3 class="text-center">Rp. ${fnum(split_num(data.total_nilai_transportasi))}</h3>`);
            $('#total_berat_1').html(`<p class="text-center">Total Berat : ${fnum(split_num(data.total_volume_diangkut))} Ton </p>`);
            penyerapan_vendor(data.penyerapan_per_vendor);
            top5project(data.po_per_project);
            podivisibar(data.po_per_divisi_per_volume_bar);
            dailyvolumearea(data.all_volume_per_bulan_berjalan);
            podivisipie(data.po_per_divisi_per_volume_pie);
            po_bulan_tahun(data.po_per_bulan_berjalan, data.po_per_tahun_berjalan);
            vehiclelist(data.vehicle_terbanyak_by_volume);
          },
        })

        function vehiclelist(data){
          if (data.length > 0) {
            let view = '';
            no = 1;
            $.each(data, function(i, v){
              console.log(Math.round(data[no - 1].volume / data[0].volume * 100));
                view += `
                <h6 class="text-left">No.${no} ${v.name}</h6>
                <h6 class="text-left">Volume : <strong>${fnum(split_num(v.volume))} Ton </strong></h6>
                <div class="line_space"></div>
                `;
                no++;
            })

            $('#vehiclelist').html(view);
          } else {
            $('#vehiclelist').html("Tidak ada data.");
          }
        }

        function po_bulan_tahun(bulan, tahun){
          let html_bulan = `
          <div class="c100 p${bulan} blue" style="margin-bottom: 1px; margin-top: 1px;">
            <span>
              <span id="po_bulanan">
                <p>Bulan Ini</p>
                <p>${bulan}</p>
              </span>
            </span>
            <div class="slice">
              <div class="bar"></div>
              <div class="fill"></div>
            </div>
          </div>
          `;

          let html_tahun = `
          <div class="c100 p${tahun} blue" style="margin-bottom: -5px; margin-top: 1px;">
            <span>
              <span id="po_tahunan">
                <p>Tahun Ini</p>
                <p>${tahun}</p>
              </span>
            </span>
            <div class="slice">
              <div class="bar"></div>
              <div class="fill"></div>
            </div>
          </div>
          `;

          $('#bulanini').html(html_bulan);
          $('#tahunini').html(html_tahun);
        }

        function penyerapan_vendor(data){
          let html = '';
          if (data.length > 0) {
            $.each(data, function(i,v){
              split_num(v.harga);
                html += `
                <p class="card-text">${v.name}</p>
                <p class="card-text">Berat : ${fnum(split_num(v.berat))} Ton</p>
                <p class="card-text">Nilai : Rp. ${fnum(split_num(v.harga))}</p>
                <div class="line_space"></div>
                `;
            })
            $('#penyerapan_js').html(html);
          } else {
            $('#penyerapan_js').html('Tidak ada data.');
          }

        }

        function podivisipie(data){
          // Build the chart
          let final = [];
          $.each(data, function(i,v){
            final.push({
                name: v.name,
                y: parseInt(v.volume)		
              });
          })
          $('#podivisipie').html('');
          if (data.length > 0) {
                Highcharts.chart('podivisipie', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: null
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
                },
                series: [{
                name: 'Brands',
                colorByPoint: true,
                data: final
                }]
            });
          } else {
            $('#podivisipie').html('Tidak ada data.');
          }
        }

        function dailyvolumearea(data){
          $('#dailyvolumearea').html('');
          if (data.tgl.length > 0) {
            Highcharts.chart('dailyvolumearea', {
                chart: {
                  type: 'area'
                },
                title: {
                  text: null
                },
                xAxis: {
                  categories: data.tgl
                },
                yAxis: {
                  title: {
                    text: 'Volume'
                  },
                  labels: {
                    formatter: function () {
                      return fnum(this.value);
                    }
                  }
                },
                tooltip: {
                  crosshairs: true,
                  shared: true
                },
                plotOptions: {
                  spline: {
                    marker: {
                      radius: 4,
                      lineColor: '#666666',
                      lineWidth: 1
                    }
                  }
                },
                series: [{
                  name: 'Volume',
                  data: data.vol
                }]
              });
          } else {
            $('#dailyvolumearea').html('Tidak ada data.');
          }
        }

        function top5project(data){
          let proj = [];
          let po = [];
          $.each(data, function(i,v){
              proj.push(v.name);
              po.push(parseInt(v.total));
          })

          $('#top5project').html('');
          Highcharts.chart('top5project', {
            chart: {
              type: 'bar'
            },
            title: {
              text: null
            },
            width: 200,
            xAxis: {
              categories: proj,
              title: {
                text: null
              }
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Project',
                align: 'high'
              },
              labels: {
                overflow: 'justify'
              }
            },
            // tooltip: {
            //   valueSuffix: ' millions'
            // },
            plotOptions: {
              bar: {
                dataLabels: {
                  enabled: true
                }
              }
            },
            legend: {
              layout: 'vertical',
              align: 'right',
              verticalAlign: 'top',
              x: -40,
              y: 80,
              floating: true,
              borderWidth: 1,
              backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
              shadow: true
            },
            credits: {
              enabled: false
            },
            series: [{
              name: 'Project',
              data: po
            }]
          });
        }

        function podivisibar(data){
          $('#podivisibar').html('');
          if (data.length > 0) {
            let lab = [];
            let vol = [];
            $.each(data, function(i,v){
                lab.push(v.name);
                vol.push(parseInt(v.volume));
            })

            Highcharts.chart('podivisibar', {
              chart: {
                type: 'bar'
              },
              title: {
                text: null
              },
              xAxis: {
                categories: lab,
                title: {
                  text: null
                }
              },
              yAxis: {
                min: 0,
                title: {
                  text: 'Volume',
                  align: 'high'
                },
                labels: {
                  overflow: 'justify'
                }
              },
              tooltip: {
                valueSuffix: ' Ton'
              },
              plotOptions: {
                bar: {
                  dataLabels: {
                    enabled: true
                  }
                }
              },
              legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor:
                  Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
              },
              credits: {
                enabled: false
              },
              series: [{
                name: 'volume',
                data: vol
              }]
            });
          } else {
            $('#podivisibar').html('Tidak ada data.');
          }
        }

		  },
      getDetailPo : function(){
        $(document).on('click', '#po_bulanan', function () {
          $('#modal_title').html('')
          $('#modal_body').html('');
          bulan = $('#volume_bulan_ini_bulan').val();
          tahun = $('#filter_tahun').val();
          get_data_bulan(tahun+bulan);
        })

        let m = ['Januari', 'February', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        function get_data_bulan(params) {
          content = "";
          allpo = 0;

          $.ajax({
            url: App.baseUrl+"dashboard_transportasi/get_detail_po",
            data: {
              params: params,
            },
            method: "post",
            dataType: "json",
            success: function (data) {
              console.log(data);
              no = 1;
              $.each(data, function(i, v){
                content += `
                  <tr>
                    <td>${no}</td>
                    <td>${v.project}</td>
                    <td>${v.lokasi}</td>
                    <td class="text-right">${v.total}</td>
                  </tr>
                `;

                allpo += parseInt(v.total);
                no++;
              })

              body = `
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Project</th>
                      <th>Lokasi</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${content}
                    <tr>
                      <th colspan="3">TOTAL PEMESANAN</th>
                      <th class="text-right">${allpo}</th>
                    </tr>
                  </tbody>
                </table>
              `;

              $('#modal_title').html('<h5><strong>Jumlah Pemesanan Bulan ' + m[bulan - 1] + ' ' + tahun + '</strong></h5>')
              $('#modal_body').html(body);
              $('#modal_detail').modal('show');
            },
          })

        }

        $(document).on('click', '#po_tahunan', function () {
          $('#modal_title').html('')
          $('#modal_body').html('');
          tahun = $('#filter_tahun').val();
          get_data_tahun(tahun);
        })

        function get_data_tahun(params) {
          content = "";
          allpo = 0;

          $.ajax({
            url: App.baseUrl+"dashboard_transportasi/get_detail_po",
            data: {
              params: params,
            },
            method: "post",
            dataType: "json",
            success: function (data) {
              console.log(data);
              no = 1;
              $.each(data, function(i, v){
                content += `
                  <tr>
                    <td>${no}</td>
                    <td>${v.project}</td>
                    <td>${v.lokasi}</td>
                    <td class="text-right">${v.total}</td>
                  </tr>
                `;

                allpo += parseInt(v.total);
                no++;
              })

              body = `
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Project</th>
                      <th>Lokasi</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${content}
                    <tr>
                      <th colspan="3">TOTAL PEMESANAN</th>
                      <th class="text-right">${allpo}</th>
                    </tr>
                  </tbody>
                </table>
              `;

              $('#modal_title').html('<h5><strong>Jumlah Pemesanan Tahun ' + tahun + '</strong></h5>')
              $('#modal_body').html(body);
              $('#modal_detail').modal('show');
            },
          })

        }
      },
	  }
});
