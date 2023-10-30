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
    table_history: null,
    req: false,
    init: function () {
      App.initFunc();
      App.checkAll();
      App.downloadData();
      App.selectSub();
      App.initEvent();
      App.initConfirm();
      App.specificationChange();
      App.imagepreview();
      App.initPlugin();
      App.onChangeCategory();
      App.searchTable();
      App.resetSearch();
      App.btnIncludePrice();
      App.generateCodeProduct();
      App.setdate();
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
    setdate: function () {
      $('*[data-datepicker="true"] input[type="text"]').datepicker({
        format: "yyyy-mm-dd",
        orientation: "bottom center",
        autoclose: true,
        todayHighlight: true,
      });
    },
    downloadData : function() {
      $("#download_data").on("click", function() {
        if ($('input[name="idsData[]"]:checked').length > 0) {
          var favorite = [];
          $.each($("input[name='idsData[]']:checked"), function(){
            favorite.push($(this).val());
          });
            $('#ids').val(favorite.join(","));
            $('#form_code1').modal('show');
        } else {
            alert('Anda belum memilih data untuk didownload.')
            return false;
        }
        
         
      });
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
    selectSub: function () {
      $("#kategori").on("change", function () {
        let kategori = $("#kategori").val();
        $.ajax({
          url: App.baseUrl + "peralatan/get_kategori",
          data: { kategori: kategori },
          method: "post",
          dataType: "json",
          success: function (data) {
            sub_kategori = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              sub_kategori +=
                '<option value="' +
                val.id +
                '">' +
                val.name +
                "</option>";
            });
            $("#sub_kategori").html(sub_kategori).removeAttr("disabled");
          },
        });
      });
    },
    
    checkAll : function(){
      $("#checkAll").click(function () {
          $('input:checkbox').not(this).prop('checked', this.checked);
      });
    },
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
        searching: true,
        ajax: {
          url: App.baseUrl + "peralatan/dataList",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "cek_data" , orderable: false },
          { data: "id" , orderable: false },
          { data: "jenis_name2" },
          { data: "jenis_name" },
          { data: "name" },
          { data: "no_inventaris" },
          { data: "project_name" },
          { data: "user_name" },
          { data: "updated_at" },
          // { "data": "price","class": "text-right" },
          { data: "action", orderable: false },
        ],
      });

      App.table_history = $("#table_history").DataTable({
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
        searching: true,
        ajax: {
          url: App.baseUrl + "peralatan/list_history",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "id" , orderable: false },
          { data: "tender" },
          { data: "owner" },
          { data: "tgl_tender" },
          { data: "user_name" },
          { data: "divisi_name" },
          { data: "jenis_name" },
          { data: "name" },
          { data: "merek" },
          { data: "no_inventaris" },
          { data: "posisi" },
          { data: "project_name" },
          { data: "created_at" },
          // { "data": "price","class": "text-right" },
        ],
      });

      //$(".dataTables_filter").hide();
      $(".dataTables_info").hide();
      // //append button to datatables
      // add_btn = '<a href="'+App.baseUrl+'product/create" class="btn btn-sm btn-primary ml-2 mt-1"><i class="fa fa-plus"></i> Jabatan</a>';
      // $('#table_filter').append(add_btn);

      if ($("#form").length > 0) {
        $("#save-btn").removeAttr("disabled");
        $("#form").validate({
          ignore: [],
          rules: {
            name: {
              required: true,
            },
            jenis: {
              required: true,
            },
            merek: {
              required: true,
            },
            no_inventaris: {
              required: true,
            },
            // size_id: {
            //     required: true
            // },
            posisi: {
              required: true,
            },
            proyek: {
              required: true,
            },
            divisi: {
              required: true,
            },
          },
          messages: {
            name: {
              required: "Nama Produk Harus Diisi",
            },
            jenis: {
              required: "Jenis Harus Diisi",
            },
            merek: {
              required: "Merek Harus Diisi",
            },
            no_inventaris: {
              required: "No Inventaris Harus Diisi",
            },
            posisi: {
              required: "Posisi Harus Diisi",
            },
            proyek: {
              required: "Proyek Harus Diisi",
            },
            divisi: {
              required: "Divisi Harus Diisi",
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
      if ($("#form_download").length > 0) {
        $("#save-btn").removeAttr("disabled");
        $("#form_download").validate({
          ignore: [],
          rules: {
            tender: {
              required: true,
            },
            owner: {
              required: true,
            },
            tgl_tender: {
              required: true,
            },
            
          },
          messages: {
            tender: {
              required: "Tender Harus Diisi",
            },
            owner: {
              required: "Owner Harus Diisi",
            },
            tgl_tender: {
              required: "Tanggal tender Harus Diisi",
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
            form.submit(location.reload());
          },
        });
      }
    },
    initConfirm: function () {
      $("#table tbody").on("click", ".delete", function () {
        var url = $(this).attr("url");
        App.confirm("Apakah Anda Yakin Untuk menghapus data Ini?", function () {
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
        var allowedFile = ["pdf"];
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
