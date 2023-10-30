define([
  "jQuery",
  "bootstrap",
  "datatables",
  "datatablesBootstrap",
  "sidebar",
  "jqvalidate",
  "select2",
  "bootstrapDatepicker",
  "Handsontable",
], function (
  $,
  bootstrap,
  datatables,
  datatablesBootstrap,
  sidebar,
  jqvalidate,
  select2,
  bootstrapDatepicker,
  Handsontable
) {
  return {
    table: null,
    init: function () {
      App.initEvent();
      $(".loadingpage").hide();
      App.initConfirm();
      if ($("#generate_harga_baru").length > 0) {
        App.handsonGenerate();
      }

      if ($("#table2").length > 0) {
        $(".dataTables_filter").hide();
      }
    },
    handsonGenerate: function () {
      var container2 = document.getElementById("generate_harga_baru");
      var id_kontrak = $("#id_kontrak_transportasi").val();
      $.ajax({
        url:
          App.baseUrl +
          "kontrak_transportasi/get_harga_for_generate/" +
          id_kontrak,
        type: "GET",
        dataType: "json",
        success: function (result) {
          if (result.data.length > 0) {
            App.status = result.status;
            App.hot2 = new Handsontable(container2, {
              data: result.data,
              columns: result.column,
              height: 320,
              contextMenu: true,
              colHeaders: true,
              stretchH: "all",
              colHeaders: result.header,
              colWidths: [30, 200, 150, 150, 150, 100, 100, 100, 100, 100],
            });

            App.hot2.updateSettings({
              cells: function (row, col, prop) {
                var cellProperties = {};
                if (App.hot2.getData()[row][col] == "-") {
                  cellProperties.readOnly = true;
                }

                if (!isNaN(App.hot2.getData()[row][col])) {
                  cellProperties.type = "numeric";
                  cellProperties.numericFormat = { pattern: "0,0" };
                }

                return cellProperties;
              },
            });
          } else {
            if (id_kontrak != undefined) {
              App.alert("Tidak ada data product", function () {
                window.location.replace(App.baseUrl + "kontrak_transportasi");
              });
            }
          }
        },
      });

      $("#btn-generate").on("click", function () {
        App.confirm("Simpan ?", function () {
          var data = App.hot2.getData();
          $(".loadingpage").show();
          $.ajax({
            url: App.baseUrl + "kontrak_transportasi/act_generate_harga",
            data: {
              data: data,
              status: App.status,
              kontrak_transportasi_id: $("#id_kontrak_transportasi").val(),
            },
            type: "post",
            dataType: "json",
            success: function (result) {
              if (result.status == true) {
                setTimeout(function () {
                  $(".loadingpage").hide();
                  App.alert(result.msg, function () {
                    window.location.replace(
                      App.baseUrl + "kontrak_transportasi"
                    );
                  });
                }, 1000);
              } else {
                alert("tidak ada");
              }
            },
          });
        });
      });
    },
    initConfirm: function () {
      $("#table tbody").on("click", ".delete", function () {
        var url = $(this).attr("url");
        App.confirm("Apakah Anda Yakin Untuk Mengubah Ini?", function () {
          $.ajax({
            method: "GET",
            url: url,
          }).done(function (msg) {
            App.table.ajax.reload(null, true);
          });
        });
      });
    },
    initEvent: function () {
      $('*[data-datepicker="true"] input[type="text"]').datepicker({
        format: "yyyy-mm-dd",
        orientation: "bottom center",
        autoclose: true,
        todayHighlight: true,
      });

      $('*select[data-selectjs="true"]').select2({ width: "100%" });
      $("#data_traller").select2({
        width: "100%",
        tags: true,
        createTag: function (params) {
          return {
            id: params.term,
            text: params.term,
            newOption: true,
          };
        },
      });

      App.table = $("#table").DataTable({
        language: {
          search: "Cari",
          lengthMenu: "Tampilkan _MENU_ baris per halaman",
          zeroRecords: "Data tidak ditemukan",
          info: "Menampilkan _PAGE_ dari _PAGES_",
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
        searching: App.searchDatatable,
        ajax: {
          url: App.baseUrl + "kontrak_transportasi/dataList",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "id", class: "text-center" },
          { data: "no_contract" },
          { data: "vendor_name" },
          { data: "tgl_kontrak" },
          { data: "start_date" },
          { data: "end_date" },
          { data: "action", orderable: false },
        ],
      });

      App.table2 = $("#table2").DataTable({
        language: {
          search: "Cari",
          lengthMenu: "Tampilkan _MENU_ baris per halaman",
          zeroRecords: "Data tidak ditemukan",
          info: "Menampilkan _PAGE_ dari _PAGES_",
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
        ajax: {
          url:
            App.baseUrl +
            "kontrak_transportasi/detail_dataList/" +
            $("#kontrak_transportasi_id").val(),
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "no_kontrak" },
          { data: "vendor_name" },
          { data: "start_contract" },
          { data: "end_contract" },
        ],
      });

      if ($("#form").length > 0) {
        $("#save-btn").removeAttr("disabled");
        $("#form").validate({
          rules: {
            vendor_id: {
              required: true,
            },
            no_contract: {
              required: true,
            },
            start_date: {
              required: true,
            },
            end_date: {
              required: true,
            },
            tgl_kontrak: {
              required: true,
            },
            data_trailer: {
              required: true,
            },
          },
          messages: {
            tgl_kontrak: {
              required: "Tanggal Kontrak harus diisi",
            },
            vendor_id: {
              required: "Vendor harus diisi",
            },
            no_contract: {
              required: "No Kontrak harus diisi",
            },
            start_date: {
              required: "Start date harus diisi",
            },
            end_date: {
              required: "End date harus diisi",
            },
            data_trailer: {
              required: "Data Trailer harus diisi",
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
            App.noFormattedNumber("#weight_minimum");
            // return;
            form.submit();
          },
        });
      }
    },
  };
});
