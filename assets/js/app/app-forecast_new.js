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
  sidebar,
  datatables,
  datatablesBootstrap,
  bootstrapDatepicker,
  highchart,
  highchartmore,
  select2
) {
  return {
    table: null,
    req: false,
    init: function () {
      App.initFunc();
      App.formSubmit();
      App.initEvent();
      App.initPlugin();
      App.initChart();
      App.yearFilter();
      App.editForecast();
      App.checkAll();
      App.enableDelete();
      App.chartForecast();
      App.tableForecast();
      $(".loadingpage").hide();
    },
    editForecast: function () {
      $("#table").on("click", ".modalUbah", function () {
        $("#judulModalLabel").html("Form Ubah");
        $(".modal-footer button[type=submit]").html("Ubah Data");

        const id = $(this).data("id");
        $.ajax({
          url: App.baseUrl + "forecast_new/edit",
          data: { id: id },
          method: "post",
          dataType: "json",
          success: function (data) {
            console.log(data);
            $("#tglHarga").val(data.tgl_harga);
            $("#priceBilletTangshan").val(data.price_billet_tangshan);
            $("#priceBilletCis").val(data.price_billet_cis);
            $("#kursBi").val(data.kurs_bi);
            $("#hargaBesiTangshan").val(data.harga_besi_tangshan);
            $("#hargaBesiCis").val(data.harga_besi_cis);
          },
        });
      });
    },
    initPlugin: function () {
      $('*select[data-selectjs="true"]').select2({ width: "100%" });
    },
    tableForecast: function () {
      let days = 0;
      ajax_call(days);
      ajax_call2(days);

      $("#option_chart_hari").on("change", function () {
        days = $("#option_chart_hari").val();
        ajax_call(days);
        ajax_call2(days);
      });

      function ajax_call(days) {
        $.ajax({
          method: "POST",
          url: App.baseUrl + "forecast_new/get_table_data",
          data: { days: days },
          beforeSend: function () {
            $(".loading").show();
          },
          dataType: "json",
        }).done(function (ret) {
          let body = "";
          $.each(ret, function (i, val) {
            body += `
                        <tr>
                            <td class="text-center">${val.tgl_forecast}</td>
                            <td class="text-right">${val.forecast_tang.toFixed(
                              5
                            )}</td>
                            <td class="text-right">${val.forecast_cis.toFixed(
                              5
                            )}</td>
                        </tr>
                        `;
          });

          generate_table(body);
        });
      }

      function generate_table(body) {
        table = `
                <table class="table table-striped" id="table_forecast">
                    <thead>
                        <tr>
                            <th class="text-center">Tanggal Forecast</th>
                            <th class="text-right">Forecast Tangshan</th>
                            <th class="text-right">Forecast CIS</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${body}
                    </tbody>
                </table>
                `;

        $("#tabel_forecast").html(table);

        App.table = $("#table_forecast").DataTable({
          language: {
            search: "Cari",
            lengthMenu: "Tampilkan _MENU_ baris per halaman",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_  sampai _END_ dari _MAX_ data",
            infoEmpty: "Tidak ada data yang ditampilkan ",
            infoFiltered: "(pencarian dari _MAX_ total records)",
            paginate: {
              first: "Pertama",
              last: "Terakhir",
              next: "Selanjutnya",
              previous: "Sebelum",
            },
          },
          processing: true,
          serverSide: false,
          searching: true,
          order: [[0, "desc"]],
        });
      }

      function ajax_call2(days) {
        $.ajax({
          method: "POST",
          url: App.baseUrl + "forecast_new/get_table_rata",
          data: { days: days },
          beforeSend: function () {
            $(".loading").show();
          },
          dataType: "json",
        }).done(function (ret) {
          let body = "";
          $.each(ret, function (i, val) {
            body += `
                        <tr>
                            <td class="text-center">${val.tgl_forecast}</td>
                            <td class="text-right">${(
                              val.forecast_tang / val.jumlah
                            ).toFixed(5)}</td>
                            <td class="text-right">${(
                              val.forecast_cis / val.jumlah
                            ).toFixed(5)}</td>
                        </tr>
                        `;
          });

          generate_table2(body);
        });
      }

      function generate_table2(body) {
        table = `
                <table class="table table-striped" id="table_rata_rata">
                    <thead>
                        <tr>
                            <th class="text-center">Bulan</th>
                            <th class="text-right">Forecast Tangshan</th>
                            <th class="text-right">Forecast CIS</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${body}
                    </tbody>
                </table>
                `;

        $("#tabel_rata_rata").html(table);

        App.table = $("#table_rata_rata").DataTable({
          language: {
            search: "Cari",
            lengthMenu: "Tampilkan _MENU_ baris per halaman",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_  sampai _END_ dari _MAX_ data",
            infoEmpty: "Tidak ada data yang ditampilkan ",
            infoFiltered: "(pencarian dari _MAX_ total records)",
            paginate: {
              first: "Pertama",
              last: "Terakhir",
              next: "Selanjutnya",
              previous: "Sebelum",
            },
          },
          processing: true,
          serverSide: false,
          searching: true,
          order: [[0, "desc"]],
        });
      }
    },
    chartForecast: function () {
      let days = 0;
      ajax_call(days);

      $("#option_chart_hari").on("change", function () {
        days = $("#option_chart_hari").val();
        ajax_call(days);
      });

      function ajax_call(days) {
        $.ajax({
          method: "POST",
          url: App.baseUrl + "forecast_new/get_chart_data",
          data: { days: days },
          beforeSend: function () {
            $(".loading").show();
          },
          dataType: "json",
        }).done(function (ret) {
          Highcharts.chart("container", {
            chart: {
              scrollablePlotArea: {
                minWidth: 500,
              },
            },
            title: {
              text: "Forecast Tangshan",
            },
            xAxis: {
              categories: ret.tgl_forecast,
            },
            yAxis: {
              title: {
                text: "Harga",
              },
            },

            tooltip: {
              shared: true,
              crosshairs: true,
            },
            plotOptions: {
              series: {
                cursor: "pointer",
                point: {
                  events: {
                    click: function (e) {
                      hs.htmlExpand(null, {
                        pageOrigin: {
                          x: e.pageX || e.clientX,
                          y: e.pageY || e.clientY,
                        },
                        headingText: this.series.name,
                        maincontentText:
                          Highcharts.dateFormat("%A, %b %e, %Y", this.x) +
                          ":<br/> " +
                          this.y +
                          " sessions",
                        width: 200,
                      });
                    },
                  },
                },
                marker: {
                  lineWidth: 1,
                },
              },
            },

            series: [
              {
                name: "Harga Besi",
                data: ret.besi_tang,
              },
              {
                name: "Prediction",
                data: ret.fore_tang,
              },
            ],
          });
          Highcharts.chart("container1", {
            chart: {
              scrollablePlotArea: {
                minWidth: 500,
              },
            },
            title: {
              text: "Forecast CIS",
            },
            xAxis: {
              categories: ret.tgl_forecast,
            },
            yAxis: {
              title: {
                text: "Harga",
              },
            },

            tooltip: {
              shared: true,
              crosshairs: true,
            },
            plotOptions: {
              series: {
                cursor: "pointer",
                point: {
                  events: {
                    click: function (e) {
                      hs.htmlExpand(null, {
                        pageOrigin: {
                          x: e.pageX || e.clientX,
                          y: e.pageY || e.clientY,
                        },
                        headingText: this.series.name,
                        maincontentText:
                          Highcharts.dateFormat("%A, %b %e, %Y", this.x) +
                          ":<br/> " +
                          this.y +
                          " sessions",
                        width: 200,
                      });
                    },
                  },
                },
                marker: {
                  lineWidth: 1,
                },
              },
            },

            series: [
              {
                name: "Harga Besi",
                data: ret.besi_cis,
              },
              {
                name: "Prediction",
                data: ret.fore_cis,
              },
            ],
          });
          Highcharts.chart("tangshan", {
            chart: {
              scrollablePlotArea: {
                minWidth: 500,
              },
            },
            title: {
              text: "Harga Besi Vs Harga Billet Tangshan",
            },
            xAxis: {
              categories: ret.tgl_harga,
            },
            yAxis: [
              {
                title: {
                  text: "Harga Besi",
                },
              },
              {
                title: {
                  text: "Harga Billet",
                },
                opposite: true,
              },
            ],

            tooltip: {
              shared: true,
              crosshairs: true,
            },
            plotOptions: {
              series: {
                cursor: "pointer",
                point: {
                  events: {
                    click: function (e) {
                      hs.htmlExpand(null, {
                        pageOrigin: {
                          x: e.pageX || e.clientX,
                          y: e.pageY || e.clientY,
                        },
                        headingText: this.series.name,
                        maincontentText:
                          Highcharts.dateFormat("%A, %b %e, %Y", this.x) +
                          ":<br/> " +
                          this.y +
                          " sessions",
                        width: 200,
                      });
                    },
                  },
                },
                marker: {
                  lineWidth: 1,
                },
              },
            },

            series: [
              {
                yAxis: 1,
                name: "Price Billet Tangshan",
                data: ret.price_billet_tangshan,
              },
              {
                name: "Harga Besi Tangshan",
                data: ret.besi_tang,
              },
            ],
          });
          Highcharts.chart("cis", {
            chart: {
              scrollablePlotArea: {
                minWidth: 500,
              },
            },
            title: {
              text: "Harga Besi Vs Harga Billet CIS",
            },
            xAxis: {
              categories: ret.tgl_harga,
            },
            yAxis: [
              {
                title: {
                  text: "Harga Besi",
                },
              },
              {
                title: {
                  text: "Harga Billet",
                },
                opposite: true,
              },
            ],

            tooltip: {
              shared: true,
              crosshairs: true,
            },
            plotOptions: {
              series: {
                cursor: "pointer",
                point: {
                  events: {
                    click: function (e) {
                      hs.htmlExpand(null, {
                        pageOrigin: {
                          x: e.pageX || e.clientX,
                          y: e.pageY || e.clientY,
                        },
                        headingText: this.series.name,
                        maincontentText:
                          Highcharts.dateFormat("%A, %b %e, %Y", this.x) +
                          ":<br/> " +
                          this.y +
                          " sessions",
                        width: 200,
                      });
                    },
                  },
                },
                marker: {
                  lineWidth: 1,
                },
              },
            },

            series: [
              {
                yAxis: 1,
                name: "Price Billet CIS",
                data: ret.price_billet_cis,
              },
              {
                name: "Harga Besi CIS",
                data: ret.besi_cis,
              },
            ],
          });
          Highcharts.chart("kurs_tangshan", {
            chart: {
              scrollablePlotArea: {
                minWidth: 500,
              },
            },
            title: {
              text: "Harga Besi Tangshan Vs Kurs BI",
            },
            xAxis: {
              categories: ret.tgl_harga,
            },
            yAxis: [
              {
                title: {
                  text: "Harga Besi",
                },
              },
              {
                title: {
                  text: "Kurs BI",
                },
                opposite: true,
              },
            ],

            tooltip: {
              shared: true,
              crosshairs: true,
            },
            plotOptions: {
              series: {
                cursor: "pointer",
                point: {
                  events: {
                    click: function (e) {
                      hs.htmlExpand(null, {
                        pageOrigin: {
                          x: e.pageX || e.clientX,
                          y: e.pageY || e.clientY,
                        },
                        headingText: this.series.name,
                        maincontentText:
                          Highcharts.dateFormat("%A, %b %e, %Y", this.x) +
                          ":<br/> " +
                          this.y +
                          " sessions",
                        width: 200,
                      });
                    },
                  },
                },
                marker: {
                  lineWidth: 1,
                },
              },
            },

            series: [
              {
                yAxis: 1,
                name: "Kurs BI",
                data: ret.kurs_bi,
              },
              {
                name: "Harga Besi Tangshan",
                data: ret.besi_tang,
              },
            ],
          });
          Highcharts.chart("kurs_cis", {
            chart: {
              scrollablePlotArea: {
                minWidth: 500,
              },
            },
            title: {
              text: "Harga Besi CIS Vs Kurs BI",
            },
            xAxis: {
              categories: ret.tgl_harga,
            },
            yAxis: [
              {
                title: {
                  text: "Harga Besi",
                },
              },
              {
                title: {
                  text: "Kurs BI",
                },
                opposite: true,
              },
            ],

            tooltip: {
              shared: true,
              crosshairs: true,
            },
            plotOptions: {
              series: {
                cursor: "pointer",
                point: {
                  events: {
                    click: function (e) {
                      hs.htmlExpand(null, {
                        pageOrigin: {
                          x: e.pageX || e.clientX,
                          y: e.pageY || e.clientY,
                        },
                        headingText: this.series.name,
                        maincontentText:
                          Highcharts.dateFormat("%A, %b %e, %Y", this.x) +
                          ":<br/> " +
                          this.y +
                          " sessions",
                        width: 200,
                      });
                    },
                  },
                },
                marker: {
                  lineWidth: 1,
                },
              },
            },

            series: [
              {
                yAxis: 1,
                name: "Kurs BI",
                data: ret.kurs_bi,
              },
              {
                name: "Harga Besi CIS",
                data: ret.besi_cis,
              },
            ],
          });
        });
      }
    },
    enableDelete: function () {
      $("#btnHapus").on("click", function () {
        if ($('input[name="idsData[]"]:checked').length > 0) {
          return confirm("Anda yakin menghapus data yang dipilih?");
        } else {
          alert("Anda belum memilih data untuk dihapus.");
          return false;
        }
      });
    },
    checkAll: function () {
      $("#checkAll").click(function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
      });
    },
    initEvent: function () {
      App.table = $("#table").DataTable({
        language: {
          search: "Cari",
          lengthMenu: "Tampilkan _MENU_ baris per halaman",
          zeroRecords: "Data tidak ditemukan",
          info: "Menampilkan _START_  sampai _END_ dari _MAX_ data",
          infoEmpty: "Tidak ada data yang ditampilkan ",
          infoFiltered: "(pencarian dari _MAX_ total records)",
          paginate: {
            first: "Pertama",
            last: "Terakhir",
            next: "Selanjutnya",
            previous: "Sebelum",
          },
        },
        processing: true,
        serverSide: false,
        searching: true,
        // "paging": true,
        columnDefs: [{ orderable: false, targets: [0, 1] }],
        order: [[2, "desc"]],
      });
    },
    formSubmit: function () {
      if ($("#form").length > 0) {
        $("#save-btn").removeAttr("disabled");
        $("#form").validate({
          rules: {
            tglHarga: {
              required: true,
            },
            priceBilletTangshan: {
              required: true,
            },
            priceBilletCis: {
              required: true,
            },
            kursBi: {
              required: true,
            },
            hargaBesiTangshan: {
              required: true,
            },
            hargaBesiCis: {
              required: true,
            },
            ImportExcel: {
              required: true,
            },
          },
          messages: {
            tglHarga: {
              required: "Tanggal Harus Diisi",
            },
            priceBilletTangshan: {
              required: "Price Billet Tangshan Harus Diisi",
            },
            priceBilletCis: {
              required: "Price Billet CIS Harus Diisi",
            },
            kursBi: {
              required: "Kurs Mid BI Harus Diisi",
            },
            hargaBesiTangshan: {
              required: "Harga Besi Tangshan Harus Diisi",
            },
            hargaBesiCis: {
              required: "Harga Besi CIS Harus Diisi",
            },
            ImportExcel: {
              required: "Import Excel Harus Diisi",
            },
          },
          debug: true,

          errorPlacement: function (error, element) {
            var name = element.attr("name");
            var errorSelector = '.form-control-feedback[for="' + name + '"]';
            var $element = $(errorSelector);
            if ($element.length) {
              $(errorSelector).html(error.html());
            } else {
              error.insertAfter(element);
            }
          },
          submitHandler: function (form) {
            var val;
            function restoreMoneyValueFloatFromStr(str) {
              // fungsi ini utk mengembalikan string dari format money standar ke nilai float
              // nilai float dengan saparator decimal titik biar php/javascript bisa parsing
              var rr = new String(str);
              var r = rr.replace(/ /g, "");
              r = r.replace(/\./g, "");
              r = r.replace(/,/, "#");
              r = r.replace(/,/g, "");
              r = r.replace(/#/, ".");
              return r;
            }

            $('input[name^="harga_periode"]').each(function () {
              val = restoreMoneyValueFloatFromStr($(this).val());
              $(this).val(val);
              //alert(restoreMoneyValueFloatFromStr($(this).val()));
            });
            $('input[name^="harga_periode_upper"]').each(function () {
              val = restoreMoneyValueFloatFromStr($(this).val());
              $(this).val(val);
              //alert(restoreMoneyValueFloatFromStr($(this).val()));
            });

            var val = restoreMoneyValueFloatFromStr($("#price").val());
            $("#price").val(val);

            var val2 = restoreMoneyValueFloatFromStr($("#price_upper").val());
            $("#price_upper").val(val2);
            //return;

            form.submit();
          },
        });
      }
      if ($("#formimp").length > 0) {
        $("#save-btn").removeAttr("disabled");
        $("#formimp").validate({
          rules: {
            ImportExcel: {
              required: true,
            },
          },
          messages: {
            ImportExcel: {
              required: "Import Excel Harus Dipilih",
            },
          },
          debug: true,

          errorPlacement: function (error, element) {
            var name = element.attr("name");
            var errorSelector = '.form-control-feedback[for="' + name + '"]';
            var $element = $(errorSelector);
            if ($element.length) {
              $(errorSelector).html(error.html());
            } else {
              error.insertAfter(element);
            }
          },
          submitHandler: function (form) {
            var val;
            function restoreMoneyValueFloatFromStr(str) {
              // fungsi ini utk mengembalikan string dari format money standar ke nilai float
              // nilai float dengan saparator decimal titik biar php/javascript bisa parsing
              var rr = new String(str);
              var r = rr.replace(/ /g, "");
              r = r.replace(/\./g, "");
              r = r.replace(/,/, "#");
              r = r.replace(/,/g, "");
              r = r.replace(/#/, ".");
              return r;
            }

            $('input[name^="harga_periode"]').each(function () {
              val = restoreMoneyValueFloatFromStr($(this).val());
              $(this).val(val);
              //alert(restoreMoneyValueFloatFromStr($(this).val()));
            });
            $('input[name^="harga_periode_upper"]').each(function () {
              val = restoreMoneyValueFloatFromStr($(this).val());
              $(this).val(val);
              //alert(restoreMoneyValueFloatFromStr($(this).val()));
            });

            var val = restoreMoneyValueFloatFromStr($("#price").val());
            $("#price").val(val);

            var val2 = restoreMoneyValueFloatFromStr($("#price_upper").val());
            $("#price_upper").val(val2);
            //return;

            form.submit();
          },
        });
      }
    },
    yearFilter: function () {
      $("#year_filter").on("change", function () {
        App.initChart($("#bulan_filter").val(), $(this).val());
      });
      $("#bulan_filter").on("change", function () {
        App.initChart($(this).val(), $("#year_filter").val());
      });
    },
    initChart: function (bulan = null, tahun = null) {
      console.log(tahun);
      if (tahun == null) {
        tahun = new Date().getFullYear();
      }
      if (bulan == null) {
        bulan = new Date().getMonth();
      }
      if ($("#salesMonth").length > 0) {
        $.ajax({
          method: "GET",
          url: App.baseUrl + "forecast/getGraphCategory",
          beforeSend: function () {
            $(".loading").show();
          },
          data: { year_filter: tahun, bulan_filter: bulan },
        }).done(function (ret) {
          // $('#loading').hide();
          data = JSON.parse(ret);
          console.log(data.category);
          if (data.category != null) {
            $("#chart-forecast").removeClass("hidden");
            // console.log(data.category)
            Highcharts.chart("salesMonth", {
              chart: {
                type: "arearange",
                zoomType: "xy",
              },
              title: {
                text: "Forecast Kategori",
              },
              subtitle: {
                text: "Tahun " + tahun,
              },
              credits: {
                enabled: false,
              },
              xAxis: {
                categories: data.month,
              },
              yAxis: {
                title: {
                  text: "Sales (Rupiah)",
                },
              },
              tooltip: {
                headerFormat:
                  '<span style="font-size:10px">{point.key}</span><br>',
                // pointFormat:  '{point.y:.2f} Rupiah',
                crosshairs: true,
                shared: true,
              },
              plotOptions: {
                line: {
                  enableMouseTracking: true,
                },
              },
              series: data.category,
            });
          }
        });
      }
    },
  };
});
