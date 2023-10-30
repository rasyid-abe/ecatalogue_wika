define([
  "jQuery",
  "bootstrap",
  "bootstrapDatepicker",
  "datatables",
  "datatablesBootstrap",
  "sidebar",
  "jqvalidate",
  "select2",
  "bootstrapDatetimepicker",
  "daterangepicker",
], function (
  $,
  bootstrap,
  datatables,
  bootstrapDatepicker,
  datatablesBootstrap,
  jqvalidate,
  sidebar,
  bootstrapDatetimepicker,
  daterangepicker
) {
  return {
    table: null,
    init: function () {
      App.initFunc();
      App.initEvent();
      App.initConfirm();
      App.initPlugin();
      App.searchTable();
      App.resetSearch();
      App.btnOrder();
      // $('#order_modal').modal('show');
      // $(".dataTables_filter").hide();
      App.exportToExcel();
      App.selectAlasan();
      $(".loadingpage").hide();
    },
    exportToExcel: function () {
      $("#btn-export-to-excel").on("click", function () {
        var q_string = "";
        var i = 0;
        $.each(App.filter, function (k, v) {
          q_string += i == 0 ? "?" : "&";

          q_string += k + "=" + v;
          i++;
        });

        window.open(
          App.baseUrl + "frontend/orderhistory/export_to_excel" + q_string
        );
      });
    },
    selectAlasan: function () {
      $("#status").on("change", function () {
        let status = $("#status").val();
        $.ajax({
          url: App.baseUrl + "order/get_alasan",
          data: { status: status },
          method: "post",
          dataType: "json",
          success: function (data) {
            alasan = '<option value="">- Pilih -</option>';
            $.each(data, function (key, val) {
              alasan +=
                '<option value="' +
                val.id +
                '">' +
                val.alasan +
                "</option>";
            });
            $("#alasan").html(alasan).removeAttr("disabled");
          },
        });
      });
    },
    initPlugin: function () {
      $('*select[data-selectjs="true"]').select2({ width: "100%" });
      $('*[data-datetimepicker-search="true"] input[type="text"]')
        .datetimepicker({
          format: "YYYY-MM-DD HH:mm:ss",
          useCurrent: "day",
          showClear: true,
        })
        .on("dp.change", function (e) {
          if (!e.oldDate || !e.date.isSame(e.oldDate, "day")) {
            $(this).data("DateTimePicker").hide();
          }
        });
      $("#daterange").daterangepicker();
    },
    initEvent: function () {
      $('*select[data-selectjs="true"]').select2({ width: "100%" });

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
        searching: true, //karena menggunakan filter sendiri
        order: [[6, "desc"]],
        ajax: {
          url: App.baseUrl + "order/dataList",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "id", class: "text-center" },
          { data: "order_no" },
          { data: "perihal" },
          { data: "payment_method_name" },
          { data: "shipping_name" },
          { data: "tonase", class: "text-right" },
          { data: "total_price", class: "text-right" },
          { data: "created_at" },
          { data: "action", orderable: false },
        ],
      });

      $(".dataTables_filter").hide();
      $(".dataTables_info").hide();
    },

    searchTable: function () {
      $("#search").on("click", function () {
        console.log("SEARCH");
        var order_no = $("#order_no").val();
        var nm_project = $("#nm_project").val();
        var daterange = $("#daterange").val();

        var filter = [
          {
            order_no: $("#order_no").val(),
            nm_project: $("#nm_project").val(),
            daterange: $("#daterange").val(),
            no_surat: $("#no_surat").val(),
            vendor_name: $("#vendor_name").val(),
            location_name: $("#location_name").val(),
            perihal: $("#perihal").val(),
            departemen_id: $("#departemen_id").val(),
            po_status: $("#po_status").val(),
          },
        ];

        //var email = $("#email").val();
        App.filter = filter[0];
        App.table.column(1).search(JSON.stringify(filter), true, true);
        console.log(filter);

        App.table.draw();
      });
    },
    filter: [],
    resetSearch: function () {
      $("#reset").on("click", function () {
        $("#order_no").val("");
        $("#nm_project").val("");
        $("#daterange").val("");
        $("#no_surat").val("");
        $("#vendor_name").val("");
        $("#location_name").val("");
        $("#perihal").val("");
        $("#departemen_id").val("").trigger("change");
        $("#po_status").val("1000");

        App.table.search("").columns().search("").draw();
      });
    },

    initConfirm: function () {
      $('#detail_submit').on('click', function () {
        var url = $(this).attr("url_approve");
        var alasan = $("#alasan").val();
        var keterangan = $("#keterangan").val();
        var status = $("#status").val();
        var order_no = $("#order_no").val();
        var users_groups = $("#users_groups").val();
        if (status == 1) {
          var url2 = url + "approve_po/" + order_no + "/" + users_groups;
          var status2 = "Approve";
        }
        else if (status == 2) {
          var url2 = url + "revisi/" + order_no + "/" + users_groups;
          var status2 = "Revisi";
        }
        else if (status == 3) {
          var url2 = url + "reject/" + order_no + "/" + users_groups;
          var status2 = "Cancel";
        }

        App.confirm("Apakah Anda Yakin " + status2 + " PO ini?", function () {
          $(".loadingpage").show();
          $.ajax({
            method: "POST",
            url: url2,
            data: {
              alasan: alasan,
              keterangan: keterangan,
            },
            dataType: 'json',
          }).done(function (msg) {
            setTimeout(function () {
              if (msg.status == true) {
                App.alert(status2 + ' Berhasil');
                location.reload();
              }
              else {
                App.alert(status2 + ' Gagal');
              }
              $(".loadingpage").hide();
            }, 500)
          });
        })
      });
      $("#detail_approve").on("click", function () {
        var url = $(this).attr("url_approve");
        App.confirm("Apakah Anda Yakin Approve PO ini?", function () {
          $(".loadingpage").show();
          $.ajax({
            method: "GET",
            url: url,
            dataType: "json",
          }).done(function (msg) {
            setTimeout(function () {
              if (msg.status == true) {
                App.alert("Approve Berhasil");
                location.reload();
              } else {
                App.alert("Approve Gagal");
              }
            }, 500);
          });
        });
      });

      $("#detail_reject").on("click", function () {
        var url = $(this).attr("url_reject");
        App.confirm("Apakah Anda Yakin reject PO ini?", function () {
          $(".loadingpage").show();
          $.ajax({
            method: "GET",
            url: url,
            dataType: "json",
          }).done(function (msg) {
            setTimeout(function () {
              if (msg.status == true) {
                App.alert("Reject Berhasil");
                location.reload();
              } else {
                App.alert("Reject Gagal");
              }
            }, 500);
          });
        });
      });

      $('#detail_revisi').on('click', function () {
        var url = $(this).attr("url_reject");
        var alasan = $("#alasan").val();
        var keterangan = $("#keterangan").val();
        App.confirm("Apakah Anda Yakin revisi PO ini?", function () {
          $.ajax({
            method: "POST",
            url: url,
            data: {
              alasan: alasan,
              keterangan: keterangan,
            },
            dataType: 'json',
          }).done(function (msg) {
            setTimeout(function () {
              if (msg.status == true) {
                App.alert('Revisi Berhasil');
                window.location.href = msg.url;
              }
              else {
                App.alert('Revisi Gagal');
              }
            }, 500)
          });
        })
      });
      $("#table tbody").on("click", ".reject", function () {
        var url = $(this).attr("url");
        App.confirm("Apakah Anda Yakin reject PO ini?", function () {
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
        App.confirm("Apakah Anda Yakin approve PO ini?", function () {
          $.ajax({
            method: "GET",
            url: url,
            dataType: "json",
          }).done(function (msg) {
            setTimeout(function () {
              if (msg.status == true) {
                App.table.ajax.reload(null, false);
                App.alert("approve Berhasil");
              } else {
                App.alert("approve Gagal");
              }
            }, 500);
          });
        });
      });
    },
    btnOrder: function () {
      if ($("#form_set_order").length > 0) {
        $("#form_set_order").validate({
          rules: {
            dp: {
              required: false,
            },
            no_surat: {
              required: false,
            },
          },
          messages: {
            dp: {
              required: "Uang Muka Harus Diisi",
            },
            no_surat: {
              required: "Nomor Surat Harus Diisi",
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

            var val = restoreMoneyValueFloatFromStr($("#dp").val());
            $("#dp").val(val);

            form.submit();
          },
        });
      }

      $("#table tbody").on("click", ".btn-process", function () {
        $(".form-control").val("");
        $("#order_id").val($(this).attr("data-id"));
        $("#order_modal").modal("show");
      });
    },
  };
});
