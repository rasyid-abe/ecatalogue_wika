define([
  "jQuery",
  "bootstrap",
  "datatables",
  "datatablesBootstrap",
  "sidebar",
  "select2",
  "jqvalidate",
  "Handsontable",
], function (
  $,
  bootstrap,
  datatables,
  datatablesBootstrap,
  sidebar,
  select2,
  jqvalidate,
  Handsontable
) {
  return {
    table: null,
    init: function () {
      App.initFunc();
      App.initEvent();
      App.initConfirm();
      App.searchTable();
      App.resetSearch();
      $(".loadingpage").hide();
      $(".dataTables_filter").hide();
      localStorage.setItem("items", "OK");
      console.log(localStorage);
    },
    idYangDihapus: [],
    initHandson: function (vendorId) {
      $("#btn-generate").removeClass("hidden");
      $(".btn-download").removeClass("hidden");

      $(".btn-download").on("click", function () {
        btn = $(this).attr("data-btn");
        if (btn == "transport") {
          window.open(
            App.baseUrl + "transportasi/downloadTransportasi/" + vendorId
          );
        } else {
          window.open(App.baseUrl + "transportasi/downloadWilayah/");
        }
      });

      App.vendorId = vendorId;
      App.idYangDihapus = [];
      var container = document.getElementById("handson"),
        sda = JSON.parse($("#sda").val()),
        data_vendor = JSON.parse($("#data_vendor").val()),
        location = JSON.parse($("#location").val()),
        location_destination = JSON.parse($("#location_destination").val()),
        hot;
      // var data = [[0,'', '', 0]];
      var data = [["", "", "", "", 0, 0, 0, 0, 0]];
      var locationArr = {};
      var projectArr = {};
      var sdaArr = {};
      var vendorArr = {};

      $.get(
        App.baseUrl + "Transportasi/getTransportasiVendor/" + vendorId,
        function (result) {
          if (result.status == true) {
            data = result.data;
          }

          locationArr = result.locationArr;
          projectArr = result.projectArr;
          sdaArr = result.sdaArr;
          vendorArr = result.vendorArr;

          height = data.length > 13 ? data.length * 23.4 : 400;
          App.hot = new Handsontable(container, {
            afterValidate: function (isValid, value, row, prop, source) {
              if (!isValid) {
                var message;
                if (prop == 0) {
                  message = "Silahkan Pilih Kode SDA dari List";
                } else if (prop == 1 || prop == 2) {
                  message = "Silahkan Pilih Lokasi dari List";
                } else if (prop == 3 || prop == 4) {
                  message = "Masukan angka saja";
                } else {
                  message = "error";
                }
                App.alert(message);
              }
            },
            colWidths: [200, 150, 150, 150, 130, 100, 100, 100, 100],
            height: 425,
            data: data,
            colHeaders: [
              "SUMBER DAYA TRANSPORT",
              "VENDOR",
              "ASAL",
              "TUJUAN",
              "BERAT MIN (TON)",
              "FOT SCF 180",
              "FOT TT",
              "FOG SCF 180",
              "FOG TT",
            ],
            columns: [
              {
                type: "dropdown",
                source: sda,
                strict: true,
                allowInvalid: false,
              },
              {
                type: "dropdown",
                source: data_vendor,
                strict: true,
                allowInvalid: false,
              },
              {
                type: "dropdown",
                source: location,
                strict: true,
                allowInvalid: false,
              },
              {
                type: "dropdown",
                source: location_destination,
                strict: true,
                allowInvalid: false,
              },
              {
                type: "numeric",
                numericFormat: { pattern: "0,0" },
                allowInvalid: false,
              },
              {
                type: "numeric",
                numericFormat: { pattern: "0,0" },
                allowInvalid: false,
              },
              {
                type: "numeric",
                numericFormat: { pattern: "0,0" },
                allowInvalid: false,
              },
              {
                type: "numeric",
                numericFormat: { pattern: "0,0" },
                allowInvalid: false,
              },
              {
                type: "numeric",
                numericFormat: { pattern: "0,0" },
                allowInvalid: false,
              },
            ],
            afterChange: function (changes, source) {
              if (!changes) return;

              //console.log(changes);
              //return;
              //console.log(source);
              changedRow = changes[0][0];
              changedCol = changes[0][1];
              if ((changedCol == 0 || changedCol == 1) && changes[0][4] != "") {
                // return;
                kode_sda = this.getDataAtCell(changedRow, 0);
                kode_vendor = this.getDataAtCell(changedRow, 1);
                asal = this.getDataAtCell(changedRow, 2);
                tujuan = this.getDataAtCell(changedRow, 3);
                // console.log(asal);
                isError = false;
                $.each(this.getData(), function (key, value) {
                  if (
                    value[0] == kode_sda &&
                    value[1] == kode_vendor &&
                    value[2] == asal &&
                    value[3] == tujuan &&
                    key != changedRow
                  ) {
                    isError = true;
                    return false;
                  }
                });

                if (isError == true) {
                  App.alert("Lokasi dan tujuan tersebut sudah ada !.");
                  this.setDataAtCell(changedRow, 0, "");
                  this.setDataAtCell(changedRow, 1, "");
                  this.setDataAtCell(changedRow, 2, "");
                  this.setDataAtCell(changedRow, 3, "");
                }
              }
              // this.setCellMeta(changedRow, 3, 'valid', false);
              //console.log(this.getData());
            },
          });

          App.hot.updateSettings({
            contextMenu: {
              items: {
                add_transport: {
                  name: "Tambah Transportasi",
                  callback: function (key, options) {
                    row = App.hot.countRows();
                    App.hot.alter("insert_row", row, 1);
                    // App.hot.setDataAtCell(row, 0,'0');
                    //App.hot.setDataAtCell(row, 2, 0);
                  },
                },
                del_transport: {
                  name: "Hapus Transportasi",
                  callback: function (key, options) {
                    // console.log(App.hot.getSelected()[0]);
                    var dataRow = App.hot.getDataAtRow(
                      App.hot.getSelected()[0][0]
                    );
                    // console.log(dataRow[0] in locationArr);
                    if (
                      dataRow[0] in sdaArr &&
                      dataRow[1] in vendorArr &&
                      dataRow[2] in locationArr &&
                      dataRow[3] in projectArr
                    ) {
                      index =
                        sdaArr[dataRow[0]] +
                        "_" +
                        vendorArr[dataRow[1]] +
                        "_" +
                        locationArr[dataRow[2]] +
                        "_" +
                        projectArr[dataRow[3]];
                      App.idYangDihapus.push(index);
                    }
                    // console.log(App.idYangDihapus);
                    // return;
                    App.hot.alter("remove_row", App.hot.getSelected()[0][0], 1);
                  },
                },
              },
            },
          });
        },
        "json"
      );
    },
    initEvent: function () {
      $("#btn-generate").on("click", function (e) {
        e.preventDefault();
        App.confirm("apakah anda yakin akan menyimpan data?", function () {
          $.ajax({
            url: App.baseUrl + "transportasi/actSimpanHarga/",
            type: "POST",
            dataType: "json",
            data: {
              vendor_id: App.vendorId,
              data_yang_dihapus: App.idYangDihapus,
              data: App.hot.getData(),
            },
            success: function (result) {
              if (result.status == true) {
                alert("Transportasi berhasil disimpan");
              } else {
                alert("Transportasi gagal disimpan");
              }
            },
          });
        });
      });

      if ($("#handson").length > 0) {
        vendor_id = $("#vendorId").val();
        if (vendor_id != "0") {
          App.initHandson(vendor_id);
        }
      }

      $("#vendorSelectHandson").on("change", function () {
        vendor_id = $(this).val();
        App.initHandson(vendor_id);
      });

      $('*select[data-selectjs="true"]').select2({ width: "100%" });

      App.table = $("#table").DataTable({
        language: {
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
          url: App.baseUrl + "transportasi/dataList",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "id", class: "text-center" },
          { data: "vendor_name" },
          { data: "origin_name" },
          { data: "destination_name" },
          { data: "price", class: "text-right" },
          { data: "action", orderable: false },
        ],
      });

      if ($("#form").length > 0) {
        $("#form").validate({
          rules: {
            vendor_id: {
              required: true,
            },
            origin_location_id: {
              required: true,
            },
            destination_location_id: {
              required: true,
            },
            price: {
              required: true,
            },
          },
          messages: {
            vendor_id: {
              required: "Vendor harus diisi",
            },
            origin_location_id: {
              required: "Origin harus diisi",
            },
            destination_location_id: {
              required: "Destinasi harus diisi",
            },
            price: {
              required: "Harga harus diisi",
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
            App.noFormattedNumber("#price");
            form.submit();
          },
        });
      }
    },
    initConfirm: function () {
      $("#table tbody").on("click", ".delete", function () {
        var url = $(this).attr("url");
        App.confirm("Apakah Anda Yakin Untuk Mengubah Ini?", function () {
          $.ajax({
            method: "GET",
            url: url,
          }).done(function (msg) {
            App.table.ajax.reload(null, false);
          });
        });
      });
    },
    resetSearch: function () {
      $("#reset").on("click", function () {
        $("#vendor_id").val("").trigger("change");
        $("#origin_location_id").val("").trigger("change");
        $("#destination_location_id").val("").trigger("change");
        $("#price").val("").trigger("change");

        App.table.search("").columns().search("").draw();
      });
    },
    searchTable: function () {
      $("#search").on("click", function () {
        console.log("SEARCH");
        var vendor_id = $("#vendor_id").val();
        var origin_location_id = $("#origin_location_id").val();
        // console.log(origin_location_id);
        var destination_location_id = $("#destination_location_id").val();
        var price = $("#price").val();

        App.table.column(1).search(vendor_id, true, true);
        App.table.column(2).search(origin_location_id, true, true);
        App.table.column(3).search(destination_location_id, true, true);
        App.table.column(4).search(price, true, true);

        App.table.draw();
      });
    },
  };
});
