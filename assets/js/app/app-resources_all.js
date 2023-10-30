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
    sidebar ,
    datatables,
    datatablesBootstrap,
    bootstrapDatepicker,
    highchart,
    highchartmore,
    select2
) {
    return {
        table:null,
        req:false,
        init: function () {
            App.initFunc();
            App.initEvent();
            // App.checkAll();
            App.tblFirst();
            App.level1();
            App.level2();
            App.level3();
            App.level4();
            App.level5();
            App.enableDelete();
            $(".loadingpage").hide();
        },
        tblFirst : function(){
            $.ajax({
                url: App.baseUrl+"resources_all/show_data",
                // method: 'post',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    let body = '';
                    $.each(data, function(i, val) {
                        if (val.sts_matgis == 1) {
                            matgis = 'Matgis';
                        } else if (val.sts_matgis == 2) {
                            matgis = 'Non Matgis';
                        }

                        if (val.status == 0) {
                            status = 'Waiting';
                            cls = 'info';
                        } else if (val.status == 1) {
                            status = 'Approved';
                            cls = 'success';
                        } else {
                            cls = 'warning';
                            status = 'Rejected';
                        }

                        body += `
                            <tr>
                                <td>${val.code}</td>
                                <td>${val.parent_code != null ? val.parent_code : '-'}</td>
                                <td>${val.name}</td>
                                <td>${val.sts_matgis != null ? matgis : '-'}</td>
                                <td>${val.unspsc != null ? val.unspsc : '-'}</td>
                                <td><span class="label label-${cls}">${status}</span></td>
                            </tr>
                        `;
                    })
                    generate_table(body)
                }
            })

            function generate_table(body) {
                table = `
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Parent</th>
                            <th>Nama</th>
                            <th>Matgis</th>
                            <th>UNSPSC</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${body}
                    </tbody>
                </table>
                `;

                $('#tblFirst').html(table);

                App.table = $('#table').DataTable({
                    "language": {
                        "search": "Cari",
                        "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                        "zeroRecords": "Data tidak ditemukan",
                        "info": "Menampilkan _START_  sampai _END_ dari _MAX_ data",
                        "infoEmpty": "Tidak ada data yang ditampilkan ",
                        "infoFiltered": "(pencarian dari _MAX_ total records)",
                        "paginate": {
                            "first":      "Pertama",
                            "last":       "Terakhir",
                            "next":       "Selanjutnya",
                            "previous":   "Sebelum"
                        },
                    },
                    "processing": true,
                    "serverSide": false,
                    "searching": true,
                    "order": [[0, 'desc']],
                });
            }
        },
        level1 : function(){
            $('#all_level1').on('change', function() {
                $(".loadingpage").show();
                data = $('#all_level1').val();
                $.ajax({
                    url: App.baseUrl+"resources_all/level_change",
                    data: {data:data},
                    method: 'post',
                    dataType: 'json',
                    success: function(res) {
                        all_level2 = '<option value="">Pilih Level 2</option>';
                        $.each(res, function(key, val){
                            all_level2 += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        });
                        $('#all_level2').html(all_level2).removeAttr( 'disabled' );
                        $('#all_level3').html('<option value="">Pilih Level 3</option>').prop('disabled', true);
                        $('#all_level4').html('<option value="">Pilih Level 4</option>').prop('disabled', true);
                        $('#all_level5').html('<option value="">Pilih Level 5</option>').prop('disabled', true);
                        get_level_data($('#all_level1').val());
                    }
                })
            })

            function get_level_data(data) {
                $.ajax({
                    url: App.baseUrl+"resources_all/show_data_param",
                    data: {data:data, lvl:1},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        let body = '';

                        if (data.length > 0) {
                            $.each(data, function(i, val) {
                                if (val.sts_matgis == 1) {
                                    matgis = 'Matgis';
                                } else if (val.sts_matgis == 2) {
                                    matgis = 'Non Matgis';
                                }

                                if (val.status == 0) {
                                    status = 'Waiting';
                                    cls = 'info';
                                } else if (val.status == 1) {
                                    status = 'Approved';
                                    cls = 'success';
                                } else {
                                    cls = 'warning';
                                    status = 'Rejected';
                                }

                                body += `
                                    <tr>
                                        <td>${val.code}</td>
                                        <td>${val.parent_code != null ? val.parent_code : '-'}</td>
                                        <td>${val.name}</td>
                                        <td>${val.sts_matgis != null ? matgis : '-'}</td>
                                        <td>${val.unspsc != null ? val.unspsc : '-'}</td>
                                        <td><span class="label label-${cls}">${status}</span></td>
                                    </tr>
                                `;

                            })
                            generate_table(body);
                        } else {
                            generate_table(body);
                        }
                    }
                })
            }

            function generate_table(body) {
                table = `
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Parent</th>
                            <th>Nama</th>
                            <th>Matgis</th>
                            <th>UNSPSC</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${body}
                    </tbody>
                </table>
                `;

                $('#tblFirst').html(table);

                App.table = $('#table').DataTable({
                    "language": {
                        "search": "Cari",
                        "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                        "zeroRecords": "Data tidak ditemukan",
                        "info": "Menampilkan _START_  sampai _END_ dari _MAX_ data",
                        "infoEmpty": "Tidak ada data yang ditampilkan ",
                        "infoFiltered": "(pencarian dari _MAX_ total records)",
                        "paginate": {
                            "first":      "Pertama",
                            "last":       "Terakhir",
                            "next":       "Selanjutnya",
                            "previous":   "Sebelum"
                        },
                    },
                    "processing": true,
                    "serverSide": false,
                    "searching": true,
                    "order": [[0, 'desc']],
                });
                $(".loadingpage").hide();
            }
        },
        level2 : function(){
            $('#all_level2').on('change', function() {
                $(".loadingpage").show();
                data = $('#all_level2').val();

                $.ajax({
                    url: App.baseUrl+"resources_all/level_change",
                    data: {data:data},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        all_level3 = '<option value="">Pilih Level 3</option>';
                        $.each(data, function(key, val){
                            all_level3 += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        });
                        $('#all_level3').html(all_level3).removeAttr( 'disabled' );
                        $('#all_level4').html('<option value="">Pilih Level 4</option>').prop('disabled', true);
                        $('#all_level5').html('<option value="">Pilih Level 5</option>').prop('disabled', true);
                        get_level_data($('#all_level2').val());
                    }
                })
            })

            function get_level_data(data) {
                $.ajax({
                    url: App.baseUrl+"resources_all/show_data_param",
                    data: {data:data, lvl:2},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        let body = '';
                        if (data.length > 0) {
                            $.each(data, function(i, val) {
                                if (val.sts_matgis == 1) {
                                    matgis = 'Matgis';
                                } else if (val.sts_matgis == 2) {
                                    matgis = 'Non Matgis';
                                }

                                if (val.status == 0) {
                                    status = 'Waiting';
                                    cls = 'info';
                                } else if (val.status == 1) {
                                    status = 'Approved';
                                    cls = 'success';
                                } else {
                                    cls = 'warning';
                                    status = 'Rejected';
                                }

                                body += `
                                    <tr>
                                        <td>${val.code}</td>
                                        <td>${val.parent_code != null ? val.parent_code : '-'}</td>
                                        <td>${val.name}</td>
                                        <td>${val.sts_matgis != null ? matgis : '-'}</td>
                                        <td>${val.unspsc != null ? val.unspsc : '-'}</td>
                                        <td><span class="label label-${cls}">${status}</span></td>
                                    </tr>
                                `;

                            })
                            generate_table(body);
                        } else {
                            generate_table(body);
                        }
                    }
                })
            }

            function generate_table(body) {
                table = `
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Parent</th>
                            <th>Nama</th>
                            <th>Matgis</th>
                            <th>UNSPSC</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${body}
                    </tbody>
                </table>
                `;

                $('#tblFirst').html(table);

                App.table = $('#table').DataTable({
                    "language": {
                        "search": "Cari",
                        "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                        "zeroRecords": "Data tidak ditemukan",
                        "info": "Menampilkan _START_  sampai _END_ dari _MAX_ data",
                        "infoEmpty": "Tidak ada data yang ditampilkan ",
                        "infoFiltered": "(pencarian dari _MAX_ total records)",
                        "paginate": {
                            "first":      "Pertama",
                            "last":       "Terakhir",
                            "next":       "Selanjutnya",
                            "previous":   "Sebelum"
                        },
                    },
                    "processing": true,
                    "serverSide": false,
                    "searching": true,
                    "order": [[0, 'desc']],
                });

                $(".loadingpage").hide();
            }
        },
        level3 : function(){
            $('#all_level3').on('change', function() {
                $(".loadingpage").show();
                data = $('#all_level3').val();

                $.ajax({
                    url: App.baseUrl+"resources_all/level_change",
                    data: {data:data},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        all_level4 = '<option value="">Pilih Level 4</option>';
                        $.each(data, function(key, val){
                            all_level4 += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        });
                        $('#all_level4').html(all_level4).removeAttr( 'disabled' );
                        $('#all_level5').html('<option value="">Pilih Level 5</option>').prop('disabled', true);
                        get_level_data($('#all_level3').val());
                    }
                })
            })

            function get_level_data(data) {
                $.ajax({
                    url: App.baseUrl+"resources_all/show_data_param",
                    data: {data:data, lvl:3},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        let body = '';
                        if (data.length > 0) {
                            $.each(data, function(i, val) {
                                if (val.sts_matgis == 1) {
                                    matgis = 'Matgis';
                                } else if (val.sts_matgis == 2) {
                                    matgis = 'Non Matgis';
                                }

                                if (val.status == 0) {
                                    status = 'Waiting';
                                    cls = 'info';
                                } else if (val.status == 1) {
                                    status = 'Approved';
                                    cls = 'success';
                                } else {
                                    cls = 'warning';
                                    status = 'Rejected';
                                }

                                body += `
                                    <tr>
                                        <td>${val.code}</td>
                                        <td>${val.parent_code != null ? val.parent_code : '-'}</td>
                                        <td>${val.name}</td>
                                        <td>${val.sts_matgis != null ? matgis : '-'}</td>
                                        <td>${val.unspsc != null ? val.unspsc : '-'}</td>
                                        <td><span class="label label-${cls}">${status}</span></td>
                                    </tr>
                                `;

                            })
                            generate_table(body);
                        } else {
                            generate_table(body);
                        }
                    }
                })
            }

            function generate_table(body) {
                table = `
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Parent</th>
                            <th>Nama</th>
                            <th>Matgis</th>
                            <th>UNSPSC</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${body}
                    </tbody>
                </table>
                `;

                $('#tblFirst').html(table);

                App.table = $('#table').DataTable({
                    "language": {
                        "search": "Cari",
                        "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                        "zeroRecords": "Data tidak ditemukan",
                        "info": "Menampilkan _START_  sampai _END_ dari _MAX_ data",
                        "infoEmpty": "Tidak ada data yang ditampilkan ",
                        "infoFiltered": "(pencarian dari _MAX_ total records)",
                        "paginate": {
                            "first":      "Pertama",
                            "last":       "Terakhir",
                            "next":       "Selanjutnya",
                            "previous":   "Sebelum"
                        },
                    },
                    "processing": true,
                    "serverSide": false,
                    "searching": true,
                    "order": [[0, 'desc']],
                });
                $(".loadingpage").hide();
            }
        },
        level4 : function(){
            $('#all_level4').on('change', function() {
                $(".loadingpage").show();
                data = $('#all_level4').val();
                $.ajax({
                    url: App.baseUrl+"resources_all/level_change",
                    data: {data:data},
                    method: 'post',
                    dataType: 'json',
                    success: function(res) {
                        all_level5 = '<option value="">Pilih Level 5</option>';
                        $.each(res, function(key, val){
                            all_level5 += '<option value="'+val.code+'">'+val.code +' - '+ val.name+'</option>';
                        });
                        $('#all_level5').html(all_level5).removeAttr( 'disabled' );

                        get_level_data(data);
                    }
                })

            })

            function get_level_data(data) {
                $.ajax({
                    url: App.baseUrl+"resources_all/show_data_param",
                    data: {data:data, lvl:4},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        let body = '';
                        if (data.length > 0) {
                            $.each(data, function(i, val) {
                                if (val.sts_matgis == 1) {
                                    matgis = 'Matgis';
                                } else if (val.sts_matgis == 2) {
                                    matgis = 'Non Matgis';
                                }
                                if (val.status == 0) {
                                    status = 'Waiting';
                                    cls = 'info';
                                } else if (val.status == 1) {
                                    status = 'Approved';
                                    cls = 'success';
                                } else {
                                    cls = 'warning';
                                    status = 'Rejected';
                                }

                                body += `
                                    <tr>
                                        <td>${val.code}</td>
                                        <td>${val.parent_code != null ? val.parent_code : '-'}</td>
                                        <td>${val.name}</td>
                                        <td>${val.sts_matgis != null ? matgis : '-'}</td>
                                        <td>${val.unspsc != null ? val.unspsc : '-'}</td>
                                        <td><span class="label label-${cls}">${status}</span></td>
                                    </tr>
                                `;

                            })
                            generate_table(body);
                        } else {
                            generate_table(body);
                        }
                    }
                })
            }

            function generate_table(body) {
                table = `
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Parent</th>
                            <th>Nama</th>
                            <th>Matgis</th>
                            <th>UNSPSC</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${body}
                    </tbody>
                </table>
                `;

                $('#tblFirst').html(table);

                App.table = $('#table').DataTable({
                    "language": {
                        "search": "Cari",
                        "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                        "zeroRecords": "Data tidak ditemukan",
                        "info": "Menampilkan _START_  sampai _END_ dari _MAX_ data",
                        "infoEmpty": "Tidak ada data yang ditampilkan ",
                        "infoFiltered": "(pencarian dari _MAX_ total records)",
                        "paginate": {
                            "first":      "Pertama",
                            "last":       "Terakhir",
                            "next":       "Selanjutnya",
                            "previous":   "Sebelum"
                        },
                    },
                    "processing": true,
                    "serverSide": false,
                    "searching": true,
                    "order": [[0, 'desc']],
                });

                $(".loadingpage").hide();
            }
        },
        level5 : function(){
            $('#all_level5').on('change', function() {
                $(".loadingpage").show();
                data = $('#all_level5').val();
                get_level_data(data);
            })

            function get_level_data(data) {
                $.ajax({
                    url: App.baseUrl+"resources_all/show_data_param",
                    data: {data:data, lvl:5},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        let body = '';
                        if (data.length > 0) {
                            $.each(data, function(i, val) {
                                if (val.sts_matgis == 1) {
                                    matgis = 'Matgis';
                                } else if (val.sts_matgis == 2) {
                                    matgis = 'Non Matgis';
                                }
                                if (val.status == 0) {
                                    status = 'Waiting';
                                    cls = 'info';
                                } else if (val.status == 1) {
                                    status = 'Approved';
                                    cls = 'success';
                                } else {
                                    cls = 'warning';
                                    status = 'Rejected';
                                }

                                body += `
                                    <tr>
                                        <td>${val.code}</td>
                                        <td>${val.parent_code != null ? val.parent_code : '-'}</td>
                                        <td>${val.name}</td>
                                        <td>${val.sts_matgis != null ? matgis : '-'}</td>
                                        <td>${val.unspsc != null ? val.unspsc : '-'}</td>
                                        <td><span class="label label-${cls}">${status}</span></td>
                                    </tr>
                                `;

                            })
                            generate_table(body);
                        } else {
                            generate_table(body);
                        }
                    }
                })
            }

            function generate_table(body) {
                table = `
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Parent</th>
                            <th>Nama</th>
                            <th>Matgis</th>
                            <th>UNSPSC</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${body}
                    </tbody>
                </table>
                `;

                $('#tblFirst').html(table);

                App.table = $('#table').DataTable({
                    "language": {
                        "search": "Cari",
                        "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                        "zeroRecords": "Data tidak ditemukan",
                        "info": "Menampilkan _START_  sampai _END_ dari _MAX_ data",
                        "infoEmpty": "Tidak ada data yang ditampilkan ",
                        "infoFiltered": "(pencarian dari _MAX_ total records)",
                        "paginate": {
                            "first":      "Pertama",
                            "last":       "Terakhir",
                            "next":       "Selanjutnya",
                            "previous":   "Sebelum"
                        },
                    },
                    "processing": true,
                    "serverSide": false,
                    "searching": true,
                    "order": [[0, 'desc']],
                });

                $(".loadingpage").hide();
            }
        },
        enableDelete : function(){
            $('#btnHapus').on('click', function() {
                if ($('input[name="idsData[]"]:checked').length > 0) {
                    return confirm('Anda yakin menghapus data yang dipilih?');
                } else {
                    alert('Anda belum memilih data untuk dihapus.')
                    return false;
                }
            })
            $('#btnReject').on('click', function() {
                if ($('input[name="idsData[]"]:checked').length > 0) {
                    return confirm('Anda yakin reject data yang dipilih?');
                } else {
                    alert('Anda belum memilih data untuk di-reject.')
                    return false;
                }
            })
            $('#btnApprove').on('click', function() {
                if ($('input[name="idsData[]"]:checked').length > 0) {
                    return confirm('Anda yakin approve data yang dipilih?');
                } else {
                    alert('Anda belum memilih data untuk di-approve.')
                    return false;
                }
            })
        },
        // checkAll : function(){
        //     $("#checkAll").click(function () {
        //         $('input:checkbox').not(this).prop('checked', this.checked);
        //     });
        // },
        initEvent : function()
        {
            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_  sampai _END_ dari _MAX_ data",
                    "infoEmpty": "Tidak ada data yang ditampilkan ",
                    "infoFiltered": "(pencarian dari _MAX_ total records)",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Selanjutnya",
                        "previous":   "Sebelum"
                    },
                },
                "processing": true,
                "serverSide": false,
                "searching": true,
                // "paging": true,
                "columnDefs": [
                    { "orderable": false, "targets": [0,1] },
                ],
                "order": [[2, 'desc']],
            });

        },

    }
});
