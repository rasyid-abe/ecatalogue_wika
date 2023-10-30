define([
  "jQuery",
  "jQueryUI",
  "jqvalidate",
  "bootstrap",
  "sidebar",
  "datatables",
  "datatablesBootstrap",
  "bootstrapDatepicker",
  "select2",
  "numeral",
], function (
  $,
  jQueryUI,
  jqvalidate,
  bootstrap,
  sidebar,
  datatables,
  datatablesBootstrap,
  bootstrapDatepicker,
  select2,
  numeral
) {
  return {
    table: null,
    req: false,
    init: function () {
      App.initFunc();
      App.initEvent();
      App.selectLevel2();
      App.selectLevel3();
      App.selectLevel4();
      App.selectLevel5();
      App.selectLevel6();
      App.selectBerat4();
      App.selectBerat5();
      App.selectBerat6();
      App.selectUom();
      App.initConfirm();
      App.specificationChange();
      App.imagepreview();
      App.initPlugin();
      App.onChangeCategory();
      App.searchTable();
      App.resetSearch();
      App.btnIncludePrice();
      App.generateCodeProduct();
      $(".loadingpage").hide();
    },
    generateCodeProduct: function () {
      var cat;
      var spe;
      var code_fix;

      if ($("#id_yang_dihapus").length > 0) {
        cat =
          $("option:selected", "#category_id").attr("data-code") == undefined
            ? ""
            : $("option:selected", "#category_id").attr("data-code");
        spe =
          $("option:selected", "#specification_id").attr("data-code") ==
          undefined
            ? ""
            : $("option:selected", "#specification_id").attr("data-code");
      }

      /*
            $('#category_id').on('change',function(){
                cat = $('option:selected', this).attr('data-code') == undefined ? '' : $('option:selected', this).attr('data-code');
                gabung();
            })
            */

      $("#specification_id").on("change", function () {
        spe =
          $("option:selected", this).attr("data-code") == undefined
            ? ""
            : $("option:selected", this).attr("data-code");
        category_id = $("option:selected", this).attr("data-category_id");
        $("#category_id").val(category_id);
        console.log(category_id);
        gabung();
      });

      $("#size_id").on("change", function () {
        code_fix =
          $("option:selected", this).attr("data-code") == undefined
            ? ""
            : $("option:selected", this).attr("data-code");
        //console.log(spe);
        gabung();
      });

      var gabung = function () {
        if (cat == undefined || cat == "null") {
          cat = "";
        }

        if (spe == undefined || spe == "null") {
          spe = "";
        }

        if (code_fix == undefined || code_fix == "null") {
          code_fix = "";
        }
        // console.log(cat);
        var code = cat + spe + code_fix;
        $("#code_1").val(code);
      };
    },
    btnIncludePrice: function () {
      $("#btn-tambah-include").on("click", function () {
        var include = $(".include-price");
        var insert =
          include.length == 0 ? $(this).parent().parent() : include.last();
        var is_edit = $(this).attr("data-is-edit");

        $(App.includePriceForm(is_edit)).insertAfter(insert);
      });
    },
    includePriceForm: function (is_edit) {
      var tambahan = "";
      if (is_edit == "true") {
        tambahan =
          '<input type="hidden" name="ket[]" value="insert">' +
          '<input type="hidden" name="pkey[]" value="0">';
      }
      var ret =
        '<div class="form-group row include-price">' +
        tambahan +
        '<div class="col-sm-6">' +
        '<input type="text" name="include_desc[]" class="form-control" placeholder="deskripsi" autocomplete="off">' +
        "</div>" +
        '<div class="col-sm-4">' +
        '<input type="text" name="include_price[]" class="form-control" placeholder="harga" onkeyup="App.format(this)" autocomplete="off">' +
        "</div>" +
        '<div class="col-sm-2">' +
        '<button class="btn btn-danger" type="button" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash-o"></i></button>' +
        "</div>" +
        "</div>";
      return ret;

      /* polosannya
            <div class="form-group row include-price">
                <div class="col-sm-6">
                    <input type="text" name="" id="" class="form-control" placeholder="deskripsi">
                </div>
                <div class="col-sm-6">
                    <input type="text" name="" id="" class="form-control" placeholder="harga">
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
                </div>
            </div>
            */
    },
    addHapusId: function (id) {
      var val = [];
      if ($("#id_yang_dihapus").val() != "") {
        val = $("#id_yang_dihapus").val().split(",");
      }
      val.push(id);
      $("#id_yang_dihapus").val(val.join());
    },
    resetSearch: function () {
      $("#reset").on("click", function () {
        $("#vendor_id").val("").trigger("change");
        $("#category_id").val("").trigger("change");
        $("#specification_id").val("").trigger("change");
        $("#location_id").val("").trigger("change");

        App.table.search("").columns().search("").draw();
      });
    },
    searchTable: function () {
      $("#search").on("click", function () {
        console.log("SEARCH");
        var vendor_id = $("#vendor_id").val();
        var sda_code = $("#sda_code").val();

        App.table.column(3).search(vendor_id, true, true);
        App.table.column(4).search(sda_code, true, true);

        App.table.draw();
      });
    },
    onChangeCategory: function () {
      $("#category_id").on("change", function () {
        //alert($(this).val());
        $.ajax({
          url: App.baseUrl + "specification/getSpecificationByCatId",
          method: "POST",
          data: {
            category_id: $(this).val(),
          },
          dataType: "json",
          success: function (data) {
            if (data.data.length > 0) {
              $("#specification_id").html(
                '<option value="">Pilih Sumber daya</option>'
              );
              for (var i = 0; i < data.data.length; i++) {
                $("#specification_id").append(
                  '<option value="' +
                    data.data[i].id +
                    '" data-code="' +
                    data.data[i].code +
                    '">' +
                    data.data[i].name +
                    "</option>"
                );
              }
            } else {
              $("#specification_id").html(
                '<option value="">Pilih Sumber daya</option>'
              );
            }
          },
        });
      });
    },
    initPlugin: function () {
      $('*select[data-selectjs="true"]').select2({ width: "100%" });
      $(".select-td").select2({
        width: "element",
      });

      var initSelect2 = function () {
        $('*select[data-selectjs="true"]').select2({ width: "100%" });
      };

      $("#is_include").on("click", function () {
        if ($(this).is(":checked")) {
          $("#include_price").prop("readonly", false);
        } else {
          $("#include_price").val(0);
          $("#include_price").prop("readonly", true);
        }
      });
      var count = $("#count_harga").val();
      //alert($('#arrPayment').val());
      var arr =
        $("#arrPayment").val() == undefined
          ? []
          : $("#arrPayment").val().split(",");
      $("#payment_method").on("select2:select", function (e) {
        var combo_location =
          '<option value="" disabled selected>Pilih Lokasi</option>';
        var arr_combo = JSON.parse($("#arrLocation").val());
        $.each(arr_combo, function (index, value) {
          combo_location +=
            '<option value="' + value.id + '">' + value.name + "</option>";
        });

        var form_group = $(this).parent();
        var content =
          '<div class="form-group row" id="for-harga-' +
          e.params.data.id +
          '">';
        content += '<div class="col-lg-4">';
        content += '<label for="">' + e.params.data.text + "</label>";
        content +=
          '<input class="form-control" type="text" name="harga[' +
          e.params.data.id +
          ']" autocomplete="off" required placeholder="' +
          e.params.data.text +
          '" onkeyup="App.format(this)">';
        content += "</div>";
        content += '<div class="col-lg-4">';
        content += '<label for="">Lokasi</label>';
        content +=
          '<select class="form-control" name="location_id_ar[' +
          e.params.data.id +
          ']" data-selectjs="true" required>';
        content += combo_location;
        content += "</select>";
        content += "</div>";
        content += '<div class="col-lg-4">';
        content += '<label for="">Notes</label>';
        content +=
          '<input class="form-control" type="text" name="notes[' +
          e.params.data.id +
          ']" autocomplete="off" placeholder="Notes">';
        content += "</div>";
        content += "</div>";

        if (count == 0) {
          $(content).insertAfter(form_group);
        } else {
          $(content).insertAfter($("#for-harga-" + arr.slice(-1).pop()));
        }

        arr.push(e.params.data.id);
        count++;
        initSelect2();
      });

      $("#payment_method").on("select2:unselect", function (e) {
        var index = arr.indexOf(e.params.data.id);
        if (index !== -1) arr.splice(index, 1);

        $("#for-harga-" + e.params.data.id).empty();

        count--;
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
    selectLevel3: function () {
      $("#level2").on("change", function () {
        let level2 = $("#level2").val();
        $.ajax({
          url: App.baseUrl + "product/get_level3",
          data: { jenis: level2 },
          method: "post",
          dataType: "json",
          success: function (data) {
            level3 = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              level3 +=
                '<option value="' +
                val.code +
                '">' +
                val.code +
                " - " +
                val.name +
                "</option>";
            });
            $("#level3").html(level3).removeAttr("disabled");
          },
        });
      });
    },
    selectLevel4: function () {
      $("#level3").on("change", function () {
        let level3 = $("#level3").val();
        $.ajax({
          url: App.baseUrl + "product/get_level4",
          data: { level3: level3 },
          method: "post",
          dataType: "json",
          success: function (data) {
            level4 = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              level4 +=
                '<option value="' +
                val.code +
                '">' +
                val.code +
                " - " +
                val.name +
                "</option>";
            });
            $("#level4").html(level4).removeAttr("disabled");
          },
        });
      });
    },
    selectLevel5: function () {
      $("#level4").on("change", function () {
        let level4 = $("#level4").val();
        $.ajax({
          url: App.baseUrl + "product/get_level5",
          data: { level4: level4 },
          method: "post",
          dataType: "json",
          success: function (data) {
            level5 = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              level5 +=
                '<option value="' +
                val.code +
                '">' +
                val.code +
                " - " +
                val.name +
                "</option>";
            });
            $("#level5").html(level5).removeAttr("disabled");
          },
        });
      });
    },

    selectLevel6: function () {
      $("#level5").on("change", function () {
        let level5 = $("#level5").val();
        $.ajax({
          url: App.baseUrl + "product/get_level6",
          data: { level5: level5 },
          method: "post",
          dataType: "json",
          success: function (data) {
            level6 = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              level6 +=
                '<option value="' +
                val.code +
                '">' +
                val.code +
                " - " +
                val.name +
                "</option>";
            });
            $("#level6").html(level6).removeAttr("disabled");
          },
        });
      });
    },
    selectBerat4: function () {
      $("#level4").on("change", function () {
        let level4 = $("#level4").val();
        $.ajax({
          url: App.baseUrl + "product/get_berat",
          data: { level: level4 },
          method: "post",
          dataType: "json",
          success: function (data) {
            berat_unit = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              berat_unit +=
                '<option value="' +
                val.berat +
                '" data-key="' +
                val.satuan +
                '">' +
                val.berat +
                "</option>";
            });
            $("#berat_unit").html(berat_unit).removeAttr("disabled");
          },
        });
      });
    },
    selectBerat5: function () {
      $("#level5").on("change", function () {
        let level5 = $("#level5").val();
        $.ajax({
          url: App.baseUrl + "product/get_berat",
          data: { level: level5 },
          method: "post",
          dataType: "json",
          success: function (data) {
            berat_unit = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              berat_unit +=
                '<option value="' +
                val.berat +
                '" data-key="' +
                val.satuan +
                '">' +
                val.berat +
                "</option>";
            });
            $("#berat_unit").html(berat_unit).removeAttr("disabled");
          },
        });
      });
    },
    selectBerat6: function () {
      $("#level6").on("change", function () {
        let level6 = $("#level6").val();
        $.ajax({
          url: App.baseUrl + "product/get_berat",
          data: { level: level6 },
          method: "post",
          dataType: "json",
          success: function (data) {
            berat_unit = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              berat_unit +=
                '<option value="' +
                val.berat +
                '" data-key="' +
                val.satuan +
                '">' +
                val.berat +
                "</option>";
            });
            $("#berat_unit").html(berat_unit).removeAttr("disabled");
          },
        });
      });
    },
    selectUom: function () {
      $("#berat_unit").on("change", function () {
        satuan = $("option:selected", this).attr("data-key");
        $.ajax({
          url: App.baseUrl + "product/get_uom",
          data: { satuan: satuan },
          method: "post",
          dataType: "json",
          success: function (data) {
            uom_id = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              uom_id +=
                '<option value="' + val.id + '">' + val.name + "</option>";
            });
            $("#uom_id").html(uom_id);
          },
        });
      });
    },
    countArray: $("#countArray").val(),
    jsonLocation: JSON.parse($("#arrLocationVendor").val()),
    initEvent: function () {
      // btn on-click row metode pembayaran

      $("#btn-add-row").on("click", function () {
        if (!$("#vendor_id").val()) {
          App.alert("Pilih Vendor Terlebih dulu");
          return false;
        }

        var row = $("#template-row-product").html();
        row = row.replace(/countArraynyaDigantiNanti/g, App.countArray);
        $row = $(row);
        // console.log($row);
        $row
          .find(".select-location")
          .html('<option value="" disabled>Pilih Lokasi</option>');
        locationCount = 0;
        $.each(App.jsonLocation, function (key, value) {
          $row
            .find(".select-location")
            .append(
              '<option value="' +
                value.wilayah_id +
                '">' +
                value.wilayah_name +
                "</option>"
            );
          locationCount++;
        });

        if (locationCount == 0) {
          $row
            .find(".select-location")
            .html('<option value="" disabled>Lokasi tidak tersedia !</option>');
        }

        App.countArray++;
        $("#tbody-row").append($row);
        $(".select-td").select2({
          width: "element",
        });
      });

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
        searching: App.searchDatatable,
        ajax: {
          url: App.baseUrl + "product/dataList",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "id" },
          { data: "vendor_name" },
          { data: "name" },
          { data: "code" },
          { data: "specification_name" },
          // { "data": "price","class": "text-right" },
          { data: "action", orderable: false },
        ],
      });
      $(".dataTables_filter").hide();
      $(".dataTables_info").hide();
      // //append button to datatables
      // add_btn = '<a href="'+App.baseUrl+'product/create" class="btn btn-sm btn-primary ml-2 mt-1"><i class="fa fa-plus"></i> Jabatan</a>';
      // $('#table_filter').append(add_btn);

      if ($("#form").length > 0) {
        $("#vendor_id").on("change", function () {
          $.get(
            App.baseUrl + "vendor_lokasi/getLocationVendor/" + $(this).val(),
            function (result) {
              if (result.status == true) {
                $(".select-location").html(
                  '<option value="" disabled>Pilih Lokasi</option>'
                );
                $.each(result.data, function (key, value) {
                  $(".select-location").append(
                    '<option value="' +
                      value.wilayah_id +
                      '">' +
                      value.wilayah_name +
                      "</option>"
                  );
                });
                App.jsonLocation = result.data;
              } else {
                $(".select-location").html(
                  '<option value="" disabled>Lokasi tidak tersedia !</option>'
                );
                App.jsonLocation = JSON.parse("[]");
              }
              // console.log(App.jsonLocation);
            },
            "json"
          );
        });

        if ($("#is_createpage").val() == 1) {
          App.req = true;
        }

        $("#save-btn").removeAttr("disabled");
        $("#form").validate({
          ignore: [],
          rules: {
            name: {
              required: true,
            },
            code: {
              required: false,
            },
            level1: {
              required: true,
            },
            reference: {
              required: true,
            },
            // size_id: {
            //     required: true
            // },
            price: {
              required: true,
            },
            vendor_id: {
              required: true,
            },
            location_id: {
              required: true,
            },
            uom_id: {
              required: true,
            },
            category_id: {
              required: true,
            },
            volume: {
              required: true,
            },
            product_gallery0: {
              required: App.req,
            },
            // 'location_id_ar[]':"required",
          },
          messages: {
            name: {
              required: "Nama Produk Harus Diisi",
            },
            code: {
              required: "Kode Harus Diisi",
            },
            level1: {
              required: "Sumber Daya Harus Diisi",
            },
            reference: {
              required: "Referensi Harus Diisi",
            },
            size_id: {
              required: "Ukuran Harus Diisi",
            },
            price: {
              required: "Harga Harus Diisi",
            },
            vendor_id: {
              required: "Vendor Harus Diisi",
            },
            location_id: {
              required: "Location Harus Diisi",
            },
            uom_id: {
              required: "Satuan Harus Diisi",
            },
            category_id: {
              required: "Kategori Harus Diisi",
            },
            volume: {
              required: "Volume Harus Diisi",
            },
            product_gallery0: {
              required: "Gambar Utama Harus Diisi",
            },
          },
          debug: true,

          errorPlacement: function (error, element) {
            var name = element.attr("name");
            var errorSelector = '.form-control-feedback[for="' + name + '"]';
            // console.log(name);
            var $element = $(errorSelector);
            if ($element.length) {
              $(errorSelector).html(error.html());
            } else {
              error.insertAfter(element);
            }
          },
          submitHandler: function (form) {
            var num = numeral();
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

            //$('#include_price').val(restoreMoneyValueFloatFromStr($('#include_price').val()))

            $('input[name^="include_price"]').each(function () {
              val = restoreMoneyValueFloatFromStr($(this).val());
              $(this).val(val);
              //alert(restoreMoneyValueFloatFromStr($(this).val()));
            });

            $('input[name^="harga"]').each(function () {
              val = restoreMoneyValueFloatFromStr($(this).val());
              $(this).val(val);
              //alert(restoreMoneyValueFloatFromStr($(this).val()));
            });
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
            $(".loadingpage").show();
            App.table.ajax.reload();
            setTimeout(function () {
              $(".loadingpage").hide();
            }, 500);
          });
        });
      });
    },
    specificationChange: function () {
      $("#specification_id").on("change", function () {
        $("#size_id").empty();
        $("#size_id").append("<option value=''>Pilih Spesifikasi</option>");
        var spec_id = $(this).val();
        size = JSON.parse($("#json_size").val());
        $.each(size, function (i, item) {
          if (item.specification_id == spec_id) {
            $("#size_id").append(
              "<option data-code='" +
                item.code +
                "' value='" +
                item.id +
                "'>" +
                item.name +
                "</option>"
            );
          }
        });
      });
    },

    imagepreview: function () {
      $(".product_images").change(function (d) {
        input = this;
        id = $(this).attr("data-id");
        d.preventDefault();
        var attached = $(this).get(0).files[0];
        var fname = attached.name;
        var ext = fname
          .split("")
          .reverse()
          .join("")
          .split(".")[0]
          .split("")
          .reverse()
          .join("")
          .toLowerCase();
        var allowedFile = ["bmp", "jpg", "jpeg", "gif", "png"];
        var fsize = Math.round(attached.size / 1024) + " KB";
        if (parseInt(fsize) <= 20240 && allowedFile.indexOf(ext) != -1) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
              $("#images" + id).attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
          }
        } else {
          if (allowedFile.indexOf(ext) == -1) {
            App.alert(
              'File "' +
                fname +
                '" tidak didukung, silahkan hanya masukkan file dengan ekstensi ' +
                allowedFile.join(", ").replace(/,(?=[^,]*$)/, " atau")
            );
          } else {
            App.alert("File Terlalu Besar! Maksimal 20MB");
          }
          $(this).val("");
        }
      });
    },
  };
});
