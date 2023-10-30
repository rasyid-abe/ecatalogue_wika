define([
  "jQuery",
  "bootstrap4",
  "jqvalidate",
  "datatables",
  "noUiSlider",
  "select2",
  "bootstrapDatepicker",
], function (
  $,
  bootstrap4,
  jqvalidate,
  datatables,
  noUiSlider,
  select2,
  bootstrapDatepicker
) {
  return {
    init: function () {
      App.changeRab();
      App.sdRab();
      App.initFunc();
      App.initEvent();
      App.inpuNumberValidation();
      App.deleteItem();
      App.payCart();
      App.emptyCart();
      //console.log("loaded");
      $(".loadingpage").hide();
      App.onChangeProject();

      //alert(App.toRp('23000.1234222222222222'))
    },
    rpToFloat: function (str) {
      var rr = new String(str);
      var r = rr.replace(/ /g, "");
      r = r.replace(/\./g, "");
      r = r.replace(/,/, "#");
      r = r.replace(/,/g, "");
      r = r.replace(/#/, ".");
      return r;
    },
    totalProduct: 0,
    totalAsuransi: 0,
    totalTransport: 0,
    onChangeProject: function () {
      App.totalProduct = parseInt(App.rpToFloat($("#total_price").text()));
      $("#project_id").on("change", function () {
        var location_project = $("option:selected", this).attr(
          "data-destination_location_id"
        );
        $(".loadingpage").show();
        var id_project = $(this).val();
        is_error = true;
        $.each($(".vendor-transportasi"), function (key, value) {
          location_id = $(this).attr("data-location-id");
          data_vendor = $(this).attr("data-vendor-id");
          
          //console.log(data_vendor);
          vendor_location = $(this).attr("data-vendor-location");
          tr = this;
          $.ajax({
            url: App.baseUrl + "transportasi/cekVendor/",
            type: "POST",
            dataType: "json",
            async: false,
            data: {
              origin_location_id: location_id,
              destination_location_id: location_project,
              project_id: id_project,
              data_vendor: data_vendor,
            },
            success: function (result) {
              if (result.status == true) {
                $("#transportasi_" + vendor_location).html(
                  '<option value="" selected data-key="' +
                    vendor_location +
                    '" data-harga="0">Pilih Vendor</option>'
                );
                $.each(result.data, function (k, new_data) {
                  $("#transportasi_" + vendor_location).append(
                    '<option value="' +
                      new_data.vendor_id +
                      '" data-key="' +
                      vendor_location +
                      '" data-harga="' +
                      new_data.price +
                      '" data-project="' +
                      id_project +
                      '">' +
                      new_data.vendor_name +
                      "</option>"
                  );
                });
              } else {
                $("#transportasi_" + vendor_location).html(
                  '<option value="" selected data-key="' +
                    vendor_location +
                    '" data-harga="0">Pilih Transportasi</option>'
                );
              }
              $("#destination_location_id")
                .val(result.location_id)
                .trigger("change");
              $("#harga_satuan_tranport_" + vendor_location).html("");
              $("#sub_total_tranport_" + vendor_location).html("");
            },
          });

          setTimeout(function () {
            $(".loadingpage").hide();
          }, 500);
        });
      });

      //jika menggunakan transportasi jenis pengiriman dipaksa pindah ke value 2
      $(".is_use_transport").on("click", function () {
        var td = $(this).parent().parent().next();

        if ($(this).is(":checked")) {
          $("#shipping_id").val("2").trigger("change");
          td.find(".for-select-transportasi").removeClass("hidden");
        } else {
          $("#shipping_id").val("1").trigger("change");
          td.find(".for-select-transportasi").addClass("hidden");
          td.find(".vendor-transportasi").val("").trigger("change");
        }
      });

      //jika jenis pengiriman pilih loco (1) maka pilihan transportasi uncheck
      $("#shipping_id").on("change", function (event) {
        /* Act on the event */
        if ($(this).val() == 1) {
          $(".is_use_transport").prop("checked", false);
        }
      });
      /*
            function hitungTotalTransport()
            {
                totalTransport = 0;
                $.each($('.vendor-transportasi'), function(key, value){
                    vendor_location = $(this).attr('data-vendor-location');
                    // totalTransport += $('#transportasi_' + key + ' option:selected').attr('data-harga') * $('#quantity' + key).val() * $('#weight_' + key).val();
                    totalTransport += isNaN(parseInt($('#sub_total_tranport_' + vendor_location).html())) ? 0 : App.rpToFloat($('#sub_total_tranport_' + vendor_location).html());
                    // console.log(totalTransport);
                    //vendor_location
                });
                App.totalTransport = totalTransport;
                App.hitungTotalPrice();
            }
            */
      $(".vendor-transportasi").on("change", function () {
        key = $("option:selected", this).attr("data-key");
        id_project = $("option:selected", this).attr("data-project");
        let id_vendor = $("#transportasi_" + key).val();
        location_id = $(this).attr("data-location-id");
        data_vendor = $(this).attr("data-vendor-id");

        $.ajax({
          url: App.baseUrl + "transportasi/cekTransport/",
          type: "POST",
          dataType: "json",
          async: false,
          data: {
            id_vendor: id_vendor,
            data_vendor: data_vendor,
            origin_location_id: location_id,
            project_id: id_project,
          },
          success: function (result) {
            if (result.status == true) {
              $("#sda_transportasi_" + key).html(
                '<option value="" selected  data-harga="0">Pilih Transportasi</option>'
              );
              $.each(result.data, function (k, new_data) {
                $("#sda_transportasi_" + key).append(
                  '<option value="' +
                    new_data.id +
                    '" data-key="' +
                    key +
                    '" data-project="' +
                    id_project +
                    '" data-vendor="' +
                    id_vendor +
                    '">' +
                    new_data.sda_name +
                    "</option>"
                );
              });
            } else {
              $("#sda_transportasi_" + key).html(
                '<option value="" selected data-harga="0">Pilih Transportasi</option>'
              );
            }
          },
        });
      });
      $(".sda-transportasi").on("change", function () {
        key = $("option:selected", this).attr("data-key");
        id_project = $("option:selected", this).attr("data-project");
        id_vendor = $("option:selected", this).attr("data-vendor");
        let transport_id = $("#sda_transportasi_" + key).val();
        location_id = $(this).attr("data-location-id");

        $.ajax({
          url: App.baseUrl + "transportasi/cekHarga/",
          type: "POST",
          dataType: "json",
          async: false,
          data: {
            transport_id: transport_id,
            id_vendor: id_vendor,
            origin_location_id: location_id,
            project_id: id_project,
          },
          success: function (result) {
            if (result.status == true) {
              $("#harga_transportasi_" + key).html(
                '<option value="0" selected data-key="' +
                  key +
                  '" data-harga="0">Pilih Harga</option>'
              );
              $.each(result.data, function (k, new_data) {
                $("#harga_transportasi_" + key).append(
                  '<option value="' +
                    new_data.harga +
                    '" data-key="' +
                    key +
                    '" data-keterangan="' +
                    new_data.keterangan +
                    '">' +
                    new_data.keterangan +
                    "</option>"
                );
              });
            } else {
              $("#harga_transportasi_" + key).html(
                '<option value="0" data-key="' +
                  key +
                  '" selected data-harga="0">Pilih Harga</option>'
              );
            }
          },
        });
      });
      $(".harga-transportasi").on("change", function () {
        //alert(App.totalAsuransi);
        key = $("option:selected", this).attr("data-key");
        keterangan = $("option:selected", this).attr("data-keterangan");
        price = $("#harga_transportasi_" + key).val();
        qtyBarang = 0;
        weightBarang = 0;
        subTotal = 0;
        arrQty = [];
        arrWeight = [];
        $.each($(".qty_" + key), function (k, v) {
          arrQty.push(parseInt($(this).val()));
          //qtyBarang += parseInt($(this).val());
        });

        $.each($(".weight_" + key), function (k, v) {
          arrWeight.push(parseFloat($(this).val()));
          //weightBarang += parseFloat($(this).val());
        });

        //console.log(arrQty);
        $.each(arrQty, function (a, b) {
          subTotal += price * b * arrWeight[a];
        });

        //subTotal = price * qtyBarang * weightBarang;
        //console.log(price);
        //console.log(subTotal);

        $("#keterangan_satuan_tranport_" + key).val(keterangan);
        $("#harga_satuan_tranport_" + key).html(App.toRp(price));
        $("#sub_total_tranport_" + key).html(App.toRp(subTotal));

        App.hitungTotalTransport();
      });
      /* yang lama
      $(".vendor-transportasi").on("change", function () {
        //alert(App.totalAsuransi);
        key = $("option:selected", this).attr("data-key");
        
        price = $("option:selected", this).attr("data-harga");
        qtyBarang = 0;
        weightBarang = 0;
        subTotal = 0;
        arrQty = [];
        arrWeight = [];
        $.each($(".qty_" + key), function (k, v) {
          arrQty.push(parseInt($(this).val()));
          //qtyBarang += parseInt($(this).val());
        });

        $.each($(".weight_" + key), function (k, v) {
          arrWeight.push(parseFloat($(this).val()));
          //weightBarang += parseFloat($(this).val());
        });

        //console.log(arrQty);
        $.each(arrQty, function (a, b) {
          subTotal += price * b * arrWeight[a];
        });

        //subTotal = price * qtyBarang * weightBarang;
        //console.log(price);
        //console.log(subTotal);

        $("#harga_satuan_tranport_" + key).html(App.toRp(price));
        $("#sub_total_tranport_" + key).html(App.toRp(subTotal));

        App.hitungTotalTransport();
      });
      */
      $("#is_use_asuransi").on("click", function () {
        var input = $("#vendor_asuransi");
        if ($(this).is(":checked")) {
          $(".table-cart tbody").append(
            '<tr id = "biaya_asuransi" style="border-top: 3px solid black;"><td colspan="3"><b>Total Biaya Asuransi</b></td><td id="satuan_asuransi" align="right"></td><td id="sub_sotal_asuransi" align="right"></td><td colspan="2"></td></tr>'
          );
          $("#asuransi_id").prop("required", true);
          input.removeClass("hidden");
        } else {
          App.totalAsuransi = 0;
          $("#biaya_asuransi").remove();
          input.addClass("hidden");
          $("#asuransi_id").prop("required", false);
          $("#asuransi_id").val("").trigger("change");
        }
      });

      $("#asuransi_id").on("change", function () {
        nilai_asuransi = $("option:selected", this).attr("data-nilai_asuransi");
        jenis_asuransi = $("option:selected", this).attr("data-jenis_asuransi");

        $("#satuan_asuransi").html(
          App.toRp(nilai_asuransi) +
            (jenis_asuransi == "percent" ? " %" : " /Kg")
        );

        var total_price = 0,
          total_volume = 0;
        $.each($(".tr-product"), function (key, value) {
          total_price +=
            parseInt($("#quantity" + key).val()) *
            parseInt($("#price_" + key).val()) *
            parseFloat($("#weight_" + key).val());
          total_volume +=
            parseInt($("#quantity" + key).val()) *
            parseFloat($("#weight_" + key).val());
        });

        sub_total_asuransi =
          jenis_asuransi == "percent"
            ? (nilai_asuransi * total_price) / 100
            : total_volume * nilai_asuransi;
        sub_total_asuransi = parseInt(sub_total_asuransi);
        $("#sub_sotal_asuransi").html(App.toRp(sub_total_asuransi));
        App.totalAsuransi = sub_total_asuransi;
        App.hitungTotalPrice();
      });
    },
    hitungTotalTransport: function () {
      totalTransport = 0;
      var harga;
      $.each($(".vendor-transportasi"), function (key, value) {
        vendor_location = $(this).attr("data-vendor-location");
        harga = isNaN(
          parseInt($("#sub_total_tranport_" + vendor_location).html())
        )
          ? 0
          : App.rpToFloat($("#sub_total_tranport_" + vendor_location).html());
        totalTransport += parseInt(harga);
      });
      App.totalTransport = totalTransport;
      App.hitungTotalPrice();
    },
    hitungTotalPrice: function () {
      $("#total_price").html(
        App.toRp(
          parseInt(App.totalProduct) +
            parseInt(App.totalAsuransi) +
            parseInt(App.totalTransport)
        )
      );
    },
    initEvent: function () {
      $('*select[data-selectjs="true"]').select2({ width: "100%" });

      //keluarkan modal feedback jika sudah finishorder
      if ($("#form-finishorder").length > 0) {
        App.modalFeedback("user");
        App.get_list_kategori_feedback();
        $("#dismiss-modal-feedback").attr("style", "display : none");
        $("#modal_feedback").modal({ backdrop: "static", keyboard: false });
      }

      $("#btn-back").on("click", function () {
        window.location.href = App.baseUrl + "home";
      });

      $('*[data-datepicker="true"] input[type="text"]').datepicker({
        format: "yyyy-mm-dd",
        orientation: "bottom center",
        autoclose: true,
        todayHighlight: true,
      });
    },
    payCart: function () {
      if ($("#form-pay").length > 0) {
        $("#save-btn").removeAttr("disabled");
        $("#form-pay").validate({
          rules: {
            perihal: {
              required: true,
            },
            payment_method_id: {
              required: true,
            },
            shipping_id: {
              required: true,
            },
            project_id: {
              required: true,
            },
            smcb_data: {
              required: true,
            },
            periode_pengadaan_pmcs: {
              required: true,
            },
            price_pmcs: {
              required: true,
            },
            catatan: {
              required: true,
            },
            tgl_diambil: {
              required: true,
            },
            destination_location_id: {
              required: true,
            },
          },
          messages: {
            perihal: {
              required: "Perihal Harus Diisi",
            },
            payment_method_id: {
              required: "Metode Pembayaran Harus Diisi",
            },
            shipping_id: {
              required: "Jenis Pengiriman Harus Diisi",
            },
            project_id: {
              required: "Project Harus Diisi",
            },
            smcb_data: {
              required: "SMCB Harus Diisi",
            },
            catatan: {
              required: "Catatan Harus Diisi",
            },
            tgl_diambil: {
              required: "Tanggal Diambil Harus Diisi",
            },
            destination_location_id: {
              required: "Lokasi Destinasi harus dipilih",
            },
            transportasi_id: {
              required: "Transportasi harus dipilih",
            },
            asuransi_id: {
              required: "Asuransi harus dipilih",
            },
          },
          debug: true,

          errorPlacement: function (error, element) {
            $(".loadingpage").hide();
            var name = element.attr("name");
            //console.log(name);
            var errorSelector = '.form-control-feedback[for="' + name + '"]';
            var $element = $(errorSelector);
            if ($element.length) {
              $(errorSelector).html(error.html());
            } else {
              error.addClass("text-danger").insertAfter(element);
            }
          },
          submitHandler: function (form) {
            $(".loadingpage").show();
            var form_data = new FormData($("#form-pay")[0]);
            form_data.append("user_id", $("#users_login_id").val());
            $.ajax({
              method: "POST",
              url: App.baseUrl + "mycart/pay",
              cache: false,
              contentType: false,
              processData: false,
              dataType: "JSON",
              data: form_data,
            })
              .done(function (data, textStatus, errorThrown) {
                if (data.status == true) {
                  window.location.href =
                    App.baseUrl +
                    "feedback/newfeedback/" +
                    data.data.list_id_vendor +
                    (data.email_send == false ? "/email_not_sent" : "");
                } else {
                  $(".loadingpage").hide();
                  if (Array.isArray(data.messages)) {
                    App.alert(data.messages.join(""));
                  } else {
                    App.alert(data.messages);
                  }
                }
              })
              .fail(function (data, textStatus, errorThrown) {
                $(".loadingpage").hide();
                App.alert(errorThrown);
              });
          },
        });
      }
    },
    emptyCart: function () {
      $("#empty_cart").on("click", function () {
        App.confirm(
          "Semua Item Akan Dihapus dan Proses Tidak Dapat Diulang Kembali, Lanjutkan?",
          function () {
            $.ajax({
              method: "GET",
              url: App.baseUrl + "cart/empty_cart",
            }).done(function (data) {
              data = JSON.parse(data);
              if (data.status == false) {
                App.alert(data.messages);
              } else {
                window.location.reload();
              }
            });
          }
        );
      });
    },
    sdRab: function () {
      $("#project_id").on("change", function () {
        let pro_data = $("#project_id").val();
        $.ajax({
          type: "post",
          url: App.baseUrl + "frontend/Mycart/get_smcb",
          data: {
            data: pro_data,
          },
          dataType: "json",
          success: function (response) {
            option_smcb = '<option value="">Pilih Sumber Daya RAB</option>';
            $.each(response, function (key, val) {
              option_smcb +=
                '<option value="' +
                val.id +
                '">' +
                val.smbd_code +
                "-" +
                val.smbd_name +
                "</option>";
            });
            $(".smcb_data").html(option_smcb);
          },
        });
      });
    },
    changeRab: function () {
      $(".smcb_data").on("change", function () {
        let key = $(this).attr("data-changeRab");
        let smcb = $(this).val();
        let pprice = $("#product_price" + key).val();
        $.ajax({
          type: "post",
          url: App.baseUrl + "frontend/Mycart/price_smcb",
          data: {
            data: smcb,
          },
          dataType: "json",
          success: function (res) {
            var pengadaan_tgl = res[0].periode_pengadaan_format;
            var updated_date = res[0].updated_date;
            var price_smcb = res[0].price;

            var selisih = price_smcb - pprice;

            if (selisih < 0) {
              $("#selisih" + key)
                .html(
                  selisih.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
                )
                .css("color", "red");
            } else {
              $("#selisih" + key).html(
                selisih.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
              );
            }
            $("#hrgRab" + key).html(
              price_smcb.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
            );
            $("#tglRab" + key).html(pengadaan_tgl);
            $("#tglUpdated" + key).html(updated_date);

            $("#kethrgRab" + key).html("Harga RAB");
            $("#ketselisih" + key).html("Selisih");
            $("#kettglRab" + key).html("Periode Pengadaan");
            $("#kettglUpdated" + key).html("Updated");

            $(".pengadaan_pmcs" + key).val(res[0].periode_pengadaan);
            $(".price_pmcs" + key).val(price_smcb);
          },
        });
      });
    },
    deleteItem: function () {
      var toRp = function (str) {
        var sf = new String(str);
        var n = new Number(parseFloat(sf));
        n = isNaN(n) ? 0 : n;

        var r = n.toLocaleString();

        r = r.replace(/\./g, "#");
        r = r.replace(/,/g, ".");
        r = r.replace(/#/g, ",");

        var myreg = /([-][0-9\.]*)(,?[0-9]{0,4})/;
        if (myreg.test(r)) {
          r = RegExp.$1 + RegExp.$2;
        }

        return r;
      };

      $(".deleteitem").on("click", function () {
        var pointer = $(this);
        var id_session = $(this).attr("data-session");
        var for_order = $(this).attr("data-for-order");
        var delete_rab = $(this).attr("data-delete-rab");
        // console.log(id_session)
        App.confirm("Item Ini Akan Dihapus, Lanjutkan?", function () {
          $(".loadingpage").show();
          $.ajax({
            method: "POST",
            url: App.baseUrl + "cart/delete",
            data: { id_session: id_session },
          }).done(function (data) {
            data = JSON.parse(data);
            if (data.status == false) {
              App.alert(data.messages);
            } else {
              var cart_notif = $("#cart_notif").text();

              cart_notif = parseInt(cart_notif) - 1;
              $("#cart_notif").text(cart_notif);

              if (cart_notif == 0) {
                $("#cart_notif").addClass("hidden");
              }
              App.totalProduct = data.data["total_price"];
              // $('#total_price').text(toRp(data.data['total_price']));
              $("." + id_session).remove();
              if ($(".qty_" + for_order).length == 0) {
                $("#for_transportasi_" + for_order).remove();
              } else {
                $("#harga_transportasi_" + for_order).trigger("change");
              }
              $("#smcb_data_" + delete_rab).html("");
              App.hitungTotalTransport();
              //pointer.closest('tr').next().next().remove();
              //pointer.closest('tr').next().remove();
              //pointer.parent().parent().remove();
            }
          });
          setTimeout(function () {
            $(".loadingpage").hide();
          }, 500);
        });
      });
    },
    updateCartSessionAjax: function (id_session, jml) {
      $.ajax({
        url: App.baseUrl + "cart/update_cart",
        data: {
          id_session: id_session,
          quantity: jml,
        },
        type: "POST",
        dataType: "json",
        success: function (result) {},
      });
    },
    inpuNumberValidation: function () {
      // first init enable/disable handling
      var toRp = function (str) {
        var sf = new String(str);
        var n = new Number(parseFloat(sf));
        n = isNaN(n) ? 0 : n;

        var r = n.toLocaleString();

        r = r.replace(/\./g, "#");
        r = r.replace(/,/g, ".");
        r = r.replace(/#/g, ",");

        var myreg = /([-][0-9\.]*)(,?[0-9]{0,4})/;
        if (myreg.test(r)) {
          r = RegExp.$1 + RegExp.$2;
        }

        return r;
      };

      var rpToFloat = function (str) {
        var rr = new String(str);
        var r = rr.replace(/ /g, "");
        r = r.replace(/\./g, "");
        r = r.replace(/,/, "#");
        r = r.replace(/,/g, "");
        r = r.replace(/#/, ".");
        return r;
      };
      //alert(toRp(2500000))

      $(".quantity").on("keyup", function () {
        id = $(this).attr("id");
        key = $(this).attr("data-key");
        berat_satuan = parseFloat($(this).attr("data-berat"));

        price = parseInt($(this).attr("data-price"));
        all_price = parseFloat($(this).attr("data-all-price"));
        var all_include_price = parseInt($(this).attr("data-include-price"));
        var currentVal = $(this).val();
        if (!isNaN(currentVal)) {
          temp_price = 0;
          $(".quantity").each(function (index) {
            if (id != $(this).attr("id")) {
              temp_price +=
                $(this).val() * parseInt($(this).attr("data-all-price"));
            }
          });

          temp_price += parseInt(currentVal * all_price);
          //$('#total_price').text(toRp(temp_price));
          berat_total = berat_satuan * currentVal;
          $("#berat_" + id).text(App.toRp(berat_total));

          sub = parseInt(all_price * currentVal);
          $("#sub_" + id).text(toRp(sub));

          App.updateCartSessionAjax(
            $(this).attr("data-id-session"),
            currentVal
          );
          App.totalProduct = temp_price;
          // console.log(App.totalProduct)
          $("#asuransi_id").trigger("change");
          $("#harga_transportasi_" + key).trigger("change");
        }
      });

      var btn_plus = $(".btn-number[data-type=plus]");
      btn_plus.each(function (index) {
        var input = $(this).parent().prev();
        var key = input.attr("data-key");

        if (parseInt(input.val()) > parseInt(input.attr("min"))) {
          // input.prev().find('.btn-number').removeAttr("disabled");
        }
        if (parseInt(input.val()) < parseInt(input.attr("max"))) {
          // input.next().find('.btn-number').removeAttr("disabled");
        }

        // check if event handler already exists
        // if exists, skip this item and go to next item
        if (input.data("click-event")) {
          return true;
        }

        // flag item to prevent attaching handler again
        input.data("click-event", true);

        // set eventhandler if not set
        input
          .next()
          .find(".btn-number")
          .click(function (e) {
            //console.log(this);
            var quantity = $(this).parent().prev();
            berat_satuan = parseFloat(quantity.attr("data-berat"));
            id_session = quantity.attr("data-id-session");
            id = quantity.attr("id");
            e.preventDefault();
            fieldName = $(this).attr("data-field");
            type = $(this).attr("data-type");
            price = parseInt($(this).attr("data-price"));
            all_price = parseFloat($(this).attr("data-all-price"));
            // console.log(all_price);
            var all_include_price = parseInt(
              $(this).attr("data-include-price")
            );
            var input = $(this).parent().prev();
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
              if (currentVal < input.attr("max")) {
                input.val(currentVal + 1).change();
                //temp_price = parseInt(rpToFloat($('#total_price').text()));
                temp_price = App.totalProduct;
                temp_price = temp_price + all_price;
                $("#total_price").text(toRp(temp_price));

                berat_total = berat_satuan * (currentVal + 1);
                $("#berat_" + id).text(App.toRp(berat_total));

                // sub = (all_price + all_include_price) * (currentVal + 1);
                sub = parseInt(all_price * (currentVal + 1));
                $("#sub_" + id).text(toRp(sub));

                App.updateCartSessionAjax(id_session, currentVal + 1);
                App.totalProduct = temp_price;
                $("#asuransi_id").trigger("change");
                $("#harga_transportasi_" + key).trigger("change");
              }
              if (parseInt(input.val()) == input.attr("max")) {
                // $(this).attr('disabled', true);
              }
            } else {
              input.val(0);
            }
          });
        input
          .prev()
          .find(".btn-number")
          .click(function (e) {
            var quantity = $(this).parent().next();
            berat_satuan = parseFloat(quantity.attr("data-berat"));
            id = quantity.attr("id");
            id_session = quantity.attr("data-id-session");

            e.preventDefault();

            fieldName = $(this).attr("data-field");
            type = $(this).attr("data-type");
            price = $(this).attr("data-price");
            all_price = parseFloat($(this).attr("data-all-price"));
            var all_include_price = parseInt(
              $(this).attr("data-include-price")
            );
            var input = $(this).parent().next();
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
              if (currentVal > input.attr("min")) {
                input.val(currentVal - 1).change();
                //temp_price = parseInt(rpToFloat($('#total_price').text()));
                temp_price = App.totalProduct;
                temp_price = temp_price - all_price;
                $("#total_price").text(toRp(temp_price));

                berat_total = berat_satuan * (currentVal - 1);
                $("#berat_" + id).text(App.toRp(berat_total));

                // sub = (all_price + all_include_price) * (currentVal - 1);
                sub = parseInt(all_price * (currentVal - 1));
                $("#sub_" + id).text(toRp(sub));

                App.updateCartSessionAjax(id_session, currentVal - 1);
                App.totalProduct = temp_price;
                $("#asuransi_id").trigger("change");
                $("#harga_transportasi_" + key).trigger("change");
              }
              if (parseInt(input.val()) == input.attr("min")) {
                // $(this).attr('disabled', true);
              }
            } else {
              input.val(0);
            }
          });
      });

      $(".input-number").focusin(function () {
        $(this).data("oldValue", $(this).val());
      });

      $(".input-number").change(function () {
        minValue = parseInt($(this).attr("min"));
        maxValue = parseInt($(this).attr("max"));
        valueCurrent = parseInt($(this).val());
        // console.log(valueCurrent+"-"+minValue)
        // console.log(valueCurrent+"-"+maxValue)

        name = $(this).attr("name");
        if (valueCurrent >= minValue) {
          //console.log("dis")
          $(
            ".btn-number[data-type='minus'][data-field='" + name + "']"
          ).removeAttr("disabled");
        } else {
          $(this).val($(this).data("oldValue"));
        }
        if (valueCurrent <= maxValue) {
          //console.log("disas")
          $(
            ".btn-number[data-type='plus'][data-field='" + name + "']"
          ).removeAttr("disabled");
        } else {
          $(this).val($(this).data("oldValue"));
        }
      });

      $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (
          $.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
          // Allow: Ctrl+A
          (e.keyCode == 65 && e.ctrlKey === true) ||
          // Allow: home, end, left, right
          (e.keyCode >= 35 && e.keyCode <= 39)
        ) {
          // let it happen, don't do anything
          return;
        }
        // Ensure that it is a number and stop the keypress
        if (
          (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) &&
          (e.keyCode < 96 || e.keyCode > 105)
        ) {
          e.preventDefault();
        }
      });
    },
  };
});
