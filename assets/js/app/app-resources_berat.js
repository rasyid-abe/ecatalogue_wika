define([
    "jQuery",
    "jqvalidate",
    "bootstrap",
    "sidebar",
    "datatables",
    "datatablesBootstrap",
    "bootstrapDatepicker",
    "highchart",
    "highchartmore",
    "select2",
], function (
    $,
    jqvalidate,
    bootstrap,
    sidebar,
    datatables,
    datatablesBootstrap,
    bootstrapDatepicker,
    highchart,
    highchartmore,
    select2
) {
    return {
        table: null,
        req: false,
        init: function () {
            App.initFunc();
            App.initEvent();
            App.tblFirst();
            App.level1();
            App.level2();
            App.level3();
            App.level4();
            App.level5();
            App.enableDelete();
            $(".loadingpage").hide();
        },
        tblFirst: function () {
            $.ajax({
                url: App.baseUrl + "resources_berat/show_data",
                dataType: "json",
                success: function (res) {
                    data = res.data;
                    can_edit = res.can_edit;

                    let body = "";
                    $.each(data, function (i, val) {
                        // <td class="text-left">${can_edit == true ? '<a href="#" class="btn btn-xs btn-warning modalUbah" data-toggle="modal" data-target="#form_berat" data-code="'+val.code+'" data-name="'+val.name+'"><i class="fa fa-pencil"></i></a>' : '-'}</td>
                        body += `
                        <tr>
                        <td>${val.code}</td>
                        <td>${val.name}</td>
                        <td>${val.berat1 + " " + val.satuan1}</td>
                        <td>${val.berat2 + " " + val.satuan2}</td>
                        <td>${val.berat3 + " " + val.satuan3}</td>
                        </tr>
                        `;
                    });
                    generate_table(body);
                },
            });

            function generate_table(body) {
                table = `
                <table class="table table-striped" id="table">
                <thead>
                <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Berat 1</th>
                <th>Berat 2</th>
                <th>Berat 3</th>
                </tr>
                </thead>
                <tbody>
                ${body}
                </tbody>
                </table>
                `;

                $("#tblFirst").html(table);

                App.table = $("#table").DataTable({
                    language: {
                        search: "Cari",
                        lengthMenu: "Tampilkan _MENU_ baris per halaman",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan _START_  sampai _END_ dari _MAX_ data",
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
                    serverSide: false,
                    searching: true,
                    order: [[0, "desc"]],
                });

                $("#table").on("click", ".modalUbah", function () {
                    $(".modal-footer button[type=submit]").html("Ubah Data");
                    const code = $(this).data("code");
                    const name = $(this).data("name");
                    $("#code").val(code).prop("readonly", true);
                    $("#name").val(name).prop("readonly", true);
                    $.ajax({
                        url: App.baseUrl + "resources_berat/get_data",
                        data: { code: code },
                        method: "post",
                        dataType: "json",
                        success: function (res) {
                            dat = res.data;
                            sat = res.uoms;

                            $("#berat1").val(dat.berat1);
                            $("#berat2").val(dat.berat2);
                            $("#berat3").val(dat.berat3);

                            sat1 = sat2 = sat3 = select1 = select2 = select3 = "";
                            $.each(sat, function (key, val) {
                                sat1 += `<option value="${val.id}" ${
                                    dat.satuan1 == val.id ? "selected" : ""
                                }>${val.name + " " + val.description}</option>`;
                                sat2 += `<option value="${val.id}" ${
                                    dat.satuan2 == val.id ? "selected" : ""
                                }>${val.name + " " + val.description}</option>`;
                                sat3 += `<option value="${val.id}" ${
                                    dat.satuan3 == val.id ? "selected" : ""
                                }>${val.name + " " + val.description}</option>`;
                            });
                            $("#satuan1").html(sat1);
                            $("#satuan2").html(sat2);
                            $("#satuan3").html(sat3);
                        },
                    });
                });
            }
        },
        level1: function () {
            $("#all_level1").on("change", function () {
                data = $("#all_level1").val();
                $.ajax({
                    url: App.baseUrl + "resources_berat/level_change",
                    data: { data: data },
                    method: "post",
                    dataType: "json",
                    success: function (res) {
                        all_level2 = '<option value="">Pilih Level 2</option>';
                        $.each(res, function (key, val) {
                            all_level2 +=
                            '<option value="' +
                            val.code +
                            '">' +
                            val.code +
                            " - " +
                            val.name +
                            "</option>";
                        });
                        $("#all_level2").html(all_level2).removeAttr("disabled");
                        $("#all_level3")
                        .html('<option value="">Pilih Level 3</option>')
                        .prop("disabled", true);
                        $("#all_level4")
                        .html('<option value="">Pilih Level 4</option>')
                        .prop("disabled", true);
                        $("#all_level5")
                        .html('<option value="">Pilih Level 5</option>')
                        .prop("disabled", true);
                    },
                });
            });
        },
        level2: function () {
            $("#all_level2").on("change", function () {
                data = $("#all_level2").val();

                $.ajax({
                    url: App.baseUrl + "resources_berat/level_change",
                    data: { data: data },
                    method: "post",
                    dataType: "json",
                    success: function (data) {
                        all_level3 = '<option value="">Pilih Level 3</option>';
                        $.each(data, function (key, val) {
                            all_level3 +=
                            '<option value="' +
                            val.code +
                            '">' +
                            val.code +
                            " - " +
                            val.name +
                            "</option>";
                        });
                        $("#all_level3").html(all_level3).removeAttr("disabled");
                        $("#all_level4")
                        .html('<option value="">Pilih Level 4</option>')
                        .prop("disabled", true);
                        $("#all_level5")
                        .html('<option value="">Pilih Level 5</option>')
                        .prop("disabled", true);
                    },
                });
            });
        },
        level3: function () {
            $("#all_level3").on("change", function () {
                $(".loadingpage").show();
                data = $("#all_level3").val();

                $.ajax({
                    url: App.baseUrl + "resources_berat/level_change",
                    data: { data: data },
                    method: "post",
                    dataType: "json",
                    success: function (data) {
                        all_level4 = '<option value="">Pilih Level 4</option>';
                        $.each(data, function (key, val) {
                            all_level4 +=
                            '<option value="' +
                            val.code +
                            '">' +
                            val.code +
                            " - " +
                            val.name +
                            "</option>";
                        });
                        $("#all_level4").html(all_level4).removeAttr("disabled");
                        $("#all_level5")
                        .html('<option value="">Pilih Level 5</option>')
                        .prop("disabled", true);
                        get_level_data($("#all_level3").val());
                    },
                });
            });

            function get_level_data(data) {
                $.ajax({
                    url: App.baseUrl + "resources_berat/show_data_param",
                    data: { data: data, lvl: 3 },
                    method: "post",
                    dataType: "json",
                    success: function (res) {
                        data = res.data;
                        uoms = res.uoms;
                        can_edit = res.can_edit;

                        let body = "";
                        let satuan1 = "";
                        let satuan2 = "";
                        let satuan3 = "";
                        if (data.length > 0) {

                            $.each(uoms, function (ind, v) {
                                satuan1 += `<option value="${v.id}">${v.name}</option>`;
                                satuan2 += `<option value="${v.id}">${v.name}</option>`;
                                satuan3 += `<option value="${v.id}">${v.name}</option>`;
                            })

                            $.each(data, function (i, val) {
                                if (val.satuan1 > 0) {
                                    res_satuan1 =  `<option value="${val.satuan1}">${uoms[val.satuan1 - 1].name}</option>` + satuan1;
                                } else {
                                    res_satuan1 = satuan1;
                                }
                                if (val.satuan2 > 0) {
                                    res_satuan2 =  `<option value="${val.satuan2}">${uoms[val.satuan2 - 1].name}</option>` + satuan2;
                                } else {
                                    res_satuan2 = satuan2;
                                }
                                if (val.satuan3 > 0) {
                                    res_satuan3 =  `<option value="${val.satuan3}">${uoms[val.satuan3 - 1].name}</option>` + satuan3;
                                } else {
                                    res_satuan3 = satuan3;
                                }

                                body += `
                                <tr>
                                <td>${val.code}</td>
                                <td>${val.name}</td>

                                <td>
                                    <input type="number" step="0.001" class="form-control" name="berat1" id="berat1${val.code}" value="${val.berat1 < 1 ? '' : val.berat1}" style="max-width: 120px;">
                                </td>

                                <td>
                                    <select class="form-control form-sm" name="satuan1" id="satuan1${val.code}" style="max-width: 120px;">
                                        ${res_satuan1}
                                    </select>
                                </td>

                                <td>
                                    <input type="number" step="0.001" class="form-control" name="berat2" id="berat2${val.code}" value="${val.berat2 < 1 ? '' : val.berat2}" style="max-width: 120px;">
                                </td>

                                <td>
                                    <select class="form-control form-sm" name="satuan2" id="satuan2${val.code}" style="max-width: 120px;">
                                        ${res_satuan2}
                                    </select>
                                </td>

                                <td>
                                    <input type="number" step="0.001" class="form-control" name="berat3" id="berat3${val.code}" value="${val.berat3 < 1 ? '' : val.berat3}" style="max-width: 120px;">
                                </td>

                                <td>
                                    <select class="form-control form-sm" name="satuan3" id="satuan3${val.code}" style="max-width: 120px;">
                                        ${res_satuan3}
                                    </select>
                                </td>

                                <td class="text-center">${can_edit == true ? '<a href="#" class="btn btn-sm btn-success btn_store" data-code="'+val.code+'" data-name="'+val.name+'"><i class="fa fa-save"></i> </a>' : '-'}
                                </td>

                                </tr>
                                `;
                            });
                            generate_table(body);
                        } else {
                            generate_table(body);
                        }
                    },
                });
            }

            function generate_table(body) {
                table = `
                <table class="table table-striped" id="table">
                <thead>
                <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Berat 1</th>
                <th>Satuan 1</th>
                <th>Berat 2</th>
                <th>Satuan 2</th>
                <th>Berat 3</th>
                <th>Satuan 3</th>
                <th class="text-center">Save</th>
                </tr>
                </thead>
                <tbody>
                ${body}
                </tbody>
                </table>
                `;

                $("#tblFirst").html(table);

                App.table = $("#table").DataTable({
                    language: {
                        search: "Cari",
                        lengthMenu: "Tampilkan _MENU_ baris per halaman",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan _START_  sampai _END_ dari _MAX_ data",
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
                    serverSide: false,
                    searching: true,
                    order: [[0, "desc"]],
                });
                $(".loadingpage").hide();

                $("#table").on("click", ".btn_store", function () {
                    const code = $(this).data("code");
                    const name = $(this).data("name");
                    $.ajax({
                        url: App.baseUrl + "resources_berat/store",
                        data: {
                            code: code,
                            name: name,
                            berat1: $('#berat1'+code).val(),
                            berat2: $('#berat2'+code).val(),
                            berat3: $('#berat3'+code).val(),
                            satuan1: $('#satuan1'+code).val(),
                            satuan2: $('#satuan2'+code).val(),
                            satuan3: $('#satuan3'+code).val(),
                            status: 1,
                        },
                        method: "post",
                        dataType: "json",
                        success: function (res) {
                            if (res.status) {
                                App.alert(res.pesan);
                            }
                        },
                    });
                });
            }
        },
        level4: function () {
            $("#all_level4").on("change", function () {
                $(".loadingpage").show();
                data = $("#all_level4").val();
                $.ajax({
                    url: App.baseUrl + "resources_berat/level_change",
                    data: { data: data },
                    method: "post",
                    dataType: "json",
                    success: function (res) {
                        all_level5 = '<option value="">Pilih Level 5</option>';
                        $.each(res, function (key, val) {
                            all_level5 +=
                            '<option value="' +
                            val.code +
                            '">' +
                            val.code +
                            " - " +
                            val.name +
                            "</option>";
                        });
                        $("#all_level5").html(all_level5).removeAttr("disabled");

                        get_level_data(data);
                    },
                });
            });

            // function get_level_data(data) {
            //     $.ajax({
            //         url: App.baseUrl + "resources_berat/show_data_param",
            //         data: { data: data, lvl: 4 },
            //         method: "post",
            //         dataType: "json",
            //         success: function (res) {
            //             data = res.data;
            //             can_edit = res.can_edit;
            //
            //             let body = "";
            //             if (data.length > 0) {
            //                 $.each(data, function (i, val) {
            //                     body += `
            //                     <tr>
            //                     <td class="text-left">${can_edit == true ? '<a href="#" class="btn btn-xs btn-info modalUbah" data-toggle="modal" data-target="#form_berat" data-code="'+val.code+'" data-name="'+val.name+'"><i class="fa fa-plus"></i> </a>' : '-'}
            //                     </td>
            //                     <td>${val.code}</td>
            //                     <td>${val.name}</td>
            //                     </tr>
            //                     `;
            //                 });
            //                 generate_table(body);
            //             } else {
            //                 generate_table(body);
            //             }
            //         },
            //     });
            // }
            //
            // function generate_table(body) {
            //     table = `
            //     <table class="table table-striped" id="table">
            //     <thead>
            //     <tr>
            //     <th class="text-left">#</th>
            //     <th>Kode</th>
            //     <th>Nama</th>
            //     </tr>
            //     </thead>
            //     <tbody>
            //     ${body}
            //     </tbody>
            //     </table>
            //     `;
            //
            //     $("#tblFirst").html(table);
            //
            //     App.table = $("#table").DataTable({
            //         language: {
            //             search: "Cari",
            //             lengthMenu: "Tampilkan _MENU_ baris per halaman",
            //             zeroRecords: "Data tidak ditemukan",
            //             info: "Menampilkan _START_  sampai _END_ dari _MAX_ data",
            //             infoEmpty: "Tidak ada data yang ditampilkan ",
            //             infoFiltered: "(pencarian dari _MAX_ total records)",
            //             paginate: {
            //                 first: "Pertama",
            //                 last: "Terakhir",
            //                 next: "Selanjutnya",
            //                 previous: "Sebelum",
            //             },
            //         },
            //         processing: true,
            //         serverSide: false,
            //         searching: true,
            //         order: [[0, "desc"]],
            //     });
            //
            //     $(".loadingpage").hide();
            //
            //     $("#table").on("click", ".modalUbah", function () {
            //         const code = $(this).data("code");
            //         const name = $(this).data("name");
            //         $("#code").val(code).prop("readonly", true);
            //         $("#name").val(name).prop("readonly", true);
            //         $.ajax({
            //             url: App.baseUrl + "resources_berat/get_data",
            //             data: { code: code },
            //             method: "post",
            //             dataType: "json",
            //             success: function (res) {
            //                 dat = res.data;
            //                 sat = res.uoms;
            //
            //                 if (dat != null) {
            //                     sat1 = sat2 = sat3 = select1 = select2 = select3 = "";
            //                     $.each(sat, function (key, val) {
            //                         sat1 += `<option value="${val.id}" ${
            //                             dat.satuan1 == val.id ? "selected" : ""
            //                         }>${val.name + " " + val.description}</option>`;
            //                         sat2 += `<option value="${val.id}" ${
            //                             dat.satuan2 == val.id ? "selected" : ""
            //                         }>${val.name + " " + val.description}</option>`;
            //                         sat3 += `<option value="${val.id}" ${
            //                             dat.satuan3 == val.id ? "selected" : ""
            //                         }>${val.name + " " + val.description}</option>`;
            //                     });
            //                     $("#satuan1").html(sat1);
            //                     $("#satuan2").html(sat2);
            //                     $("#satuan3").html(sat3);
            //
            //                     $("#berat1").val(data.berat1);
            //                     $("#berat2").val(data.berat2);
            //                     $("#berat3").val(data.berat3);
            //                 } else {
            //                     console.log(sat);
            //                     sat1 = sat2 = sat3 = select1 = select2 = select3 = "";
            //                     $.each(sat, function (key, val) {
            //                         sat1 += `<option value="${val.id}" >${
            //                             val.name + " " + val.description
            //                         }</option>`;
            //                         sat2 += `<option value="${val.id}" >${
            //                             val.name + " " + val.description
            //                         }</option>`;
            //                         sat3 += `<option value="${val.id}" >${
            //                             val.name + " " + val.description
            //                         }</option>`;
            //                     });
            //                     $("#satuan1").html(sat1);
            //                     $("#satuan2").html(sat2);
            //                     $("#satuan3").html(sat3);
            //
            //                     $("#berat1").val("");
            //                     $("#berat2").val("");
            //                     $("#berat3").val("");
            //                 }
            //             },
            //         });
            //     });
            // }

            function get_level_data(data) {
                $.ajax({
                    url: App.baseUrl + "resources_berat/show_data_param",
                    data: { data: data, lvl: 4 },
                    method: "post",
                    dataType: "json",
                    success: function (res) {
                        console.log(res);
                        data = res.data;
                        uoms = res.uoms;
                        can_edit = res.can_edit;

                        let body = "";
                        let satuan1 = "";
                        let satuan2 = "";
                        let satuan3 = "";
                        if (data.length > 0) {

                            $.each(uoms, function (ind, v) {
                                satuan1 += `<option value="${v.id}">${v.name}</option>`;
                                satuan2 += `<option value="${v.id}">${v.name}</option>`;
                                satuan3 += `<option value="${v.id}">${v.name}</option>`;
                            })

                            $.each(data, function (i, val) {
                                if (val.satuan1 > 0) {
                                    res_satuan1 =  `<option value="${val.satuan1}">${uoms[val.satuan1 - 1].name}</option>` + satuan1;
                                } else {
                                    res_satuan1 = satuan1;
                                }
                                if (val.satuan2 > 0) {
                                    res_satuan2 =  `<option value="${val.satuan2}">${uoms[val.satuan2 - 1].name}</option>` + satuan2;
                                } else {
                                    res_satuan2 = satuan2;
                                }
                                if (val.satuan3 > 0) {
                                    res_satuan3 =  `<option value="${val.satuan3}">${uoms[val.satuan3 - 1].name}</option>` + satuan3;
                                } else {
                                    res_satuan3 = satuan3;
                                }

                                body += `
                                <tr>
                                <td>${val.code}</td>
                                <td>${val.name}</td>

                                <td>
                                <input type="number" step="0.001" class="form-control" name="berat1" id="berat1${val.code}" value="${val.berat1 < 1 ? '' : val.berat1}" style="max-width: 120px;">
                                </td>

                                <td>
                                <select class="form-control form-sm" name="satuan1" id="satuan1${val.code}" style="max-width: 120px;">
                                ${res_satuan1}
                                </select>
                                </td>

                                <td>
                                <input type="number" step="0.001" class="form-control" name="berat2" id="berat2${val.code}" value="${val.berat2 < 1 ? '' : val.berat2}" style="max-width: 120px;">
                                </td>

                                <td>
                                <select class="form-control form-sm" name="satuan2" id="satuan2${val.code}" style="max-width: 120px;">
                                ${res_satuan2}
                                </select>
                                </td>

                                <td>
                                <input type="number" step="0.001" class="form-control" name="berat3" id="berat3${val.code}" value="${val.berat3 < 1 ? '' : val.berat3}" style="max-width: 120px;">
                                </td>

                                <td>
                                <select class="form-control form-sm" name="satuan3" id="satuan3${val.code}" style="max-width: 120px;">
                                ${res_satuan3}
                                </select>
                                </td>

                                <td class="text-center">${can_edit == true ? '<a href="#" class="btn btn-sm btn-success btn_store" data-code="'+val.code+'" data-name="'+val.name+'"><i class="fa fa-save"></i> </a>' : '-'}
                                </td>

                                </tr>
                                `;
                            });
                            generate_table(body);
                        } else {
                            generate_table(body);
                        }
                    },
                });
            }

            function generate_table(body) {
                table = `
                <table class="table table-striped" id="table">
                <thead>
                <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Berat 1</th>
                <th>Satuan 1</th>
                <th>Berat 2</th>
                <th>Satuan 2</th>
                <th>Berat 3</th>
                <th>Satuan 3</th>
                <th class="text-center">Save</th>
                </tr>
                </thead>
                <tbody>
                ${body}
                </tbody>
                </table>
                `;

                $("#tblFirst").html(table);

                App.table = $("#table").DataTable({
                    language: {
                        search: "Cari",
                        lengthMenu: "Tampilkan _MENU_ baris per halaman",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan _START_  sampai _END_ dari _MAX_ data",
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
                    serverSide: false,
                    searching: true,
                    order: [[0, "desc"]],
                });
                $(".loadingpage").hide();

                $("#table").on("click", ".btn_store", function () {
                    const code = $(this).data("code");
                    const name = $(this).data("name");
                    $.ajax({
                        url: App.baseUrl + "resources_berat/store",
                        data: {
                            code: code,
                            name: name,
                            berat1: $('#berat1'+code).val(),
                            berat2: $('#berat2'+code).val(),
                            berat3: $('#berat3'+code).val(),
                            satuan1: $('#satuan1'+code).val(),
                            satuan2: $('#satuan2'+code).val(),
                            satuan3: $('#satuan3'+code).val(),
                            status: 1,
                        },
                        method: "post",
                        dataType: "json",
                        success: function (res) {
                            if (res.status) {
                                App.alert(res.pesan);
                            }
                        },
                    });
                });
            }
        },
        level5: function () {
            $("#all_level5").on("change", function () {
                $(".loadingpage").show();
                data = $("#all_level5").val();
                get_level_data(data);
            });

            function get_level_data(data) {
                $.ajax({
                    url: App.baseUrl + "resources_berat/show_data_param",
                    data: { data: data, lvl: 5 },
                    method: "post",
                    dataType: "json",
                    success: function (res) {
                        data = res.data;
                        uoms = res.uoms;
                        can_edit = res.can_edit;

                        let body = "";
                        let satuan1 = "";
                        let satuan2 = "";
                        let satuan3 = "";
                        if (data.length > 0) {

                            $.each(uoms, function (ind, v) {
                                satuan1 += `<option value="${v.id}">${v.name}</option>`;
                                satuan2 += `<option value="${v.id}">${v.name}</option>`;
                                satuan3 += `<option value="${v.id}">${v.name}</option>`;
                            })

                            $.each(data, function (i, val) {
                                if (val.satuan1 > 0) {
                                    res_satuan1 =  `<option value="${val.satuan1}">${uoms[val.satuan1 - 1].name}</option>` + satuan1;
                                } else {
                                    res_satuan1 = satuan1;
                                }
                                if (val.satuan2 > 0) {
                                    res_satuan2 =  `<option value="${val.satuan2}">${uoms[val.satuan2 - 1].name}</option>` + satuan2;
                                } else {
                                    res_satuan2 = satuan2;
                                }
                                if (val.satuan3 > 0) {
                                    res_satuan3 =  `<option value="${val.satuan3}">${uoms[val.satuan3 - 1].name}</option>` + satuan3;
                                } else {
                                    res_satuan3 = satuan3;
                                }

                                body += `
                                <tr>
                                <td>${val.code}</td>
                                <td>${val.name}</td>

                                <td>
                                <input type="number" step="0.001" class="form-control" name="berat1" id="berat1${val.code}" value="${val.berat1 < 1 ? '' : val.berat1}" style="max-width: 120px;">
                                </td>

                                <td>
                                <select class="form-control form-sm" name="satuan1" id="satuan1${val.code}" style="max-width: 120px;">
                                ${res_satuan1}
                                </select>
                                </td>

                                <td>
                                <input type="number" step="0.001" class="form-control" name="berat2" id="berat2${val.code}" value="${val.berat2 < 1 ? '' : val.berat2}" style="max-width: 120px;">
                                </td>

                                <td>
                                <select class="form-control form-sm" name="satuan2" id="satuan2${val.code}" style="max-width: 120px;">
                                ${res_satuan2}
                                </select>
                                </td>

                                <td>
                                <input type="number" step="0.001" class="form-control" name="berat3" id="berat3${val.code}" value="${val.berat3 < 1 ? '' : val.berat3}" style="max-width: 120px;">
                                </td>

                                <td>
                                <select class="form-control form-sm" name="satuan3" id="satuan3${val.code}" style="max-width: 120px;">
                                ${res_satuan3}
                                </select>
                                </td>

                                <td class="text-center">${can_edit == true ? '<a href="#" class="btn btn-sm btn-success btn_store" data-code="'+val.code+'" data-name="'+val.name+'"><i class="fa fa-save"></i> </a>' : '-'}
                                </td>

                                </tr>
                                `;
                            });
                            generate_table(body);
                        } else {
                            generate_table(body);
                        }
                    },
                });
            }

            function generate_table(body) {
                table = `
                <table class="table table-striped" id="table">
                <thead>
                <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Berat 1</th>
                <th>Satuan 1</th>
                <th>Berat 2</th>
                <th>Satuan 2</th>
                <th>Berat 3</th>
                <th>Satuan 3</th>
                <th class="text-center">Save</th>
                </tr>
                </thead>
                <tbody>
                ${body}
                </tbody>
                </table>
                `;

                $("#tblFirst").html(table);

                App.table = $("#table").DataTable({
                    language: {
                        search: "Cari",
                        lengthMenu: "Tampilkan _MENU_ baris per halaman",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan _START_  sampai _END_ dari _MAX_ data",
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
                    serverSide: false,
                    searching: true,
                    order: [[0, "desc"]],
                });
                $(".loadingpage").hide();

                $("#table").on("click", ".btn_store", function () {
                    const code = $(this).data("code");
                    const name = $(this).data("name");
                    $.ajax({
                        url: App.baseUrl + "resources_berat/store",
                        data: {
                            code: code,
                            name: name,
                            berat1: $('#berat1'+code).val(),
                            berat2: $('#berat2'+code).val(),
                            berat3: $('#berat3'+code).val(),
                            satuan1: $('#satuan1'+code).val(),
                            satuan2: $('#satuan2'+code).val(),
                            satuan3: $('#satuan3'+code).val(),
                            status: 1,
                        },
                        method: "post",
                        dataType: "json",
                        success: function (res) {
                            if (res.status) {
                                App.alert(res.pesan);
                            }
                        },
                    });
                });
            }
        },
        enableDelete: function () {
            $("#btnHapus").on("click", function () {
                if ($('input[name="idsData[]"]:checked').length > 0) {
                    return confirm("Anda yakin menghapus data yang dipilih?");
                } else {
                    alert("Anda belum memilih data untuk dihapus.");
                    return false;
                }
            });
            $("#btnReject").on("click", function () {
                if ($('input[name="idsData[]"]:checked').length > 0) {
                    return confirm("Anda yakin reject data yang dipilih?");
                } else {
                    alert("Anda belum memilih data untuk di-reject.");
                    return false;
                }
            });
            $("#btnApprove").on("click", function () {
                if ($('input[name="idsData[]"]:checked').length > 0) {
                    return confirm("Anda yakin approve data yang dipilih?");
                } else {
                    alert("Anda belum memilih data untuk di-approve.");
                    return false;
                }
            });
        },
        initEvent: function () {
            App.table = $("#table").DataTable({
                language: {
                    search: "Cari",
                    lengthMenu: "Tampilkan _MENU_ baris per halaman",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_  sampai _END_ dari _MAX_ data",
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
                serverSide: false,
                searching: true,
                // "paging": true,
                columnDefs: [{ orderable: false, targets: [0, 1] }],
                order: [[2, "desc"]],
            });
        },
    };
});
