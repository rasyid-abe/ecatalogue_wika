define([
  "jQuery",
  "bootstrap",
  "datatables",
  "datatablesBootstrap",
  "sidebar",
  "select2",
  "bootstrapDatepicker",
], function (
  $,
  bootstrap,
  datatables,
  datatablesBootstrap,
  sidebar,
  select2,
  bootstrapDatepicker
) {
  return {
    table: null,
    init: function () {
      App.initFunc();
      App.initEvent();
      App.searchTable();
      App.resetSearch();
      App.detailProductAmandemen();
      App.initConfirm();
      $(".loadingpage").hide();
    },
    detailProductAmandemen: function () {
      $("#table tbody").on("click", ".detail", function () {
        //$('#amandemen_product_modal').modal('show');
        //return;
        //var id_amandemen = $(this).attr('data-id');
        var proyek_pengguna = $(this).attr("data-proyek_pengguna");
        var vendor = $(this).attr("data-vendor");
        var keterangan = $(this).attr("data-keterangan");
        var tgl_terkontrak = $(this).attr("data-tgl_terkontrak");
        var tgl_akhir_kontrak = $(this).attr("data-tgl_akhir_kontrak");
        var url = App.baseUrl + "data_lelang/detail_data_lelang";
        $.ajax({
          method: "POST",
          url: url,
          dataType: "json",
          data: {
            proyek_pengguna: proyek_pengguna,
            vendor: vendor,
            keterangan: keterangan,
            tgl_terkontrak: tgl_terkontrak,
            tgl_akhir_kontrak: tgl_akhir_kontrak,
          },
        }).done(function (data) {
          //console.log(data);
          var nama_project = proyek_pengguna;
          var nomor_amandemen = vendor;
          $("#table-amandemen tbody").empty();
          $("#nomor_amandemens").html(nama_project + " - " + nomor_amandemen);

          html = "";
          //no = 0;
          $.each(data.data, function (key, value) {
            //console.log(value);
            no = parseInt(key) + 1;
            html +=
              "<tr>\
                        <td>" +
              no +
              "</td>\
                        <td>" +
              value.nama +
              "</td>\
                        <td>" +
              value.spesifikasi +
              "</td>\
                        <td>" +
              value.harga +
              "</td>\
                      ";
          });

          $("#table-amandemen tbody").html(html);
          $("#amandemen_product_modal").modal("show");
        });
      });
    },
    initEvent: function () {
      $("#btn-download-excel").on("click", function () {
        /*
                App.table.column(2).search($("#departemen").val(),true,true);
                App.table.column(4).search($("#nama").val(),true,true);
                App.table.column(5).search($("#spesifikasi").val(),true,true);
                App.table.column(7).search($("#vendor").val(),true,true);
                App.table.column(8).search($("#start_contract").val(),true,true);
                App.table.column(9).search($("#end_contract").val(),true,true);
                App.table.column(13).search($("#lokasi").val(),true,true);
                App.table.column(0).search($("#keterangan").val(),true,true);
                */
        var q_string = {};
        var departemen = $("#departemen").val();
        var nama = $("#nama").val();
        var spesifikasi = $("#spesifikasi").val();
        var vendor = $("#vendor").val();
        var start_contract = $("#start_contract").val();
        var end_contract = $("#end_contract").val();
        var lokasi = $("#lokasi").val();
        var keterangan = $("#keterangan").val();

        if (departemen != "") {
          q_string.departemen = departemen;
        }

        if (nama != "") {
          q_string.nama = nama;
        }

        if (spesifikasi != "") {
          q_string.spesifikasi = spesifikasi;
        }

        if (vendor != "") {
          q_string.vendor = vendor;
        }

        if (start_contract != "") {
          q_string.start_contract = start_contract;
        }

        if (end_contract != "") {
          q_string.end_contract = end_contract;
        }

        if (lokasi != "") {
          q_string.lokasi = lokasi;
        }

        if (keterangan != "") {
          q_string.keterangan = keterangan;
        }

        var i2 = 0;
        var search = "";
        $.each(q_string, function (i, v) {
          if (i2 == 0) {
            //alert('ada?')
            search += "?";
          } else {
            search += "&";
          }

          search += i + "=" + v;

          i2++;
        });

        window.open(App.baseUrl + "data_lelang/exportToExcel" + search);
      });

      $('*[data-datepicker="true"] input[type="text"]').datepicker({
        format: "yyyy-mm-dd",
        orientation: "bottom center",
        autoclose: true,
        todayHighlight: true,
      });

      $('*select[data-selectjs="true"]').select2({ width: "100%" });

      //multiple data
      $("#check-all").click(function () {
        // Ketika user men-cek checkbox all
        if ($(this).is(":checked"))
          // Jika checkbox all diceklis
          $(".check-item").prop("checked", true);
        // ceklis semua checkbox dengan class "check-item"
        // Jika checkbox all tidak diceklis
        else $(".check-item").prop("checked", false); // un-ceklis semua checkbox dengan class "check-item"
      });

      $("#btn-delete").on("click", function () {
        App.confirm("Apakah Anda Yakin Untuk Menghapus Data Ini?", function () {
          $("#form-delete").submit(); // Submit form
        });
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
        //"searching" : false,
        ajax: {
          url: App.baseUrl + "data_lelang/dataList",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "delete_url", orderable: false },
          { data: "id" },
          { data: "departemen" },
          { data: "kategori" },
          { data: "nama" },
          { data: "spesifikasi" },
          { data: "currency" },
          { data: "harga" },
          { data: "vendor" },
          { data: "tgl_terkontrak" },
          { data: "tgl_akhir_kontrak" },
          { data: "volume" },
          { data: "satuan" },
          { data: "proyek_pengguna" },
          { data: "lokasi" },
          { data: "keterangan" },
          { data: "status" },
          { "data": "action" ,"orderable": false}
        ],
      });

      App.table2 = $("#table-history").DataTable({
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
        //"searching" : false,
        ajax: {
          url: App.baseUrl + "data_lelang/history_upload_dataList",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "id", class: "text-center" },
          { data: "first_name" },
          { data: "jml_row" },
          { data: "created_at" },
        ],
      });

      if ($("#table").length > 0) {
        $(".dataTables_filter").hide();
        $(".dataTables_info").hide();
      }
    },
    searchTable: function () {
      $("#search").on("click", function () {
        console.log("SEARCH");

        App.table.column(2).search($("#departemen").val(), true, true);
        App.table.column(4).search($("#nama").val(), true, true);
        App.table.column(5).search($("#spesifikasi").val(), true, true);
        App.table.column(7).search($("#vendor").val(), true, true);
        App.table.column(8).search($("#start_contract").val(), true, true);
        App.table.column(9).search($("#end_contract").val(), true, true);
        App.table.column(13).search($("#lokasi").val(), true, true);
        App.table.column(0).search($("#keterangan").val(), true, true);

        App.table.draw();
      });
    },
    resetSearch: function () {
      $("#reset").on("click", function () {
        $("#vendor").val("").trigger("change");
        $("#departemen").val("").trigger("change");
        $("#keterangan").val("").trigger("change");
        $("#lokasi").val("");
        $("#nama").val("");
        $("#spesifikasi").val("");
        $("#start_contract").val("");
        $("#end_contract").val("");
        //alert('ada?');
        App.table.search("").columns().search("").draw();
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
            $(".loadingpage").show();
            App.table.ajax.reload();
            $("#alert-hapus").show();
            setTimeout(function () {
              $(".loadingpage").hide();
            }, 500);
          });
        });
      });
      $("#table tbody").on("click", ".reject", function () {
        var url = $(this).attr("url");
        App.confirm("Apakah Anda Yakin reject Data lelang ini?", function () {
          $.ajax({
            method: "GET",
            url: url,
            dataType: "json",
          }).done(function (msg) {
            setTimeout(function () {
              if (msg.status == true) {
                App.table.ajax.reload(null, false);
                App.alert("Reject Berhasil");
              } else {
                App.alert("Reject Gagal");
              }
            }, 500);
          });
        });
      });
      $("#table tbody").on("click", ".approve", function () {
        var url = $(this).attr("url");
        App.confirm("Apakah Anda Yakin Approve Data lelang ini?", function () {
          $(".loadingpage").show();
          $.ajax({
            method: "GET",
            url: url,
            dataType: "json",
          }).done(function (msg) {
            $(".loadingpage").hide();
            setTimeout(function () {
              if (msg.status == true) {
                App.table.ajax.reload(null, false);
                App.alert("Approve Berhasil");
              } else {
                App.alert("Approve Gagal");
              }
            }, 500);
          });
        });
      });
    },
  };
});
