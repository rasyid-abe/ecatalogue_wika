define([
  "jQuery",
  "bootstrap",
  "datatables",
  "datatablesBootstrap",
  "jqvalidate",
  "sidebar",
  "bootstrapDatepicker",
  "select2",
], function (
  $,
  bootstrap,
  datatables,
  datatablesBootstrap,
  jqvalidate,
  sidebar,
  bootstrapDatepicker,
  select2
) {
  return {
    table: null,
    init: function () {
      App.initEvent();
      App.initConfirm();
      App.clearForm();

      App.selectKecamatan();
      App.selectKabupaten();
      App.selectDesa();
      App.selectJenis();
      App.searchTable();
      App.resetSearch();
      $(".loadingpage").hide();
    },
    clearForm: function () {
      $(".show_modal").on("click", function () {
        $("#code").val("");
        $("#name").val("");
        $("#id").val("");
      });
    },
    initEvent: function () {
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
          url: App.baseUrl + "project/dataList",
          dataType: "json",
          type: "POST",
        },
        columns: [
          { data: "id", class: "text-center" },
          { data: "name" },
          { data: "no_spk" },
          { data: "departemen_name" },
          { data: "location_name" },
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
            departemen_id: {
              required: true,
            },
            kategori_id: {
              required: true,
            },
            provinsi: {
              required: true,
            },
            kabupaten: {
              required: true,
            },
            kecamatan: {
              required: true,
            },
            desa: {
              required: true,
            },
            no_spk: {
              required: true,
            },
            alamat: {
              required: true,
            },
            contact_person: {
              required: true,
            },
            no_hp: {
              required: true,
            },
          },
          messages: {
            name: {
              required: "Nama Harus Diisi",
            },
            departemen_id: {
              required: "Departemen Harus Diisi",
            },
            kategori_id: {
              required: "Kategori Harus Diisi",
            },
            provinsi: {
              required: "Provinsi Harus Diisi",
            },
            kabupaten: {
              required: "Kabupaten Harus Diisi",
            },
            kecamatan: {
              required: "Kecamatan Harus Diisi",
            },
            desa: {
              required: "Desa Harus Diisi",
            },
            no_spk: {
              required: "No SPK harus diisi",
            },
            alamat: {
              required: "Alamat harus diisi",
            },
            contact_person: {
              required: "Contact Person harus diis",
            },
            no_hp: {
              required: "No HP Harus diisi",
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
            form.submit();
          },
        });
      }
    },
    selectKabupaten: function () {
      $("#provinsi").on("change", function () {
        let provinsi = $("#provinsi").val();
        $.ajax({
          url: App.baseUrl + "project/get_kabupaten",
          data: { provinsi: provinsi },
          method: "post",
          dataType: "json",
          success: function (data) {
            kabupaten = '<option value="">- Pilih Kabupaten -</option>';
            $.each(data, function (key, val) {
              kabupaten +=
                '<option value="' +
                val.location_id +
                '">' +
                val.full_name +
                "</option>";
            });
            $("#kabupaten").html(kabupaten).removeAttr("disabled");
          },
        });
      });
    },
    selectKecamatan: function () {
      $("#kabupaten").on("change", function () {
        let kabupaten = $("#kabupaten").val();
        $.ajax({
          url: App.baseUrl + "project/get_kecamatan",
          data: { kabupaten: kabupaten },
          method: "post",
          dataType: "json",
          success: function (data) {
            kecamatan = '<option value="">- Pilih Kecamatan -</option>';
            $.each(data, function (key, val) {
              kecamatan +=
                '<option value="' +
                val.location_id +
                '">' +
                val.full_name +
                "</option>";
            });
            $("#kecamatan").html(kecamatan).removeAttr("disabled");
          },
        });
      });
    },
    selectDesa: function () {
      $("#kecamatan").on("change", function () {
        let kecamatan = $("#kecamatan").val();
        $.ajax({
          url: App.baseUrl + "project/get_desa",
          data: { kecamatan: kecamatan },
          method: "post",
          dataType: "json",
          success: function (data) {
            desa = '<option value="">- Pilih Desa -</option>';
            $.each(data, function (key, val) {
              desa +=
                '<option value="' +
                val.location_id +
                '">' +
                val.full_name +
                "</option>";
            });
            $("#desa").html(desa).removeAttr("disabled");
          },
        });
      });
    },
    selectJenis: function () {
      $("#kategori_id").on("change", function () {
        let kategori = $("#kategori_id").val();
        $.ajax({
          url: App.baseUrl + "project/get_jenis",
          data: { kategori: kategori },
          method: "post",
          dataType: "json",
          success: function (data) {
            desa = '<option value="">- Pilih Jenis -</option>';
            $.each(data, function (key, val) {
              desa +=
                '<option value="' + val.id + '">' + val.name + "</option>";
            });
            $("#jenis_id").html(desa).removeAttr("disabled");
          },
        });
      });
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
          }).done(function (msg) {
            App.table.ajax.reload(null, true);
          });
        });
      });
    },
  };
});
