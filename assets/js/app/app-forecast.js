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
      // App.getdatabtn();
      $(".loadingpage").hide();
    },
    initPlugin: function () {
      $('*select[data-selectjs="true"]').select2({ width: "100%" });
    },
    initEvent: function () {
      // begin untuk memunculkan input All

      $("#periode").on("keyup", function () {
        //alert($(this).val())
        var bulan = parseInt($(this).val());
        if (bulan == 1) {
          $(".input-all").css("display", "none");
          $("#is_input_all").prop("checked", true);
          $(".harga-periode").remove();
          $(".harga").show();
          $(".hargaupper").show();
          //$('.harga-periode').remove();
        } else {
          $(".input-all").css("display", "");
          if (!$("#is_input_all").is(":checked")) {
            $(".harga-periode").remove();
            munculkan();
          }
        }
      });

      var munculkan = function () {
        $(".harga").hide();
        $(".hargaupper").hide();
        var banyak = parseInt($("#periode").val());
        var input = '<div class="row "><div class ="col-md-12">';
        for (var i = 1; i <= banyak; i++) {
          input += forharga(i);
        }

        input += "</div></div>";
        $(input).insertAfter($(".hargaupper"));
      };

      $("#is_input_all").on("click", function () {
        if ($(this).is(":checked")) {
          //alert('OK');
          $(".harga").show();
          $(".hargaupper").show();
          $(".harga-periode").remove();
        } else {
          munculkan();
        }
      });

      var forharga = function (periode) {
        var harga =
          `
                <div class="form-group harga-periode col-md-6">
                    <label for="">Harga Lower Periode Ke - ` +
          periode +
          `</label>
                    <input type="text" class="form-control" name="harga_periode[]" onkeyup="App.format(this)">
                </div>
                <div class="form-group harga-periode col-md-6">
                    <label for="">Harga Upper Periode Ke - ` +
          periode +
          `</label>
                    <input type="text" class="form-control" name="harga_periode_upper[]" onkeyup="App.format(this)">
                </div>
                `;
        return harga;
      };

      // end untuk memunculkan input All
      App.table = $("#table").DataTable({
        language: {
          search: "Cari",
          lengthMenu: "Tampilkan _MENU_ baris per halaman",
          zeroRecords: "Data tidak ditemukan",
          info: "Menampilkan _START_  dari _END_ ",
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
        serverSide: true,
        searching: false,
        order: [[2, "desc"]],
        ajax: {
          url: App.baseUrl + "forecast/dataList",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "id" },
          { data: "category_name" },
          { data: "created_at" },
          { data: "start_month" },
          { data: "year" },
          { data: "periode" },
          { data: "detail", orderable: false },
        ],
      });
    },
    formSubmit: function () {
      if ($("#form").length > 0) {
        $("#save-btn").removeAttr("disabled");
        $("#form").validate({
          rules: {
            category_id: {
              required: true,
            },
            month_forecast: {
              required: true,
            },
            year_forecast: {
              required: true,
            },
            periode: {
              required: true,
            },
            price: {
              required: true,
            },
          },
          messages: {
            category_id: {
              required: "Kategori Harus Diisi",
            },
            month_forecast: {
              required: "Bulan Harus Diisi",
            },
            year_forecast: {
              required: "Tahun Harus Diisi",
            },
            periode: {
              required: "Periode Harus Diisi",
            },
            price: {
              required: "hHarga Harus Diisi",
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
