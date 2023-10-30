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
      App.initHandsonlelang();
      $(".loadingpage").hide();
      localStorage.setItem("items", "OK");
      console.log(localStorage);
    },
    idYangDihapus: [],
    initHandsonlelang: function () {
      $("#btn-generate").removeClass("hidden");

      App.idYangDihapus = [];
      var container = document.getElementById("handsonLelang"),
        kategori = JSON.parse($("#kategori").val()),
        vendor = JSON.parse($("#vendor").val()),
        proyek = JSON.parse($("#proyek").val()),
        uoms = JSON.parse($("#uoms").val()),
        hot;
      // var data = [[0,'', '', 0]];
      var data = [["", "", "", "", "", "", "", "", "", "", ""]];
      var kategoriArr = {};
      var vendorArr = {};
      var proyekArr = {};
      var locationArr = {};
      var uomsArr = {};
      var keteranganArr = {};
      var volumeArr = {};
      var namaArr = {};
      var no_kontrakArr = {};
      var awal_kontrakArr = {};
      var akhir_kontrakArr = {};

      $.get(
        App.baseUrl + "Data_lelang_new/HandsonDataLelang",
        function (result) {
          if (result.status == true) {
            data = result.data;
          }

          kategoriArr = result.kategoriArr;
          vendorArr = result.vendorArr;
          proyekArr = result.projectArr;
          locationArr = result.locationArr;
          uomsArr = result.uomsArr;

          height = data.length > 13 ? data.length * 23.4 : 500;
          App.hot = new Handsontable(container, {
            afterValidate: function (isValid, value, row, prop, source) {
              if (!isValid) {
                var message;
                if (prop == 0 || prop == 1) {
                  message = "Silahkan Pilih kategori dari List";
                } else if (prop == 2) {
                  message = "Masukan data";
                } else {
                  message = "error";
                }
                App.alert(message);
              }
            },
            colWidths: [
              250,
              200,
              200,
              250,
              150,
              100,
              100,
              150,
              150,
              270,
              250,
            ],
            height: 425,
            data: data,
            colHeaders: [
              "SUMBER DAYA",
              "NO.KONTRAK",
              "NAMA",
              "VENDOR",
              "HARGA KONTRAK",
              "VOLUME",
              "SATUAN",
              "AWAL KONTRAK",
              "AKHIR KONTRAK",
              "PROYEK",
              "KETERANGAN",
            ],
            columns: [
              {
                type: "dropdown",
                source: kategori,
                strict: true,
                allowInvalid: false,
              },
              {
                type: "text",
                strict: true,
                allowInvalid: false,
              },
              {
                type: "text",
                strict: true,
                allowInvalid: false,
              },
              {
                type: "dropdown",
                source: vendor,
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
                type: "dropdown",
                source: uoms,
                strict: true,
                allowInvalid: false,
              },
              {
                type: "date",
                strict: true,
                allowInvalid: false,
              },
              {
                type: "date",
                strict: true,
                allowInvalid: false,
              },
              {
                type: "dropdown",
                source: proyek,
                strict: true,
                allowInvalid: false,
              },
              {
                type: "text",
                strict: true,
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
              if (
                (changedCol == 0 || changedCol == 1) &&
                changes[0][11] != ""
              ) {
                // return;
                kategori = this.getDataAtCell(changedRow, 0);
                no_kontrak = this.getDataAtCell(changedRow, 1);
                nama = this.getDataAtCell(changedRow, 2);
                vendor = this.getDataAtCell(changedRow, 3);
                harga_kontrak = this.getDataAtCell(changedRow, 4);
                volume = this.getDataAtCell(changedRow, 5);
                uoms = this.getDataAtCell(changedRow, 6);
                awal_kontrak = this.getDataAtCell(changedRow, 7);
                akhir_kontrak = this.getDataAtCell(changedRow, 8);
                proyek = this.getDataAtCell(changedRow, 9);
                keterangan = this.getDataAtCell(changedRow, 10);
                // console.log(asal);
                isError = false;
                $.each(this.getData(), function (key, value) {
                  if (
                    value[0] == kategori &&
                    value[1] == no_kontrak &&
                    value[2] == nama &&
                    value[3] == vendor &&
                    value[4] == harga_kontrak &&
                    value[5] == volume &&
                    value[6] == uoms &&
                    value[7] == awal_kontrak &&
                    value[8] == akhir_kontrak &&
                    value[9] == proyek &&
                    value[10] == keterangan &&
                    key != changedRow
                  ) {
                    isError = true;
                    return false;
                  }
                });

                if (isError == true) {
                  App.alert("kategori tersebut sudah ada !.");
                  this.setDataAtCell(changedRow, 0, "");
                  this.setDataAtCell(changedRow, 1, "");
                  this.setDataAtCell(changedRow, 2, "");
                  this.setDataAtCell(changedRow, 3, "");
                  this.setDataAtCell(changedRow, 4, "");
                  this.setDataAtCell(changedRow, 5, "");
                  this.setDataAtCell(changedRow, 6, "");
                  this.setDataAtCell(changedRow, 7, "");
                  this.setDataAtCell(changedRow, 8, "");
                  this.setDataAtCell(changedRow, 9, "");
                  this.setDataAtCell(changedRow, 10, "");
                }
              }
              // this.setCellMeta(changedRow, 3, 'valid', false);
              //console.log(this.getData());
            },
          });

          App.hot.updateSettings({
            contextMenu: {
              items: {
                add_datalelang: {
                  name: "Tambah Data Lelang",
                  callback: function (key, options) {
                    row = App.hot.countRows();
                    App.hot.alter("insert_row", row, 1);
                    // App.hot.setDataAtCell(row, 0,'0');
                    App.hot.setDataAtCell(row, 5, 0);
                    App.hot.setDataAtCell(row, 6, 0);
                  },
                },
                del_datalelang: {
                  name: "Hapus Data Lelang",
                  callback: function (key, options) {
                    // console.log(App.hot.getSelected()[0]);
                    var dataRow = App.hot.getDataAtRow(
                      App.hot.getSelected()[0][0]
                    );
                    // console.log(dataRow[0] in locationArr);
                    // if (dataRow[0] in kategoriArr && dataRow[4] in vendorArr && dataRow[7] in satuanArr && dataRow[10] in projectArr && dataRow[11] in locationArr) {
                    //   index =
                    //     kategoriArr[dataRow[0]] + "_" + no_kontrakArr[dataRow[1]] + "_" + namaArr[dataRow[2]] + "_" + spesifikasiArr[dataRow[3]]
                    //   + "_" + vendorArr[dataRow[4]] + "_" + harga_kontrakArr[dataRow[5]] + "_" + volumeArr[dataRow[6]] + "_" + satuanArr[dataRow[7]]
                    //   + "_" + awal_kontrakArr[dataRow[8]] + "_" + akhir_kontrakArr[dataRow[9]] + "_" + projectArr[dataRow[10]] + "_" + locationArr[dataRow[11]]
                    //   + "_" + keteranganArr[dataRow[12]];
                    //   App.idYangDihapus.push(index);
                    // }
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
            url: App.baseUrl + "Data_lelang_new/actSimpanData/",
            type: "POST",
            dataType: "json",
            data: {
              data_yang_dihapus: App.idYangDihapus,
              data: App.hot.getData(),
            },
            success: function (result) {
              if (result.status == true) {
                setTimeout(function () {
                  $(".loadingpage").hide();
                  App.alert(result.msg, function () {
                    window.location.replace(App.baseUrl + "data_lelang_new");
                  });
                }, 1000);
              } else {
                alert("tidak ada");
              }
            },
          });
        });
      });

      // if ($("#initHandsonlelang").length > 0) {
      //   vendor_id = $("#vendorId").val();
      //   if (vendor_id != "0") {
      //     App.initHandsonlelang(vendor_id);
      //   }
      // }

      if ($("#form").length > 0) {
        $("#form").validate({
          rules: {
            kategori: {
              required: true,
            },
            no_kontrak: {
              required: true,
            },
            nama: {
              required: true,
            },
            vendor: {
              required: true,
            },
            harga_kontrak: {
              required: true,
            },
            volume: {
              required: true,
            },
            satuan: {
              required: true,
            },
            awal_kontrak: {
              required: true,
            },
            akhir_kontrak: {
              required: true,
            },
            proyek: {
              required: true,
            },
            keterangan: {
              required: true,
            },
          },
          messages: {
            kategori: {
              required: "Sumber Daya harus diisi",
            },
            no_kontrak: {
              required: "No.Kontrak harus diisi",
            },
            nama: {
              required: "Nama harus diisi",
            },
            vendor: {
              required: "Vendor harus diisi",
            },
            harga_kontrak: {
              required: "Harga harus diisi",
            },
            volume: {
              required: "Volume harus diisi",
            },
            satuan: {
              required: "Satuan harus diisi",
            },
            awal_kontrak: {
              required: "tanggal awal kontrak harus diisi",
            },
            akhir_kontrak: {
              required: "tanggal akhir kontrak harus diisi",
            },
            location: {
              required: "lokasi harus diisi",
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
  };
});
