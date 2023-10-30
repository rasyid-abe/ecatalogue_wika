define([
  "jQuery",
  "bootstrap",
  "datatables",
  "datatablesBootstrap",
  "jqvalidate",
  "sidebar",
  "bootstrapDatepicker",
  "select2",
  "Handsontable",
], function (
  $,
  bootstrap,
  datatables,
  datatablesBootstrap,
  jqvalidate,
  sidebar,
  bootstrapDatepicker,
  select2,
  Handsontable
) {
  return {
    table: null,
    init: function () {
      App.initEvent();
      App.initConfirm();
      App.selectLevel2();

      App.searchTable();
      App.resetSearch();
      App.setdate();
      //App.onChangeVendor();
      App.detailProductAmandemen();
      if ($("#generate_harga_baru").length > 0) {
        App.handsonGenerate();
      }
      App.saveGenerate();
      $(".loadingpage").hide();
      $('[data-toggle="tooltip"]').tooltip();
    },
    saveGenerate: function () {
      $("#btn-generate").on("click", function () {
        App.confirm("Simpan ?", function () {
          var data = App.hot2.getData();
          //console.log(data);
          var product_id = [],
            payment_id = [],
            project_id = [],
            price = [];

          /*
                    $.each(data,  function( rowKey, object){
                        if (!App.hot2.isEmptyRow(rowKey))
                        {
                            product_id.push(data[rowKey][0]);
                            project_id.push(data[rowKey][1]);
                            payment_id.push(data[rowKey][2]);
                            project_id
                        }
                    });
                    */
          $(".loadingpage").show();
          $.ajax({
            url: App.baseUrl + "kontrak/act_generate_harga",
            data: {
              data: data,
              status: App.status,
              project_id: $("#id_kontrak").val(),
              id_payment_method: App.id_payment_method,
              id_location: App.id_location,
            },
            type: "post",
            dataType: "json",
            success: function (result) {
              if (result.status == true) {
                //$('#alert_modal').modal({backdrop: 'static', keyboard: false});
                setTimeout(function () {
                  $(".loadingpage").hide();
                  App.alert(result.msg, function () {
                    window.location.replace(App.baseUrl + "kontrak");
                  });
                }, 1000);
                /*
                                $('#alert_modal').on('hidden.bs.modal', function () {
                                    window.location.replace(App.baseUrl+'kontrak');
                                })
                                */
              } else {
                alert("tidak ada");
              }
            },
          });
        });
      });
    },
    handsonGenerate: function () {
      var dummy = [
        { id: 1, nama: "Agus", telp: "023", dis: true },
        { id: 2, nama: "Sobari", telp: "321", dis: true },
        { id: 3, nama: "Sobari", telp: "321", dis: false },
        { id: 4, nama: "Sobari", telp: "321", dis: true },
      ];
      var dummy2 = [
        [1, "Nama", 100, "-", "-", 2000],
        [2, "aduh", 300, 5000, "-", 2000],
      ];
      var container2 = document.getElementById("generate_harga_baru");
      var id_kontrak = $("#id_kontrak").val();
      $.ajax({
        url: App.baseUrl + "kontrak/get_harga_for_generate2/" + id_kontrak,
        type: "GET",
        dataType: "json",
        success: function (result) {
          if (result.data.length > 0) {
            App.status = result.status;
            App.id_payment_method = result.id_header;
            App.id_location = result.id_location;
            App.hot2 = new Handsontable(container2, {
              data: result.data,
              columns: result.column,
              height: 320,
              contextMenu: true,
              colHeaders: true,
              stretchH: "all",
              colHeaders: result.header,
              colWidths: 100,
              manualColumnResize: true,
            });

            App.hot2.updateSettings({
              cells: function (row, col, prop) {
                //var a = this.getData(row,col);
                var cellProperties = {};
                //console.log(hot2.getData()[row][col])
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
                window.location.replace(App.baseUrl + "kontrak");
              });
            }
          }
        },
      });
    },
    detailProductAmandemen: function () {
      $("#table2 tbody").on("click", ".detail", function () {
        var id_amandemen = $(this).attr("data-id");
        var url = App.baseUrl + "kontrak/get_detail_amandemen/" + id_amandemen;
        $.ajax({
          method: "GET",
          url: url,
          dataType: "json",
        }).done(function (data) {
          console.log(data);
          var nama_project = data.data[0].project_name;
          var nomor_amandemen =
            data.data[0].no_contract + "-Amd" + data.data[0].no_amandemen;
          $("#table-amandemen tbody").empty();
          $("#nomor_amandemens").html(nama_project + " - " + nomor_amandemen);

          html = "";
          $.each(data.data, function (key, value) {
            no = parseInt(key) + 1;
            html +=
              "<tr>\
                        <td>" +
              no +
              "</td><td>" +
              value.code_full +
              " " +
              value.product_name +
              "</td>";
          });

          $("#table-amandemen tbody").html(html);
          $("#amandemen_product_modal").modal("show");
        });
      });
    },
    onChangeVendor: function () {
      var vendor_id = $("#vendor_id").val();
      var level2 = $("#level2").val();

      var target = "#product_id";
      $.ajax({
        url: App.baseUrl + "product/getProductsByVenId",
        method: "POST",
        data: {
          vendor_id: vendor_id,
          level2: level2,
        },
        dataType: "json",
        success: function (data) {
          //console.log(data.data);
          if (data.data.length > 0) {
            $(target).html('<option value="" disabled>Pilih Produk</option>');
            for (var i = 0; i < data.data.length; i++) {
              $(target).append(
                '<option value="' +
                  data.data[i].id +
                  '">' +
                  data.data[i].name +
                  "</option>"
              );
            }
          } else {
            $(target).html('<option value="" disabled>Pilih Produk</option>');
          }
        },
      });
    },
    setdate: function () {
      $('*[data-datepicker="true"] input[type="text"]').datepicker({
        format: "yyyy-mm-dd",
        orientation: "bottom center",
        autoclose: true,
        todayHighlight: true,
      });
    },
    selectLevel2: function () {
      $("#level1").on("change", function () {
        let level1 = $("#level1").val();
        $.ajax({
          url: App.baseUrl + "product/get_jenis",
          data: { kategori: level1 },
          method: "post",
          dataType: "json",
          success: function (data) {
            level2 = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              level2 +=
                '<option value="' +
                val.code +
                '">' +
                val.code +
                " - " +
                val.name +
                "</option>";
            });
            $("#level2").html(level2).removeAttr("disabled");
          },
        });
      });
    },
    initEvent: function () {
      /*
            begin on change product amandemen
            */

      var get_form = function (id = null, text = null) {
        var product_amandemen =
          `
                <div class="form-group product-amandenen">
                    <label for="inputPassword3" class="col-sm-3 control-label">` +
          text +
          `</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="harga_product[` +
          id +
          `]" id="harga_product_` +
          id +
          `" autocomplete="off" onkeyup="App.format(this)">
                    </div>
                </div>
                `;

        return product_amandemen;
      };

      var form_group;

      $("#product_id_amandemen").on("select2:unselect", function (e) {
        var data = e.params.data;

        element = $("#harga_product_" + data.id)
          .parent()
          .parent();
        element.remove();
      });
      /*
            end on change product amandemen
            */

      $("#departemen").on("select2:select", function (e) {
        var data = e.params.data;

        $.post(
          App.baseUrl + "user/getUsersByGroupId",
          { group_id: data.id },
          function (data) {
            if (data.status) {
              for (var i = 0; i < data.data.length; i++) {
                $("#users").append(
                  '<option value="' +
                    data.data[i].id +
                    '" data-group-id="' +
                    data.data[i].group_id +
                    '">' +
                    data.data[i].first_name +
                    "</option>"
                );
              }
            }
          },
          "json"
        );
      });

      $("#departemen").on("select2:unselect", function (e) {
        var data = e.params.data;

        var cek = $("#users").find("[data-group-id='" + data.id + "']");
        cek.remove();
      });

      $("#departemen_pemantau").on("select2:select", function (e) {
        var data = e.params.data;
        var target = "#user_pemantau";

        $.post(
          App.baseUrl + "user/getUsersByGroupId",
          { group_id: data.id },
          function (data) {
            $(target).html(
              '<option value="" disabled selected>Pilih User</option>'
            );

            if (data.status) {
              for (var i = 0; i < data.data.length; i++) {
                $(target).append(
                  '<option value="' +
                    data.data[i].id +
                    '" data-group-id="' +
                    data.data[i].group_id +
                    '">' +
                    data.data[i].first_name +
                    "</option>"
                );
              }
            }
          },
          "json"
        );
      });

      $('*select[data-selectjs="true"]').select2({ width: "100%" });

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
          url: App.baseUrl + "kontrak/dataList",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "id", class: "text-center" },
          { data: "name" },
          { data: "tanggal" },
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
            App.baseUrl + "kontrak/detail_dataList/" + $("#id_project").val(),
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "no_kontrak" },
          { data: "departemen_name" },
          { data: "vendor_name" },
          { data: "start_contract" },
          { data: "end_contract" },
          { data: "tgl_amandemen" },
          { data: "volume" },
          { data: "harga" },
          { data: "action", orderable: false },
        ],
      });

      if ($("#form").length > 0) {
        $("#save-btn").removeAttr("disabled");
        $("#form").validate({
          rules: {
            name: {
              required: true,
            },
            tgl: {
              required: true,
            },
            deskripsi: {
              required: true,
            },
            departemen_pemantau: {
              required: true,
            },
            user_pemantau: {
              required: true,
            },
            harga: {
              required: true,
            },
            volume: {
              required: true,
            },
            vendor_id: {
              required: true,
            },
            level2: {
              required: true,
            },
          },
          messages: {
            name: {
              required: "Nama Harus Diisi",
            },
            tgl: {
              required: "Tanggal Harus Diisi",
            },
            deskripsi: {
              required: "Deskripsi Harus Diisi",
            },
            departemen_pemantau: {
              required: "Departemen Pemantau Harus Diisi",
            },
            user_pemantau: {
              required: "User Pemantau Harus Diisi",
            },
            harga: {
              required: "Harga Pemantau Harus Diisi",
            },
            volume: {
              required: "Volume Pemantau Harus Diisi",
            },
            vendor_id: {
              required: "Vendor harus diisi",
            },
            level2: {
              required: "level 2 harus diisi",
            },
          },
          debug: true,

          errorPlacement: function (error, element) {
            var name = element.attr("name");
            //console.log(name);
            var errorSelector = '.form-control-feedback[for="' + name + '"]';
            var $element = $(errorSelector);
            if ($element.length) {
              $(errorSelector).html(error.html());
            } else {
              error.insertAfter(element);
            }
          },
          submitHandler: function (form) {
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

            $('input[name^="harga_product"]').each(function () {
              val = restoreMoneyValueFloatFromStr($(this).val());
              $(this).val(val);
              //alert(restoreMoneyValueFloatFromStr($(this).val()));
            });

            App.noFormattedNumber("#harga");
            App.noFormattedNumber("#volume");
            //return;
            form.submit();
          },
        });
      }
    },

    searchTable: function () {
      $("#search").on("click", function () {
        console.log("SEARCH");
        var name = $("#name").val();
        var category_name = $("#category_name").val();

        App.table.column(1).search(category_name, true, true);
        App.table.column(2).search(name, true, true);

        App.table.draw();
      });
    },
    resetSearch: function () {
      $("#reset").on("click", function () {
        $("#name").val("");
        $("#category_name").val("");

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
            dataType: "json",
          }).done(function (result) {
            //alert('ada?');
            if (result.status == true) {
              App.table.ajax.reload(null, true);
            }
          });
        });
      });
    },
  };
});
